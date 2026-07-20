<?php
declare(strict_types=1);

require_once __DIR__ . '/database.php';

/**
 * Lädt die aktive Hauptnavigation ausschließlich aus der Datenbank.
 * Es existiert bewusst kein statischer PHP-Fallback: Der sichtbare
 * Menübestand entspricht damit immer dem Inhalt von navigation_items.
 */
function horizontal_menu_items(): array
{
    if (!db_available()) {
        error_log('Navigation konnte nicht geladen werden: Datenbank ist nicht verfügbar.');
        return [];
    }

    try {
        $stmt = db()->query(
            'SELECT id, parent_id, title, url, sort_order, is_active
             FROM navigation_items
             WHERE is_active <> 0
             ORDER BY sort_order, id'
        );
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
        error_log('Navigation konnte nicht aus der Datenbank geladen werden: ' . $e->getMessage());
        return [];
    }

    if (!$rows) {
        error_log('Navigation konnte nicht geladen werden: navigation_items enthält keine aktiven Einträge.');
        return [];
    }

    // Zuerst alle aktiven IDs erfassen. Dadurch können auch ältere Bestände
    // mit parent_id = 0 sowie verwaiste Parent-Verweise sicher verarbeitet werden.
    $activeIds = [];
    foreach ($rows as $row) {
        $activeIds[(int)$row['id']] = true;
    }

    $byParent = [];
    foreach ($rows as $row) {
        $id = (int)$row['id'];
        $rawParent = $row['parent_id'];
        $parentId = ($rawParent === null || (int)$rawParent === 0) ? 0 : (int)$rawParent;

        // Verweist ein aktiver Eintrag auf einen nicht vorhandenen oder inaktiven
        // Parent, wird er nicht unsichtbar, sondern als Haupteintrag ausgegeben.
        if ($parentId !== 0 && !isset($activeIds[$parentId])) {
            error_log('Navigation: Parent ' . $parentId . ' für Eintrag ' . $id . ' fehlt oder ist inaktiv; Eintrag wird auf Hauptebene ausgegeben.');
            $parentId = 0;
        }

        $byParent[$parentId][] = [
            'id' => $id,
            'title' => trim((string)$row['title']),
            'url' => trim((string)$row['url']) !== '' ? (string)$row['url'] : '#',
            'sort_order' => (int)$row['sort_order'],
        ];
    }

    foreach ($byParent as &$siblings) {
        usort($siblings, static fn(array $a, array $b): int =>
            [$a['sort_order'], $a['id']] <=> [$b['sort_order'], $b['id']]
        );
    }
    unset($siblings);

    $build = static function (int $parentId, array $trail = []) use (&$build, $byParent): array {
        $items = [];
        foreach ($byParent[$parentId] ?? [] as $row) {
            $id = (int)$row['id'];
            if (in_array($id, $trail, true)) {
                error_log('Zyklische Navigation erkannt; Eintrag ' . $id . ' wurde übersprungen.');
                continue;
            }

            $item = ['title' => $row['title'], 'url' => $row['url']];
            $children = $build($id, [...$trail, $id]);
            if ($children) {
                $item['children'] = $children;
            }
            $items[] = $item;
        }
        return $items;
    };

    $menu = $build(0);
    if (!$menu) {
        error_log('Navigation: Aktive Datensätze wurden gelesen, aber es konnte keine Hauptebene gebildet werden.');
    }

    return $menu;
}

function horizontal_menu_active(array $item): bool
{
    $current = basename((string)($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
    $path = parse_url((string)$item['url'], PHP_URL_PATH);
    if (is_string($path) && $path !== '' && $path !== '#' && basename($path) === $current) return true;
    foreach ($item['children'] ?? [] as $child) if (horizontal_menu_active($child)) return true;
    return false;
}

function render_horizontal_menu(array $items, int $level=1, string $idPrefix='menu'): string
{
    $html = '<ul class="'.($level===1?'menu level-1':'submenu level-'.$level).'">';
    foreach ($items as $index => $item) {
        $children = $item['children'] ?? [];
        $classes = [];
        if ($children) $classes[]='has-submenu';
        if (horizontal_menu_active($item)) $classes[]='is-active';
        $submenuId = $idPrefix.'-'.$level.'-'.$index;
        $html .= '<li'.($classes?' class="'.implode(' ',$classes).'"':'').'>';

        if ($children) {
            $html .= '<div class="menu-entry">';
            if ((string)$item['url'] !== '#') {
                $html .= '<a class="menu-link" href="'.e($item['url']).'">'.e($item['title']).'</a>';
                $html .= '<button class="submenu-button" type="button" aria-expanded="false" aria-controls="'.e($submenuId).'" aria-label="Untermenü '.e($item['title']).' öffnen"><span aria-hidden="true">▾</span></button>';
            } else {
                $html .= '<button class="submenu-button submenu-button--label" type="button" aria-expanded="false" aria-controls="'.e($submenuId).'">'.e($item['title']).'<span aria-hidden="true">▾</span></button>';
            }
            $html .= '</div>';
            $html .= '<div id="'.e($submenuId).'" class="submenu-panel">'.render_horizontal_menu($children,$level+1,$submenuId).'</div>';
        } else {
            $html .= '<a class="menu-link" href="'.e($item['url']).'">'.e($item['title']).'</a>';
        }
        $html .= '</li>';
    }
    return $html.'</ul>';
}
