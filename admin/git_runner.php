<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

chdir(dirname(__DIR__));

if (file_exists('test_render.php')) @unlink('test_render.php');
if (file_exists('admin/test_render.php')) @unlink('admin/test_render.php');
if (file_exists('git_runner.php')) @unlink('git_runner.php');

$steps = [];

// 1. Remove temp files from git index
$out = []; $ret = 0;
exec('git rm --cached -f admin/test_render.php test_render.php 2>&1', $out, $ret);
$steps['unstage_temp'] = ['code' => $ret, 'output' => $out];

// 2. Stage all admin changes
$out = []; $ret = 0;
exec('git add admin/ 2>&1', $out, $ret);
$steps['git_add'] = ['code' => $ret, 'output' => $out];

// 3. Status before commit
$out = []; $ret = 0;
exec('git status -s 2>&1', $out, $ret);
$steps['status_before_commit'] = ['code' => $ret, 'output' => $out];

// 4. Commit
$msg = 'feat(admin): bilingual Arabic/English support, RTL layout, hero sliders and settings translations';
$out = []; $ret = 0;
exec('git commit -m ' . escapeshellarg($msg) . ' 2>&1', $out, $ret);
$steps['git_commit'] = ['code' => $ret, 'output' => $out];

// 5. Push to GitHub
$out = []; $ret = 0;
exec('git push origin main 2>&1', $out, $ret);
$steps['git_push'] = ['code' => $ret, 'output' => $out];

// 6. Final status
$out = []; $ret = 0;
exec('git status 2>&1', $out, $ret);
$steps['final_status'] = ['code' => $ret, 'output' => $out];

header('Content-Type: application/json; charset=utf-8');
echo json_encode($steps, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
