<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_role('admin');
$adminTitle = 'Blockeditor-Handbuch – Band A + Band B.1 bis B.5';
require __DIR__ . '/includes/header.php';
?>
<link rel="stylesheet" href="<?= admin_e(app_path('/assets/css/homepage-block-help.css')) ?>">
<div id="top" class="help-hero">
  <div><p class="help-kicker">Blockeditor-Handbuch · Band A + Band B.1 bis B.5</p><h1>Designgrundlagen, Farben, Typografie, Bilder und Kartenlayouts</h1><p class="help-lead">Band A erklärt die Bedienung. Band B.1 bis B.4 behandeln Designgrundlagen, Farben, Typografie und Bildgestaltung. Band B.5 ergänzt Flexbox, CSS Grid, Kartenaufbau, gleiche Höhen, responsive Raster, Overlays und konkrete Layoutrezepte.</p></div>
  <div class="help-hero-actions"><a class="admin-btn admin-btn--gold" href="<?= admin_e(app_path('/admin/homepage_blocks_edit.php')) ?>">Block anlegen</a><a class="admin-btn" href="<?= admin_e(app_path('/admin/homepage_blocks.php')) ?>">Blockübersicht</a></div>
</div>
<div class="help-search" role="search"><label for="help-search-input">Handbuch durchsuchen</label><div class="help-search-row"><input id="help-search-input" type="search" placeholder="Beispiel: Innenabstand, Schriftgröße, cover, Mobilansicht"><button type="button" class="admin-btn" id="help-search-reset">Suche löschen</button></div><p id="help-search-status" aria-live="polite">Alle Inhalte werden angezeigt.</p></div>
<div class="help-layout">
<aside class="help-sidebar"><nav>
<a href="#start">1. Schnellstart</a><a href="#oberflaeche">2. Editoroberfläche</a><a href="#inhalt">3. Inhalte</a><a href="#workflow">4. Arbeitsablauf</a><a href="#farben">5. Farben</a><a href="#typografie">6. Typografie</a><a href="#layout">7. Layout</a><a href="#abstaende">8. Abstände</a><a href="#bilder">9. Bilder</a><a href="#responsive">10. Responsive</a><a href="#expertenmodus">11. Expertenmodus</a><a href="#pruefung">12. Abschlussprüfung</a><a href="#fehler">13. Fehlerhilfe</a><a href="#praxis">14. Praxisrezepte</a><a href="#glossar">15. Glossar</a><hr><a href="#designprinzipien">B.1.1 Designprinzipien</a><a href="#hierarchie">B.1.2 Visuelle Hierarchie</a><a href="#blickfuehrung">B.1.3 Blickführung</a><a href="#weissraum">B.1.4 Weißraum</a><a href="#proportionen">B.1.5 Proportionen</a><a href="#raster">B.1.6 Gestaltungsraster</a><a href="#konsistenz">B.1.7 Konsistenz</a><a href="#b1-praxis">B.1.8 Praxisprüfung</a><hr><a href="#farbwirkung">B.2.1 Farbwirkung</a><a href="#farbharmonien">B.2.2 Farbharmonien</a><a href="#farbmodelle">B.2.3 HEX, RGB und HSL</a><a href="#verlaeufe">B.2.4 Farbverläufe</a><a href="#transparenzen">B.2.5 Transparenzen</a><a href="#zustaende">B.2.6 Zustandsfarben</a><a href="#statusfarben">B.2.7 Statusfarben</a><a href="#b2-paletten">B.2.8 Praxispaletten</a><a href="#b2-pruefung">B.2.9 Farbprüfung</a><hr><a href="#b3-hierarchie">B.3.1 Typografische Hierarchie</a><a href="#b3-schriftwahl">B.3.2 Schriftwahl</a><a href="#b3-kombinationen">B.3.3 Schriftkombinationen</a><a href="#b3-groessen">B.3.4 Responsive Größen</a><a href="#b3-zeilenhoehe">B.3.5 Zeilenhöhe</a><a href="#b3-zeichenabstand">B.3.6 Zeichenabstand</a><a href="#b3-gewicht">B.3.7 Schriftgewichte</a><a href="#b3-buttons">B.3.8 Buttons und Mikrotext</a><a href="#b3-vorlagen">B.3.9 Typografie-Vorlagen</a><a href="#b3-pruefung">B.3.10 Typografieprüfung</a><hr><a href="#b4-formate">B.4.1 Bildformate</a><a href="#b4-groessen">B.4.2 Bildgrößen</a><a href="#b4-position">B.4.3 Bildposition</a><a href="#b4-ausschnitt">B.4.4 Bildausschnitt</a><a href="#b4-responsive">B.4.5 Responsive Bilder</a><a href="#b4-overlays">B.4.6 Overlays</a><a href="#b4-alttexte">B.4.7 Alt-Texte</a><a href="#b4-praxis">B.4.8 Praxisrezepte</a><a href="#b4-fehler">B.4.9 Fehlerhilfe</a><a href="#b4-pruefung">B.4.10 Bildprüfung</a>
<hr><a href="#b5-grundlagen">B.5.1 Layoutgrundlagen</a><a href="#b5-flexbox">B.5.2 Flexbox</a><a href="#b5-flex-details">B.5.3 Flex-Eigenschaften</a><a href="#b5-grid">B.5.4 CSS Grid</a><a href="#b5-kartenaufbau">B.5.5 Kartenaufbau</a><a href="#b5-gleiche-hoehen">B.5.6 Gleiche Höhen</a><a href="#b5-responsive">B.5.7 Responsive Raster</a><a href="#b5-overlays">B.5.8 Overlays und Ebenen</a><a href="#b5-praxis">B.5.9 Praxisrezepte</a><a href="#b5-pruefung">B.5.10 Layoutprüfung</a>
</nav></aside>
<article class="help-content" id="help-content">
<section id="start" class="help-section" data-search="schnellstart anlegen bearbeiten speichern block kachel">
<span class="help-step">Kapitel 1</span><h2>Schnellstart</h2><ol class="help-steps"><li><strong>Block öffnen.</strong><span>In der Blockübersicht „Bearbeiten“ wählen oder einen neuen Block anlegen.</span></li><li><strong>Inhalte eintragen.</strong><span>Titel, Text, Button und Bild festlegen.</span></li><li><strong>Grundlayout wählen.</strong><span>Bild links, rechts, oben oder nur Text einstellen.</span></li><li><strong>Design anpassen.</strong><span>Farben, Abstände, Größen, Rahmen und Schatten festlegen.</span></li><li><strong>Alle Ansichten prüfen.</strong><span>Desktop, Tablet und Mobil nacheinander kontrollieren.</span></li><li><strong>Speichern und Startseite prüfen.</strong><span>Nach dem Speichern die reale Ausgabe öffnen.</span></li></ol><div class="help-callout help-callout--tip"><strong>Arbeitsregel:</strong> Ändern Sie immer nur eine Gestaltungsgruppe gleichzeitig. So bleibt nachvollziehbar, welche Einstellung welche Wirkung erzeugt.</div>
</section>
<section id="oberflaeche" class="help-section" data-search="oberfläche inhalt visueller editor vorschau experten css speichern">
<span class="help-step">Kapitel 2</span><h2>Die Editoroberfläche</h2><div class="help-ui-map"><div class="help-ui-column"><div class="help-ui-box"><b>A · Inhalt</b><span>Typ, Titel, Text, Button, Position, Aktivstatus und Bild.</span></div><div class="help-ui-box"><b>B · Visueller Editor</b><span>Farben, Layout, Abstände, Größen, Rahmen, Schatten und Hover.</span></div><div class="help-ui-box"><b>C · Experten-CSS</b><span>Optionale Deklarationen für Sonderfälle.</span></div><div class="help-ui-box help-ui-save"><b>D · Speichern</b><span>Änderungen dauerhaft übernehmen.</span></div></div><div class="help-ui-preview"><b>E · Live-Vorschau</b><span>Desktop, Tablet und Mobil.</span><div class="help-mini-card"><i></i><div><strong>Beispieltitel</strong><small>So erscheint der Block.</small><em>Mehr erfahren</em></div></div></div></div><table class="help-table"><thead><tr><th>Bereich</th><th>Zweck</th><th>Empfehlung</th></tr></thead><tbody><tr><td>Inhalt</td><td>Informationen des Blocks</td><td>Zuerst vollständig bearbeiten</td></tr><tr><td>Visueller Editor</td><td>Normale Gestaltung</td><td>Bevorzugt verwenden</td></tr><tr><td>Expertenmodus</td><td>Sondergestaltung</td><td>Erst am Ende einsetzen</td></tr><tr><td>Vorschau</td><td>Wirkung kontrollieren</td><td>Nach jeder größeren Änderung</td></tr></tbody></table>
</section>
<section id="inhalt" class="help-section" data-search="titel text button url position aktiv bild typ">
<span class="help-step">Kapitel 3</span><h2>Inhaltsfelder richtig verwenden</h2><div class="help-field-list"><div><h3>Typ</h3><p>Ordnet den Block inhaltlich ein. Wählen Sie die Kategorie, die dem Zweck am nächsten kommt.</p></div><div><h3>Titel</h3><p>Kurze, klare Hauptaussage. Ideal sind drei bis acht Wörter.</p></div><div><h3>Text</h3><p>Zwei bis fünf kurze Sätze. Lange Absätze erschweren die mobile Darstellung.</p></div><div><h3>Button-Text</h3><p>Als konkrete Handlung formulieren, etwa „Termin anfragen“ oder „Kurs ansehen“.</p></div><div><h3>Button-URL</h3><p>Interne Ziele als Pfad wie <code>/kontakt.php</code>, externe Ziele vollständig mit <code>https://</code>.</p></div><div><h3>Position</h3><p>Kleinere Zahlen erscheinen vor größeren Zahlen.</p></div><div><h3>Aktiv</h3><p>Deaktivierte Blöcke bleiben gespeichert, werden aber nicht ausgegeben.</p></div><div><h3>Bild</h3><p>JPEG, PNG oder WebP bis 5 MB. Für Fotos ist WebP oder JPEG meist sinnvoll.</p></div></div>
</section>
<section id="workflow" class="help-section" data-search="reihenfolge workflow grundlayout farben feinschliff prüfen speichern">
<span class="help-step">Kapitel 4</span><h2>Empfohlener Arbeitsablauf</h2><div class="help-flow"><div><span>1</span><b>Inhalt</b><small>Texte und Ziel festlegen</small></div><div><span>2</span><b>Layout</b><small>Bildposition wählen</small></div><div><span>3</span><b>Farben</b><small>Kontrast und Akzent setzen</small></div><div><span>4</span><b>Typografie</b><small>Größen und Ausrichtung</small></div><div><span>5</span><b>Feinschliff</b><small>Abstände und Schatten</small></div><div><span>6</span><b>Prüfung</b><small>Alle Ansichten testen</small></div></div><div class="help-callout help-callout--warning"><strong>Wichtig:</strong> Eigenes CSS kann Werte des visuellen Editors überlagern. Deshalb Experten-CSS erst nach Abschluss der normalen Gestaltung ergänzen.</div>
</section>
<section id="farben" class="help-section" data-search="farben kontrast hintergrund text button rahmen hex palette">
<span class="help-step">Kapitel 5</span><h2>Farben und Kontraste</h2><p>Eine gute Kachel nutzt eine ruhige Grundfarbe, eine klare Textfarbe und höchstens eine dominante Akzentfarbe.</p><div class="help-palette-grid"><article class="help-palette-card"><div class="help-palette-preview" style="--p-bg:#eef7ff;--p-text:#073764;--p-button:#0057a4;--p-button-text:#fff;--p-border:#b9d0df"><strong>Klassisch</strong><span>Sachlich und vertrauenswürdig.</span><b>Mehr erfahren</b></div><div class="help-palette-values"><code>#EEF7FF</code><code>#073764</code><code>#0057A4</code></div></article><article class="help-palette-card"><div class="help-palette-preview" style="--p-bg:#fff8dc;--p-text:#5b4300;--p-button:#b86b00;--p-button-text:#fff;--p-border:#efd47a"><strong>Warm</strong><span>Für Aktionen und Ferienkurse.</span><b>Platz sichern</b></div><div class="help-palette-values"><code>#FFF8DC</code><code>#5B4300</code><code>#B86B00</code></div></article><article class="help-palette-card"><div class="help-palette-preview" style="--p-bg:#effaf3;--p-text:#174d2d;--p-button:#2a8c56;--p-button-text:#fff;--p-border:#aad7bb"><strong>Positiv</strong><span>Für Beratung und Lernerfolg.</span><b>Beratung starten</b></div><div class="help-palette-values"><code>#EFFAF3</code><code>#174D2D</code><code>#2A8C56</code></div></article><article class="help-palette-card"><div class="help-palette-preview" style="--p-bg:#073764;--p-text:#fff;--p-button:#ffda58;--p-button-text:#26384a;--p-border:#2f6898"><strong>Dunkel</strong><span>Für wichtige Hauptangebote.</span><b>Details ansehen</b></div><div class="help-palette-values"><code>#073764</code><code>#FFFFFF</code><code>#FFDA58</code></div></article></div><ul class="help-checklist"><li>Überschrift und Text sind sofort lesbar.</li><li>Der Button hebt sich deutlich ab.</li><li>Nicht mehr als zwei kräftige Farben konkurrieren miteinander.</li><li>Rot und Grün werden nicht als einzige Unterscheidung verwendet.</li></ul>
</section>
<section id="typografie" class="help-section" data-search="typografie schriftgröße titel text zeilenhöhe ausrichtung gewicht">
<span class="help-step">Kapitel 6</span><h2>Typografie und Lesbarkeit</h2><table class="help-table"><thead><tr><th>Element</th><th>Desktop</th><th>Tablet</th><th>Mobil</th></tr></thead><tbody><tr><td>Titel</td><td>30–40 px</td><td>26–34 px</td><td>22–30 px</td></tr><tr><td>Fließtext</td><td>16–18 px</td><td>16–18 px</td><td>16–17 px</td></tr><tr><td>Button</td><td>16–18 px</td><td>16–18 px</td><td>16–17 px</td></tr></tbody></table><div class="help-compare-grid"><div class="help-compare help-compare--bad"><span>Ungünstig</span><div><strong style="font-size:42px;line-height:.95">Zu große Überschrift mit zu engem Zeilenabstand</strong><p style="font-size:13px;line-height:1.15">Der Fließtext ist zu klein und anstrengend zu lesen.</p></div></div><div class="help-compare help-compare--good"><span>Gut</span><div><strong style="font-size:30px;line-height:1.15">Klare Überschrift</strong><p style="font-size:17px;line-height:1.6">Ausreichende Größe und Zeilenhöhe verbessern die Lesbarkeit.</p></div></div></div><p><strong>Empfehlungen:</strong> Titel fett, Fließtext normal, linksbündige Ausrichtung für längere Inhalte. Zentrierung eignet sich eher für sehr kurze Werbeaussagen.</p>
</section>
<section id="layout" class="help-section" data-search="layout bild links rechts oben nur text spalten">
<span class="help-step">Kapitel 7</span><h2>Grundlayouts</h2><div class="help-layout-demo-grid"><div><span class="layout-demo image-left"><i></i><b></b></span><h3>Bild links</h3><p>Gut für klassische Angebotsblöcke.</p></div><div><span class="layout-demo image-right"><i></i><b></b></span><h3>Bild rechts</h3><p>Gut für abwechslungsreiche Reihenfolgen.</p></div><div><span class="layout-demo image-top"><i></i><b></b></span><h3>Bild oben</h3><p>Geeignet für schmale Kacheln und mobile Nutzung.</p></div><div><span class="layout-demo text-only"><b></b></span><h3>Nur Text</h3><p>Für Hinweise, FAQ und kurze Informationen.</p></div></div><div class="help-callout help-callout--info"><strong>Gestaltungsregel:</strong> Wechseln mehrere Kacheln Bild links und Bild rechts ab, entsteht ein ruhiger visueller Rhythmus. Auf Mobilgeräten sollten horizontale Layouts automatisch untereinander umbrechen.</div>
</section>
<section id="abstaende" class="help-section" data-search="innenabstand padding gap außenabstand margin radius rahmen schatten">
<span class="help-step">Kapitel 8</span><h2>Abstände, Rahmen und Schatten</h2><table class="help-table"><thead><tr><th>Einstellung</th><th>Wirkung</th><th>Richtwert</th></tr></thead><tbody><tr><td>Innenabstand</td><td>Abstand zwischen Kachelrand und Inhalt</td><td>24–40 px</td></tr><tr><td>Bild/Text-Abstand</td><td>Trennt Bild und Text optisch</td><td>20–36 px</td></tr><tr><td>Eckenradius</td><td>Rundet die Kachel</td><td>12–24 px</td></tr><tr><td>Rahmenbreite</td><td>Betont die Begrenzung</td><td>0–2 px</td></tr><tr><td>Schatten</td><td>Hebt die Kachel vom Hintergrund ab</td><td>Leicht oder mittel</td></tr></tbody></table><p>Zu kleine Innenabstände wirken gedrängt. Zu große Abstände verschwenden auf Mobilgeräten Platz. Ein starker Schatten sollte nur für besonders wichtige Blöcke verwendet werden.</p>
</section>
<section id="bilder" class="help-section" data-search="bilder webp jpg png cover contain bildposition ausschnitt alt text">
<span class="help-step">Kapitel 9</span><h2>Bilder und Bildausschnitt</h2><table class="help-table"><thead><tr><th>Format</th><th>Geeignet für</th><th>Hinweis</th></tr></thead><tbody><tr><td>WebP</td><td>Fotos und Grafiken</td><td>Meist beste Kombination aus Qualität und Dateigröße</td></tr><tr><td>JPEG</td><td>Fotos</td><td>Keine Transparenz</td></tr><tr><td>PNG</td><td>Logos und transparente Grafiken</td><td>Kann deutlich größer sein</td></tr></tbody></table><h3><code>cover</code> oder <code>contain</code>?</h3><div class="help-image-fit-grid"><div><span class="fit-demo fit-cover"></span><b>cover</b><p>Füllt die Bildfläche vollständig. Bildteile können abgeschnitten werden.</p></div><div><span class="fit-demo fit-contain"></span><b>contain</b><p>Zeigt das ganze Bild. Freie Flächen sind möglich.</p></div></div><p>Mit der Bildposition legen Sie fest, welcher Ausschnitt beim Zuschneiden erhalten bleibt. Für Porträts meist „oben“, für allgemeine Motive meist „Mitte“.</p><ul class="help-checklist"><li>Bild ist scharf und nicht verzerrt.</li><li>Das Hauptmotiv bleibt in allen Ansichten sichtbar.</li><li>Dateigröße ist möglichst klein.</li><li>Text liegt nicht unlesbar über unruhigen Bildbereichen.</li></ul>
</section>
<section id="responsive" class="help-section" data-search="responsive desktop tablet mobil umbruch prüfen">
<span class="help-step">Kapitel 10</span><h2>Responsive Darstellung</h2><div class="help-device-grid"><div><span class="device device--desktop"></span><h3>Desktop</h3><p>Horizontale Layouts, große Bilder und großzügige Abstände prüfen.</p></div><div><span class="device device--tablet"></span><h3>Tablet</h3><p>Auf ausreichend breite Textspalten und saubere Umbrüche achten.</p></div><div><span class="device device--mobile"></span><h3>Mobil</h3><p>Bild und Text sollten untereinander erscheinen. Buttons müssen vollständig sichtbar bleiben.</p></div></div><ol class="help-checklist"><li>Kein horizontaler Scrollbalken.</li><li>Titel bricht sinnvoll um.</li><li>Bild wird nicht unverständlich beschnitten.</li><li>Button bleibt gut antippbar.</li><li>Innenabstand ist nicht zu groß.</li></ol>
</section>
<section id="expertenmodus" class="help-section" data-search="experten css deklarationen sicher background gradient letter spacing">
<span class="help-step">Kapitel 11</span><h2>Experten-CSS sicher verwenden</h2><p>Der Expertenmodus akzeptiert nur CSS-Deklarationen für die jeweilige Kachel. Selektoren, geschweifte Klammern, <code>@import</code> und JavaScript-URLs sind gesperrt.</p><pre class="help-code"><code>background-image: linear-gradient(135deg, #ffffff, #eef6ff);
letter-spacing: 0.01em;
outline: 1px solid rgba(0, 87, 164, 0.12);</code></pre><div class="help-callout help-callout--warning"><strong>Beachten:</strong> Deklarationen wie <code>background</code>, <code>color</code> oder <code>border</code> können die sichtbaren Einstellungen des Editors überschreiben.</div><p>Entfernen Sie eigene Deklarationen einzeln, wenn die Ursache einer unerwarteten Darstellung gesucht wird.</p>
</section>
<section id="pruefung" class="help-section" data-search="abschlussprüfung speichern startseite checklist">
<span class="help-step">Kapitel 12</span><h2>Abschlussprüfung vor Veröffentlichung</h2><ol class="help-checklist"><li>Titel und Text sind inhaltlich korrekt.</li><li>Button führt zum richtigen Ziel.</li><li>Bild ist scharf und passend zugeschnitten.</li><li>Text und Hintergrund besitzen ausreichenden Kontrast.</li><li>Desktop-, Tablet- und Mobilvorschau wurden geprüft.</li><li>Keine Inhalte werden abgeschnitten.</li><li>Experten-CSS enthält nur notwendige Deklarationen.</li><li>Block ist aktiv und an der richtigen Position.</li><li>Nach dem Speichern wurde die reale Startseite geöffnet.</li></ol>
</section>
<section id="fehler" class="help-section" data-search="fehler bild nicht sichtbar farbe überschrieben button css mobil speichern">
<span class="help-step">Kapitel 13</span><h2>Häufige Fehler und Lösungen</h2><details><summary>Das Bild wird nicht angezeigt</summary><p>Dateiformat, Dateigröße und Upload prüfen. Danach speichern und die Startseite neu laden.</p></details><details><summary>Die gewählte Farbe erscheint nicht</summary><p>Experten-CSS auf <code>background</code>, <code>background-color</code> oder <code>color</code> prüfen.</p></details><details><summary>Der Button führt zur falschen Seite</summary><p>Die Button-URL kontrollieren. Interne Seiten sollten mit einem Schrägstrich beginnen.</p></details><details><summary>Die Mobilansicht ist zu breit</summary><p>Bildbreite, Innenabstand und sehr lange Wörter prüfen. Layout „Bild oben“ testen.</p></details><details><summary>Die Kachel wirkt zu hoch</summary><p>Text kürzen, Mindesthöhe reduzieren und Bildhöhe prüfen.</p></details><details><summary>Änderungen sind auf der Startseite nicht sichtbar</summary><p>Prüfen, ob gespeichert wurde, ob der Block aktiv ist und ob ein Cache geleert werden muss.</p></details>
</section>
<section id="praxis" class="help-section" data-search="praxis rezepte nachhilfe ferienkurs kontakt gutschein">
<span class="help-step">Kapitel 14</span><h2>Vier Praxisrezepte</h2><div class="help-recipe-grid"><article><h3>Nachhilfe-Angebot</h3><p><b>Layout:</b> Bild links<br><b>Farben:</b> Hellblau, Dunkelblau<br><b>Abstand:</b> 32 px<br><b>Schatten:</b> leicht</p></article><article><h3>Ferienkurs</h3><p><b>Layout:</b> Bild oben<br><b>Farben:</b> Warmes Creme, Orange<br><b>Button:</b> „Platz sichern“<br><b>Hover:</b> anheben</p></article><article><h3>Kontakt</h3><p><b>Layout:</b> nur Text<br><b>Farben:</b> Dunkelblau, Weiß<br><b>Ausrichtung:</b> zentriert<br><b>Button:</b> „Termin anfragen“</p></article><article><h3>Gutschein</h3><p><b>Layout:</b> Bild rechts<br><b>Farben:</b> Grün, Weiß<br><b>Radius:</b> 20 px<br><b>Schatten:</b> mittel</p></article></div>
</section>
<section id="glossar" class="help-section" data-search="glossar padding margin gap radius cover contain responsive hex">
<span class="help-step">Kapitel 15</span><h2>Glossar</h2><dl class="help-glossary"><div><dt>Padding</dt><dd>Innenabstand zwischen Rand und Inhalt.</dd></div><div><dt>Gap</dt><dd>Abstand zwischen Bild und Text.</dd></div><div><dt>Border Radius</dt><dd>Rundung der Ecken.</dd></div><div><dt>Hex-Farbe</dt><dd>Farbcode wie <code>#0057A4</code>.</dd></div><div><dt>cover</dt><dd>Bild füllt die Fläche vollständig und kann beschnitten werden.</dd></div><div><dt>contain</dt><dd>Das komplette Bild bleibt sichtbar.</dd></div><div><dt>Responsive</dt><dd>Anpassung an verschiedene Bildschirmbreiten.</dd></div><div><dt>Hover</dt><dd>Zustand beim Überfahren mit der Maus.</dd></div><div><dt>Live-Vorschau</dt><dd>Sofortige Darstellung der aktuellen Einstellungen.</dd></div><div><dt>Experten-CSS</dt><dd>Zusätzliche, manuell eingegebene CSS-Deklarationen.</dd></div></dl>
</section>

<section id="designprinzipien" class="help-section" data-search="band b designprinzipien gestaltung ordnung kontrast wiederholung ausrichtung nähe">
<span class="help-step">Band B.1 · Kapitel 1</span><h2>Designprinzipien für professionelle Block-Kacheln</h2>
<p>Eine hochwertige Kachel entsteht nicht durch möglichst viele Effekte, sondern durch eine klare Ordnung. Vier Grundprinzipien helfen bei jeder Gestaltung: <strong>Kontrast</strong>, <strong>Wiederholung</strong>, <strong>Ausrichtung</strong> und <strong>Nähe</strong>.</p>
<div class="help-principle-grid"><article><b>Kontrast</b><p>Wichtige Elemente unterscheiden sich deutlich. Titel, Text und Button dürfen nicht gleich stark wirken.</p></article><article><b>Wiederholung</b><p>Farben, Rundungen, Schriften und Buttonformen werden über mehrere Kacheln hinweg wiederverwendet.</p></article><article><b>Ausrichtung</b><p>Alle Inhalte folgen erkennbaren Linien. Zufällige Einrückungen wirken unruhig.</p></article><article><b>Nähe</b><p>Zusammengehörige Inhalte stehen enger beieinander als voneinander unabhängige Inhalte.</p></article></div>
<div class="help-callout help-callout--tip"><strong>Merksatz:</strong> Jede Kachel braucht eine Hauptaussage, einen unterstützenden Text und höchstens eine primäre Handlung.</div>
</section>
<section id="hierarchie" class="help-section" data-search="visuelle hierarchie titel text button bild gewicht größe priorität">
<span class="help-step">Band B.1 · Kapitel 2</span><h2>Visuelle Hierarchie</h2>
<p>Der Besucher sollte innerhalb weniger Sekunden erkennen, was zuerst, zweitens und zuletzt gelesen werden soll. Die Reihenfolge wird vor allem durch Größe, Farbe, Gewicht, Abstand und Position erzeugt.</p>
<div class="help-hierarchy-demo"><div class="is-good"><span>1</span><h3>Mathematik sicher verstehen</h3><p>Individuelle Unterstützung für Schule und Prüfung.</p><a>Termin anfragen</a></div><div class="is-bad"><span>?</span><h3>MATHEMATIK SICHER VERSTEHEN</h3><p>INDIVIDUELLE UNTERSTÜTZUNG FÜR SCHULE UND PRÜFUNG</p><a>TERMIN ANFRAGEN</a></div></div>
<table class="help-table"><thead><tr><th>Rang</th><th>Element</th><th>Gestaltung</th></tr></thead><tbody><tr><td>1</td><td>Titel</td><td>größte Schrift, klare Farbe, kurze Aussage</td></tr><tr><td>2</td><td>Bild oder Kurztext</td><td>unterstützt die Aussage, konkurriert nicht</td></tr><tr><td>3</td><td>Button</td><td>deutlich erkennbar, aber nicht größer als der Titel</td></tr><tr><td>4</td><td>Zusatzinformationen</td><td>kleiner und ruhiger gesetzt</td></tr></tbody></table>
</section>
<section id="blickfuehrung" class="help-section" data-search="blickführung leserichtung z muster f muster bild blickrichtung call to action">
<span class="help-step">Band B.1 · Kapitel 3</span><h2>Blickführung bewusst steuern</h2>
<p>Bei breiten Kacheln folgt der Blick häufig einer Z-Bewegung: oben links beginnt die Orientierung, danach wandert der Blick zum Bild oder Titel und schließlich zum Button. Bei textreichen Kacheln ähnelt die Bewegung eher einem F.</p>
<div class="help-eye-grid"><div class="eye-card eye-card--z"><i>1</i><i>2</i><i>3</i><i>4</i><b>Z-Muster</b></div><div class="eye-card eye-card--f"><i>1</i><i>2</i><i>3</i><b>F-Muster</b></div></div>
<ul class="help-checklist"><li>Der Titel steht nahe am Einstiegspunkt der Leserichtung.</li><li>Ein Personenfoto blickt möglichst in Richtung Text oder Button.</li><li>Der Button steht am Ende des inhaltlichen Weges.</li><li>Wichtige Inhalte werden nicht in einer optisch schwachen Ecke versteckt.</li></ul>
</section>
<section id="weissraum" class="help-section" data-search="weißraum freiraum innenabstand abstand luft ruhe padding">
<span class="help-step">Band B.1 · Kapitel 4</span><h2>Weißraum schafft Ruhe und Verständlichkeit</h2>
<p>Weißraum ist kein ungenutzter Platz. Er trennt Funktionsgruppen, erhöht die Lesbarkeit und verleiht einer Kachel Wertigkeit. Gemeint ist jeder freie Bereich – unabhängig von der tatsächlichen Hintergrundfarbe.</p>
<div class="help-space-compare"><div class="space-bad"><h3>Zu eng</h3><p>Text, Titel und Button stehen ohne klare Trennung.</p><b>Mehr</b></div><div class="space-good"><h3>Gut gegliedert</h3><p>Abstände zeigen, welche Inhalte zusammengehören.</p><b>Mehr erfahren</b></div></div>
<table class="help-table"><thead><tr><th>Abstand</th><th>Empfehlung</th><th>Zweck</th></tr></thead><tbody><tr><td>Titel zu Text</td><td>12–20 px</td><td>enge inhaltliche Verbindung</td></tr><tr><td>Text zu Button</td><td>20–32 px</td><td>klare Trennung von Information und Handlung</td></tr><tr><td>Kachelrand zu Inhalt</td><td>24–40 px</td><td>Ruhe und Schutz vor Gedränge</td></tr><tr><td>Zwischen zwei Blöcken</td><td>32–64 px</td><td>Abgrenzung eigenständiger Themen</td></tr></tbody></table>
</section>
<section id="proportionen" class="help-section" data-search="proportionen verhältnis goldener schnitt drittel bild text breite höhe">
<span class="help-step">Band B.1 · Kapitel 5</span><h2>Proportionen von Bild, Text und Kachel</h2>
<p>Für die Praxis genügt meist eine einfache Drittelregel. Ein Bild kann etwa ein Drittel bis zwei Fünftel der Kachelbreite einnehmen, während der Text den größeren Bereich erhält. Ein exakt berechneter Goldener Schnitt ist nicht erforderlich.</p>
<div class="help-ratio-grid"><div><span class="ratio ratio--40"><i></i><b></b></span><strong>40 : 60</strong><p>Ideal für Bild und erklärenden Text.</p></div><div><span class="ratio ratio--50"><i></i><b></b></span><strong>50 : 50</strong><p>Gut bei gleichwertigem Bild und kurzer Aussage.</p></div><div><span class="ratio ratio--65"><i></i><b></b></span><strong>65 : 35</strong><p>Geeignet, wenn das Bild die Hauptwirkung trägt.</p></div></div>
<div class="help-callout help-callout--warning"><strong>Vermeiden:</strong> Ein sehr schmales Textfeld neben einem dominanten Bild erzeugt unnötig viele Zeilenumbrüche und wird auf Tablets schnell instabil.</div>
</section>
<section id="raster" class="help-section" data-search="gestaltungsraster grid spalten ausrichtung kacheln reihe höhe basislinie">
<span class="help-step">Band B.1 · Kapitel 6</span><h2>Gestaltungsraster und Ausrichtung</h2>
<p>Ein Raster sorgt dafür, dass mehrere Block-Kacheln als zusammengehöriges System erscheinen. Für die Startseite sind besonders gemeinsame Außenkanten, gleiche Abstände und wiederkehrende Breiten wichtig.</p>
<div class="help-grid-demo"><div></div><div></div><div></div><div></div><div></div><div></div></div>
<ol class="help-steps"><li><strong>Container festlegen.</strong><span>Alle Kacheln beginnen und enden an denselben Seitenlinien.</span></li><li><strong>Spaltenzahl bestimmen.</strong><span>Desktop meist zwei oder drei, Mobil grundsätzlich eine Spalte.</span></li><li><strong>Zwischenraum vereinheitlichen.</strong><span>Für eine Serie denselben horizontalen und vertikalen Abstand verwenden.</span></li><li><strong>Inhalte ausrichten.</strong><span>Titel, Texte und Buttons auf wiederkehrenden Linien anordnen.</span></li></ol>
</section>
<section id="konsistenz" class="help-section" data-search="konsistenz design system wiederholung serie buttons radius schatten farben">
<span class="help-step">Band B.1 · Kapitel 7</span><h2>Konsistenz über mehrere Kacheln</h2>
<p>Einzelne Blöcke dürfen unterschiedliche Aufgaben erfüllen, sollten aber dieselbe visuelle Sprache sprechen. Legen Sie deshalb wenige feste Werte fest und verwenden Sie diese wiederholt.</p>
<table class="help-table"><thead><tr><th>Gestaltungsmerkmal</th><th>Empfohlene Systemregel</th></tr></thead><tbody><tr><td>Eckenradius</td><td>ein Hauptwert, zum Beispiel 18 px</td></tr><tr><td>Innenabstand</td><td>ein Standardwert und ein kompakter Wert</td></tr><tr><td>Schatten</td><td>maximal zwei Stufen: leicht und hervorgehoben</td></tr><tr><td>Button</td><td>gleiche Höhe, Rundung und Schriftstärke</td></tr><tr><td>Farben</td><td>eine Grundfarbe, eine Akzentfarbe, neutrale Hintergründe</td></tr><tr><td>Bildstil</td><td>ähnliche Helligkeit, Perspektive und Zuschnittslogik</td></tr></tbody></table>
</section>
<section id="b1-praxis" class="help-section" data-search="band b1 praxis prüfung design checklist vor veröffentlichung">
<span class="help-step">Band B.1 · Kapitel 8</span><h2>Praxisprüfung für eine Kachelserie</h2>
<ol class="help-checklist"><li>Jede Kachel besitzt genau eine erkennbare Hauptaussage.</li><li>Titel, Text und Button bilden eine eindeutige Hierarchie.</li><li>Freiräume sind regelmäßig und nicht zufällig.</li><li>Bild-Text-Verhältnisse bleiben in vergleichbaren Kacheln ähnlich.</li><li>Alle Kacheln folgen denselben Außenkanten und Zwischenräumen.</li><li>Buttons besitzen dieselbe Grundform.</li><li>Akzentfarben werden gezielt und nicht flächendeckend eingesetzt.</li><li>Die Serie funktioniert auch in einer einzigen mobilen Spalte.</li></ol>
<div class="help-callout help-callout--info"><strong>Abschluss von Band B.1:</strong> Erst wenn die Serie ohne Effekte klar und geordnet wirkt, sollten Schatten, Hover-Effekte oder Animationen ergänzt werden.</div>
</section>
<section id="farbwirkung" class="help-section" data-search="band b2 farbwirkung psychologie blau gelb grün rot violett grau">
<span class="help-step">Band B.2 · Kapitel 1</span><h2>Farbwirkung gezielt einsetzen</h2>
<p>Farben unterstützen die inhaltliche Wirkung einer Kachel. Sie ersetzen jedoch keine klare Überschrift und keine verständliche Handlungsaufforderung. Für die Startseite sollte jede kräftige Farbe eine erkennbare Aufgabe besitzen.</p>
<div class="help-color-meaning-grid">
<article style="--meaning:#0057a4"><b>Blau</b><p>Vertrauen, Ruhe und fachliche Verlässlichkeit. Geeignet für Beratung, Mathematik und Hauptangebote.</p></article>
<article style="--meaning:#e0a400"><b>Gelb</b><p>Aufmerksamkeit und Aktivierung. Geeignet als Akzent, für Hinweise oder zeitlich begrenzte Aktionen.</p></article>
<article style="--meaning:#2a8c56"><b>Grün</b><p>Fortschritt, Erfolg und Entlastung. Geeignet für Lernerfolg, Anmeldung oder positive Rückmeldungen.</p></article>
<article style="--meaning:#b23a3a"><b>Rot</b><p>Dringlichkeit und Fehler. Nur sparsam für Warnungen, nicht als dauerhafte Hauptfarbe einsetzen.</p></article>
<article style="--meaning:#7151a8"><b>Violett</b><p>Kreativität und Besonderheit. Geeignet für Informatik, Workshops oder innovative Angebote.</p></article>
<article style="--meaning:#5b6670"><b>Grau</b><p>Neutralität und Ordnung. Ideal für Hintergründe, Rahmen und sekundäre Informationen.</p></article>
</div>
<div class="help-callout help-callout--tip"><strong>Praxisregel:</strong> Verwenden Sie für eine Kachel eine dominante Grundfarbe, eine gut lesbare Textfarbe und höchstens eine zusätzliche Akzentfarbe.</div>
</section>
<section id="farbharmonien" class="help-section" data-search="farbharmonie monochrom analog komplementär triadisch farbkreis palette">
<span class="help-step">Band B.2 · Kapitel 2</span><h2>Farbharmonien verständlich auswählen</h2>
<p>Eine Farbharmonie beschreibt, wie mehrere Farben miteinander kombiniert werden. Für Block-Kacheln sind kontrollierte, kleine Paletten besser geeignet als ein vollständiger Farbkreis.</p>
<div class="help-harmony-grid">
<article><div class="harmony-dots mono"><i></i><i></i><i></i><i></i></div><h3>Monochrom</h3><p>Mehrere Helligkeitsstufen derselben Farbe. Sehr ruhig und sicher.</p></article>
<article><div class="harmony-dots analog"><i></i><i></i><i></i><i></i></div><h3>Analog</h3><p>Benachbarte Farbtöne. Harmonisch, aber lebendiger als monochrome Paletten.</p></article>
<article><div class="harmony-dots complement"><i></i><i></i><i></i><i></i></div><h3>Komplementär</h3><p>Gegenüberliegende Farben. Hoher Kontrast; eine Farbe muss klar dominieren.</p></article>
<article><div class="harmony-dots triad"><i></i><i></i><i></i><i></i></div><h3>Triadisch</h3><p>Drei deutlich verschiedene Farbtöne. Nur für wenige Akzente verwenden.</p></article>
</div>
<table class="help-table"><thead><tr><th>Harmonie</th><th>Geeignet für</th><th>Risiko</th></tr></thead><tbody><tr><td>Monochrom</td><td>Fächer- und Informationsserien</td><td>kann ohne Akzent zu ruhig wirken</td></tr><tr><td>Analog</td><td>freundliche Angebotsgruppen</td><td>Kontrast muss geprüft werden</td></tr><tr><td>Komplementär</td><td>Button gegen ruhigen Hintergrund</td><td>beide Farben dürfen nicht gleich stark sein</td></tr><tr><td>Triadisch</td><td>kleine Icons oder Kategorien</td><td>schnell zu bunt</td></tr></tbody></table>
</section>
<section id="farbmodelle" class="help-section" data-search="hex rgb rgba hsl hsla farbcode transparenz experten css">
<span class="help-step">Band B.2 · Kapitel 3</span><h2>HEX, RGB, RGBA und HSL</h2>
<p>Im visuellen Editor werden Farben meist als HEX-Code gespeichert. Im Expertenmodus können zusätzlich RGB-, RGBA- und HSL-Werte sinnvoll sein.</p>
<table class="help-table"><thead><tr><th>Schreibweise</th><th>Beispiel</th><th>Verwendung</th></tr></thead><tbody><tr><td>HEX</td><td><code>#0057A4</code></td><td>klare, feste Farbe</td></tr><tr><td>RGB</td><td><code>rgb(0, 87, 164)</code></td><td>gleiche Farbe als Rot-Grün-Blau-Wert</td></tr><tr><td>RGBA</td><td><code>rgba(0, 87, 164, .18)</code></td><td>Farbe mit Transparenz</td></tr><tr><td>HSL</td><td><code>hsl(208 100% 32%)</code></td><td>Farbton, Sättigung und Helligkeit getrennt steuern</td></tr></tbody></table>
<pre class="help-code"><code>background: hsl(208 100% 96%);
color: hsl(208 86% 21%);
border-color: hsl(208 40% 78%);</code></pre>
<div class="help-callout help-callout--info"><strong>Vorteil von HSL:</strong> Für Hover-Zustände lässt sich die Helligkeit verändern, ohne den Farbcharakter vollständig neu festzulegen.</div>
</section>
<section id="verlaeufe" class="help-section" data-search="farbverlauf linear gradient radial gradient winkel hintergrund">
<span class="help-step">Band B.2 · Kapitel 4</span><h2>Farbverläufe für Flächen und Akzente</h2>
<p>Farbverläufe sollten eine Fläche strukturieren, nicht die Lesbarkeit beeinträchtigen. Für Texte ist ein ruhiger, kontrastreicher Bereich erforderlich.</p>
<div class="help-gradient-grid">
<article><div class="gradient-sample gradient-blue"></div><h3>Linear, ruhig</h3><code>linear-gradient(135deg,#eef7ff,#cfe8f8)</code></article>
<article><div class="gradient-sample gradient-warm"></div><h3>Linear, warm</h3><code>linear-gradient(120deg,#fff8dc,#ffd98a)</code></article>
<article><div class="gradient-sample gradient-radial"></div><h3>Radialer Lichtpunkt</h3><code>radial-gradient(circle at 20% 20%,#fff,#d9ecfa)</code></article>
<article><div class="gradient-sample gradient-overlay"></div><h3>Bild-Overlay</h3><code>linear-gradient(90deg,rgba(7,55,100,.92),rgba(7,55,100,.18))</code></article>
</div>
<pre class="help-code"><code>background:
  linear-gradient(135deg, rgba(0,87,164,.94), rgba(7,55,100,.76)),
  url('/assets/img/blocks/mathematik.webp') center / cover;</code></pre>
</section>
<section id="transparenzen" class="help-section" data-search="transparenz alpha rgba overlay lesbarkeit deckkraft opacity">
<span class="help-step">Band B.2 · Kapitel 5</span><h2>Transparenzen sicher einsetzen</h2>
<p>Transparenz eignet sich besonders für Overlays, Schatten und dezente Rahmen. Die Eigenschaft <code>opacity</code> wirkt dagegen auf das gesamte Element einschließlich Text und sollte für Kachelhintergründe vermieden werden.</p>
<div class="help-alpha-demo"><div class="alpha-image"><span class="alpha-overlay alpha-20">20 %</span><span class="alpha-overlay alpha-50">50 %</span><span class="alpha-overlay alpha-80">80 %</span></div></div>
<table class="help-table"><thead><tr><th>Ziel</th><th>Empfehlung</th><th>Beispiel</th></tr></thead><tbody><tr><td>dezenter Rahmen</td><td>Alpha 0,15–0,30</td><td><code>rgba(0,87,164,.22)</code></td></tr><tr><td>Text auf Bild</td><td>Overlay 0,55–0,85</td><td><code>rgba(7,55,100,.72)</code></td></tr><tr><td>Schatten</td><td>Alpha 0,08–0,20</td><td><code>rgba(7,55,100,.14)</code></td></tr></tbody></table>
</section>
<section id="zustaende" class="help-section" data-search="hover focus active disabled zustandsfarben button interaktion">
<span class="help-step">Band B.2 · Kapitel 6</span><h2>Zustandsfarben für Buttons und Kacheln</h2>
<p>Interaktive Elemente benötigen unterscheidbare Zustände. Ein Hover-Effekt allein reicht nicht, weil Tastaturbenutzer den Fokuszustand benötigen.</p>
<div class="help-state-row"><button class="state-default">Standard</button><button class="state-hover">Hover</button><button class="state-focus">Fokus</button><button class="state-active">Aktiv</button><button class="state-disabled" disabled>Deaktiviert</button></div>
<pre class="help-code"><code>.block-button { background:#0057a4; color:#fff; }
.block-button:hover { background:#073764; }
.block-button:focus-visible { outline:3px solid #ffda58; outline-offset:3px; }
.block-button:active { transform:translateY(1px); }
.block-button:disabled { background:#aab4bd; color:#fff; }</code></pre>
</section>
<section id="statusfarben" class="help-section" data-search="statusfarben erfolg info warnung fehler meldung barrierefreiheit">
<span class="help-step">Band B.2 · Kapitel 7</span><h2>Statusfarben nicht nur über Farbe vermitteln</h2>
<p>Erfolg, Hinweis, Warnung und Fehler müssen zusätzlich durch Überschrift, Symbol oder Text erkennbar sein. Farbe allein ist keine ausreichende Information.</p>
<div class="help-status-grid"><article class="status-success"><b>✓ Erfolg</b><p>Die Änderung wurde gespeichert.</p></article><article class="status-info"><b>i Hinweis</b><p>Prüfen Sie anschließend die Mobilansicht.</p></article><article class="status-warning"><b>! Warnung</b><p>Der Kontrast des Buttons ist möglicherweise zu niedrig.</p></article><article class="status-error"><b>× Fehler</b><p>Das Bildformat wird nicht unterstützt.</p></article></div>
</section>
<section id="b2-paletten" class="help-section" data-search="praxispalette nachhilfe mathematik physik chemie informatik ferienkurs kontakt gutschein">
<span class="help-step">Band B.2 · Kapitel 8</span><h2>Direkt nutzbare Praxispaletten</h2>
<div class="help-b2-palette-grid">
<article style="--c1:#eef7ff;--c2:#073764;--c3:#0057a4;--c4:#ffda58"><div></div><h3>easyIT Klassisch</h3><code>#EEF7FF · #073764 · #0057A4 · #FFDA58</code><p>Hauptangebote, Beratung und allgemeine Nachhilfe.</p></article>
<article style="--c1:#effaf3;--c2:#174d2d;--c3:#2a8c56;--c4:#dff3e7"><div></div><h3>Lernerfolg</h3><code>#EFFAF3 · #174D2D · #2A8C56 · #DFF3E7</code><p>Fortschritt, Feedback und ruhige Beratungsblöcke.</p></article>
<article style="--c1:#fff8dc;--c2:#5b4300;--c3:#b86b00;--c4:#ffd36a"><div></div><h3>Ferienkurs</h3><code>#FFF8DC · #5B4300 · #B86B00 · #FFD36A</code><p>Aktionen, Termine und saisonale Angebote.</p></article>
<article style="--c1:#f2effa;--c2:#3f2d68;--c3:#7151a8;--c4:#d8c9ef"><div></div><h3>Informatik</h3><code>#F2EFFA · #3F2D68 · #7151A8 · #D8C9EF</code><p>Programmierung, digitale Themen und Workshops.</p></article>
<article style="--c1:#f3f7fa;--c2:#26384a;--c3:#4f6f86;--c4:#d7e2ea"><div></div><h3>Neutral</h3><code>#F3F7FA · #26384A · #4F6F86 · #D7E2EA</code><p>FAQ, Kontakt, organisatorische Informationen.</p></article>
<article style="--c1:#073764;--c2:#ffffff;--c3:#ffda58;--c4:#2f6898"><div></div><h3>Hervorgehoben</h3><code>#073764 · #FFFFFF · #FFDA58 · #2F6898</code><p>Hero-Kachel oder besonders wichtiges Hauptangebot.</p></article>
</div>
</section>
<section id="b2-pruefung" class="help-section" data-search="band b2 prüfung farbcheck kontrast palette mobile hover fokus">
<span class="help-step">Band B.2 · Kapitel 9</span><h2>Abschlussprüfung der Farbgestaltung</h2>
<ol class="help-checklist"><li>Hintergrund und Fließtext sind in allen Ansichten deutlich unterscheidbar.</li><li>Die Überschrift bleibt auch auf einem Farbverlauf klar lesbar.</li><li>Der Button besitzt einen eindeutigen Standard-, Hover- und Fokuszustand.</li><li>Kräftige Farben werden nur für wichtige Elemente eingesetzt.</li><li>Eine Kachelserie nutzt eine gemeinsame Grundpalette.</li><li>Statusmeldungen enthalten zusätzlich Text oder Symbol.</li><li>Transparente Overlays verdecken keine wesentlichen Bildinformationen.</li><li>Die Mobilansicht wurde auf einem schmalen Bildschirm geprüft.</li></ol>
<div class="help-callout help-callout--info"><strong>Abschluss von Band B.2:</strong> Speichern Sie häufig verwendete Farbwerte als feste Projektpalette. Dadurch bleiben neue Kacheln konsistent und schneller bearbeitbar.</div>
</section>


<section id="b3-hierarchie" class="help-section" data-search="band b3 typografische hierarchie überschrift untertitel fließtext button rangfolge">
<span class="help-step">Band B.3 · Kapitel 1</span><h2>Typografische Hierarchie aufbauen</h2>
<p>Typografie steuert die Reihenfolge, in der Inhalte wahrgenommen werden. Eine Block-Kachel sollte eine klar erkennbare Hauptüberschrift, einen ruhigen Beschreibungstext und eine eindeutige Handlungsaufforderung besitzen.</p>
<div class="help-type-hierarchy"><article><span>1</span><h3>Mathematik verständlich lernen</h3><p>Individuelle Unterstützung für Schule und Prüfung.</p><b>Termin anfragen</b></article><article class="is-flat"><span>?</span><h3>Mathematik verständlich lernen</h3><p>Individuelle Unterstützung für Schule und Prüfung.</p><b>Termin anfragen</b></article></div>
<table class="help-table"><thead><tr><th>Rang</th><th>Element</th><th>Gestaltung</th></tr></thead><tbody><tr><td>1</td><td>Überschrift</td><td>größte Schrift, kräftiges Gewicht, kurze Aussage</td></tr><tr><td>2</td><td>Beschreibung</td><td>kleiner, ruhiger und mit guter Zeilenhöhe</td></tr><tr><td>3</td><td>Button</td><td>gut lesbar, aber nicht größer als die Überschrift</td></tr><tr><td>4</td><td>Zusatztext</td><td>kleiner und visuell zurückhaltend</td></tr></tbody></table>
</section>
<section id="b3-schriftwahl" class="help-section" data-search="schriftwahl systemschrift sans serif serif monospace datenschutz lokal google fonts">
<span class="help-step">Band B.3 · Kapitel 2</span><h2>Geeignete Schriftarten auswählen</h2>
<p>Für Block-Kacheln sind gut ausgebaute Systemschriften meist die robusteste Lösung. Sie laden schnell, funktionieren auf allen Geräten und benötigen keine externe Verbindung.</p>
<div class="help-font-family-grid"><article class="font-system"><h3>System Sans</h3><p>Arial, Helvetica, Segoe UI</p><b>klar · neutral · schnell</b></article><article class="font-serif"><h3>Serifenschrift</h3><p>Georgia, Times New Roman</p><b>klassisch · redaktionell</b></article><article class="font-mono"><h3>Monospace</h3><p>Consolas, Courier New</p><b>Code · Technik · Werte</b></article></div>
<div class="help-callout help-callout--tip"><strong>Empfehlung:</strong> Für easyIT-Nachhilfe eine klare Sans-Serif-Schrift für alle Bedienelemente verwenden. Eine Serifenschrift nur gezielt für Zitate oder redaktionelle Akzente einsetzen.</div>
</section>
<section id="b3-kombinationen" class="help-section" data-search="schriftkombination font pairing überschrift text system font kombination">
<span class="help-step">Band B.3 · Kapitel 3</span><h2>Schriftkombinationen sicher einsetzen</h2>
<p>Eine gute Kombination unterscheidet Überschrift und Fließtext, ohne zwei konkurrierende Stile zu erzeugen. Für eine Kachel reichen gewöhnlich ein bis zwei Schriftfamilien.</p>
<div class="help-font-pair-grid"><article><h3 style="font-family:Georgia,serif">Georgia + Arial</h3><p style="font-family:Arial,sans-serif">Klassische Überschrift mit neutralem Fließtext.</p></article><article><h3 style="font-family:'Segoe UI',Arial,sans-serif">Segoe UI + Arial</h3><p style="font-family:Arial,sans-serif">Ruhige und vollständig systembasierte Kombination.</p></article><article><h3 style="font-family:Arial,sans-serif;font-weight:800">Arial Bold + Arial</h3><p style="font-family:Arial,sans-serif">Eine Familie, aber klar durch Gewicht unterschieden.</p></article></div>
<ul class="help-checklist"><li>Maximal zwei Schriftfamilien pro Kachelserie.</li><li>Überschrift und Text müssen auch ohne Farbe unterscheidbar sein.</li><li>Keine dekorative Schrift für längere Texte verwenden.</li><li>Externe Schriften nur lokal und datenschutzkonform einbinden.</li></ul>
</section>
<section id="b3-groessen" class="help-section" data-search="responsive schriftgrößen clamp desktop tablet mobil rem px">
<span class="help-step">Band B.3 · Kapitel 4</span><h2>Responsive Schriftgrößen</h2>
<table class="help-table"><thead><tr><th>Element</th><th>Desktop</th><th>Tablet</th><th>Smartphone</th></tr></thead><tbody><tr><td>Kacheltitel</td><td>30–40 px</td><td>26–34 px</td><td>22–30 px</td></tr><tr><td>Fließtext</td><td>17–19 px</td><td>16–18 px</td><td>16–18 px</td></tr><tr><td>Button</td><td>16–18 px</td><td>16–18 px</td><td>16–18 px</td></tr><tr><td>Zusatztext</td><td>14–16 px</td><td>14–16 px</td><td>14–16 px</td></tr></tbody></table>
<p>Mit <code>clamp()</code> kann eine Schriftgröße fließend zwischen einem Mindest- und Höchstwert wachsen:</p>
<pre class="help-code"><code>.homepage-block__title {
  font-size: clamp(1.5rem, 3vw, 2.5rem);
}</code></pre>
<div class="help-callout help-callout--warning"><strong>Nicht zu klein:</strong> Fließtext sollte auf Smartphones normalerweise nicht unter 16 px fallen.</div>
</section>
<section id="b3-zeilenhoehe" class="help-section" data-search="zeilenhöhe line-height lesbarkeit eng optimal weit">
<span class="help-step">Band B.3 · Kapitel 5</span><h2>Zeilenhöhe und Lesbarkeit</h2>
<p>Die Zeilenhöhe bestimmt, wie leicht ein Text verfolgt werden kann. Für Fließtext ist ein Wert zwischen 1,45 und 1,7 meist gut geeignet.</p>
<div class="help-lineheight-grid"><article class="lh-tight"><b>Zu eng · 1.1</b><p>Individuelle Nachhilfe hilft dabei, mathematische Zusammenhänge Schritt für Schritt sicher zu verstehen.</p></article><article class="lh-good"><b>Optimal · 1.55</b><p>Individuelle Nachhilfe hilft dabei, mathematische Zusammenhänge Schritt für Schritt sicher zu verstehen.</p></article><article class="lh-wide"><b>Zu weit · 2.0</b><p>Individuelle Nachhilfe hilft dabei, mathematische Zusammenhänge Schritt für Schritt sicher zu verstehen.</p></article></div>
</section>
<section id="b3-zeichenabstand" class="help-section" data-search="zeichenabstand letter spacing wortabstand uppercase großbuchstaben">
<span class="help-step">Band B.3 · Kapitel 6</span><h2>Zeichenabstand gezielt verwenden</h2>
<p>Ein leichter Zeichenabstand kann kurze Labels und Überschriften ordnen. Bei Fließtext sollte er nahezu unverändert bleiben.</p>
<div class="help-letterspacing-grid"><article class="ls-normal"><b>Normal</b><p>Prüfungsvorbereitung</p></article><article class="ls-open"><b>Leicht geöffnet</b><p>PRÜFUNGSVORBEREITUNG</p></article><article class="ls-too-wide"><b>Zu weit</b><p>PRÜFUNGSVORBEREITUNG</p></article></div>
<table class="help-table"><thead><tr><th>Einsatz</th><th>Richtwert</th></tr></thead><tbody><tr><td>Fließtext</td><td>0 bis 0,02em</td></tr><tr><td>Überschrift</td><td>-0,02em bis 0,03em</td></tr><tr><td>Großbuchstaben-Label</td><td>0,05em bis 0,12em</td></tr></tbody></table>
</section>
<section id="b3-gewicht" class="help-section" data-search="schriftgewicht font weight 300 400 500 600 700 800 fett">
<span class="help-step">Band B.3 · Kapitel 7</span><h2>Schriftgewichte richtig abstufen</h2>
<div class="help-weight-list"><p style="font-weight:300">300 · Light – nur für große, ruhige Überschriften</p><p style="font-weight:400">400 · Normal – Fließtext</p><p style="font-weight:500">500 · Medium – leichte Hervorhebung</p><p style="font-weight:600">600 · Semibold – Buttons und Zwischenüberschriften</p><p style="font-weight:700">700 · Bold – Hauptüberschriften</p><p style="font-weight:800">800 · Extrabold – sparsame Aktionsakzente</p></div>
<div class="help-callout help-callout--tip"><strong>Praxisregel:</strong> Fließtext 400, Button 600 und Titel 700 bilden bereits eine gut erkennbare Hierarchie.</div>
</section>
<section id="b3-buttons" class="help-section" data-search="button mikrotext call to action beschriftung termin anfragen mehr erfahren">
<span class="help-step">Band B.3 · Kapitel 8</span><h2>Buttons und Mikrotexte</h2>
<p>Buttontexte sollen eine konkrete Handlung benennen. Allgemeine Wörter wie „Mehr“ oder „Hier“ sind weniger verständlich als ein eindeutiger Handlungsauftrag.</p>
<div class="help-button-copy-grid"><article class="is-good"><b>Gut</b><button>Termin anfragen</button><button>Kursdetails ansehen</button><button>Beratung vereinbaren</button></article><article class="is-bad"><b>Ungenau</b><button>Mehr</button><button>Klicken</button><button>Hier</button></article></div>
<ul class="help-checklist"><li>Buttontext möglichst zwei bis vier Wörter.</li><li>Verben verwenden: anfragen, ansehen, vereinbaren, sichern.</li><li>Keine vollständigen Sätze in den Button schreiben.</li><li>Gleiche Handlung auf der gesamten Seite gleich benennen.</li></ul>
</section>
<section id="b3-vorlagen" class="help-section" data-search="typografie vorlagen hero angebot kontakt hinweis css kopieren">
<span class="help-step">Band B.3 · Kapitel 9</span><h2>Direkt nutzbare Typografie-Vorlagen</h2>
<div class="help-type-template-grid"><article class="type-template-hero"><small>HAUPTANGEBOT</small><h3>Nachhilfe, die Zusammenhänge erklärt</h3><p>Individuell, verständlich und mit einem klaren Lernziel.</p></article><article class="type-template-course"><small>FERIENKURS</small><h3>Mathematik intensiv</h3><p>Gezielte Vorbereitung in einer kompakten Woche.</p></article><article class="type-template-contact"><small>BERATUNG</small><h3>Gemeinsam den passenden Weg finden</h3><p>Schreiben Sie uns kurz, wobei Unterstützung gebraucht wird.</p></article><article class="type-template-info"><small>HINWEIS</small><h3>Neue Termine verfügbar</h3><p>Aktuelle freie Zeiten finden Sie in der Terminübersicht.</p></article></div>
<pre class="help-code"><code>.homepage-block__title {
  font-size: clamp(1.5rem, 3vw, 2.5rem);
  line-height: 1.15;
  font-weight: 700;
  letter-spacing: -0.015em;
}
.homepage-block__text {
  font-size: 1.05rem;
  line-height: 1.6;
}</code></pre>
</section>
<section id="b3-pruefung" class="help-section" data-search="band b3 typografie prüfung checklist mobil lesbarkeit font">
<span class="help-step">Band B.3 · Kapitel 10</span><h2>Abschlussprüfung der Typografie</h2>
<ol class="help-checklist"><li>Die Überschrift ist auf den ersten Blick als wichtigstes Textelement erkennbar.</li><li>Fließtext ist auf Smartphones mindestens 16 px groß.</li><li>Zeilenhöhe und Textbreite ermöglichen ruhiges Lesen.</li><li>Es werden höchstens zwei Schriftfamilien verwendet.</li><li>Schriftgewichte unterscheiden Titel, Text und Button eindeutig.</li><li>Großbuchstaben werden nur für kurze Labels genutzt.</li><li>Buttons besitzen konkrete, verständliche Handlungsbegriffe.</li><li>Desktop-, Tablet- und Mobilansicht wurden geprüft.</li></ol>
<div class="help-callout help-callout--info"><strong>Abschluss von Band B.3:</strong> Eine gute Typografie wirkt unauffällig. Besucher lesen zuerst die Aussage und bemerken nicht die technische Gestaltung dahinter.</div>
</section>

<section id="b4-formate" class="help-section" data-search="band b4 bildformate webp jpeg jpg png svg bildqualität dateigröße">
<span class="help-step">Band B.4 · Kapitel 1</span><h2>Geeignete Bildformate auswählen</h2>
<p>Das Bildformat entscheidet über Qualität, Transparenz und Ladezeit. Für fotografische Kachelbilder ist WebP meist die beste Wahl. JPEG bleibt eine kompatible Alternative. PNG eignet sich für transparente Grafiken, SVG für Logos und einfache Vektorgrafiken.</p>
<table class="help-table"><thead><tr><th>Format</th><th>Geeignet für</th><th>Hinweis</th></tr></thead><tbody><tr><td>WebP</td><td>Fotos, Banner, Kacheln</td><td>gute Qualität bei kleiner Datei</td></tr><tr><td>JPEG</td><td>Fotos</td><td>keine Transparenz</td></tr><tr><td>PNG</td><td>Freisteller, Screenshots</td><td>häufig größere Dateien</td></tr><tr><td>SVG</td><td>Logos, Icons</td><td>nur aus vertrauenswürdiger Quelle</td></tr></tbody></table>
<div class="help-callout help-callout--tip"><strong>Empfehlung:</strong> Fotos als WebP exportieren, Logos als SVG oder transparentes PNG verwenden.</div>
</section>
<section id="b4-groessen" class="help-section" data-search="bildgröße pixel dateigröße hero kachel smartphone komprimierung">
<span class="help-step">Band B.4 · Kapitel 2</span><h2>Bildgrößen und Dateigewicht planen</h2>
<table class="help-table"><thead><tr><th>Einsatz</th><th>Empfohlene Abmessung</th><th>Zielgröße</th></tr></thead><tbody><tr><td>breite Hero-Kachel</td><td>1600 × 900 px</td><td>etwa 150–350 KB</td></tr><tr><td>normale Inhaltskachel</td><td>1200 × 800 px</td><td>etwa 100–250 KB</td></tr><tr><td>kleine Kartenansicht</td><td>800 × 600 px</td><td>etwa 70–180 KB</td></tr><tr><td>Icon oder Logo</td><td>SVG oder 256–512 px</td><td>möglichst unter 100 KB</td></tr></tbody></table>
<p>Ein Bild sollte nicht wesentlich größer ausgeliefert werden, als es im Layout angezeigt wird. Überdimensionierte Dateien verlängern die Ladezeit, ohne sichtbar mehr Qualität zu liefern.</p>
</section>
<section id="b4-position" class="help-section" data-search="bild links rechts oben nur bild nur text position layout">
<span class="help-step">Band B.4 · Kapitel 3</span><h2>Bildposition passend zum Inhalt wählen</h2>
<div class="help-image-layout-grid"><article><div class="mini-image"></div><div><h3>Bild links</h3><p>Geeignet für sachliche Angebots- und Informationskacheln.</p></div></article><article class="is-right"><div class="mini-image"></div><div><h3>Bild rechts</h3><p>Der Text beginnt sofort und führt anschließend zum Bild.</p></div></article><article class="is-top"><div class="mini-image"></div><div><h3>Bild oben</h3><p>Gut für Kartenserien, News und Kursangebote.</p></div></article></div>
<p>Bei mehreren Kacheln derselben Reihe sollte die Bildposition einheitlich bleiben. Wechselnde Positionen sind nur sinnvoll, wenn dadurch eine bewusst gestaltete Abfolge entsteht.</p>
</section>
<section id="b4-ausschnitt" class="help-section" data-search="object fit cover contain object position bildausschnitt fokuspunkt">
<span class="help-step">Band B.4 · Kapitel 4</span><h2>Bildausschnitt mit cover und contain steuern</h2>
<div class="help-fit-grid"><article><div class="fit-demo fit-cover"><span>cover</span></div><p>Füllt die Fläche vollständig. Randbereiche dürfen abgeschnitten werden.</p></article><article><div class="fit-demo fit-contain"><span>contain</span></div><p>Zeigt das vollständige Bild. Freie Flächen können sichtbar bleiben.</p></article></div>
<pre class="help-code"><code>.homepage-block__image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: 50% 35%;
}</code></pre>
<p>Mit <code>object-position</code> lässt sich der Fokuspunkt verschieben. Bei Porträts sollte das Gesicht in allen Ansichten sichtbar bleiben.</p>
</section>
<section id="b4-responsive" class="help-section" data-search="responsive bilder desktop tablet mobil aspect ratio höhe">
<span class="help-step">Band B.4 · Kapitel 5</span><h2>Responsive Bilder gestalten</h2>
<table class="help-table"><thead><tr><th>Ansicht</th><th>Empfehlung</th></tr></thead><tbody><tr><td>Desktop</td><td>Bild und Text nebeneinander; feste Mindesthöhe vermeiden.</td></tr><tr><td>Tablet</td><td>Verhältnis prüfen; bei wenig Platz Bildanteil reduzieren.</td></tr><tr><td>Smartphone</td><td>Bild meist oberhalb des Textes; Höhe begrenzen und Fokuspunkt kontrollieren.</td></tr></tbody></table>
<pre class="help-code"><code>@media (max-width: 700px) {
  .homepage-block { grid-template-columns: 1fr; }
  .homepage-block__image { aspect-ratio: 16 / 9; }
}</code></pre>
</section>
<section id="b4-overlays" class="help-section" data-search="overlay text auf bild gradient kontrast lesbarkeit">
<span class="help-step">Band B.4 · Kapitel 6</span><h2>Text auf Bildern mit Overlays absichern</h2>
<div class="help-overlay-demo"><div><small>PRÜFUNGSVORBEREITUNG</small><h3>Konzentriert zum Ziel</h3><p>Ein dunkler Verlauf schafft eine ruhige Textfläche.</p></div></div>
<pre class="help-code"><code>.homepage-block--image-text::before {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(90deg, rgba(7,55,100,.92), rgba(7,55,100,.15));
}</code></pre>
<div class="help-callout help-callout--warning"><strong>Wichtig:</strong> Ein Overlay ersetzt keine Kontrastprüfung. Text muss auch über hellen Bildbereichen lesbar bleiben.</div>
</section>
<section id="b4-alttexte" class="help-section" data-search="alt text barrierefreiheit bildbeschreibung dekorativ leer">
<span class="help-step">Band B.4 · Kapitel 7</span><h2>Alt-Texte verständlich formulieren</h2>
<p>Alt-Texte beschreiben die Information des Bildes, nicht jede sichtbare Einzelheit. Ein rein dekoratives Bild erhält einen leeren Alt-Text, damit Screenreader es überspringen.</p>
<div class="help-compare-grid"><div class="help-compare help-compare--bad"><span>Ungünstig</span><div><p><code>alt="Bild123"</code></p><p>Ohne Information für den Nutzer.</p></div></div><div class="help-compare help-compare--good"><span>Gut</span><div><p><code>alt="Schüler löst mit seinem Lehrer eine Geometrieaufgabe"</code></p><p>Beschreibt Zweck und Inhalt knapp.</p></div></div></div>
</section>
<section id="b4-praxis" class="help-section" data-search="bild praxis rezept nachhilfe ferienkurs team gutschein">
<span class="help-step">Band B.4 · Kapitel 8</span><h2>Praxisrezepte für typische Blockarten</h2>
<div class="help-recipe-grid"><article><h3>Nachhilfe-Angebot</h3><p>Bild links, <code>cover</code>, Fokus auf Lernmaterial und Person, ruhiger Hintergrund.</p></article><article><h3>Ferienkurs</h3><p>Breites Bild oben, kurze Überschrift, farbiger Termin-Sticker.</p></article><article><h3>Teamvorstellung</h3><p>Porträt im Verhältnis 4:5, Fokuspunkt auf Augenhöhe, neutraler Hintergrund.</p></article><article><h3>Gutschein</h3><p>Grafisches Motiv mit <code>contain</code>, damit Ränder und Schrift vollständig sichtbar bleiben.</p></article></div>
</section>
<section id="b4-fehler" class="help-section" data-search="bild fehler unscharf verzerrt abgeschnitten lädt nicht langsam">
<span class="help-step">Band B.4 · Kapitel 9</span><h2>Häufige Bildprobleme beheben</h2>
<table class="help-table"><thead><tr><th>Problem</th><th>Ursache</th><th>Lösung</th></tr></thead><tbody><tr><td>Bild ist verzerrt</td><td>Breite und Höhe werden unabhängig erzwungen</td><td><code>object-fit</code> und korrektes Seitenverhältnis verwenden</td></tr><tr><td>Gesicht abgeschnitten</td><td>Fokuspunkt liegt falsch</td><td><code>object-position</code> anpassen</td></tr><tr><td>Bild wirkt unscharf</td><td>Quelldatei ist zu klein</td><td>größere Ausgangsdatei exportieren</td></tr><tr><td>Ladezeit ist hoch</td><td>Datei zu groß oder ungeeignetes Format</td><td>WebP und Komprimierung verwenden</td></tr><tr><td>Bild fehlt</td><td>Pfad oder Dateiname fehlerhaft</td><td>Upload, Groß-/Kleinschreibung und URL kontrollieren</td></tr></tbody></table>
</section>
<section id="b4-pruefung" class="help-section" data-search="band b4 bildprüfung checklist responsive alt text performance">
<span class="help-step">Band B.4 · Kapitel 10</span><h2>Abschlussprüfung der Bildgestaltung</h2>
<ol class="help-checklist"><li>Das Bildformat passt zu Foto, Logo oder Grafik.</li><li>Dateigröße und Pixelmaße sind angemessen.</li><li>Der wichtigste Bildbereich bleibt auf Desktop, Tablet und Smartphone sichtbar.</li><li><code>cover</code> oder <code>contain</code> wurde bewusst gewählt.</li><li>Text auf Bildern besitzt ausreichenden Kontrast.</li><li>Informative Bilder haben einen verständlichen Alt-Text.</li><li>Dekorative Bilder werden von Screenreadern übersprungen.</li><li>Das Bild ist nicht verzerrt und verursacht kein horizontales Scrollen.</li></ol>
<div class="help-callout help-callout--info"><strong>Abschluss von Band B.4:</strong> Gute Bilder unterstützen die Aussage der Kachel. Sie ersetzen weder eine klare Überschrift noch eine verständliche Handlungsaufforderung.</div>
</section>

<section id="b5-grundlagen" class="help-section" data-search="band b5 layout grundlagen flexbox grid karten äußeres raster inneres layout">
<span class="help-step">Band B.5 · Kapitel 1</span><h2>Äußeres Raster und inneres Kachellayout trennen</h2>
<p>Für stabile Seiten werden zwei Ebenen getrennt geplant: Das <strong>äußere Raster</strong> ordnet mehrere Kacheln auf der Seite. Das <strong>innere Layout</strong> ordnet Bild, Text und Button innerhalb einer einzelnen Kachel.</p>
<div class="help-layout-levels"><article><b>Äußeres Raster</b><div class="layout-mini-grid"><i></i><i></i><i></i></div><p>Bestimmt Spaltenzahl, Zwischenräume und Umbruch.</p></article><article><b>Inneres Layout</b><div class="layout-mini-card"><i></i><span></span></div><p>Bestimmt Bildposition, Textbreite und Buttonausrichtung.</p></article></div>
<div class="help-callout help-callout--tip"><strong>Praxisregel:</strong> Verwenden Sie Grid für die Kachelserie und Flexbox oder Grid innerhalb der einzelnen Kachel.</div>
</section>
<section id="b5-flexbox" class="help-section" data-search="flexbox display flex row column bild text nebeneinander">
<span class="help-step">Band B.5 · Kapitel 2</span><h2>Flexbox für Bild-Text-Anordnungen</h2>
<p>Flexbox eignet sich besonders für eindimensionale Anordnungen: Bild und Text nebeneinander oder untereinander.</p>
<div class="help-flex-demo"><article class="flex-row-demo"><i></i><div><b>Bild links</b><p>Textbereich wächst flexibel.</p></div></article><article class="flex-column-demo"><i></i><div><b>Bild oben</b><p>Für schmale und mobile Ansichten.</p></div></article></div>
<pre class="help-code"><code>.homepage-block {
  display: flex;
  gap: 1.5rem;
  align-items: stretch;
}
.homepage-block__image { flex: 0 0 40%; }
.homepage-block__content { flex: 1 1 auto; }</code></pre>
</section>
<section id="b5-flex-details" class="help-section" data-search="gap justify-content align-items flex-wrap flex-grow flex-basis">
<span class="help-step">Band B.5 · Kapitel 3</span><h2>Wichtige Flexbox-Eigenschaften</h2>
<table class="help-table"><thead><tr><th>Eigenschaft</th><th>Wirkung</th><th>Typischer Einsatz</th></tr></thead><tbody><tr><td><code>gap</code></td><td>Abstand zwischen Flex-Elementen</td><td>Bild-Text-Abstand</td></tr><tr><td><code>justify-content</code></td><td>Verteilung entlang der Hauptachse</td><td>Button unten oder Elemente zentrieren</td></tr><tr><td><code>align-items</code></td><td>Ausrichtung quer zur Hauptachse</td><td>gleiche Höhe oder vertikale Zentrierung</td></tr><tr><td><code>flex-wrap</code></td><td>Umbruch in neue Zeile</td><td>mehrere kleine Karten</td></tr><tr><td><code>flex-basis</code></td><td>bevorzugte Ausgangsbreite</td><td>Bildanteil 35–45 %</td></tr></tbody></table>
<div class="help-callout help-callout--warning"><strong>Nicht erzwingen:</strong> Vermeiden Sie starre Pixelbreiten für Bild und Text. Flexible Prozent- oder <code>flex-basis</code>-Werte reagieren besser auf Tablets.</div>
</section>
<section id="b5-grid" class="help-section" data-search="css grid auto-fit minmax spalten raster kacheln">
<span class="help-step">Band B.5 · Kapitel 4</span><h2>CSS Grid für responsive Kachelserien</h2>
<p>CSS Grid ordnet mehrere Kacheln in Zeilen und Spalten. Mit <code>auto-fit</code> und <code>minmax()</code> passt sich die Spaltenzahl automatisch an den verfügbaren Platz an.</p>
<div class="help-grid-live"><i></i><i></i><i></i><i></i><i></i><i></i></div>
<pre class="help-code"><code>.homepage-block-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}</code></pre>
<p>Der Mindestwert von 280 px verhindert zu schmale Karten. Der Wert <code>1fr</code> verteilt den übrigen Raum gleichmäßig.</p>
</section>
<section id="b5-kartenaufbau" class="help-section" data-search="karte card header bild content footer button struktur">
<span class="help-step">Band B.5 · Kapitel 5</span><h2>Professioneller Kartenaufbau</h2>
<p>Eine robuste Karte besitzt klar getrennte Bereiche für Bild, Inhalt und Aktion.</p>
<div class="help-card-anatomy"><div class="card-anatomy-image">Bild</div><div class="card-anatomy-content"><small>KATEGORIE</small><h3>Kartentitel</h3><p>Kurzer Erklärungstext mit einer klaren Aussage.</p></div><div class="card-anatomy-footer">Handlungsbutton</div></div>
<pre class="help-code"><code>.card {
  display: flex;
  flex-direction: column;
}
.card__content { flex: 1 1 auto; }
.card__footer { margin-top: auto; }</code></pre>
</section>
<section id="b5-gleiche-hoehen" class="help-section" data-search="gleiche höhen karten buttons unten stretch min-height">
<span class="help-step">Band B.5 · Kapitel 6</span><h2>Gleiche Kartenhöhen und ausgerichtete Buttons</h2>
<p>In einer Kachelreihe sollen Buttons auch bei unterschiedlich langen Texten auf derselben Grundlinie stehen. Das gelingt ohne feste Höhe, indem der Inhaltsbereich wächst und der Footer nach unten gedrückt wird.</p>
<div class="help-equal-card-grid"><article><h3>Kurzer Titel</h3><p>Kurzer Text.</p><b>Mehr erfahren</b></article><article><h3>Etwas längerer Titel für ein Angebot</h3><p>Mehr Text zeigt, dass der Button trotzdem unten auf gleicher Höhe bleibt.</p><b>Details ansehen</b></article><article><h3>Dritte Karte</h3><p>Mittellanger Inhalt mit derselben Kartenstruktur.</p><b>Termin anfragen</b></article></div>
<div class="help-callout help-callout--tip"><strong>Besser als feste Höhe:</strong> Nutzen Sie <code>display:flex</code>, <code>flex-direction:column</code> und <code>margin-top:auto</code> am Footer.</div>
</section>
<section id="b5-responsive" class="help-section" data-search="responsive breakpoint desktop tablet smartphone grid spalten">
<span class="help-step">Band B.5 · Kapitel 7</span><h2>Responsive Raster planen</h2>
<table class="help-table"><thead><tr><th>Ansicht</th><th>Typische Spaltenzahl</th><th>Hinweis</th></tr></thead><tbody><tr><td>Desktop ab ca. 1100 px</td><td>3</td><td>nur bei ausreichend breiten Karten</td></tr><tr><td>Tablet 700–1099 px</td><td>2</td><td>Bildanteile und Textumbrüche prüfen</td></tr><tr><td>Smartphone unter 700 px</td><td>1</td><td>Karten vollständig untereinander</td></tr></tbody></table>
<pre class="help-code"><code>@media (max-width: 700px) {
  .homepage-block-grid { grid-template-columns: 1fr; }
  .homepage-block { flex-direction: column; }
}</code></pre>
</section>
<section id="b5-overlays" class="help-section" data-search="overlay sticker badge position absolute z-index ebenen">
<span class="help-step">Band B.5 · Kapitel 8</span><h2>Overlays, Sticker und Ebenen</h2>
<p>Sticker und Text-Overlays liegen über Bild oder Kachel. Der umschließende Block benötigt dafür <code>position: relative</code>; das Overlay wird absolut positioniert.</p>
<div class="help-layer-demo"><span class="layer-badge">NEU</span><div><small>FERIENKURS</small><h3>Intensivwoche Mathematik</h3><p>Overlay und Text bleiben klar getrennt.</p></div></div>
<pre class="help-code"><code>.card { position: relative; }
.card__badge {
  position: absolute;
  top: 1rem;
  right: 1rem;
  z-index: 2;
}</code></pre>
<div class="help-callout help-callout--warning"><strong>Lesbarkeit:</strong> Overlays dürfen weder wichtige Bildbereiche noch Überschrift oder Button verdecken.</div>
</section>
<section id="b5-praxis" class="help-section" data-search="praxis rezept fächer angebote team faq flex grid">
<span class="help-step">Band B.5 · Kapitel 9</span><h2>Praxisrezepte für typische Kartenlayouts</h2>
<div class="help-recipe-grid"><article><h3>Fächerübersicht</h3><p>Grid mit <code>minmax(240px,1fr)</code>, vier gleichartige Fachkarten, Icon oben.</p></article><article><h3>Angebotskarten</h3><p>Drei Karten mit Bild, Inhalt und Footer; Buttons mit <code>margin-top:auto</code>.</p></article><article><h3>Teamkarten</h3><p>Porträt oben, Name und Fachgebiet, Kontaktaktion im Footer.</p></article><article><h3>FAQ-Kacheln</h3><p>Einspaltiges Layout; Frage als Kopf, Antwortbereich flexibel darunter.</p></article></div>
</section>
<section id="b5-pruefung" class="help-section" data-search="band b5 layout prüfung checklist flexbox grid responsive">
<span class="help-step">Band B.5 · Kapitel 10</span><h2>Abschlussprüfung für Kartenlayouts</h2>
<ol class="help-checklist"><li>Äußeres Seitenraster und inneres Kachellayout sind getrennt definiert.</li><li>Karten werden nicht durch starre Breiten oder Höhen eingeschränkt.</li><li>Zwischenräume werden über <code>gap</code> statt über zufällige Einzelabstände gesteuert.</li><li>Buttons stehen in vergleichbaren Karten auf derselben Grundlinie.</li><li>Grid-Karten unterschreiten keine sinnvolle Mindestbreite.</li><li>Auf Smartphones wird zuverlässig auf eine Spalte umgebrochen.</li><li>Overlays besitzen eine klare Ebene und verdecken keine Inhalte.</li><li>Desktop-, Tablet- und Mobilansicht wurden ohne horizontales Scrollen geprüft.</li></ol>
<div class="help-callout help-callout--info"><strong>Abschluss von Band B.5:</strong> Ein gutes Kartenlayout bleibt flexibel. Es ordnet Inhalte klar, ohne sie in starre Größen zu zwingen.</div>
</section>

</article></div>
<a class="help-back-top" href="#top" aria-label="Zum Seitenanfang">↑</a>
<script src="<?= admin_e(app_path('/assets/js/homepage-block-help.js')) ?>" defer></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
