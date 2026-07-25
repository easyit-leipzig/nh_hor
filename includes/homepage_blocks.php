<?php
declare(strict_types=1);

function homepage_blocks(): array
{
    static $blocks = null;
    if ($blocks !== null) return $blocks;
    $blocks = [];
    if (!db_available()) return $blocks;
    try {
        $stmt = db()->query("SELECT * FROM homepage_blocks WHERE active=1 AND (valid_from IS NULL OR valid_from<=CURDATE()) AND (valid_until IS NULL OR valid_until>=CURDATE()) ORDER BY position,id");
        $blocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) { error_log('[homepage blocks] ' . $e->getMessage()); }
    return $blocks;
}

function homepage_block_style(array $block): array
{
    $defaults = [
        'backgroundColor'=>'#ffffff','textColor'=>'#17324d','accentColor'=>'#0057a4','buttonColor'=>'#0057a4','buttonTextColor'=>'#ffffff',
        'padding'=>32,'gap'=>32,'borderRadius'=>20,'borderWidth'=>0,'borderColor'=>'#cad8e4','shadow'=>'medium',
        'minHeight'=>220,'imageWidth'=>280,'imageHeight'=>220,'imageRadius'=>16,'imageFit'=>'cover','imagePosition'=>'center center',
        'layout'=>'image-left','textAlign'=>'left','titleSize'=>32,'contentSize'=>16,'hoverEffect'=>'lift'
    ];
    $saved = json_decode((string)($block['style_json'] ?? ''), true);
    if (!is_array($saved)) return $defaults;
    $style = array_merge($defaults, array_intersect_key($saved, $defaults));
    foreach (['backgroundColor','textColor','accentColor','buttonColor','buttonTextColor','borderColor'] as $key) {
        if (!preg_match('/^#[0-9a-f]{6}$/i', (string)$style[$key])) $style[$key] = $defaults[$key];
    }
    $ranges = ['padding'=>[0,80],'gap'=>[0,80],'borderRadius'=>[0,60],'borderWidth'=>[0,12],'minHeight'=>[120,600],'imageWidth'=>[100,600],'imageHeight'=>[100,500],'imageRadius'=>[0,60],'titleSize'=>[18,64],'contentSize'=>[12,28]];
    foreach ($ranges as $key => [$min,$max]) $style[$key] = max($min, min($max, (int)$style[$key]));
    foreach (['shadow'=>['none','soft','medium','strong'],'imageFit'=>['cover','contain','fill'],'imagePosition'=>['center center','center top','center bottom','left center','right center'],'layout'=>['image-left','image-right','image-top','text-only'],'textAlign'=>['left','center','right'],'hoverEffect'=>['none','lift','zoom','glow']] as $key=>$allowed) {
        if (!in_array($style[$key], $allowed, true)) $style[$key] = $defaults[$key];
    }
    return $style;
}

function homepage_block_custom_css(string $css): string
{
    $css = trim($css);
    if ($css === '' || strlen($css) > 10000) return '';
    if (preg_match('/[{}]|@import|<\/?style|expression\s*\(|javascript\s*:|behavior\s*:|-moz-binding/i', $css)) return '';
    return $css;
}

function render_homepage_blocks(): void
{
    $shadows = ['none'=>'none','soft'=>'0 4px 14px rgba(0,0,0,.08)','medium'=>'0 8px 25px rgba(0,0,0,.12)','strong'=>'0 16px 38px rgba(0,0,0,.22)'];
    foreach (homepage_blocks() as $block) {
        $type = (string)$block['block_type'];
        $style = homepage_block_style($block);
        $classes = [
            'homepage-block', 'homepage-block--'.preg_replace('/[^a-z0-9_-]/i','',$type),
            'homepage-block--layout-'.$style['layout'], 'homepage-block--hover-'.$style['hoverEffect']
        ];
        $inline = implode(';', [
            '--hb-bg:'.$style['backgroundColor'],'--hb-text:'.$style['textColor'],'--hb-accent:'.$style['accentColor'],
            '--hb-button:'.$style['buttonColor'],'--hb-button-text:'.$style['buttonTextColor'],'--hb-padding:'.$style['padding'].'px',
            '--hb-gap:'.$style['gap'].'px','--hb-radius:'.$style['borderRadius'].'px','--hb-border-width:'.$style['borderWidth'].'px',
            '--hb-border:'.$style['borderColor'],'--hb-min-height:'.$style['minHeight'].'px','--hb-image-width:'.$style['imageWidth'].'px',
            '--hb-image-height:'.$style['imageHeight'].'px','--hb-image-radius:'.$style['imageRadius'].'px','--hb-title-size:'.$style['titleSize'].'px',
            '--hb-content-size:'.$style['contentSize'].'px','--hb-image-fit:'.$style['imageFit'],'--hb-image-position:'.$style['imagePosition'],
            'text-align:'.$style['textAlign'],'box-shadow:'.$shadows[$style['shadow']]
        ]);
        $customCss = homepage_block_custom_css((string)($block['custom_css'] ?? ''));
        if ($customCss !== '') $inline .= ';'.$customCss;
        echo '<section class="'.e(implode(' ', $classes)).'" style="'.e($inline).'">';
        echo '<div class="homepage-block__media">';
        if (!empty($block['image'])) {
            $crop = !empty($block['image_crop']) ? ' homepage-block__image--'.preg_replace('/[^a-z0-9_-]/i','',(string)$block['image_crop']) : '';
            $imagePath = (string)$block['image'];
            if (str_starts_with($imagePath,'blocks/') || str_starts_with($imagePath,'img/blocks/')) $imagePath='assets/img/'.$imagePath;
            echo '<img src="'.e($imagePath).'" alt="'.e($block['title']??'').'" class="homepage-block__image'.e($crop).'">';
        }
        if (!empty($block['sticker'])) {
            $pos = !empty($block['sticker_position']) ? preg_replace('/[^a-z0-9_-]/i','',(string)$block['sticker_position']) : 'top-right';
            $src = !empty($block['sticker_image']) ? $block['sticker_image'] : 'assets/img/blocks/sticker_sheet.png';
            if (str_starts_with($src,'blocks/') || str_starts_with($src,'img/blocks/')) $src='assets/img/'.$src;
            echo '<div class="homepage-block__sticker homepage-block__sticker--'.e($pos).' homepage-block__sticker--'.e($block['sticker']).'"><img src="'.e($src).'" alt="'.e($block['sticker']).'"></div>';
        }
        echo '</div><div class="homepage-block__content">';
        echo '<h2>'.e($block['title']??'').'</h2><p>'.nl2br(e($block['content']??'')).'</p>';
        if (!empty($block['button_url'])) echo '<a class="button button--blue homepage-block__button" href="'.e($block['button_url']).'">'.e($block['button_text']??'Mehr erfahren').'</a>';
        echo '</div></section>';
    }
}
