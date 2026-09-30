<?php
$nav = [
    'Overview' => [['index', 'Dashboard', 'layout-dashboard']],
    'Site content' => [
        ['hero', 'Hero Slides', 'image'], ['services', 'Sectors & Services', 'layers'],
        ['categories', 'Categories', 'folder'], ['products', 'Products', 'package'],
        ['brands', 'Brands', 'award'], ['clients', 'Clients', 'handshake'],
        ['testimonials', 'Testimonials', 'quote'], ['faqs', 'FAQs', 'help-circle'],
    ],
    'Company data' => [
        ['values', 'Values', 'sparkles'], ['ecosystem', 'Digital Ecosystem', 'bot'],
        ['comparison', 'Comparison Table', 'table'], ['stats', 'Stats', 'trending-up'],
        ['countries', 'Countries', 'globe'],
    ],
    'Inbox & system' => [
        ['messages', 'Messages', 'mail'], ['settings', 'Settings', 'settings'], ['profile', 'Profile', 'user'],
    ],
];
?>
<aside class="sidebar" id="sidebar">
  <div class="brand">
    <span class="logo-mark">S</span>
    <span class="brand-text">SAUD TRADING<small>Admin Dashboard</small></span>
  </div>
  <nav>
    <?php foreach ($nav as $group => $items): ?>
      <div class="nav-group"><?= e($group) ?></div>
      <?php foreach ($items as [$key, $label, $icon]): ?>
        <a href="<?= e($key) ?>.php" class="nav-link<?= ($active ?? '') === $key ? ' active' : '' ?>" title="<?= e($label) ?>">
          <i data-lucide="<?= e($icon) ?>"></i><span><?= e($label) ?></span>
          <?php if ($key === 'messages' && $unread): ?><em class="badge-n"><?= (int)$unread ?></em><?php endif; ?>
        </a>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </nav>
  <div class="side-foot">
    <div class="mini-user">
      <span class="avatar"><?= e(mb_strtoupper(mb_substr($ADMIN['username'], 0, 1))) ?></span>
      <span class="mini-text"><?= e($ADMIN['username']) ?><small>Administrator</small></span>
    </div>
    <button class="icon-btn" id="collapseBtn" title="Collapse"><i data-lucide="chevrons-left"></i></button>
  </div>
</aside>