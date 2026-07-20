<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/security.php';
$site = require __DIR__ . '/config/site.php';
$pageTitle = 'Anfrage erfolgreich | easyIT Nachhilfe Leipzig';
$pageDescription = 'Die Anfrage wurde erfolgreich übermittelt.';
$pageCanonical = $site['base_url'] . '/anfrage-erfolgreich.php';
$pageRobots = 'noindex,follow';

ensure_session_started();
$valid = (bool)($_SESSION['contact_success'] ?? false);
unset($_SESSION['contact_success']);

if (!$valid) {
    header('Location: /kontakt.php', true, 303);
    exit;
}
?><!doctype html>
<html lang="de">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt">
<div class="content-wrap">
<section class="section success-page">
  <span class="success-icon" aria-hidden="true">✓</span>
  <span class="eyebrow">Anfrage aufgenommen</span>
  <h1>Vielen Dank für die Nachricht.</h1>
  <p>Die Angaben wurden verarbeitet. Sofern der E-Mail-Versand in der Serverkonfiguration aktiviert ist, wurde die Anfrage an easyIT übermittelt.</p>
  <div class="hero-actions">
    <a class="button button--gold" href="/index.php">Zur Startseite</a>
    <a class="button button--blue" href="/faq.php">Häufige Fragen</a>
  </div>
</section>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
</main>
</div>
</body>
</html>
