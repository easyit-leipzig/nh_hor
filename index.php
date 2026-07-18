<?php
declare(strict_types=1);

/**
 * easyIT-Startseite
 * Nur diese Seite wurde vom statischen HTML-Stand auf das DB-Menü umgestellt.
 * Erwartete Tabelle: menu_items
 */

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $config = require __DIR__ . '/config/database.php';
    $pdo = new PDO(
        $config['dsn'],
        $config['user'],
        $config['password'],
        $config['options']
    );

    return $pdo;
}

/** @return array<int,array<string,mixed>> */
function loadMenuTree(): array
{
    $sql = <<<'SQL'
        SELECT
            id,
            parent_id,
            title,
            url,
            target,
            css_class,
            sort_order
        FROM menu_items
        WHERE is_active = 1
        ORDER BY
            COALESCE(parent_id, 0),
            sort_order,
            id
    SQL;

    $rows = db()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $itemsByParent = [];

    foreach ($rows as $row) {
        $row['id'] = (int) $row['id'];
        $row['parent_id'] = $row['parent_id'] === null ? null : (int) $row['parent_id'];
        $row['children'] = [];
        $parentKey = $row['parent_id'] ?? 0;
        $itemsByParent[$parentKey][] = $row;
    }

    $build = static function (int $parentId, int $level = 1) use (&$build, &$itemsByParent): array {
        if ($level > 3) {
            return [];
        }

        $items = $itemsByParent[$parentId] ?? [];

        // Kontakt und Anmelden bleiben bewusst als Kopfzeilen-Aktionen
        // außerhalb des horizontalen Hauptmenüs.
        if ($level === 1) {
            $items = array_values(array_filter(
                $items,
                static function (array $item): bool {
                    $title = mb_strtolower(trim((string) ($item['title'] ?? '')), 'UTF-8');
                    return !in_array($title, ['kontakt', 'anmelden', 'login'], true);
                }
            ));
        }

        foreach ($items as &$item) {
            $item['children'] = $build((int) $item['id'], $level + 1);
        }
        unset($item);

        return $items;
    };

    return $build(0);
}

function menuItemIsActive(array $item): bool
{
    $currentPage = basename((string) ($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
    $path = parse_url((string) ($item['url'] ?? ''), PHP_URL_PATH);

    if (is_string($path) && $path !== '' && basename($path) === $currentPage) {
        return true;
    }

    foreach ($item['children'] ?? [] as $child) {
        if (menuItemIsActive($child)) {
            return true;
        }
    }

    return false;
}

function renderMenu(array $items, int $level = 1): string
{
    $listClass = $level === 1
        ? 'menu level-1'
        : 'submenu level-' . $level;

    $html = '<ul class="' . e($listClass) . '">';

    foreach ($items as $item) {
        $children = $item['children'] ?? [];
        $hasChildren = $children !== [];
        $isActive = menuItemIsActive($item);
        $classes = [];

        if ($hasChildren) {
            $classes[] = 'has-submenu';
        }
        if ($isActive) {
            $classes[] = 'is-active';
        }
        if (!empty($item['css_class'])) {
            $safeClass = preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $item['css_class']);
            if ($safeClass !== '') {
                $classes[] = $safeClass;
            }
        }

        $classAttribute = $classes ? ' class="' . e(implode(' ', $classes)) . '"' : '';
        $url = trim((string) ($item['url'] ?? '#')) ?: '#';
        $title = (string) ($item['title'] ?? 'Menüpunkt');
        $target = ($item['target'] ?? '_self') === '_blank'
            ? ' target="_blank" rel="noopener noreferrer"'
            : '';

        $html .= '<li' . $classAttribute . '>';

        if ($hasChildren) {
            /*
             * Ein einziges Bedienelement pro Menüpunkt:
             * Titel und Dreieck werden gemeinsam im selben Link ausgegeben.
             */
            $html .= '<a class="submenu-toggle" href="' . e($url) . '"' . $target
                . ' aria-expanded="false" aria-haspopup="true">'
                . e($title) . '</a>';
        } else {
            $ariaCurrent = $isActive ? ' aria-current="page"' : '';
            $html .= '<a href="' . e($url) . '"' . $target . $ariaCurrent . '>' . e($title) . '</a>';
        }

        if ($hasChildren) {
            $html .= renderMenu($children, $level + 1);
        }

        $html .= '</li>';
    }

    return $html . '</ul>';
}

$menuError = null;
$menuItems = [];

try {
    $menuItems = loadMenuTree();
    if ($menuItems === []) {
        $menuError = 'In der Tabelle menu_items sind keine aktiven Hauptmenüpunkte vorhanden.';
    }
} catch (Throwable $exception) {
    $menuError = 'Das Menü konnte nicht aus der Datenbank geladen werden.';
}
?>
<!doctype html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="easyIT Nachhilfe Leipzig – Mathematik, Physik, Chemie und Informatik.">
  <title>easyIT Nachhilfe Leipzig</title>
  <link rel="stylesheet" href="css/main.css">
  <script src="js/menu.js" defer></script>
</head>
<body>
  <header class="site-header">
    <div class="header-top">
      <a class="brand" href="index.php" aria-label="easyIT Startseite">
        <span class="brand-logo" aria-hidden="true">e<span>IT</span></span>
        <span class="brand-text">
          <strong>easyIT Nachhilfe</strong>
          <small>Verstehen. Anwenden. Weiterkommen.</small>
        </span>
      </a>

      <div class="header-title">
        <h1>Nachhilfe in Leipzig</h1>
        <p>Mathematik · Physik · Chemie · Informatik</p>
      </div>

      <div class="header-actions" aria-label="Schnellzugriff">
        <a class="header-action" href="/nh_seo/kontakt.php">
          <img src="assets/icons/contact.svg" alt="" width="30" height="30" aria-hidden="true">
          <span>Kontakt</span>
        </a>
        <a class="header-action" href="/nh_seo/login.php">
          <img src="assets/icons/login.svg" alt="" width="30" height="30" aria-hidden="true">
          <span>Anmelden</span>
        </a>
      </div>

    </div>

    <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="main-navigation">
      <span></span><span></span><span></span>
      <span class="sr-only">Menü öffnen</span>
    </button>

    <nav id="main-navigation" class="main-nav" aria-label="Hauptnavigation">
      <?php if ($menuError !== null): ?>
        <p class="menu-error"><?= e($menuError) ?></p>
      <?php else: ?>
        <?= renderMenu($menuItems) ?>
      <?php endif; ?>
    </nav>
  </header>

  <main>
    <section class="hero">
      <div>
        <span class="eyebrow">Individuelle Nachhilfe in Leipzig</span>
        <h2>Verstehen beginnt mit dem richtigen Lösungsweg.</h2>
        <p>Persönliche Unterstützung in Mathematik, Physik, Chemie und Informatik – vom sicheren Fundament bis zur anspruchsvollen Prüfung.</p>
        <div class="hero-actions">
          <a class="primary-button" href="/nh_seo/kontakt.php">Kennenlerngespräch</a>
          <a class="secondary-button" href="/nh_seo/faecher.php">Fächer entdecken</a>
        </div>
      </div>
      <div class="hero-card" aria-label="Unterrichtsschwerpunkte">
        <strong>Unterricht mit System</strong>
        <ul>
          <li>Lösungswege nachvollziehbar entwickeln</li>
          <li>Schriftlich und strukturiert arbeiten</li>
          <li>Wissen sicher anwenden</li>
        </ul>
      </div>
    </section>

    <section id="faecher" class="content-grid">
      <article><h3>Mathematik</h3><p>Von Grundlagen bis Abitur und Studium.</p></article>
      <article><h3>Physik</h3><p>Zusammenhänge erkennen statt Formeln auswendig lernen.</p></article>
      <article><h3>Chemie</h3><p>Modelle, Reaktionswege und Berechnungen verständlich erklärt.</p></article>
      <article><h3>Informatik</h3><p>Algorithmen, Programmierung und technische Grundlagen.</p></article>
    </section>
  </main>

  <footer>
    <p>© 2026 easyIT Nachhilfe Leipzig</p>
  </footer>
</body>
</html>
