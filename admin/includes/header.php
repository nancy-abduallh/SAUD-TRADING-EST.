<?php
// expects: $pageTitle, $active (and $ADMIN from auth.php)
$unread = (int)val('SELECT COUNT(*) FROM contact_messages WHERE is_read = 0');
$currentParams = $_GET;
$targetLang = current_lang() === 'ar' ? 'en' : 'ar';
$currentParams['lang'] = $targetLang;
$langSwitchUrl = '?' . http_build_query($currentParams);
?>
<!DOCTYPE html>
<html lang="<?= e(current_lang()) ?>" dir="<?= is_rtl() ? 'rtl' : 'ltr' ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?= e(csrf_token()) ?>">
  <title><?= e(__($pageTitle ?? 'Dashboard')) ?> · <?= e(__('saud_trading')) ?></title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/dashboard.css?v=<?= filemtime(__DIR__ . '/../assets/css/dashboard.css') ?>">
</head>
<body>
<div class="app">
  <?php require __DIR__ . '/sidebar.php'; ?>
  <div class="main">
    <header class="topbar">
      <button class="icon-btn" id="menuBtn" aria-label="Menu"><i data-lucide="menu"></i></button>
      <h1 class="page-title"><?= e(__($pageTitle ?? '')) ?></h1>
      <div class="search"><i data-lucide="search"></i>
        <input id="globalSearch" type="search" placeholder="<?= e(__('search_placeholder')) ?>" autocomplete="off">
      </div>
      <a class="btn btn-sm lang-switch-btn" href="<?= e($langSwitchUrl) ?>" title="<?= current_lang() === 'ar' ? 'Switch to English' : 'التحويل إلى العربية' ?>" style="display:inline-flex; align-items:center; gap:6px; font-weight:600; font-size:13px; padding:6px 12px; border-radius:20px; text-decoration:none;">
        <i data-lucide="globe" style="width:15px; height:15px;"></i>
        <span><?= current_lang() === 'ar' ? 'English' : 'العربية' ?></span>
      </a>
      <a class="icon-btn bell" href="messages.php" title="<?= e(__('Messages')) ?>"><i data-lucide="bell"></i>
        <?php if ($unread): ?><span class="dot"><?= $unread ?></span><?php endif; ?>
      </a>
      <div class="dropdown">
        <button class="profile-btn" id="profileBtn" type="button">
          <span class="avatar"><?= e(mb_strtoupper(mb_substr($ADMIN['username'], 0, 1))) ?></span>
          <span><?= e($ADMIN['username']) ?></span><i data-lucide="chevron-down"></i>
        </button>
        <div class="dropdown-menu" id="profileMenu">
          <a href="profile.php"><i data-lucide="user"></i> <?= e(__('Profile')) ?></a>
          <a href="settings.php"><i data-lucide="settings"></i> <?= e(__('Settings')) ?></a>
          <a href="logout.php?t=<?= e(csrf_token()) ?>"><i data-lucide="log-out"></i> <?= e(__('Log out')) ?></a>
        </div>
      </div>
    </header>
    <section class="content">