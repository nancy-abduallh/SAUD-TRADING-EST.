<?php
define('IS_API', true);
require __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_out(['ok' => false, 'error' => 'POST required'], 405);
csrf_verify();

$action = $_GET['action'] ?? '';
$module = $_GET['module'] ?? '';
$mods = modules();

/** Reads + validates the posted values for a list of fields (handles image uploads). */
function collect(array $fields, string $dir): array
{
    $out = [];
    foreach ($fields as $f) {
        $n = $f['name'];
        $t = $f['type'];
        switch ($t) {
            case 'toggle':
                $v = isset($_POST[$n]) ? 1 : 0;
                break;
            case 'number': case 'rating': case 'select':
                $v = (int)($_POST[$n] ?? 0);
                break;
            case 'image':
                $v = trim((string)($_POST[$n] ?? ''));
                if (!empty($_FILES[$n . '__file']['name'])) $v = handle_upload($_FILES[$n . '__file'], $dir);
                break;
            default:
                $v = trim((string)($_POST[$n] ?? ''));
        }
        if (!empty($f['required']) && ($v === '' || ($t === 'select' && $v === 0))) {
            throw new RuntimeException($f['label'] . ' is required');
        }
        if ($t === 'email' && $v !== '' && !filter_var($v, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Invalid email address');
        }
        $out[$n] = $v;
    }
    return $out;
}

function module_or_fail(array $mods, string $module): array
{
    if (!isset($mods[$module])) json_out(['ok' => false, 'error' => 'Unknown module'], 400);
    return $mods[$module];
}

try {
    switch ($action) {

        case 'save': {
            $m = module_or_fail($mods, $module);
            $id = (int)($_POST['id'] ?? 0);
            $data = collect($m['fields'], $m['dir']);
            if ($id) {
                $set = implode(', ', array_map(fn($c) => "`$c` = ?", array_keys($data)));
                run("UPDATE `{$m['table']}` SET $set WHERE id = ?", [...array_values($data), $id]);
                $verb = 'Updated';
            } else {
                if (!empty($m['sortable']) && isset($data['sort_order']) && (int)$data['sort_order'] === 0) {
                    $data['sort_order'] = (int)val("SELECT COALESCE(MAX(sort_order),0)+1 FROM `{$m['table']}`");
                }
                $cols = implode(', ', array_map(fn($c) => "`$c`", array_keys($data)));
                $ph = implode(', ', array_fill(0, count($data), '?'));
                run("INSERT INTO `{$m['table']}` ($cols) VALUES ($ph)", array_values($data));
                $id = (int)db()->insert_id;
                $verb = 'Created';
            }
            $strings = array_values(array_filter($data, 'is_string'));
            log_activity("$verb {$m['singular']}", (string)($strings[0] ?? '#' . $id));
            json_out(['ok' => true, 'id' => $id, 'message' => $m['singular'] . ' saved']);
        }

        case 'delete': {
            $m = module_or_fail($mods, $module);
            $id = (int)($_POST['id'] ?? 0);
            run("DELETE FROM `{$m['table']}` WHERE id = ?", [$id]);
            log_activity("Deleted {$m['singular']}", '#' . $id);
            json_out(['ok' => true, 'message' => $m['singular'] . ' deleted']);
        }

        case 'toggle': {
            $m = module_or_fail($mods, $module);
            if (empty($m['toggle'])) json_out(['ok' => false, 'error' => 'Not toggleable'], 400);
            $c = $m['toggle'];
            $id = (int)($_POST['id'] ?? 0);
            run("UPDATE `{$m['table']}` SET `$c` = 1 - `$c` WHERE id = ?", [$id]);
            $new = (int)val("SELECT `$c` FROM `{$m['table']}` WHERE id = ?", [$id]);
            log_activity($new ? "Enabled {$m['singular']}" : "Disabled {$m['singular']}", '#' . $id);
            json_out(['ok' => true, 'value' => $new]);
        }

        case 'reorder': {
            $m = module_or_fail($mods, $module);
            if (empty($m['sortable'])) json_out(['ok' => false, 'error' => 'Not sortable'], 400);
            $ids = array_values(array_filter(array_map('intval', explode(',', (string)($_POST['ids'] ?? '')))));
            foreach ($ids as $i => $id) run("UPDATE `{$m['table']}` SET sort_order = ? WHERE id = ?", [$i + 1, $id]);
            log_activity("Reordered {$m['title']}");
            json_out(['ok' => true]);
        }

        case 'msg_read':
        case 'msg_unread': {
            run('UPDATE contact_messages SET is_read = ? WHERE id = ?',
                [$action === 'msg_read' ? 1 : 0, (int)($_POST['id'] ?? 0)]);
            json_out(['ok' => true]);
        }

        case 'msg_delete': {
            run('DELETE FROM contact_messages WHERE id = ?', [(int)($_POST['id'] ?? 0)]);
            log_activity('Deleted message', '#' . (int)$_POST['id']);
            json_out(['ok' => true, 'message' => 'Message deleted']);
        }

        case 'save_settings': {
            $g = settings_groups()[$_GET['group'] ?? ''] ?? null;
            if (!$g) json_out(['ok' => false, 'error' => 'Unknown settings group'], 400);
            $data = collect($g['fields'], $g['dir'] ?? 'misc');
            if (!empty($g['kv'])) {
                foreach ($data as $k => $v) {
                    run('INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)
                         ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)', [$k, $v]);
                }
            } else {
                $cols = array_keys($data);
                $sql = "INSERT INTO `{$g['table']}` (id, " . implode(', ', array_map(fn($c) => "`$c`", $cols)) . ') VALUES (1, '
                    . implode(', ', array_fill(0, count($cols), '?')) . ') ON DUPLICATE KEY UPDATE '
                    . implode(', ', array_map(fn($c) => "`$c` = VALUES(`$c`)", $cols));
                run($sql, array_values($data));
            }
            log_activity('Updated settings', $g['title']);
            json_out(['ok' => true, 'message' => $g['title'] . ' saved']);
        }

        case 'update_profile': {
            $u = trim((string)($_POST['username'] ?? ''));
            $em = trim((string)($_POST['email'] ?? ''));
            if (!preg_match('/^[A-Za-z0-9_.-]{3,50}$/', $u)) throw new RuntimeException('Username: 3–50 letters, numbers, . _ -');
            if ($em !== '' && !filter_var($em, FILTER_VALIDATE_EMAIL)) throw new RuntimeException('Invalid email address');
            run('UPDATE admins SET username = ?, email = ? WHERE id = ?', [$u, $em, (int)$_SESSION['admin_id']]);
            log_activity('Updated profile', $u);
            json_out(['ok' => true, 'message' => 'Profile updated']);
        }

        case 'change_password': {
            $cur = (string)($_POST['current'] ?? '');
            $new = (string)($_POST['new'] ?? '');
            $conf = (string)($_POST['confirm'] ?? '');
            $hash = (string)val('SELECT password_hash FROM admins WHERE id = ?', [(int)$_SESSION['admin_id']]);
            if (!password_verify($cur, $hash)) throw new RuntimeException('Current password is incorrect');
            if (strlen($new) < 8) throw new RuntimeException('New password must be at least 8 characters');
            if ($new !== $conf) throw new RuntimeException('Passwords do not match');
            run('UPDATE admins SET password_hash = ? WHERE id = ?', [password_hash($new, PASSWORD_DEFAULT), (int)$_SESSION['admin_id']]);
            session_regenerate_id(true);
            log_activity('Changed password');
            json_out(['ok' => true, 'message' => 'Password changed']);
        }

        default:
            json_out(['ok' => false, 'error' => 'Unknown action'], 400);
    }
} catch (RuntimeException $e) {
    json_out(['ok' => false, 'error' => $e->getMessage()], 422);
} catch (mysqli_sql_exception $e) {
    $msg = match ((int)$e->getCode()) {
        1062 => 'That value already exists (must be unique).',
        1451 => 'Cannot delete: other records depend on this one.',
        default => 'Database error: ' . $e->getMessage(),
    };
    json_out(['ok' => false, 'error' => $msg], 409);
}