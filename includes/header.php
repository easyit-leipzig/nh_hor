<?php
declare(strict_types=1);

$site = $site ?? require __DIR__ . '/../config/site.php';
require_once __DIR__ . '/navigation.php';
require_once __DIR__ . '/internal-auth.php';

$currentInternalUser = internal_user(false);
?>
<a class="skip-link" href="#hauptinhalt">Direkt zum Inhalt</a>

<header class="site-header easyit-header">
    <div class="header-top">
        <div class="brand easyit-brand">
            <a class="easyit-brand__logo-link"
               href="<?= e(app_path('/index.php')) ?>"
               aria-label="easyIT Nachhilfe Leipzig – Startseite">
                <img src="<?= e(app_path('/assets/img/brand-logo.svg')) ?>"
                     alt="easyIT Nachhilfe Leipzig"
                     width="200"
                     height="120"
                     decoding="async">
            </a>

            <div class="brand-copy easyit-brand__copy">
                <h1>
                    <a class="easyit-brand__home-link"
                       href="<?= e(app_path('/index.php')) ?>">
                        Nachhilfe mit System
                    </a>
                </h1>
                <h2>
                    Nachhilfe mit
                    <a class="easyit-brand__success-link"
                       href="<?= e(app_path('/bewertungen.php')) ?>">
                        Erfolg
                    </a>
                </h2>
            </div>
        </div>

        <form class="site-search"
              role="search"
              action="<?= e(app_path('/suche.php')) ?>"
              method="get">
            <label class="sr-only" for="siteSearchInput">Website durchsuchen</label>
            <input id="siteSearchInput"
                   name="q"
                   type="search"
                   placeholder="Seite suchen…"
                   autocomplete="off">
            <ul id="siteSearchResults"
                class="site-search__results"
                hidden></ul>
        </form>

        <div class="header-actions" aria-label="Schnellzugriff">
            <a class="header-action"
               href="<?= e(app_path('/kontakt.php')) ?>">
                <img src="<?= e(app_path('/assets/icons/contact.svg')) ?>"
                     alt=""
                     width="30"
                     height="30">
                <span>Kontakt</span>
            </a>

            <?php if ($currentInternalUser): ?>
                <a class="header-action"
                   href="<?= e(internal_start_path($currentInternalUser)) ?>">
                    <img src="<?= e(app_path('/assets/icons/login.svg')) ?>"
                         alt=""
                         width="30"
                         height="30">
                    <span>Mein Bereich</span>
                </a>
            <?php else: ?>
                <a class="header-action"
                   href="<?= e(app_path('/intern/login.php')) ?>">
                    <img src="<?= e(app_path('/assets/icons/login.svg')) ?>"
                         alt=""
                         width="30"
                         height="30">
                    <span>Anmelden</span>
                </a>
            <?php endif; ?>

            <button class="menu-toggle"
                    type="button"
                    aria-expanded="false"
                    aria-controls="main-navigation">
                <span></span>
                <span></span>
                <span></span>
                <span class="sr-only">Menü öffnen</span>
            </button>
        </div>
    </div>

    <style nonce="<?= e(security_csp_nonce()) ?>">
        .easyit-header .header-top {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .easyit-brand {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            min-width: 0;
        }

        .easyit-brand__logo-link {
            display: flex;
            align-items: center;
            flex: 0 0 auto;
            text-decoration: none;
        }

        .site-header .easyit-brand__logo-link > img,
        .site-header .brand img {
            width: auto !important;
            height: 120px !important;
            max-width: 200px !important;
            max-height: 120px !important;
            flex: 0 0 auto !important;
            object-fit: contain !important;
        }

        .easyit-brand__copy {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
            line-height: 1.08;
        }

        .easyit-brand__copy h1,
        .easyit-brand__copy h2 {
            margin: 0;
            padding: 0;
            white-space: nowrap;
        }

        .easyit-brand__copy h1 {
            font-size: clamp(1.65rem, 2.5vw, 2.35rem);
            font-weight: 800;
        }

        .easyit-brand__copy h2 {
            margin-top: .35rem;
            font-size: clamp(1.1rem, 1.7vw, 1.45rem);
            font-weight: 600;
        }

        .easyit-brand__home-link {
            color: inherit;
            text-decoration: none;
        }

        .easyit-brand__success-link {
            color: inherit;
            font: inherit;
            text-decoration: underline;
            text-decoration-thickness: .08em;
            text-underline-offset: .16em;
        }

        .site-search {
            margin-left: auto;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: .65rem;
        }

        .horizontal-nav {
            background: linear-gradient(180deg, #0067b8 0%, #0057a4 100%) !important;
            border-top: 1px solid rgba(255,255,255,.18) !important;
            border-bottom: 2px solid var(--gold, #ffd500) !important;
        }

        @media (max-width: 1000px) {
            .easyit-header .header-top {
                flex-wrap: wrap;
            }

            .site-search {
                order: 3;
                width: 100%;
                margin-left: 0;
            }
        }

        @media (max-width: 760px) {
            .easyit-brand {
                gap: .75rem;
            }

            .easyit-brand__copy h1 {
                font-size: 1.25rem;
            }

            .easyit-brand__copy h2 {
                font-size: 1rem;
            }

            .easyit-brand__copy h1,
            .easyit-brand__copy h2 {
                white-space: normal;
            }
        }
    </style>

    <nav id="main-navigation"
         class="horizontal-nav"
         aria-label="Hauptnavigation">
        <?= render_horizontal_menu(horizontal_menu_items()) ?>
    </nav>
</header>
