<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_role('admin');
$adminTitle = 'Blockeditor-Handbuch – Band A + Band B.1 bis B.4';
require __DIR__ . '/includes/header.php';
?>
<link rel="stylesheet" href="<?= admin_e(app_path('/assets/css/homepage-block-help.css')) ?>">
<div id="top" class="help-hero">
  <div><p class="help-kicker">Blockeditor-Handbuch · Band A + Band B.1 bis Band B.5</p><h1>Grundlagen und professionelle Designprinzipien</h1><p class="help-lead">Band A erklärt die Bedienung. Band B.1 behandelt die gestalterischen Grundlagen. Band B.2 führt in Farbwirkung und Farbverläufe ein. Band B.3 behandelt professionelle Typografie. Band B.4 erklärt Bildformate, Bildausschnitt, Positionierung, responsive Bilder, Overlays und Alt-Texte. Band B.5 führt Flexbox, CSS Grid und professionelle Kartenlayouts ein.</p></div>
  <div class="help-hero-actions"><a class="admin-btn admin-btn--gold" href="<?= admin_e(app_path('/admin/homepage_blocks_edit.php')) ?>">Block anlegen</a><a class="admin-btn" href="<?= admin_e(app_path('/admin/homepage_blocks.php')) ?>">Blockübersicht</a></div>
</div>
<div class="help-search" role="search"><label for="help-search-input">Handbuch durchsuchen</label><div class="help-search-row"><input id="help-search-input" type="search" placeholder="Beispiel: Innenabstand, Schriftgröße, cover, Mobilansicht"><button type="button" class="admin-btn" id="help-search-reset">Suche löschen</button></div><p id="help-search-status" aria-live="polite">Alle Inhalte werden angezeigt.</p></div>
<div class="help-layout">
<aside class="help-sidebar"><nav>
<a href="#start">1. Schnellstart</a><a href="#oberflaeche">2. Editoroberfläche</a><a href="#inhalt">3. Inhalte</a><a href="#workflow">4. Arbeitsablauf</a><a href="#farben">5. Farben</a><a href="#typografie">6. Typografie</a><a href="#layout">7. Layout</a><a href="#abstaende">8. Abstände</a><a href="#bilder">9. Bilder</a><a href="#responsive">10. Responsive</a><a href="#expertenmodus">11. Expertenmodus</a><a href="#pruefung">12. Abschlussprüfung</a><a href="#fehler">13. Fehlerhilfe</a><a href="#praxis">14. Praxisrezepte</a><a href="#glossar">15. Glossar</a><hr><a href="#designprinzipien">B.1.1 Designprinzipien</a><a href="#hierarchie">B.1.2 Visuelle Hierarchie</a><a href="#blickfuehrung">B.1.3 Blickführung</a><a href="#weissraum">B.1.4 Weißraum</a><a href="#proportionen">B.1.5 Proportionen</a><a href="#raster">B.1.6 Gestaltungsraster</a><a href="#konsistenz">B.1.7 Konsistenz</a><a href="#b1-praxis">B.1.8 Praxisprüfung</a><hr><a href="#b2-farbwirkung">B.2.1 Farbwirkung</a><a href="#b2-harmonien">B.2.2 Farbharmonien</a><a href="#b2-farbmodelle">B.2.3 HEX, RGB und HSL</a><a href="#b2-verlaeufe">B.2.4 Farbverläufe</a><a href="#b2-transparenz">B.2.5 Transparenzen</a><a href="#b2-zustaende">B.2.6 Zustandsfarben</a><a href="#b2-paletten">B.2.7 Praxispaletten</a><a href="#b2-pruefung">B.2.8 Farbprüfung</a>
<hr><a href="#b3-hierarchie">B.3.1 Typografische Hierarchie</a><a href="#b3-schriftwahl">B.3.2 Schriftwahl</a><a href="#b3-pairing">B.3.3 Schriftkombinationen</a><a href="#b3-groessen">B.3.4 Responsive Größen</a><a href="#b3-zeilen">B.3.5 Zeilen und Abstände</a><a href="#b3-gewicht">B.3.6 Gewicht und Hervorhebung</a><a href="#b3-buttons">B.3.7 Buttons und Kurztexte</a><a href="#b3-vorlagen">B.3.8 Praxisvorlagen</a><a href="#b3-pruefung">B.3.9 Typografieprüfung</a><hr><a href="#b4-formate">B.4.1 Bildformate</a><a href="#b4-groessen">B.4.2 Größe und Qualität</a><a href="#b4-layout">B.4.3 Bildposition</a><a href="#b4-ausschnitt">B.4.4 Bildausschnitt</a><a href="#b4-position">B.4.5 Fokuspunkt</a><a href="#b4-responsive">B.4.6 Responsive Bilder</a><a href="#b4-overlays">B.4.7 Overlays und Text</a><a href="#b4-alttexte">B.4.8 Alt-Texte</a><a href="#b4-praxis">B.4.9 Praxis und Prüfung</a><hr><a href="#b5-grundlagen">B.5.1 Layoutgrundlagen</a><a href="#b5-flexbox">B.5.2 Flexbox</a><a href="#b5-grid">B.5.3 CSS Grid</a><a href="#b5-karten">B.5.4 Kartenlayouts</a><a href="#b5-hoehen">B.5.5 Gleiche Höhen</a><a href="#b5-breakpoints">B.5.6 Responsive Raster</a><a href="#b5-overlays">B.5.7 Overlays und Ebenen</a><a href="#b5-praxis">B.5.8 Praxisrezepte</a><a href="#b5-pruefung">B.5.9 Layoutprüfung</a></nav></aside>
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

<section id="b2-farbwirkung" class="help-section" data-search="band b2 farbwirkung farbpsychologie blau gelb grün rot neutral wirkung">
<span class="help-step">Band B.2 · Kapitel 1</span><h2>Farbwirkung gezielt einsetzen</h2>
<p>Farben unterstützen die Aussage eines Blocks. Sie ersetzen jedoch keine verständliche Überschrift. Für die Nachhilfe-Webseite sollte die Farbwirkung ruhig, vertrauenswürdig und lernorientiert bleiben.</p>
<div class="help-color-effect-grid"><article style="--effect:#0057a4"><b>Blau</b><p>Vertrauen, Klarheit und Sachlichkeit. Geeignet für Hauptangebote, Beratung und fachliche Inhalte.</p></article><article style="--effect:#ffda58"><b>Gelb</b><p>Aufmerksamkeit und Zuversicht. Als Akzent für Buttons, Hinweise oder zeitlich begrenzte Aktionen.</p></article><article style="--effect:#2a8c56"><b>Grün</b><p>Fortschritt, Erfolg und Entlastung. Geeignet für Lernerfolg, Beratung und positive Rückmeldungen.</p></article><article style="--effect:#d3544f"><b>Rot</b><p>Dringlichkeit und Warnung. Nur sparsam für Fehler, Fristen oder wirklich dringende Hinweise einsetzen.</p></article><article style="--effect:#6b7b88"><b>Neutralgrau</b><p>Ordnung und Zurückhaltung. Ideal für Flächen, Nebeninformationen und ruhige Trennungen.</p></article><article style="--effect:#6c4aa5"><b>Violett</b><p>Kreativität und Besonderheit. Als begrenzter Akzent für spezielle Angebote nutzbar.</p></article></div>
<div class="help-callout help-callout--tip"><strong>Praxisregel:</strong> Verwenden Sie pro Kachel eine dominante Grundfarbe und eine Akzentfarbe. Weitere Farben sollten neutral bleiben.</div>
</section>
<section id="b2-harmonien" class="help-section" data-search="farbharmonie monochrom analog komplementär triadisch palette harmonisch">
<span class="help-step">Band B.2 · Kapitel 2</span><h2>Farbharmonien verstehen</h2>
<p>Eine Farbharmonie beschreibt, wie Farben zueinander ausgewählt werden. Für die tägliche Arbeit reichen vier einfache Systeme.</p>
<div class="help-harmony-grid"><article><div class="harmony-swatch mono"><i></i><i></i><i></i><i></i></div><h3>Monochrom</h3><p>Mehrere Helligkeitsstufen einer Farbe. Sehr ruhig und sicher.</p></article><article><div class="harmony-swatch analog"><i></i><i></i><i></i><i></i></div><h3>Analog</h3><p>Benachbarte Farbtöne. Freundlich, weich und wenig konfliktgeladen.</p></article><article><div class="harmony-swatch complementary"><i></i><i></i><i></i><i></i></div><h3>Komplementär</h3><p>Gegensätzliche Farben. Hohe Aufmerksamkeit, deshalb Akzent sparsam dosieren.</p></article><article><div class="harmony-swatch triadic"><i></i><i></i><i></i><i></i></div><h3>Triadisch</h3><p>Drei deutlich getrennte Farben. Nur für bewusst lebendige Aktionsflächen.</p></article></div>
<table class="help-table"><thead><tr><th>Ziel</th><th>Empfohlene Harmonie</th><th>Beispiel</th></tr></thead><tbody><tr><td>Vertrauen</td><td>monochrom</td><td>Dunkelblau, Mittelblau, Hellblau</td></tr><tr><td>Ruhige Lernatmosphäre</td><td>analog</td><td>Blau, Türkis, Grün</td></tr><tr><td>Starker Button</td><td>komplementär</td><td>Blau mit gelbem Akzent</td></tr><tr><td>Ferienaktion</td><td>triadisch, reduziert</td><td>Blau, Gelb, Rot nur als kleiner Hinweis</td></tr></tbody></table>
</section>
<section id="b2-farbmodelle" class="help-section" data-search="hex rgb hsl farbmodell farbcode sättigung helligkeit hue alpha">
<span class="help-step">Band B.2 · Kapitel 3</span><h2>HEX, RGB und HSL sicher verwenden</h2>
<p>Der visuelle Editor arbeitet vor allem mit HEX-Werten. Im Expertenmodus sind auch RGB, RGBA und HSL nützlich.</p>
<table class="help-table"><thead><tr><th>Modell</th><th>Beispiel</th><th>Geeignet für</th></tr></thead><tbody><tr><td>HEX</td><td><code>#0057A4</code></td><td>klare, feste Farben im Editor</td></tr><tr><td>RGB</td><td><code>rgb(0, 87, 164)</code></td><td>technisch identische Angabe in Rot, Grün und Blau</td></tr><tr><td>RGBA</td><td><code>rgba(0, 87, 164, .18)</code></td><td>transparente Schatten und Überlagerungen</td></tr><tr><td>HSL</td><td><code>hsl(208 100% 32%)</code></td><td>systematische Anpassung von Farbton, Sättigung und Helligkeit</td></tr></tbody></table>
<div class="help-hsl-demo"><div><span>Farbton</span><b style="--h:208"></b><code>208°</code></div><div><span>Sättigung</span><b style="--s:100%"></b><code>100 %</code></div><div><span>Helligkeit</span><b style="--l:32%"></b><code>32 %</code></div></div>
<pre class="help-code"><code>/* Gleicher Blauton in drei Schreibweisen */
color: #0057A4;
color: rgb(0, 87, 164);
color: hsl(208 100% 32%);</code></pre>
</section>
<section id="b2-verlaeufe" class="help-section" data-search="farbverlauf linear gradient radial gradient verlauf winkel stops experten css">
<span class="help-step">Band B.2 · Kapitel 4</span><h2>Farbverläufe professionell gestalten</h2>
<p>Ein Verlauf sollte aus eng verwandten Farben bestehen und die Lesbarkeit unterstützen. Harte Regenbogenverläufe wirken in Angebotskacheln meist unruhig.</p>
<div class="help-gradient-grid"><article><div class="gradient-demo gradient-blue"></div><h3>Ruhiger Markenverlauf</h3><code>linear-gradient(135deg, #073764, #0057A4)</code></article><article><div class="gradient-demo gradient-light"></div><h3>Helle Informationsfläche</h3><code>linear-gradient(135deg, #FFFFFF, #EAF4FC)</code></article><article><div class="gradient-demo gradient-warm"></div><h3>Warme Aktion</h3><code>linear-gradient(120deg, #FFF8DC, #FFDA58)</code></article><article><div class="gradient-demo gradient-radial"></div><h3>Sanfter Lichtpunkt</h3><code>radial-gradient(circle at top right, #FFFFFF, #EAF4FC)</code></article></div>
<pre class="help-code"><code>background: linear-gradient(135deg, #073764 0%, #0057A4 100%);
color: #FFFFFF;</code></pre>
<div class="help-callout help-callout--warning"><strong>Achtung:</strong> Prüfen Sie den Textkontrast an der hellsten und an der dunkelsten Stelle des Verlaufs.</div>
</section>
<section id="b2-transparenz" class="help-section" data-search="transparenz alpha rgba overlay hintergrund bild lesbarkeit glass">
<span class="help-step">Band B.2 · Kapitel 5</span><h2>Transparenzen und Überlagerungen</h2>
<p>Transparenzen eignen sich für Schatten, Bildüberlagerungen und dezente Akzentflächen. Text sollte nicht direkt auf einem unruhigen Foto stehen.</p>
<div class="help-overlay-demo"><div class="overlay-card overlay-none"><strong>Ohne Overlay</strong><span>Text konkurriert mit dem Bild.</span></div><div class="overlay-card overlay-good"><strong>Mit Overlay</strong><span>Der Text bleibt klar lesbar.</span></div></div>
<pre class="help-code"><code>background:
  linear-gradient(rgba(7, 55, 100, .72), rgba(7, 55, 100, .72)),
  url('/assets/img/beispiel.webp') center / cover no-repeat;
color: #FFFFFF;</code></pre>
<ul class="help-checklist"><li>Für Schatten reichen häufig Alpha-Werte zwischen 0,08 und 0,22.</li><li>Für Text auf Bildern sind meist 0,55 bis 0,78 nötig.</li><li>Transparenz nie als Ersatz für ausreichenden Kontrast verwenden.</li></ul>
</section>
<section id="b2-zustaende" class="help-section" data-search="zustandsfarben hover focus aktiv deaktiviert fehler erfolg hinweis button">
<span class="help-step">Band B.2 · Kapitel 6</span><h2>Zustandsfarben für Buttons und Hinweise</h2>
<p>Interaktive Elemente benötigen erkennbare Zustände. Hover und Fokus dürfen sich verändern, ohne die Grundfarbe vollständig zu verlieren.</p>
<div class="help-state-grid"><div><button class="state-default">Standard</button><code>#0057A4</code></div><div><button class="state-hover">Hover</button><code>#073764</code></div><div><button class="state-focus">Fokus</button><code>gelber Fokusrahmen</code></div><div><button class="state-disabled" disabled>Deaktiviert</button><code>reduzierte Deckkraft</code></div></div>
<table class="help-table"><thead><tr><th>Zustand</th><th>Farbempfehlung</th><th>Zusatzsignal</th></tr></thead><tbody><tr><td>Erfolg</td><td>Grün</td><td>Häkchen und verständlicher Text</td></tr><tr><td>Hinweis</td><td>Blau</td><td>Informationssymbol</td></tr><tr><td>Warnung</td><td>Gelb/Orange</td><td>klarer Warntext</td></tr><tr><td>Fehler</td><td>Rot</td><td>Fehlerbeschreibung und Lösung</td></tr></tbody></table>
</section>
<section id="b2-paletten" class="help-section" data-search="praxis palette nachhilfe prüfung ferienkurs kontakt eltern online unterricht farbcodes">
<span class="help-step">Band B.2 · Kapitel 7</span><h2>Direkt nutzbare Praxispaletten</h2>
<div class="help-preset-grid"><article style="--c1:#073764;--c2:#0057A4;--c3:#EAF4FC;--c4:#FFDA58"><div><i></i><i></i><i></i><i></i></div><h3>Nachhilfe allgemein</h3><p>Vertrauenswürdig, sachlich und freundlich.</p><code>#073764 · #0057A4 · #EAF4FC · #FFDA58</code></article><article style="--c1:#174D2D;--c2:#2A8C56;--c3:#EFFAF3;--c4:#FFFFFF"><div><i></i><i></i><i></i><i></i></div><h3>Lernerfolg</h3><p>Positiv und entlastend.</p><code>#174D2D · #2A8C56 · #EFFAF3 · #FFFFFF</code></article><article style="--c1:#5B4300;--c2:#B86B00;--c3:#FFF8DC;--c4:#FFDA58"><div><i></i><i></i><i></i><i></i></div><h3>Ferienkurs</h3><p>Warm, aktivierend und dennoch lesbar.</p><code>#5B4300 · #B86B00 · #FFF8DC · #FFDA58</code></article><article style="--c1:#26384A;--c2:#607387;--c3:#F6F9FB;--c4:#0057A4"><div><i></i><i></i><i></i><i></i></div><h3>Kontakt und Service</h3><p>Neutral mit klarem Handlungsakzent.</p><code>#26384A · #607387 · #F6F9FB · #0057A4</code></article><article style="--c1:#4A2D65;--c2:#76509A;--c3:#F6F0FA;--c4:#FFDA58"><div><i></i><i></i><i></i><i></i></div><h3>Besonderes Angebot</h3><p>Eigenständig, aber nicht verspielt.</p><code>#4A2D65 · #76509A · #F6F0FA · #FFDA58</code></article><article style="--c1:#7A2C2C;--c2:#D3544F;--c3:#FFF3F2;--c4:#FFFFFF"><div><i></i><i></i><i></i><i></i></div><h3>Frist oder Hinweis</h3><p>Nur für tatsächlich dringliche Inhalte.</p><code>#7A2C2C · #D3544F · #FFF3F2 · #FFFFFF</code></article></div>
</section>
<section id="b2-pruefung" class="help-section" data-search="farbprüfung checklist kontrast farben testen mobil farbblind barrierefrei">
<span class="help-step">Band B.2 · Kapitel 8</span><h2>Abschließende Farbprüfung</h2>
<ol class="help-checklist"><li>Text ist auf jeder Stelle des Hintergrunds gut lesbar.</li><li>Der Button ist deutlich erkennbar, ohne den Titel zu übertreffen.</li><li>Die Palette enthält höchstens zwei kräftige Farben.</li><li>Gleiche Funktionen verwenden im gesamten Projekt dieselben Zustandsfarben.</li><li>Hover und Fokus sind auch ohne reine Farbänderung erkennbar.</li><li>Rot und Grün sind nicht die einzigen Bedeutungsträger.</li><li>Die Kachel funktioniert in Desktop-, Tablet- und Mobilvorschau.</li><li>Experten-CSS überschreibt keine unbeabsichtigten Editorfarben.</li></ol>
<div class="help-callout help-callout--info"><strong>Abschluss von Band B.2:</strong> Speichern Sie erfolgreiche Paletten als feste Gestaltungsregeln und verwenden Sie sie wiederholt. Dadurch bleibt die Webseite konsistent.</div>
</section>

<section id="b3-hierarchie" class="help-section" data-search="typografie hierarchie überschrift untertitel fließtext button rangfolge">
<span class="help-step">Band B.3 · Kapitel 1</span><h2>Typografische Hierarchie</h2>
<p>Eine Kachel muss bereits beim ersten Blick erkennen lassen, was Hauptaussage, Erklärung und Handlung ist. Die Hierarchie entsteht nicht nur durch Schriftgröße, sondern durch Größe, Gewicht, Farbe, Abstand und Position gemeinsam.</p>
<div class="help-type-hierarchy"><article class="type-good"><small>Gut gegliedert</small><h3>Mathematik sicher verstehen</h3><p>Individuelle Unterstützung für Schule, Ausbildung und Studium.</p><a>Termin anfragen</a></article><article class="type-flat"><small>Ohne Hierarchie</small><h3>Mathematik sicher verstehen</h3><p>Individuelle Unterstützung für Schule, Ausbildung und Studium.</p><a>Termin anfragen</a></article></div>
<table class="help-table"><thead><tr><th>Ebene</th><th>Aufgabe</th><th>Empfehlung</th></tr></thead><tbody><tr><td>Überschrift</td><td>Hauptaussage</td><td>größte Schrift, 600–800</td></tr><tr><td>Unterzeile</td><td>Einordnung</td><td>etwas kleiner, 500–600</td></tr><tr><td>Fließtext</td><td>Erklärung</td><td>ruhig, 400–500</td></tr><tr><td>Button</td><td>Handlung</td><td>kurz, 600–700</td></tr></tbody></table>
</section>
<section id="b3-schriftwahl" class="help-section" data-search="schriftart sans serif serif monospace systemschrift google fonts lokal">
<span class="help-step">Band B.3 · Kapitel 2</span><h2>Schriften sinnvoll auswählen</h2>
<p>Für den Blockeditor sind gut lesbare serifenlose Schriften die sicherste Grundlage. Externe Webfonts sollten nur eingesetzt werden, wenn Datenschutz, Ladezeit und lokale Einbindung geklärt sind.</p>
<div class="help-font-family-grid"><article class="font-sans"><h3>Sans Serif</h3><p>Klare Formen, sehr gut für Bildschirmtexte und Buttons.</p><code>Arial, Helvetica, system-ui</code></article><article class="font-serif"><h3>Serif</h3><p>Geeignet für besondere Überschriften, aber sparsam verwenden.</p><code>Georgia, Times New Roman</code></article><article class="font-mono"><h3>Monospace</h3><p>Nur für Code, technische Angaben oder kurze Spezialelemente.</p><code>Consolas, Courier New</code></article></div>
<div class="help-callout help-callout--tip"><strong>Empfehlung:</strong> Verwenden Sie zunächst die vorhandene Systemschrift des Projekts. Dadurch bleiben Ladezeit, Datenschutz und Darstellung stabil.</div>
</section>
<section id="b3-pairing" class="help-section" data-search="font pairing schriftkombination überschrift text serif sans kombination">
<span class="help-step">Band B.3 · Kapitel 3</span><h2>Schriftkombinationen ohne Unruhe</h2>
<p>Eine gute Kombination besteht meist aus höchstens zwei Schriftfamilien. Die Unterschiede müssen erkennbar sein, dürfen aber nicht gegeneinander arbeiten.</p>
<div class="help-pairing-grid"><article><h3 class="pair-system">System + System</h3><p class="pair-system">Die sicherste Variante: gleiche Familie, unterschiedliche Größen und Gewichte.</p><b>Empfohlen für die gesamte Website</b></article><article><h3 class="pair-serif">Serif-Überschrift</h3><p class="pair-system">Serifenlose Beschreibung für bessere Bildschirmlesbarkeit.</p><b>Nur für besondere Hauptkacheln</b></article><article class="pairing-bad"><h3>Drei Schriften</h3><p>Zu viele Formen erzeugen Unruhe und schwächen die Wiedererkennbarkeit.</p><b>Vermeiden</b></article></div>
<ul class="help-checklist"><li>Maximal zwei Schriftfamilien pro Seite.</li><li>Buttons und Navigation möglichst in derselben Schriftfamilie.</li><li>Unterschiede bevorzugt durch Größe und Gewicht erzeugen.</li><li>Keine dekorative Schrift für längere Texte verwenden.</li></ul>
</section>
<section id="b3-groessen" class="help-section" data-search="responsive schriftgröße clamp desktop tablet mobil titel text font size">
<span class="help-step">Band B.3 · Kapitel 4</span><h2>Responsive Schriftgrößen</h2>
<p>Die Schrift darf auf kleinen Geräten nicht einfach proportional verkleinert werden. Fließtext bleibt nahezu gleich groß; vor allem Überschriften werden angepasst.</p>
<table class="help-table"><thead><tr><th>Element</th><th>Desktop</th><th>Tablet</th><th>Smartphone</th></tr></thead><tbody><tr><td>Kacheltitel</td><td>30–40 px</td><td>26–34 px</td><td>22–30 px</td></tr><tr><td>Untertitel</td><td>20–24 px</td><td>18–22 px</td><td>18–20 px</td></tr><tr><td>Fließtext</td><td>16–18 px</td><td>16–18 px</td><td>16–17 px</td></tr><tr><td>Button</td><td>16–18 px</td><td>16–17 px</td><td>16 px</td></tr></tbody></table>
<pre class="help-code"><code>/* Expertenmodus: fließend skalierende Überschrift */
font-size: clamp(1.5rem, 2.4vw, 2.5rem);</code></pre>
<div class="help-scale-demo"><span style="--fs:1.5rem">Mobil</span><span style="--fs:2rem">Tablet</span><span style="--fs:2.5rem">Desktop</span></div>
</section>
<section id="b3-zeilen" class="help-section" data-search="zeilenhöhe line height zeichenabstand letter spacing absatzbreite lesbarkeit">
<span class="help-step">Band B.3 · Kapitel 5</span><h2>Zeilenhöhe, Zeichenabstand und Textbreite</h2>
<div class="help-line-grid"><article class="line-tight"><h3>Zu eng</h3><p>Eine zu geringe Zeilenhöhe lässt mehrere Zeilen optisch zusammenlaufen und erschwert das Erfassen des Textes.</p></article><article class="line-good"><h3>Gut lesbar</h3><p>Eine ausgewogene Zeilenhöhe trennt die Zeilen klar, ohne den Absatz auseinanderzureißen.</p></article><article class="line-wide"><h3>Zu weit</h3><p>Eine zu große Zeilenhöhe zerstört den Zusammenhang zwischen den Zeilen und verlängert die Kachel unnötig.</p></article></div>
<table class="help-table"><thead><tr><th>Eigenschaft</th><th>Richtwert</th><th>Hinweis</th></tr></thead><tbody><tr><td>Fließtext-Zeilenhöhe</td><td>1,45–1,7</td><td>bei 16–18 px</td></tr><tr><td>Überschrift-Zeilenhöhe</td><td>1,1–1,3</td><td>mehrzeilige Titel prüfen</td></tr><tr><td>Zeichenabstand Text</td><td>0 bis 0,02em</td><td>meist Standard beibehalten</td></tr><tr><td>Zeichenabstand Großschrift</td><td>0,03–0,08em</td><td>nur bei kurzen Labels</td></tr></tbody></table>
</section>
<section id="b3-gewicht" class="help-section" data-search="font weight 300 400 500 600 700 800 fett kursiv hervorhebung">
<span class="help-step">Band B.3 · Kapitel 6</span><h2>Schriftgewicht und Hervorhebung</h2>
<div class="help-weight-list"><span style="--w:300">300 Light – nur für große, kontrastreiche Texte</span><span style="--w:400">400 Regular – normaler Fließtext</span><span style="--w:500">500 Medium – betonter Fließtext</span><span style="--w:600">600 Semibold – Untertitel und Buttons</span><span style="--w:700">700 Bold – Überschriften</span><span style="--w:800">800 Extra Bold – kurze Aktionsüberschriften</span></div>
<div class="help-callout help-callout--warning"><strong>Nicht übertreiben:</strong> Wenn fast jeder Text fett gesetzt ist, gibt es keine erkennbare Hervorhebung mehr.</div>
</section>
<section id="b3-buttons" class="help-section" data-search="button text call to action kurz verständlich großbuchstaben link">
<span class="help-step">Band B.3 · Kapitel 7</span><h2>Buttons und Kurztexte</h2>
<p>Buttontexte müssen eine konkrete Handlung benennen. Ganze Sätze, unklare Formulierungen und dauerhafte Großschreibung sind zu vermeiden.</p>
<div class="help-button-copy-grid"><article class="is-good"><h3>Geeignet</h3><button>Termin anfragen</button><button>Kurs ansehen</button><button>Rückruf vereinbaren</button></article><article class="is-bad"><h3>Ungünstig</h3><button>HIER KLICKEN</button><button>MEHR</button><button>Bitte klicken Sie hier, um fortzufahren</button></article></div>
<ul class="help-checklist"><li>Zwei bis vier Wörter sind meist ausreichend.</li><li>Verben machen die Handlung verständlich.</li><li>Großbuchstaben nur für sehr kurze Labels.</li><li>Buttontext muss auch ohne umgebenden Absatz verständlich sein.</li></ul>
</section>
<section id="b3-vorlagen" class="help-section" data-search="typografie vorlage nachhilfe kurs kontakt aktion praxis css">
<span class="help-step">Band B.3 · Kapitel 8</span><h2>Typografie-Vorlagen für typische Kacheln</h2>
<div class="help-type-preset-grid"><article><h3>Nachhilfe-Angebot</h3><p><b>Titel:</b> 34 px / 700<br><b>Text:</b> 17 px / 400 / 1,6<br><b>Button:</b> 16 px / 700</p></article><article><h3>Ferienkurs</h3><p><b>Titel:</b> 38 px / 800<br><b>Text:</b> 18 px / 500 / 1,55<br><b>Button:</b> 17 px / 700</p></article><article><h3>Kontaktblock</h3><p><b>Titel:</b> 30 px / 700<br><b>Text:</b> 17 px / 400 / 1,65<br><b>Button:</b> 16 px / 600</p></article><article><h3>Kurzer Hinweis</h3><p><b>Label:</b> 14 px / 700 / 0,05em<br><b>Titel:</b> 28 px / 700<br><b>Text:</b> 16 px / 400</p></article></div>
</section>
<section id="b3-pruefung" class="help-section" data-search="typografie prüfung checklist lesbarkeit mobil titel button schrift">
<span class="help-step">Band B.3 · Kapitel 9</span><h2>Abschließende Typografieprüfung</h2>
<ol class="help-checklist"><li>Die Hauptüberschrift ist sofort erkennbar.</li><li>Fließtext ist mindestens 16 px groß.</li><li>Zeilenhöhe und Absatzabstände erleichtern das Lesen.</li><li>Es werden höchstens zwei Schriftfamilien verwendet.</li><li>Fettschrift wird gezielt und nicht flächendeckend eingesetzt.</li><li>Buttontexte benennen eine konkrete Handlung.</li><li>Mehrzeilige Titel funktionieren auch auf Smartphones.</li><li>Experten-CSS erzeugt keine abgeschnittenen oder überlaufenden Texte.</li></ol>
<div class="help-callout help-callout--info"><strong>Abschluss von Band B.3:</strong> Prüfen Sie die Kachel zuletzt auf einem realen Smartphone. Die Vorschau ist hilfreich, ersetzt aber nicht vollständig die reale Darstellung.</div>
</section>

<section id="b4-formate" class="help-section" data-search="band b4 bildformate webp jpeg jpg png svg fotografie grafik transparenz">
<span class="help-step">Band B.4 · Kapitel 1</span><h2>Bildformate richtig auswählen</h2>
<p>Das Dateiformat beeinflusst Bildqualität, Transparenz und Ladezeit. Für Block-Kacheln sollte das Format nach dem tatsächlichen Inhalt gewählt werden.</p>
<div class="help-image-format-grid"><article><b>WebP</b><p>Empfohlen für Fotos und viele Grafiken. Gute Qualität bei meist kleiner Dateigröße.</p><small>Standard für neue Kachelbilder</small></article><article><b>JPEG</b><p>Gut für Fotos ohne Transparenz. Bei wiederholtem Speichern können sichtbare Artefakte entstehen.</p><small>Solide Alternative</small></article><article><b>PNG</b><p>Geeignet für Grafiken, Logos und Bilder mit Transparenz. Für große Fotos oft unnötig schwer.</p><small>Nur bei Transparenz oder klaren Kanten</small></article><article><b>SVG</b><p>Ideal für einfache Logos und Icons. Nur aus vertrauenswürdiger Quelle verwenden und serverseitig prüfen.</p><small>Nicht als normales Fotoformat</small></article></div>
<div class="help-callout help-callout--warning"><strong>Sicherheit:</strong> SVG-Dateien können aktiven Inhalt enthalten. Akzeptieren Sie sie nur, wenn Upload und Bereinigung im Projekt ausdrücklich abgesichert sind.</div>
</section>
<section id="b4-groessen" class="help-section" data-search="bildgröße auflösung dateigröße komprimierung pixel hero kachel web performance">
<span class="help-step">Band B.4 · Kapitel 2</span><h2>Bildgröße, Auflösung und Qualität</h2>
<table class="help-table"><thead><tr><th>Einsatz</th><th>Empfohlene Ausgangsgröße</th><th>Zielgröße Datei</th></tr></thead><tbody><tr><td>Breiter Hauptblock</td><td>1600 × 900 px</td><td>meist unter 350 KB</td></tr><tr><td>Normale Kachel</td><td>1000 × 750 px</td><td>meist unter 220 KB</td></tr><tr><td>Hochformat/Person</td><td>900 × 1200 px</td><td>meist unter 250 KB</td></tr><tr><td>Logo oder Icon</td><td>nach Bedarf</td><td>so klein wie möglich</td></tr></tbody></table>
<ol class="help-steps"><li><strong>Passenden Ausschnitt wählen.</strong><span>Unwichtige Randbereiche vor dem Upload entfernen.</span></li><li><strong>Auf reale Anzeigegröße skalieren.</strong><span>Keine 5000-Pixel-Fotos für eine 500-Pixel-Kachel laden.</span></li><li><strong>Als WebP oder JPEG exportieren.</strong><span>Qualität so reduzieren, dass keine störenden Artefakte sichtbar sind.</span></li><li><strong>Desktop und Mobil prüfen.</strong><span>Gesicht, Produkt oder Motiv dürfen nicht ungünstig abgeschnitten werden.</span></li></ol>
</section>
<section id="b4-layout" class="help-section" data-search="bild links rechts oben nur bild nur text layout position block kachel">
<span class="help-step">Band B.4 · Kapitel 3</span><h2>Bildposition im Kachellayout</h2>
<div class="help-image-layout-grid"><article><div class="image-layout image-left"><i></i><b></b></div><h3>Bild links</h3><p>Geeignet, wenn das Motiv den Einstieg bildet und der Text danach gelesen werden soll.</p></article><article><div class="image-layout image-right"><b></b><i></i></div><h3>Bild rechts</h3><p>Geeignet für textorientierte Angebote mit unterstützendem Motiv.</p></article><article><div class="image-layout image-top"><i></i><b></b></div><h3>Bild oben</h3><p>Gut für kompakte Kartenserien und mobile Umbrüche.</p></article><article><div class="image-layout image-only"><i></i></div><h3>Nur Bild</h3><p>Nur verwenden, wenn Aussage, Linkziel und Alternativtext eindeutig sind.</p></article></div>
<div class="help-callout help-callout--tip"><strong>Praxisregel:</strong> Zeigt eine Person in eine bestimmte Richtung, sollte ihr Blick möglichst in Richtung Text oder Button führen.</div>
</section>
<section id="b4-ausschnitt" class="help-section" data-search="object fit cover contain bildausschnitt skalierung abschneiden verzerren">
<span class="help-step">Band B.4 · Kapitel 4</span><h2>Bildausschnitt mit „cover“ und „contain“</h2>
<div class="help-fit-grid"><article><div class="fit-demo fit-cover"><i></i></div><h3>cover</h3><p>Der Bildbereich wird vollständig gefüllt. Teile des Bildes können abgeschnitten werden. Für Fotos meist die beste Wahl.</p></article><article><div class="fit-demo fit-contain"><i></i></div><h3>contain</h3><p>Das ganze Bild bleibt sichtbar. Freie Flächen können entstehen. Sinnvoll für Logos, Plakate und Produktgrafiken.</p></article><article><div class="fit-demo fit-stretch"><i></i></div><h3>Verzerrt</h3><p>Breite und Höhe werden unabhängig erzwungen. Diese Darstellung sollte vermieden werden.</p></article></div>
<pre class="help-code"><code>/* Foto füllt den Bildbereich ohne Verzerrung */
object-fit: cover;
width: 100%;
height: 100%;</code></pre>
</section>
<section id="b4-position" class="help-section" data-search="object position fokuspunkt bildposition gesicht mitte links rechts oben">
<span class="help-step">Band B.4 · Kapitel 5</span><h2>Fokuspunkt und Bildposition</h2>
<p>Bei <code>cover</code> bestimmt die Bildposition, welcher Bereich beim Zuschneiden erhalten bleibt. Der wichtigste Bildinhalt muss deshalb gezielt positioniert werden.</p>
<div class="help-focus-grid"><article><div class="focus-demo focus-left"><span>Fokus links</span></div><code>object-position: 25% center;</code></article><article><div class="focus-demo focus-center"><span>Fokus Mitte</span></div><code>object-position: center;</code></article><article><div class="focus-demo focus-right"><span>Fokus rechts</span></div><code>object-position: 75% center;</code></article></div>
<ul class="help-checklist"><li>Gesichter vollständig und mit ausreichendem Abstand zeigen.</li><li>Horizontlinien nicht zufällig durch Kopf oder Text laufen lassen.</li><li>Bei Mobilansicht den engeren Ausschnitt gesondert kontrollieren.</li><li>Leere Bildfläche kann bewusst für Text oder Button genutzt werden.</li></ul>
</section>
<section id="b4-responsive" class="help-section" data-search="responsive bilder desktop tablet smartphone mobil aspect ratio höhe umbruch">
<span class="help-step">Band B.4 · Kapitel 6</span><h2>Responsive Bildgestaltung</h2>
<table class="help-table"><thead><tr><th>Ansicht</th><th>Typische Anordnung</th><th>Prüfung</th></tr></thead><tbody><tr><td>Desktop</td><td>Bild und Text nebeneinander</td><td>Verhältnis und Motivschwerpunkt</td></tr><tr><td>Tablet</td><td>schmalere Spalten oder Umbruch</td><td>Titel und Button dürfen nicht gequetscht wirken</td></tr><tr><td>Smartphone</td><td>Bild meist oberhalb des Textes</td><td>Bildhöhe, Ausschnitt und Ladezeit</td></tr></tbody></table>
<div class="help-device-image-grid"><article><b>Desktop</b><div class="device-image desktop-image"><i></i><span></span></div></article><article><b>Tablet</b><div class="device-image tablet-image"><i></i><span></span></div></article><article><b>Mobil</b><div class="device-image mobile-image"><i></i><span></span></div></article></div>
<div class="help-callout help-callout--info"><strong>Wichtig:</strong> Eine feste Bildhöhe kann auf Desktop sinnvoll sein, muss auf kleinen Geräten aber angepasst oder durch ein Seitenverhältnis ersetzt werden.</div>
</section>
<section id="b4-overlays" class="help-section" data-search="overlay text auf bild gradient kontrast hintergrundbild lesbarkeit dunkel">
<span class="help-step">Band B.4 · Kapitel 7</span><h2>Text auf Bildern und Overlays</h2>
<p>Text darf nur dann direkt auf einem Bild liegen, wenn seine Lesbarkeit an jeder Stelle gesichert ist. Ein Verlauf oder eine halbtransparente Fläche ist zuverlässiger als ein reiner Textschatten.</p>
<div class="help-photo-overlay-grid"><article class="photo-overlay overlay-bad"><h3>Ohne Overlay</h3><p>Der Text verschwindet in hellen und unruhigen Bildbereichen.</p></article><article class="photo-overlay overlay-gradient"><h3>Mit Verlauf</h3><p>Der dunkle Verlauf schafft eine stabile Textfläche.</p></article></div>
<pre class="help-code"><code>background-image:
  linear-gradient(90deg, rgba(7,55,100,.88), rgba(7,55,100,.2)),
  url('/assets/img/beispiel.webp');</code></pre>
</section>
<section id="b4-alttexte" class="help-section" data-search="alt text alternativtext barrierefreiheit screenreader dekorativ bildbeschreibung seo">
<span class="help-step">Band B.4 · Kapitel 8</span><h2>Alt-Texte und Barrierefreiheit</h2>
<table class="help-table"><thead><tr><th>Bildart</th><th>Alt-Text</th><th>Beispiel</th></tr></thead><tbody><tr><td>Inhaltliches Foto</td><td>knapp beschreiben, was relevant ist</td><td>„Schüler löst gemeinsam mit einem Tutor eine Geometrieaufgabe“</td></tr><tr><td>Logo</td><td>Name oder Funktion</td><td>„easyIT Nachhilfe Leipzig“</td></tr><tr><td>Dekoratives Bild</td><td>leerer Alt-Text</td><td><code>alt=""</code></td></tr><tr><td>Bild mit Text</td><td>Information auch als echten Text anbieten</td><td>Aktionsdatum nicht nur im Bild zeigen</td></tr></tbody></table>
<div class="help-callout help-callout--warning"><strong>Kein Keyword-Stapeln:</strong> Der Alternativtext beschreibt den Bildinhalt und seine Funktion. Er ist keine Liste von Suchbegriffen.</div>
</section>
<section id="b4-praxis" class="help-section" data-search="bild praxis nachhilfe ferienkurs team kontakt checkliste prüfen band b4">
<span class="help-step">Band B.4 · Kapitel 9</span><h2>Praxisrezepte und Abschlussprüfung</h2>
<div class="help-image-recipe-grid"><article><h3>Nachhilfe-Angebot</h3><p><b>Layout:</b> Bild rechts<br><b>Fit:</b> cover<br><b>Fokus:</b> Gesicht bei 65 %<br><b>Mobil:</b> Bild oben</p></article><article><h3>Ferienkurs</h3><p><b>Layout:</b> Bild oben<br><b>Fit:</b> cover<br><b>Format:</b> 4:3<br><b>Overlay:</b> keines, Text darunter</p></article><article><h3>Teamvorstellung</h3><p><b>Layout:</b> Bild links<br><b>Fit:</b> cover<br><b>Format:</b> Hochformat<br><b>Alt-Text:</b> Name und Rolle</p></article><article><h3>Gutschein</h3><p><b>Layout:</b> contain<br><b>Hintergrund:</b> neutral<br><b>Motiv:</b> vollständig sichtbar<br><b>Text:</b> als HTML, nicht im Bild</p></article></div>
<ol class="help-checklist"><li>Format und Dateigröße passen zum Einsatzzweck.</li><li>Das Bild ist weder verzerrt noch unnötig unscharf.</li><li>Der wichtigste Motivbereich bleibt auf allen Geräten sichtbar.</li><li>Text auf dem Bild besitzt einen stabilen Kontrast.</li><li>Alt-Text beschreibt Inhalt oder Funktion korrekt.</li><li>Die mobile Bildhöhe verdeckt nicht den eigentlichen Inhalt.</li><li>Die reale Startseite wurde nach dem Speichern geprüft.</li></ol>
<div class="help-callout help-callout--info"><strong>Abschluss Band B.4:</strong> Prüfen Sie mindestens eine breite und eine schmale Browseransicht sowie ein reales Smartphone.</div>
</section>


<section id="b5-grundlagen" class="help-section" data-search="band b5 layout grundlagen flexbox grid karten container reihe spalte">
<span class="help-step">Band B.5 · Kapitel 1</span><h2>Layoutgrundlagen für Block-Kacheln</h2>
<p>Ein professionelles Kachellayout trennt die Gestaltung in zwei Ebenen: Das <strong>äußere Raster</strong> ordnet mehrere Kacheln auf der Seite an. Das <strong>innere Layout</strong> ordnet Bild, Überschrift, Text und Button innerhalb einer einzelnen Kachel.</p>
<div class="help-layout-levels"><article><h3>Äußeres Raster</h3><div class="layout-level-demo outer-grid"><i></i><i></i><i></i></div><p>Bestimmt Spaltenzahl, Abstand und Umbruch der Kachelserie.</p></article><article><h3>Innere Kachel</h3><div class="layout-level-demo inner-card"><i></i><b></b><span></span></div><p>Bestimmt Bildposition, Textfluss und Ausrichtung des Buttons.</p></article></div>
<div class="help-callout help-callout--tip"><strong>Grundregel:</strong> Verwenden Sie Flexbox für eindimensionale Anordnungen und CSS Grid für zweidimensionale Raster.</div>
</section>
<section id="b5-flexbox" class="help-section" data-search="flexbox display flex direction gap justify content align items wrap">
<span class="help-step">Band B.5 · Kapitel 2</span><h2>Flexbox für Bild-Text-Kacheln</h2>
<p>Flexbox eignet sich besonders, wenn Elemente in einer Reihe oder Spalte angeordnet werden. Für eine Kachel mit Bild links und Text rechts ist es meist die einfachste Lösung.</p>
<div class="help-flex-demo-grid"><article><h3>Reihe</h3><div class="flex-demo flex-row-demo"><i></i><b></b></div><code>display:flex; flex-direction:row;</code></article><article><h3>Spalte</h3><div class="flex-demo flex-column-demo"><i></i><b></b></div><code>display:flex; flex-direction:column;</code></article><article><h3>Umbruch</h3><div class="flex-demo flex-wrap-demo"><i></i><i></i><i></i><i></i></div><code>display:flex; flex-wrap:wrap;</code></article></div>
<table class="help-table"><thead><tr><th>Eigenschaft</th><th>Aufgabe</th><th>Typischer Wert</th></tr></thead><tbody><tr><td><code>gap</code></td><td>Abstand zwischen Elementen</td><td><code>1.5rem</code></td></tr><tr><td><code>justify-content</code></td><td>Ausrichtung entlang der Hauptachse</td><td><code>space-between</code></td></tr><tr><td><code>align-items</code></td><td>Ausrichtung entlang der Querachse</td><td><code>stretch</code> oder <code>center</code></td></tr><tr><td><code>flex-wrap</code></td><td>Erlaubt den Zeilenumbruch</td><td><code>wrap</code></td></tr></tbody></table>
<pre class="help-code"><code>.block-card {
  display: flex;
  gap: 1.5rem;
  align-items: stretch;
}
.block-card__image { flex: 0 0 42%; }
.block-card__content { flex: 1 1 auto; }</code></pre>
</section>
<section id="b5-grid" class="help-section" data-search="css grid template columns auto fit minmax gap raster kacheln">
<span class="help-step">Band B.5 · Kapitel 3</span><h2>CSS Grid für Kachelserien</h2>
<p>CSS Grid ordnet mehrere Kacheln zuverlässig in Spalten und Zeilen. Besonders praktisch ist ein automatisches Raster mit <code>auto-fit</code> und <code>minmax()</code>.</p>
<div class="help-grid-demo"><i></i><i></i><i></i><i></i><i></i><i></i></div>
<pre class="help-code"><code>.block-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}</code></pre>
<ul class="help-checklist"><li>Die Mindestbreite verhindert zu schmale Kacheln.</li><li><code>1fr</code> verteilt freien Platz gleichmäßig.</li><li><code>auto-fit</code> reduziert die Spaltenzahl automatisch.</li><li>Der Abstand bleibt auf allen Bildschirmgrößen konsistent.</li></ul>
</section>
<section id="b5-karten" class="help-section" data-search="kartenlayout card header body footer button bild text struktur">
<span class="help-step">Band B.5 · Kapitel 4</span><h2>Professionelle Kartenlayouts</h2>
<p>Eine robuste Kachel besteht aus klar getrennten Bereichen. Dadurch bleiben Bild, Inhalt und Handlungsfläche auch bei unterschiedlich langen Texten beherrschbar.</p>
<div class="help-card-anatomy"><div class="card-anatomy-image">Bildbereich</div><div class="card-anatomy-body"><b>Überschrift</b><span>Fließtext und Zusatzinformationen</span></div><div class="card-anatomy-footer">Buttonbereich</div></div>
<pre class="help-code"><code>.card {
  display: grid;
  grid-template-rows: auto 1fr auto;
}
.card__footer {
  margin-top: auto;
}</code></pre>
<div class="help-callout help-callout--info"><strong>Vorteil:</strong> Der Button bleibt am unteren Rand, auch wenn die Texte der Kacheln unterschiedlich lang sind.</div>
</section>
<section id="b5-hoehen" class="help-section" data-search="gleiche höhen karten stretch button unten min height textlänge">
<span class="help-step">Band B.5 · Kapitel 5</span><h2>Gleiche Höhen und ruhige Kachelreihen</h2>
<div class="help-equal-height-grid"><article><h3>Uneinheitlich</h3><div class="unequal-cards"><i></i><i></i><i></i></div><p>Unterschiedliche Höhen erzeugen eine unruhige Unterkante.</p></article><article><h3>Einheitlich</h3><div class="equal-cards"><i></i><i></i><i></i></div><p>Grid und <code>height:100%</code> halten die Reihe zusammen.</p></article></div>
<ul class="help-checklist"><li>Keine feste Gesamthöhe erzwingen, wenn Inhalte stark variieren.</li><li>Mit Mindesthöhe nur eine optische Untergrenze setzen.</li><li>Textlängen redaktionell begrenzen.</li><li>Buttons über ein flexibles Mittelteil nach unten schieben.</li></ul>
</section>
<section id="b5-breakpoints" class="help-section" data-search="responsive raster breakpoint desktop tablet mobil media query spalten">
<span class="help-step">Band B.5 · Kapitel 6</span><h2>Responsive Raster und Breakpoints</h2>
<table class="help-table"><thead><tr><th>Ansicht</th><th>Empfehlung</th><th>Typische Spalten</th></tr></thead><tbody><tr><td>Großer Desktop</td><td>breiter Container, großzügiger Abstand</td><td>3–4</td></tr><tr><td>Notebook/Tablet quer</td><td>mittlerer Abstand</td><td>2–3</td></tr><tr><td>Tablet hoch</td><td>breite Kacheln</td><td>2</td></tr><tr><td>Smartphone</td><td>volle Breite, Bild oben</td><td>1</td></tr></tbody></table>
<pre class="help-code"><code>@media (max-width: 760px) {
  .block-card {
    flex-direction: column;
  }
  .block-card__image {
    flex-basis: auto;
  }
}</code></pre>
<div class="help-callout help-callout--warning"><strong>Keine Gerätejagd:</strong> Breakpoints sollten dort gesetzt werden, wo das Layout sichtbar zu eng wird – nicht nach einzelnen Gerätemodellen.</div>
</section>
<section id="b5-overlays" class="help-section" data-search="overlay position absolute relative z index badge sticker ebenen">
<span class="help-step">Band B.5 · Kapitel 7</span><h2>Overlays, Sticker und Ebenen</h2>
<p>Sticker, Badges und Textflächen können über einem Bild liegen. Dafür braucht die Kachel einen positionierten Bezugspunkt und klar definierte Ebenen.</p>
<div class="help-layer-demo"><div class="layer-image"></div><div class="layer-overlay"></div><span class="layer-badge">NEU</span><b>Prüfungsvorbereitung</b></div>
<pre class="help-code"><code>.card { position: relative; overflow: hidden; }
.card__badge {
  position: absolute;
  top: 1rem;
  right: 1rem;
  z-index: 2;
}</code></pre>
<ul class="help-checklist"><li>Der Sticker verdeckt kein Gesicht und keinen wichtigen Bildinhalt.</li><li><code>z-index</code> nur innerhalb klarer Komponenten verwenden.</li><li>Interaktive Elemente dürfen nicht von einem Overlay blockiert werden.</li><li>Textkontrast trotz Bild und Overlay prüfen.</li></ul>
</section>
<section id="b5-praxis" class="help-section" data-search="praxis flexbox grid nachhilfe kurse team faq kontakt layouts">
<span class="help-step">Band B.5 · Kapitel 8</span><h2>Praxisrezepte für typische Seitenbereiche</h2>
<div class="help-layout-recipe-grid"><article><h3>Fächerübersicht</h3><p><b>Außen:</b> Grid mit <code>minmax(240px,1fr)</code><br><b>Innen:</b> Bild oben<br><b>Button:</b> unten ausgerichtet</p></article><article><h3>Nachhilfe-Angebot</h3><p><b>Außen:</b> ein breiter Block<br><b>Innen:</b> Flexbox 42/58<br><b>Mobil:</b> Bild oberhalb</p></article><article><h3>Teamkarten</h3><p><b>Außen:</b> 3-Spalten-Grid<br><b>Bild:</b> einheitliches Hochformat<br><b>Höhe:</b> gestreckt</p></article><article><h3>FAQ-Teaser</h3><p><b>Außen:</b> 2-Spalten-Grid<br><b>Innen:</b> nur Text<br><b>Aktion:</b> Link am unteren Rand</p></article></div>
</section>
<section id="b5-pruefung" class="help-section" data-search="layout prüfung checkliste band b5 flex grid responsive">
<span class="help-step">Band B.5 · Kapitel 9</span><h2>Abschlussprüfung für Kartenlayouts</h2>
<ol class="help-checklist"><li>Die Kachelserie besitzt auf Desktop eine klare Spaltenordnung.</li><li>Keine Kachel wird schmaler als ihr Inhalt sinnvoll zulässt.</li><li>Bild, Text und Button besitzen eine erkennbare Hierarchie.</li><li>Buttons stehen in gleichartigen Kacheln auf einer ruhigen Linie.</li><li>Bei Tabletbreite entsteht kein überfülltes Zwischenlayout.</li><li>Auf Smartphones wird jede Kachel einspaltig und vollständig lesbar.</li><li>Overlays verdecken keine Bedien- oder Bildinhalte.</li><li>Es entsteht nirgends horizontales Scrollen.</li></ol>
<div class="help-callout help-callout--info"><strong>Abschluss Band B.5:</strong> Prüfen Sie die Seite bei mehreren frei gewählten Browserbreiten und nicht nur mit drei festen Vorschauknöpfen.</div>
</section>

</article></div>
<a class="help-back-top" href="#top" aria-label="Zum Seitenanfang">↑</a>
<script src="<?= admin_e(app_path('/assets/js/homepage-block-help.js')) ?>" defer></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
