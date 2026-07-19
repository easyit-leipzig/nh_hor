<?php
declare(strict_types=1);

function horizontal_menu_items(): array
{
    return [
        ['title'=>'Start','url'=>'/nh_hor/index.php'],
        ['title'=>'Über','url'=>'#','children'=>[
            ['title'=>'Warum easyIT?','url'=>'/nh_hor/warum-easyit.php'],
            ['title'=>'Über mich','url'=>'/nh_hor/ueber-mich.php'],
            ['title'=>'Methodik','url'=>'/nh_hor/methodik.php'],
            ['title'=>'Bewertungen','url'=>'/nh_hor/bewertungen.php'],
        ]],
        ['title'=>'Fächer','url'=>'/nh_hor/faecher.php','children'=>[
            ['title'=>'Naturwissenschaften','url'=>'#','children'=>[
                ['title'=>'Mathematik','url'=>'/nh_hor/mathe-nachhilfe-leipzig.php'],
                ['title'=>'Physik','url'=>'/nh_hor/physik-nachhilfe-leipzig.php'],
                ['title'=>'Chemie','url'=>'/nh_hor/chemie-nachhilfe-leipzig.php'],
                ['title'=>'Informatik','url'=>'/nh_hor/informatik-nachhilfe-leipzig.php'],
            ]],
            ['title'=>'Sprachen','url'=>'#','children'=>[
                ['title'=>'Deutsch','url'=>'/nh_hor/deutsch-nachhilfe-leipzig.php'],
                ['title'=>'Englisch','url'=>'/nh_hor/englisch-nachhilfe-leipzig.php'],
                ['title'=>'Französisch','url'=>'/nh_hor/franzoesisch-nachhilfe-leipzig.php'],
                ['title'=>'Spanisch','url'=>'/nh_hor/spanisch-nachhilfe-leipzig.php'],
                ['title'=>'Latein','url'=>'/nh_hor/latein-nachhilfe-leipzig.php'],
            ]],
        ]],
        ['title'=>'Schulformen','url'=>'/nh_hor/schulformen.php','children'=>[
            ['title'=>'Grundschule','url'=>'/nh_hor/nachhilfe-grundschule-leipzig.php'],
            ['title'=>'Oberschule','url'=>'/nh_hor/nachhilfe-oberschule-leipzig.php'],
            ['title'=>'Gymnasium','url'=>'/nh_hor/nachhilfe-gymnasium-leipzig.php'],
            ['title'=>'Berufsschule','url'=>'/nh_hor/nachhilfe-berufsschule-leipzig.php'],
            ['title'=>'Abitur','url'=>'/nh_hor/abiturvorbereitung-leipzig.php'],
            ['title'=>'Studium','url'=>'/nh_hor/nachhilfe-studium-leipzig.php'],
        ]],
        ['title'=>'Sonstiges','url'=>'#','children'=>[
            ['title'=>'Leipzig & Stadtteile','url'=>'/nh_hor/nachhilfe-in-leipzig.php'],
            ['title'=>'Lernwerkzeuge','url'=>'/nh_hor/lernwerkzeuge.php'],
            ['title'=>'Lernblog','url'=>'/nh_hor/blog.php'],
            ['title'=>'Preise & Ablauf','url'=>'/nh_hor/preise.php'],
            ['title'=>'FAQ','url'=>'/nh_hor/faq.php'],
            ['title'=>'Jobs','url'=>'/nh_hor/jobs.php'],
            ['title'=>'Sitemap','url'=>'/nh_hor/sitemap.php'],
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
