<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/security.php';
$site = require __DIR__ . '/config/site.php';
$formConfig = require __DIR__ . '/config/forms.php';

$pageTitle = 'Kontakt & Probestunde | Nachhilfe Leipzig | easyIT';
$pageDescription = 'Kontakt zu easyIT Nachhilfe Leipzig. Fach, Schulform und Lernziel unverbindlich mitteilen.';
$pageCanonical = $site['base_url'] . '/nh_hor/kontakt.php';

ensure_session_started();
$errors = $_SESSION['contact_errors'] ?? [];
$old = $_SESSION['contact_old'] ?? [];
unset($_SESSION['contact_errors'], $_SESSION['contact_old']);

$subjects = ['Mathematik','Physik','Chemie','Informatik','Deutsch','Englisch','Französisch','Spanisch','Latein','Anderes Fach'];
$schoolTypes = ['Grundschule','Oberschule','Gymnasium','Berufsschule','Studium','Abiturvorbereitung','Sonstiges'];

$prefillSubject = sanitize_line((string)($_GET['fach'] ?? $_GET['subject'] ?? ''));
$prefillSchool = sanitize_line((string)($_GET['schulform'] ?? ''));
$prefillLocation = sanitize_line((string)($_GET['ort'] ?? ''));

$selectedSubject = $old['subject'] ?? $prefillSubject;
$selectedSchool = $old['school_type'] ?? $prefillSchool;
$selectedLocation = $old['location'] ?? $prefillLocation;
?><!doctype html>
<html lang="de" data-theme="leipzig-blau">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt">
<div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="/">Startseite</a><span>›</span><span aria-current="page">Kontakt</span></nav>

<section class="hero">
  <div>
    <span class="eyebrow">Unverbindlich anfragen</span>
    <h1>Kontakt zu easyIT Nachhilfe Leipzig</h1>
    <p>Mit einigen Angaben zu Fach, Lernstand und Ziel kann die erste Rückmeldung bereits konkret ausfallen.</p>
  </div>
  <aside class="hero-panel">
    <h2>Hilfreiche Angaben</h2>
    <ul>
      <li>Fach und Klassenstufe</li>
      <li>aktuelles Thema</li>
      <li>nächster Prüfungstermin</li>
      <li>gewünschter Zeitrahmen</li>
    </ul>
  </aside>
</section>

<section class="section contact-layout" id="kontaktformular">
  <div>
    <span class="eyebrow">Anfrageformular</span>
    <h2>Wobei wird Unterstützung gebraucht?</h2>

    <?php if ($errors): ?>
      <div class="form-alert form-alert--error" role="alert">
        <strong>Bitte prüfe die Eingaben:</strong>
        <ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul>
      </div>
    <?php endif; ?>

    <form class="contact-form" action="/nh_hor/kontakt-senden.php" method="post" novalidate>
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

      <div class="honeypot" aria-hidden="true">
        <label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
      </div>

      <div class="input-grid">
        <label>Name *
          <input type="text" name="name" required minlength="2" autocomplete="name" value="<?= e((string)($old['name'] ?? '')) ?>">
        </label>
        <label>E-Mail *
          <input type="email" name="email" required autocomplete="email" value="<?= e((string)($old['email'] ?? '')) ?>">
        </label>
        <label>Telefon
          <input type="tel" name="phone" autocomplete="tel" value="<?= e((string)($old['phone'] ?? '')) ?>">
        </label>
        <label>Fach
          <select name="subject">
            <option value="">Bitte auswählen</option>
            <?php foreach ($subjects as $subject): ?>
              <option value="<?= e($subject) ?>" <?= $selectedSubject === $subject ? 'selected' : '' ?>><?= e($subject) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>Schulform / Lernphase
          <select name="school_type">
            <option value="">Bitte auswählen</option>
            <?php foreach ($schoolTypes as $schoolType): ?>
              <option value="<?= e($schoolType) ?>" <?= $selectedSchool === $schoolType ? 'selected' : '' ?>><?= e($schoolType) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>Ort / Stadtteil
          <input type="text" name="location" value="<?= e($selectedLocation) ?>" placeholder="z. B. Leipzig-Gohlis">
        </label>
      </div>

      <label>Nachricht *
        <textarea name="message" rows="8" required minlength="20" maxlength="<?= (int)$formConfig['max_message_length'] ?>" placeholder="Aktuelles Thema, Schwierigkeiten, Ziel und gegebenenfalls Prüfungstermin"><?= e((string)($old['message'] ?? '')) ?></textarea>
      </label>

      <label class="checkbox-label">
        <input type="checkbox" name="privacy" value="1" required <?= (($old['privacy'] ?? '') === '1') ? 'checked' : '' ?>>
        <span>Ich habe die <a href="/nh_hor/datenschutz.php">Datenschutzhinweise</a> gelesen und stimme der Verarbeitung meiner Angaben zur Bearbeitung der Anfrage zu. *</span>
      </label>

      <button class="button button--gold" type="submit">Anfrage absenden</button>
      <p class="form-note">Pflichtfelder sind mit * gekennzeichnet. Es werden nur die für die Bearbeitung notwendigen Angaben erhoben.</p>
    </form>
  </div>

  <aside class="contact-side">
    <div class="contact-card">
      <h3>Direkter Kontakt</h3>
      <p><strong>E-Mail:</strong><br><a href="mailto:<?= e($site['email']) ?>"><?= e($site['email']) ?></a></p>
      <p><strong>Telefon:</strong><br><a href="tel:<?= e(preg_replace('/\s+/', '', $site['phone'])) ?>"><?= e($site['phone']) ?></a></p>
    </div>
    <div class="contact-card">
      <h3>Datenschutz</h3>
      <p>Das Formular nutzt CSRF-Schutz, Honeypot und ein einfaches Rate Limit. Es werden keine Werbe- oder Tracking-Cookies benötigt.</p>
    </div>
  </aside>
</section>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
</main>
</div>
</body>
</html>
