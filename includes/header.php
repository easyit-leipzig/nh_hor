<?php
declare(strict_types=1);
$site = $site ?? require __DIR__ . '/../config/site.php';
require_once __DIR__ . '/navigation.php';
?>
<a class="skip-link" href="#hauptinhalt">Direkt zum Inhalt</a>
<header class="site-header">
  <div class="header-top">
    <a class="brand" href="<?= e(app_path('/index.php')) ?>" aria-label="easyIT Nachhilfe Leipzig – Startseite">
      <img src="<?= e(app_path('/assets/img/brand-logo.svg')) ?>" alt="easyIT Nachhilfe Leipzig" width="480" height="360" decoding="async">
      <span class="brand-copy">
        <strong>Nachhilfe in Leipzig</strong>
        <small>Naturwissenschaften, Sprachen, Soziales</small>
      </span>
    </a>
    <form class="site-search" role="search" action="<?= e(app_path('/suche.php')) ?>" method="get">
      <label class="sr-only" for="siteSearchInput">Website durchsuchen</label>
      <input id="siteSearchInput" name="q" type="search" placeholder="Seite suchen…" autocomplete="off">
      <ul id="siteSearchResults" class="site-search__results" hidden></ul>
    </form>
    <div class="header-actions" aria-label="Schnellzugriff">
      <a class="header-action" href="<?= e(app_path('/kontakt.php')) ?>"><img src="<?= e(app_path('/assets/icons/contact.svg')) ?>" alt="" width="30" height="30"><span>Kontakt</span></a>
      <a class="header-action" href="<?= e(app_path('/admin/login.php')) ?>"><img src="<?= e(app_path('/assets/icons/login.svg')) ?>" alt="" width="30" height="30"><span>Anmelden</span></a>
      <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="main-navigation"><span></span><span></span><span></span><span class="sr-only">Menü öffnen</span></button>
    </div>
  </div>

  <style nonce="<?= e(security_csp_nonce()) ?>">
    .horizontal-nav {
      background: linear-gradient(180deg, #0067b8 0%, #0057a4 100%) !important;
      border-top: 1px solid rgba(255,255,255,.18) !important;
      border-bottom: 2px solid var(--gold, #ffd500) !important;
    }
  </style>

  <nav id="main-navigation" class="horizontal-nav" aria-label="Hauptnavigation">
    <?= render_horizontal_menu(horizontal_menu_items()) ?>
  </nav>
</header>
