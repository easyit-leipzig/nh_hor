<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
$site = require __DIR__ . '/config/site.php';
$pageTitle = 'Nachhilfe Leipzig für Mathe, Physik, Chemie & Informatik | easyIT';
$pageDescription = 'Persönliche Nachhilfe in Leipzig für Mathematik, Physik, Chemie und Informatik. Individuelle Förderung, Prüfungsvorbereitung und verständliche Erklärungen.';
$pageCanonical = $site['base_url'] . $site['base_path'] . '/index.php';
?><!doctype html>
<html lang="de" data-theme="leipzig-blau">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt">
<div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><span aria-current="page">Startseite</span></nav>

<section class="hero">
  <div>
    <span class="eyebrow">Individuelle Nachhilfe in Leipzig</span>
    <h1>Verstehen statt auswendig lernen.</h1>
    <p>easyIT unterstützt Schülerinnen, Schüler und Studierende in Mathematik, Physik, Chemie und Informatik – persönlich, strukturiert und mit Blick auf echte Fortschritte.</p>
    <div class="hero-actions">
      <a class="button button--gold" href="/kontakt.php">Probestunde anfragen</a>
      <a class="button button--blue" href="#faecher">Fächer entdecken</a>
    </div>
    <div class="stats" aria-label="Leistungsübersicht">
      <div class="stat"><strong>9</strong><span>Fachangebote</span></div>
      <div class="stat"><strong>1:1</strong><span>persönliche Begleitung</span></div>
      <div class="stat"><strong>Leipzig</strong><span>lokal & nah</span></div>
    </div>
  </div>
  <aside class="hero-panel hero-panel--visual">
    <img class="hero-learning-image" src="/assets/img/stud-lern.svg" width="800" height="600" alt="Schülerin lernt gemeinsam mit einem erfahrenen Tutor" loading="eager" fetchpriority="high">
    <h2>Wobei brauchst du Unterstützung?</h2>
    <ul>
      <li>Grundlagen sicher aufbauen</li>
      <li>Wissenslücken gezielt schließen</li>
      <li>Klausuren und Prüfungen vorbereiten</li>
      <li>Abitur oder Studium strukturieren</li>
    </ul>
    <a href="/methodik.php">Meine Methodik kennenlernen →</a>
  </aside>
</section>

<section class="section" id="faecher">
  <header class="section-heading">
    <div><span class="eyebrow">Fächer</span><h2>Nachhilfe, die Zusammenhänge sichtbar macht</h2></div>
    <p>Eigene Fachseiten bündeln Themen, Lernwege, Prüfungsunterstützung und häufige Fragen.</p>
  </header>
  <div class="card-grid">
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="/assets/img/subjects/mathe.svg" width="800" height="560" alt="Mathematik anschaulich lernen" loading="lazy"><h3>Mathematik</h3><p>Von Grundrechenarten bis Analysis, Algebra und Abitur.</p><a href="/mathe-nachhilfe-leipzig.php">Mathe-Nachhilfe Leipzig →</a></article>
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="/assets/img/subjects/physik.svg" width="800" height="560" alt="Physik anschaulich lernen" loading="lazy"><h3>Physik</h3><p>Mechanik, Elektrizitätslehre, Optik und moderne Physik.</p><a href="/physik-nachhilfe-leipzig.php">Physik-Nachhilfe Leipzig →</a></article>
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="/assets/img/subjects/chemie.svg" width="800" height="560" alt="Chemie anschaulich lernen" loading="lazy"><h3>Chemie</h3><p>Stoffe, Reaktionen, Gleichgewichte und organische Chemie.</p><a href="/chemie-nachhilfe-leipzig.php">Chemie-Nachhilfe Leipzig →</a></article>
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="/assets/img/subjects/informatik.svg" width="800" height="560" alt="Informatik anschaulich lernen" loading="lazy"><h3>Informatik</h3><p>Algorithmen, Programmierung, Datenbanken und Netzwerke.</p><a href="/informatik-nachhilfe-leipzig.php">Informatik-Nachhilfe Leipzig →</a></article>
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="/assets/img/subjects/deutsch.svg" width="800" height="560" alt="Deutsch anschaulich lernen" loading="lazy"><h3>Deutsch</h3><p>Grammatik, Textverständnis, Schreiben und Prüfung.</p><a href="/deutsch-nachhilfe-leipzig.php">Deutsch-Nachhilfe Leipzig →</a></article>
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="/assets/img/subjects/englisch.svg" width="800" height="560" alt="Englisch anschaulich lernen" loading="lazy"><h3>Englisch</h3><p>Grammar, vocabulary, writing, speaking und Prüfung.</p><a href="/englisch-nachhilfe-leipzig.php">Englisch-Nachhilfe Leipzig →</a></article>
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="/assets/img/subjects/franzoesisch.svg" width="800" height="560" alt="Sprachen anschaulich lernen" loading="lazy"><h3>Weitere Sprachen</h3><p>Französisch, Spanisch und Latein mit strukturierter Methodik.</p><a href="/faecher.php">Alle Sprachfächer →</a></article>
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="/assets/img/lern-stud.svg" width="800" height="600" alt="Lernende erklärt einen Lösungsweg" loading="lazy"><h3>Alle Fächer</h3><p>Die vollständige Übersicht mit neun Fachangeboten.</p><a href="/faecher.php">Fächerübersicht →</a></article>
  </div>
</section>


<section class="section" id="orientierung">
  <header class="section-heading"><div><span class="eyebrow">easyIT kennenlernen</span><h2>Mehr als eine Fachseite</h2></div><p>Methodik, Ablauf und Haltung transparent erklärt.</p></header>
  <div class="card-grid">
    <article class="card"><h3>Warum easyIT?</h3><p>Was persönliche, verständnisorientierte Nachhilfe auszeichnet.</p><a href="/warum-easyit.php">Mehr erfahren →</a></article>
    <article class="card"><h3>Über mich</h3><p>Fachübergreifender Tutor für Mathematik, Physik, Chemie und Informatik.</p><a href="/ueber-mich.php">Tutor kennenlernen →</a></article>
    <article class="card"><h3>Preise & Ablauf</h3><p>Wie Anfrage, Abstimmung und Unterricht organisiert werden.</p><a href="/preise.php">Ablauf ansehen →</a></article>
    <article class="card"><h3>Erfahrungen</h3><p>Welche Aspekte Lernende in Rückmeldungen hervorheben.</p><a href="/bewertungen.php">Bewertungen lesen →</a></article>
  </div>
</section>

<section class="section faq">
  <header class="section-heading"><div><span class="eyebrow">Häufige Fragen</span><h2>Was Eltern und Lernende wissen möchten</h2></div></header>
  <details><summary>Für welche Klassenstufen ist die Nachhilfe geeignet?</summary><p>Die Förderung kann an Schulform, Klassenstufe, Ausbildung oder Studium angepasst werden.</p></details>
  <details><summary>Wie läuft eine erste Stunde ab?</summary><p>Zunächst werden Ziele, aktueller Stand und konkrete Schwierigkeiten gemeinsam geklärt.</p></details>
  <details><summary>Ist Prüfungsvorbereitung möglich?</summary><p>Ja. Inhalte, Zeitplan, Übungsphasen und typische Aufgaben können gezielt vorbereitet werden.</p></details>
</section>

<section class="section cta">
  <div><span class="eyebrow">Nächster Schritt</span><h2>Unverbindlich kennenlernen</h2><p>Beschreibe kurz Fach, Klassenstufe und aktuelle Herausforderung.</p></div>
  <a class="button button--gold" href="/kontakt.php">Kontakt aufnehmen</a>
</section>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
</main>
</div>
</body>
</html>
