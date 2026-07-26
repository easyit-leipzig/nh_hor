<?php
declare(strict_types=1);
require_once __DIR__ . '/../../includes/functions.php';
$user = admin_user();
?><!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title><?= admin_e($adminTitle ?? 'Admin') ?> | easyIT</title>
<link rel="stylesheet" href="<?= e(asset_url('assets/css/admin.css')) ?>">
</head>
<body class="admin-body">
<header class="admin-header">
  <a href="<?= admin_e(app_path($user ? '/admin/index.php' : '/admin/login.php')) ?>" class="admin-brand" aria-label="easyIT Adminbereich">
    <img src="<?= admin_e(app_path('/assets/img/brand-logo.svg')) ?>" alt="easyIT" class="admin-brand-logo">
    <span>Administration</span>
  </a>
  <?php if ($user): ?>
    <nav aria-label="Admin-Navigation">
      <a href="<?= admin_e(app_path('/admin/index.php')) ?>">Dashboard</a>
      <a href="<?= admin_e(app_path('/admin/content.php?type=faq')) ?>">FAQ</a>
      <a href="<?= admin_e(app_path('/admin/content.php?type=review')) ?>">Bewertungen</a>
      <a href="<?= admin_e(app_path('/admin/content.php?type=job')) ?>">Jobs</a>
      <a href="<?= admin_e(app_path('/admin/content.php?type=blog')) ?>">Blog</a>
      <?php if (admin_has_role('admin')): ?>
        <a href="<?= admin_e(app_path('/admin/navigation.php')) ?>">Navigation</a>
        <a href="<?= admin_e(app_path('/admin/index-content.php')) ?>">Freie Startseiteninhalte</a>
        <a href="<?= admin_e(app_path('/admin/homepage_blocks.php')) ?>">Homepage-Blöcke</a>
        <a href="<?= admin_e(app_path('/admin/imprint-persons.php')) ?>">Personen</a>
        <a href="<?= admin_e(app_path('/admin/imprint-addresses.php')) ?>">Adressen</a>
        <a href="<?= admin_e(app_path('/admin/imprint-contacts.php')) ?>">Kontakte</a>
        <a href="<?= admin_e(app_path('/admin/imprint-roles.php')) ?>">Rollen</a>
        <a href="<?= admin_e(app_path('/admin/users.php')) ?>">Benutzer</a>
      <?php endif; ?>
      <a href="<?= admin_e(app_path('/admin/account.php')) ?>">Konto</a>
      <form method="post" action="<?= admin_e(app_path('/admin/logout.php')) ?>" class="admin-inline-form">
        <input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
        <button type="submit" class="admin-link-button">Abmelden</button>
      </form>
    </nav>
  <?php endif; ?>
</header>
<main class="admin-main">
