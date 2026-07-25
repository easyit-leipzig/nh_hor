<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/index-content.php';
require __DIR__ . '/includes/homepage_blocks.php';
$site = require __DIR__ . '/config/site.php';
$pageTitle = 'Nachhilfe Leipzig für Mathe, Physik, Chemie & Informatik | easyIT';
$pageDescription = 'Persönliche Nachhilfe in Leipzig für Mathematik, Physik, Chemie und Informatik. Individuelle Förderung, Prüfungsvorbereitung und verständliche Erklärungen.';
$pageCanonical = canonical_url($site, '/');
?><!doctype html>
<html lang="de" data-theme="leipzig-blau">
<head>
<?php require __DIR__ . '/includes/meta.php'; ?>
<link rel="stylesheet" href="<?= e(app_path('/assets/css/home-reviews.css')) ?>">
<link rel="stylesheet" href="<?= e(app_path('/assets/css/learning-images.css')) ?>">
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt">
<div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><span aria-current="page">Startseite</span></nav>
<?php render_homepage_blocks(); ?>

<?php render_index_content(1, 'before'); ?>
<?php if (!index_content_has_replace(1)): ?>
<section class="hero">
  <div>
    <span class="eyebrow">Individuelle Nachhilfe in Leipzig</span>
    <h1>Verstehen statt auswendig lernen.</h1>
    <p>easyIT unterstützt Schülerinnen, Schüler und Studierende in Mathematik, Physik, Chemie und Informatik – persönlich, strukturiert und mit Blick auf echte Fortschritte.</p>
    <div class="hero-actions">
      <a class="button button--gold" href="<?= e(app_path('/kontakt.php')) ?>">Probestunde anfragen</a>
      <a class="button button--blue" href="#faecher">Fächer entdecken</a>
    </div>
    <div class="stats" aria-label="Leistungsübersicht">
      <div class="stat"><strong>9</strong><span>Fachangebote</span></div>
      <div class="stat"><strong>1:1</strong><span>persönliche Begleitung</span></div>
      <div class="stat"><strong>Leipzig</strong><span>lokal & nah</span></div>
    </div>
  </div>
  <aside class="hero-panel hero-panel--visual hero-slider" aria-label="Einblicke in unsere Nachhilfe">
    <div class="hero-slider__stage">
      <figure class="hero-slider__slide is-active">
        <img src="<?= e(app_path('/assets/img/learning/nachhilfe-persoenlich-01.webp')) ?>" width="1024" height="1024" alt="Tutorin lernt gemeinsam mit einem Schüler" loading="eager" fetchpriority="high">
      </figure>
      <figure class="hero-slider__slide">
        <img src="<?= e(app_path('/assets/img/learning/nachhilfe-erfahrung-09.webp')) ?>" width="1024" height="1024" alt="Erfahrener Tutor unterstützt eine Schülerin" loading="lazy">
      </figure>
      <figure class="hero-slider__slide">
        <img src="<?= e(app_path('/assets/img/learning/informatik-nachhilfe.webp')) ?>" width="1024" height="1024" alt="Informatik-Nachhilfe am Computer" loading="lazy">
      </figure>
      <figure class="hero-slider__slide">
        <img src="<?= e(app_path('/assets/img/learning/abitur-pruefungsvorbereitung.webp')) ?>" width="1024" height="1024" alt="Vorbereitung auf Abitur und Prüfungen" loading="lazy">
      </figure>
      <figure class="hero-slider__slide">
        <img src="<?= e(app_path('/assets/img/learning/physik-experiment.webp')) ?>" width="1024" height="1024" alt="Anschauliches Modell für Physik und Chemie" loading="lazy">
      </figure>
    </div>
    <div class="hero-slider__overlay">
      <span>Persönlich begleitet</span>
      <h2>Wobei brauchst du Unterstützung?</h2>
      <ul>
        <li>Grundlagen sicher aufbauen</li>
        <li>Wissenslücken gezielt schließen</li>
        <li>Klausuren und Prüfungen vorbereiten</li>
        <li>Abitur oder Studium strukturieren</li>
      </ul>
      <a href="<?= e(app_path('/methodik.php')) ?>">Unsere Methodik kennenlernen →</a>
    </div>
    <div class="hero-slider__controls" aria-label="Bildauswahl">
      <button type="button" class="hero-slider__button hero-slider__button--prev" aria-label="Vorheriges Bild">‹</button>
      <div class="hero-slider__dots" role="tablist" aria-label="Bilder">
        <button type="button" class="is-active" aria-label="Bild 1 anzeigen"></button>
        <button type="button" aria-label="Bild 2 anzeigen"></button>
        <button type="button" aria-label="Bild 3 anzeigen"></button>
        <button type="button" aria-label="Bild 4 anzeigen"></button>
        <button type="button" aria-label="Bild 5 anzeigen"></button>
      </div>
      <button type="button" class="hero-slider__button hero-slider__button--next" aria-label="Nächstes Bild">›</button>
      <button type="button" class="hero-slider__pause" aria-pressed="false">Pause</button>
    </div>
  </aside>
</section>
<?php else: render_index_content(1, 'replace'); endif; ?>
<?php render_index_content(1, 'after'); ?>

<?php render_index_content(2, 'before'); ?>
<?php if (!index_content_has_replace(2)): ?>
<section class="section" id="faecher">
  <header class="section-heading">
    <div><span class="eyebrow">Fächer</span><h2>Nachhilfe, die Zusammenhänge sichtbar macht</h2></div>
    <p>Eigene Fachseiten bündeln Themen, Lernwege, Prüfungsunterstützung und häufige Fragen.</p>
  </header>
  <div class="card-grid">
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="<?= e(app_path('/assets/img/learning/mathematik-arbeitsmaterial.webp')) ?>" width="800" height="560" alt="Mathematik anschaulich lernen" loading="lazy"><h3>Mathematik</h3><p>Von Grundrechenarten bis Analysis, Algebra und Abitur.</p><a href="<?= e(app_path('/mathe-nachhilfe-leipzig.php')) ?>">Mathe-Nachhilfe Leipzig →</a></article>
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="<?= e(app_path('/assets/img/learning/physik-experiment.webp')) ?>" width="800" height="560" alt="Physik anschaulich lernen" loading="lazy"><h3>Physik</h3><p>Mechanik, Elektrizitätslehre, Optik und moderne Physik.</p><a href="<?= e(app_path('/physik-nachhilfe-leipzig.php')) ?>">Physik-Nachhilfe Leipzig →</a></article>
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="<?= e(app_path('/assets/img/learning/physik-chemie-experiment.webp')) ?>" width="800" height="560" alt="Chemie anschaulich lernen" loading="lazy"><h3>Chemie</h3><p>Stoffe, Reaktionen, Gleichgewichte und organische Chemie.</p><a href="<?= e(app_path('/chemie-nachhilfe-leipzig.php')) ?>">Chemie-Nachhilfe Leipzig →</a></article>
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="<?= e(app_path('/assets/img/learning/informatik-nachhilfe.webp')) ?>" width="800" height="560" alt="Informatik anschaulich lernen" loading="lazy"><h3>Informatik</h3><p>Algorithmen, Programmierung, Datenbanken und Netzwerke.</p><a href="<?= e(app_path('/informatik-nachhilfe-leipzig.php')) ?>">Informatik-Nachhilfe Leipzig →</a></article>
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="<?= e(app_path('/assets/img/learning/grundschule-lernen.webp')) ?>" width="800" height="560" alt="Deutsch anschaulich lernen" loading="lazy"><h3>Deutsch</h3><p>Grammatik, Textverständnis, Schreiben und Prüfung.</p><a href="<?= e(app_path('/deutsch-nachhilfe-leipzig.php')) ?>">Deutsch-Nachhilfe Leipzig →</a></article>
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="<?= e(app_path('/assets/img/learning/grundschule-gruppe.webp')) ?>" width="800" height="560" alt="Englisch anschaulich lernen" loading="lazy"><h3>Englisch</h3><p>Grammar, vocabulary, writing, speaking und Prüfung.</p><a href="<?= e(app_path('/englisch-nachhilfe-leipzig.php')) ?>">Englisch-Nachhilfe Leipzig →</a></article>
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="<?= e(app_path('/assets/img/learning/nachhilfe-beratung-08.webp')) ?>" width="800" height="560" alt="Sprachen anschaulich lernen" loading="lazy"><h3>Weitere Sprachen</h3><p>Französisch, Spanisch und Latein mit strukturierter Methodik.</p><a href="<?= e(app_path('/faecher.php')) ?>">Alle Sprachfächer →</a></article>
    <article class="card subject-card subject-card--visual"><img class="subject-card__image" src="<?= e(app_path('/assets/img/learning/abitur-pruefungsvorbereitung.webp')) ?>" width="800" height="600" alt="Lernende erklärt einen Lösungsweg" loading="lazy"><h3>Alle Fächer</h3><p>Die vollständige Übersicht mit neun Fachangeboten.</p><a href="<?= e(app_path('/faecher.php')) ?>">Fächerübersicht →</a></article>
  </div>
</section>
<?php else: render_index_content(2, 'replace'); endif; ?>
<?php render_index_content(2, 'after'); ?>

<?php render_index_content(3, 'before'); ?>
<?php if (!index_content_has_replace(3)): ?>
<section class="section" id="orientierung">
  <header class="section-heading"><div><span class="eyebrow">easyIT kennenlernen</span><h2>Mehr als eine Fachseite</h2></div><p>Methodik, Ablauf und Haltung transparent erklärt.</p></header>
  <div class="card-grid">
    <article class="card"><h3>Warum easyIT?</h3><p>Was persönliche, verständnisorientierte Nachhilfe auszeichnet.</p><a href="<?= e(app_path('/warum-easyit.php')) ?>">Mehr erfahren →</a></article>
    <article class="card"><h3>Tutorenteam</h3><p>Fachübergreifende Unterstützung in Mathematik, Physik, Chemie, Informatik und weiteren Fächern.</p><a href="<?= e(app_path('/ueber-mich.php')) ?>">Tutorenteam kennenlernen →</a></article>
    <article class="card"><h3>Preise & Ablauf</h3><p>Wie Anfrage, Abstimmung und Unterricht organisiert werden.</p><a href="<?= e(app_path('/preise.php')) ?>">Ablauf ansehen →</a></article>
    <article class="card"><h3>Erfahrungen</h3><p>Welche Aspekte Lernende und Eltern in Rückmeldungen hervorheben.</p><a href="<?= e(app_path('/bewertungen.php')) ?>">Bewertungen lesen →</a></article>
  </div>
</section>
<?php else: render_index_content(3, 'replace'); endif; ?>
<?php render_index_content(3, 'after'); ?>

<section class="section home-reviews" id="bewertungen">
  <header class="section-heading home-reviews__heading">
    <div>
      <span class="eyebrow">Echte Rückmeldungen</span>
      <h2>Was Lernende und Eltern besonders schätzen</h2>
    </div>
    <p>Die Aussagen beruhen auf tatsächlich vorliegenden Bewertungen. Sie wurden teilweise gekürzt und anonymisiert, ohne ihre Kernaussage zu verändern.</p>
  </header>

  <div class="home-reviews__summary" aria-label="Häufig genannte Stärken">
    <div><strong>Individuell</strong><span>vorbereitete Aufgaben</span></div>
    <div><strong>Verständlich</strong><span>mehrere Erklärungswege</span></div>
    <div><strong>Strukturiert</strong><span>klarer Stundenablauf</span></div>
    <div><strong>Wirksam</strong><span>belegte Verbesserungen</span></div>
  </div>

  <div class="home-reviews__grid">
    <article class="home-review home-review--featured">
      <div class="home-review__stars" aria-label="5 von 5 Sternen">★★★★★</div>
      <blockquote>„Unser Sohn geht nun fast ein Jahr zur Mathematik-Nachhilfe. Er hat sich um zwei Noten verbessert. Für uns eine klare Weiterempfehlung.“</blockquote>
      <footer><strong>Eltern eines Schülers</strong><span>Mathematik</span></footer>
    </article>

    <article class="home-review">
      <div class="home-review__stars" aria-label="5 von 5 Sternen">★★★★★</div>
      <blockquote>„Beide Töchter beschreiben den Unterricht unabhängig voneinander als besonders geduldig. Seit Beginn der Nachhilfe haben sich ihre Noten verbessert.“</blockquote>
      <footer><strong>Mutter zweier Schülerinnen</strong><span>Mathematik</span></footer>
    </article>

    <article class="home-review">
      <div class="home-review__stars" aria-label="5 von 5 Sternen">★★★★★</div>
      <blockquote>„Der Unterricht ist gut strukturiert und effektiv. Man kann so oft nachfragen, wie man möchte, und das Problem wird jedes Mal neu erklärt.“</blockquote>
      <footer><strong>Verifizierte Online-Bewertung</strong><span>Juni 2026</span></footer>
    </article>
  </div>

  <div class="home-reviews__details">
    <article>
      <span>01</span>
      <div><h3>Vorbereitet statt improvisiert</h3><p>Aufgaben orientieren sich am Lernstand, den aktuellen Schulthemen und dem individuellen Arbeitstempo.</p></div>
    </article>
    <article>
      <span>02</span>
      <div><h3>Eigene Lösungswege zählen</h3><p>Vorschläge der Lernenden werden aufgenommen, geprüft und in die gemeinsame Lösungsfindung einbezogen.</p></div>
    </article>
    <article>
      <span>03</span>
      <div><h3>Fortschritt wird reflektiert</h3><p>Am Ende der Stunde wird zusammengefasst, was verstanden wurde und woran als Nächstes gearbeitet wird.</p></div>
    </article>
  </div>

  <div class="home-reviews__actions">
    <a class="button button--blue" href="<?= e(app_path('/bewertungen.php')) ?>">Alle Bewertungen lesen</a>
    <a class="button button--gold" href="<?= e(app_path('/kontakt.php')) ?>">Tutorenteam kennenlernen</a>
  </div>
  <p class="home-reviews__note">Lernerfolge sind individuell und können nicht garantiert werden.</p>
</section>


<section class="section learning-gallery" id="lernwelten">
  <header class="section-heading">
    <div><span class="eyebrow">Lernwelten bei easyIT</span><h2>Unterstützung für unterschiedliche Lernphasen</h2></div>
    <p>Die neuen Motive zeigen die Bandbreite von Grundschule und Einzelunterricht bis zu Oberstufe, Studium und fachlicher Prüfungsvorbereitung.</p>
  </header>
  <div class="learning-gallery__grid">
    <figure class="learning-gallery__item learning-gallery__item--wide">
      <img src="<?= e(app_path('/assets/img/learning/grundschule-lernen.webp')) ?>" width="1024" height="1024" alt="Grundschulkinder lernen gemeinsam mit einer Lehrkraft" loading="lazy">
      <figcaption><strong>Grundschule</strong><span>Ruhiger Einstieg und altersgerechte Förderung</span></figcaption>
    </figure>
    <figure class="learning-gallery__item">
      <img src="<?= e(app_path('/assets/img/learning/nachhilfe-schueler-05.webp')) ?>" width="1024" height="1024" alt="Tutor arbeitet gemeinsam mit einem Schüler" loading="lazy">
      <figcaption><strong>Einzelunterricht</strong><span>Persönliche Begleitung im eigenen Tempo</span></figcaption>
    </figure>
    <figure class="learning-gallery__item">
      <img src="<?= e(app_path('/assets/img/learning/nachhilfe-studium-03.webp')) ?>" width="1024" height="1024" alt="Tutorin erklärt einer Studentin einen Lösungsweg" loading="lazy">
      <figcaption><strong>Oberstufe & Studium</strong><span>Komplexe Inhalte gemeinsam strukturieren</span></figcaption>
    </figure>
    <figure class="learning-gallery__item">
      <img src="<?= e(app_path('/assets/img/learning/nachhilfe-tafel-06.webp')) ?>" width="1024" height="1024" alt="Tutor und Studentin besprechen eine Aufgabe an der Tafel" loading="lazy">
      <figcaption><strong>Verstehen</strong><span>Lösungswege sichtbar und nachvollziehbar machen</span></figcaption>
    </figure>
    <figure class="learning-gallery__item learning-gallery__item--wide">
      <img src="<?= e(app_path('/assets/img/learning/abitur-pruefungsvorbereitung.webp')) ?>" width="1024" height="1024" alt="Vorbereitung auf Abitur und Prüfungen" loading="lazy">
      <figcaption><strong>Abitur & Prüfung</strong><span>Gezielt üben, sicher anwenden, vorbereitet starten</span></figcaption>
    </figure>
    <figure class="learning-gallery__item">
      <img src="<?= e(app_path('/assets/img/learning/nachhilfe-team-02.webp')) ?>" width="1024" height="1024" alt="Zwei Tutorinnen im fachlichen Austausch" loading="lazy">
      <figcaption><strong>Tutorenteam</strong><span>Fachlicher Austausch und abgestimmte Unterstützung</span></figcaption>
    </figure>
  </div>
</section>

<?php render_index_content(4, 'before'); ?>
<?php if (!index_content_has_replace(4)): ?>
<section class="section faq">
  <header class="section-heading"><div><span class="eyebrow">Häufige Fragen</span><h2>Was Eltern und Lernende wissen möchten</h2></div></header>
  <details><summary>Für welche Klassenstufen ist die Nachhilfe geeignet?</summary><p>Die Förderung kann an Schulform, Klassenstufe, Ausbildung oder Studium angepasst werden.</p></details>
  <details><summary>Wie läuft eine erste Stunde ab?</summary><p>Zunächst werden Ziele, aktueller Stand und konkrete Schwierigkeiten gemeinsam geklärt.</p></details>
  <details><summary>Ist Prüfungsvorbereitung möglich?</summary><p>Ja. Inhalte, Zeitplan, Übungsphasen und typische Aufgaben können gezielt vorbereitet werden.</p></details>
</section>
<?php else: render_index_content(4, 'replace'); endif; ?>
<?php render_index_content(4, 'after'); ?>

<?php render_index_content(5, 'before'); ?>
<?php if (!index_content_has_replace(5)): ?>
<section class="section cta">
  <div><span class="eyebrow">Nächster Schritt</span><h2>Unverbindlich kennenlernen</h2><p>Beschreibe kurz Fach, Klassenstufe und aktuelle Herausforderung.</p></div>
  <a class="button button--gold" href="<?= e(app_path('/kontakt.php')) ?>">Kontakt aufnehmen</a>
</section>
<?php else: render_index_content(5, 'replace'); endif; ?>
<?php render_index_content(5, 'after'); ?>
<?php render_index_content(6, 'before'); ?>
<?php render_index_content(6, 'replace'); ?>
<?php render_index_content(6, 'after'); ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
</main>
</div>
<script src="<?= e(app_path('/assets/js/learning-slider.js')) ?>" defer></script>
</body>
</html>
