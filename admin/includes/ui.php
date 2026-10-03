<?php
function stars(int $n): string { return str_repeat('★', $n) . str_repeat('☆', max(0, 5 - $n)); }

function render_field(array $f, array $lookups = [], $val = null): void
{
    $n = e($f['name']);
    $t = $f['type'];
    $req = !empty($f['required']) ? 'required' : '';
    $v = e($val ?? '');
    $full = in_array($t, ['textarea', 'image'], true) ? ' full' : '';
    echo "<div class=\"field$full\">";
    if ($t !== 'toggle') {
        echo '<label for="f_' . $n . '">' . e(__($f['label'])) . (!empty($f['required']) ? ' <b>*</b>' : '') . '</label>';
    }
    switch ($t) {
        case 'textarea':
            echo "<textarea id=\"f_$n\" name=\"$n\" rows=\"4\" dir=\"auto\" $req>$v</textarea>";
            break;
        case 'number':
            echo "<input type=\"number\" id=\"f_$n\" name=\"$n\" min=\"0\" value=\"" . e($val ?? 0) . "\">";
            break;
        case 'rating':
            echo "<select id=\"f_$n\" name=\"$n\">";
            for ($i = 5; $i >= 1; $i--) {
                $sel = ((string)($val ?? 5) === (string)$i) ? ' selected' : '';
                echo "<option value=\"$i\"$sel>" . stars($i) . " ($i)</option>";
            }
            echo '</select>';
            break;
        case 'select':
            echo "<select id=\"f_$n\" name=\"$n\" $req><option value=\"\">" . e(__('choose')) . "</option>";
            foreach (($lookups[$f['name']] ?? []) as $id => $label) {
                $sel = ((string)$val === (string)$id) ? ' selected' : '';
                echo "<option value=\"" . (int)$id . "\"$sel>" . e($label) . '</option>';
            }
            echo '</select>';
            break;
        case 'toggle':
            $on = ($val === null) ? true : ((string)$val === '1');
            echo '<label class="switch-row"><span class="switch"><input type="checkbox" name="' . $n . '" value="1"'
                . ($on ? ' checked' : '') . '><i></i></span> ' . e(__($f['label'])) . '</label>';
            break;
        case 'image':
            $src = $val ? e(media_url((string)$val)) : '';
            echo '<div class="img-field"><img class="img-preview" src="' . $src . '" alt=""' . ($src ? '' : ' hidden') . '>'
                . '<div><input type="hidden" name="' . $n . '" value="' . $v . '">'
                . '<input type="file" id="f_' . $n . '" name="' . $n . '__file" accept="image/*" class="file-input">'
                . '<small class="muted">' . e(__('image_upload_help', 'JPG, PNG, WEBP, GIF · max 5 MB')) . '</small></div></div>';
            break;
        case 'icon':
            echo '<div class="icon-field"><span class="icon-preview"><i data-lucide="' . e(kebab((string)$val)) . '"></i></span>'
                . "<input list=\"iconList\" id=\"f_$n\" name=\"$n\" value=\"$v\" placeholder=\"" . e(__('e.g. Boxes')) . "\" autocomplete=\"off\"></div>";
            break;
        default:
            $type = in_array($t, ['url', 'email'], true) ? $t : 'text';
            echo "<input type=\"$type\" id=\"f_$n\" name=\"$n\" value=\"$v\" dir=\"auto\" $req>";
    }
    if (!empty($f['help'])) echo '<small class="muted">' . e(__($f['help'])) . '</small>';
    echo '</div>';
}

function cell(array $f, array $r, array $lookups): string
{
    $v = $r[$f['name']] ?? '';
    switch ($f['type']) {
        case 'image':
            return $v ? '<img class="thumb" src="' . e(media_url($v)) . '" alt="" loading="lazy">' : '<span class="muted">—</span>';
        case 'icon':
            return $v ? '<span class="icon-cell"><i data-lucide="' . e(kebab($v)) . '"></i> ' . e($v) . '</span>' : '<span class="muted">—</span>';
        case 'select':
            return e($lookups[$f['name']][$v] ?? '—');
        case 'rating':
            return '<span class="stars">' . stars((int)$v) . '</span>';
        case 'toggle':
            return $v ? e(__('Yes')) : e(__('No'));
        case 'textarea':
            return '<span dir="auto" title="' . e((string)$v) . '">' . e(mb_strimwidth((string)$v, 0, 90, '…')) . '</span>';
        default:
            return '<span dir="auto">' . e(mb_strimwidth((string)$v, 0, 70, '…')) . '</span>';
    }
}