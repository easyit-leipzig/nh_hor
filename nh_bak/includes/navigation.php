<?php
declare(strict_types=1);

function horizontal_menu_items(): array
{
    return [
        ['title'=>'Start','url'=>'/index.php'],
        ['title'=>'Über','url'=>'#','children'=>[
            ['title'=>'Warum easyIT?','url'=>'/warum-easyit.php'],
            ['title'=>'Über mich','url'=>'/ueber-mich.php'],
            ['title'=>'Methodik','url'=>'/methodik.php'],
            ['title'=>'Bewertungen','url'=>'/bewertungen.php'],
        ]],
        ['title'=>'Fächer','url'=>'/faecher.php','children'=>[
            ['title'=>'Naturwissenschaften','url'=>'#','children'=>[
                ['title'=>'Mathematik','url'=>'/mathe-nachhilfe-leipzig.php'],
                ['title'=>'Physik','url'=>'/physik-nachhilfe-leipzig.php'],
                ['title'=>'Chemie','url'=>'/chemie-nachhilfe-leipzig.php'],
                ['title'=>'Informatik','url'=>'/informatik-nachhilfe-leipzig.php'],
            ]],
            ['title'=>'Sprachen','url'=>'#','children'=>[
                ['title'=>'Deutsch','url'=>'/deutsch-nachhilfe-leipzig.php'],
                ['title'=>'Englisch','url'=>'/englisch-nachhilfe-leipzig.php'],
                ['title'=>'Französisch','url'=>'/franzoesisch-nachhilfe-leipzig.php'],
                ['title'=>'Spanisch','url'=>'/spanisch-nachhilfe-leipzig.php'],
                ['title'=>'Latein','url'=>'/latein-nachhilfe-leipzig.php'],
            ]],
            ['title'=>'Gesellschaft','url'=>'#','children'=>[
                ['title'=>'Ethik','url'=>'/ethik-nachhilfe-leipzig.php'],
            ]],
        ]],
        ['title'=>'Schulformen','url'=>'/schulformen.php','children'=>[
            ['title'=>'Grundschule','url'=>'/nachhilfe-grundschule-leipzig.php'],
            ['title'=>'Oberschule','url'=>'/nachhilfe-oberschule-leipzig.php'],
            ['title'=>'Gymnasium','url'=>'/nachhilfe-gymnasium-leipzig.php'],
            ['title'=>'Berufsschule','url'=>'/nachhilfe-berufsschule-leipzig.php'],
            ['title'=>'Abitur','url'=>'/abiturvorbereitung-leipzig.php'],
            ['title'=>'Studium','url'=>'/nachhilfe-studium-leipzig.php'],
        ]],
        ['title'=>'Sonstiges','url'=>'#','children'=>[
            ['title'=>'Leipzig & Stadtteile','url'=>'/nachhilfe-in-leipzig.php'],
            ['title'=>'Lernwerkzeuge','url'=>'/lernwerkzeuge.php'],
            ['title'=>'Lernblog','url'=>'/blog.php'],
            ['title'=>'Preise & Ablauf','url'=>'/preise.php'],
            ['title'=>'FAQ','url'=>'/faq.php'],
            ['title'=>'Jobs','url'=>'/jobs.php'],
            ['title'=>'Sitemap','url'=>'/sitemap.php'],
        ]],
    ];
}

function horizontal_menu_active(array $item): bool
{
    $current = basename((string)($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
    $path = parse_url((string)$item['url'], PHP_URL_PATH);
    if (is_string($path) && basename($path) === $current) return true;
    foreach ($item['children'] ?? [] as $child) if (horizontal_menu_active($child)) return true;
    return false;
}

function render_horizontal_menu(array $items, int $level=1): string
{
    $html = '<ul class="'.($level===1?'menu level-1':'submenu level-'.$level).'">';
    foreach ($items as $item) {
        $children = $item['children'] ?? [];
        $classes = [];
        if ($children) $classes[]='has-submenu';
        if (horizontal_menu_active($item)) $classes[]='is-active';
        $html .= '<li'.($classes?' class="'.implode(' ',$classes).'"':'').'>';
        $html .= '<a href="'.e($item['url']).'"'.($children?' class="submenu-toggle" aria-haspopup="true" aria-expanded="false"':'').'>'.e($item['title']).'</a>';
        if ($children) $html .= render_horizontal_menu($children,$level+1);
        $html .= '</li>';
    }
    return $html.'</ul>';
}
