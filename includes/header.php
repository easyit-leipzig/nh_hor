<?php
declare(strict_types=1);
$site = $site ?? require __DIR__ . '/../config/site.php';
require_once __DIR__ . '/navigation.php';
?>
<a class="skip-link" href="#hauptinhalt">Direkt zum Inhalt</a>
<header class="site-header">
  <div class="header-top">
    <a class="brand" href="/index.php" aria-label="easyIT Nachhilfe Leipzig – Startseite">
      <img src="/assets/img/logo.svg" alt="easyIT Nachhilfe Leipzig" width="300" height="200">
      <span class="brand-copy"><strong>Nachhilfe in Leipzig</strong><small>Mathematik · Physik · Chemie · Informatik</small></span>
    </a>
    <form class="site-search" role="search" action="/sitemap.php" method="get">
      <label class="sr-only" for="siteSearchInput">Website durchsuchen</label>
      <input id="siteSearchInput" name="q" type="search" placeholder="Seite suchen…" autocomplete="off">
      <ul id="siteSearchResults" class="site-search__results" hidden></ul>
    </form>
    <div class="header-actions" aria-label="Schnellzugriff">
      <a class="header-action" href="/kontakt.php"><img src="/assets/icons/contact.svg" alt="" width="30" height="30"><span>Kontakt</span></a>
      <a class="header-action" href="/admin/login.php"><img src="/assets/icons/login.svg" alt="" width="30" height="30"><span>Anmelden</span></a>
      <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="main-navigation"><span></span><span></span><span></span><span class="sr-only">Menü öffnen</span></button>
    </div>
  </div>
  <nav id="main-navigation" class="horizontal-nav" aria-label="Hauptnavigation">
    <?= render_horizontal_menu(horizontal_menu_items()) ?>
  </nav>
</header>
