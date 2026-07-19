<?php
declare(strict_types=1);
$user = admin_user();
?><!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title><?= admin_e($adminTitle ?? 'Admin') ?> | easyIT</title>
<link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="admin-body">
<header class="admin-header">
  <a href="/admin/index.php" class="admin-brand">easyIT CMS</a>
  <?php if ($user): ?>
    <nav>
      <a href="/admin/index.php">Dashboard</a>
      <a href="/admin/content.php?type=faq">FAQ</a>
      <a href="/admin/content.php?type=review">Bewertungen</a>
      <a href="/admin/content.php?type=job">Jobs</a>
      <a href="/admin/content.php?type=blog">Blog</a>
      <a href="/admin/logout.php">Abmelden</a>
    </nav>
  <?php endif; ?>
</header>
<main class="admin-main">
