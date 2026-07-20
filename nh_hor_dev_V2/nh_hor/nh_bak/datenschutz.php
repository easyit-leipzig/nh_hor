<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
$site = require __DIR__ . '/config/site.php';
$pageTitle = 'Datenschutz | easyIT Nachhilfe Leipzig';
$pageDescription = 'Datenschutzhinweise von easyIT Nachhilfe Leipzig. Die Erklärung ist an Hosting, Kontaktformular, Protokolldaten und eingesetzte Dienste anzupassen.';
$pageCanonical = $site['base_url'] . '/datenschutz.php';
?><!doctype html>
<html lang="de">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt"><div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="index.php">Startseite</a><span>›</span><span aria-current="page">Datenschutz</span></nav>
<section class="content-hero"><span class="eyebrow">Transparente Informationen zur Datenverarbeitung</span><h1>Datenschutz</h1><p class="lead">Datenschutzhinweise von easyIT Nachhilfe Leipzig. Die Erklärung ist an Hosting, Kontaktformular, Protokolldaten und eingesetzte Dienste anzupassen.</p></section>

<section class="section prose"><div class="notice notice--error"><strong>Entwicklungsfassung – rechtlich prüfen.</strong><p>Die Datenschutzerklärung muss vor Veröffentlichung an den tatsächlichen Hoster, das Kontaktformular, den Mailversand, Cookies, Statistikdienste und eingebundene Drittanbieter angepasst werden.</p></div><h2>1. Verantwortlicher</h2><p>[Vollständiger Name, Anschrift, Telefon und E-Mail eintragen.]</p><h2>2. Hosting und Serverprotokolle</h2><p>Beim Aufruf der Website können technisch notwendige Informationen wie IP-Adresse, Zeitpunkt, aufgerufene Datei, Referrer und Browserdaten verarbeitet werden. Speicherdauer, Rechtsgrundlage und Empfänger sind anhand des Hostingvertrags zu ergänzen.</p><h2>3. Kontaktaufnahme</h2><p>Angaben aus einer Anfrage werden zur Bearbeitung des Anliegens verarbeitet. Vor Livebetrieb sind Rechtsgrundlage, Speicherdauer, Maildienstleister und mögliche Auftragsverarbeiter konkret zu benennen.</p><h2>4. Cookies und lokale Speicherung</h2><p>Die technische Grundfassung verwendet lokale Speicherung nur für funktionale Einstellungen wie den zuletzt gewählten Navigationspunkt. Vor Veröffentlichung ist zu prüfen, ob hierfür zusätzliche Hinweise oder Einwilligungen notwendig sind.</p><h2>5. Rechte betroffener Personen</h2><p>Je nach gesetzlichen Voraussetzungen bestehen Rechte auf Auskunft, Berichtigung, Löschung, Einschränkung, Datenübertragbarkeit, Widerspruch und Beschwerde bei einer Datenschutzaufsichtsbehörde.</p><h2>6. Stand</h2><p>[Monat und Jahr der finalen Prüfung eintragen.]</p></section>

</div><?php require __DIR__ . '/includes/footer.php'; ?></main></div></body></html>