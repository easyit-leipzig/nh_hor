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

<section class="section prose"><h2>1. Verantwortlicher</h2><p>Olaf Thiele, An der Kotsche 1, 04207 Leipzig. Kontakt: Telefon +49 1520 178 27 34, E-Mail info@easyit-nachhilfe.de.</p><h2>2. Hosting und Serverprotokolle</h2><p>Beim Aufruf der Website verarbeitet der Webserver technisch erforderliche Verbindungsdaten. Art und Speicherdauer der Serverprotokolle richten sich nach dem eingesetzten Hostingvertrag und sind dort abschließend zu prüfen.</p><h2>3. Kontaktformular und E-Mail-Versand</h2><p>Die im Kontaktformular eingegebenen Angaben werden ausschließlich zur Bearbeitung der Anfrage und zur damit verbundenen Kommunikation verwendet. Der Versand erfolgt über eine authentifizierte SMTP-Verbindung. Eine erfolgreiche Übergabe an den SMTP-Server ist keine Garantie dafür, dass die Nachricht im Zielpostfach zugestellt wird.</p><p>Das technische Ereignisprotokoll des Kontaktformulars enthält weder Name, E-Mail-Adresse, Telefonnummer, Nachrichtentext, IP-Adresse noch einen Geräte- oder Browser-Fingerprint. Gespeichert werden nur Zeitpunkt, technische Ereignisart, Erfolgsstatus und gegebenenfalls ein begrenzter technischer Fehlercode. Diese Einträge werden automatisch nach 30 Tagen entfernt.</p><p>Die Rechtsgrundlage richtet sich nach dem Inhalt der Anfrage: vorvertragliche Kommunikation oder Vertragserfüllung sowie im Übrigen das berechtigte Interesse an der Bearbeitung eingehender Anfragen und an der technischen Absicherung des Formulars. Kontaktdaten werden gelöscht, sobald sie für die Bearbeitung nicht mehr erforderlich sind und keine gesetzlichen Aufbewahrungspflichten entgegenstehen.</p><h2>4. Cookies und lokale Speicherung</h2><p>Die Website verwendet technisch notwendige Session-Cookies zur Formular- und Sicherheitsfunktion. Sie sind mit HttpOnly und SameSite=Lax geschützt; bei HTTPS wird zusätzlich Secure gesetzt.</p><h2>5. Rechte betroffener Personen</h2><p>Nach den gesetzlichen Voraussetzungen bestehen Rechte auf Auskunft, Berichtigung, Löschung, Einschränkung der Verarbeitung, Datenübertragbarkeit, Widerspruch und Beschwerde bei einer Datenschutzaufsichtsbehörde.</p><h2>6. Stand</h2><p>20. Juli 2026. Die Angaben zu Hostinganbieter, SMTP-Dienstleister und möglichen Auftragsverarbeitern sind vor dem Produktivbetrieb anhand der tatsächlich geschlossenen Verträge abschließend zu ergänzen.</p></section>

</div><?php require __DIR__ . '/includes/footer.php'; ?></main></div></body></html>