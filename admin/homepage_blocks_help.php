<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_role('admin');
$adminTitle = 'Bedienungsanleitung Homepage-Blockeditor';
require __DIR__ . '/includes/header.php';
?>
<link rel="stylesheet" href="<?= admin_e(app_path('/assets/css/homepage-block-help.css')) ?>">

<div class="help-hero">
  <div>
    <p class="help-kicker">Homepage-Blöcke · Bedienungsanleitung</p>
    <h1>Block-Kacheln sicher gestalten und bearbeiten</h1>
    <p class="help-lead">Diese Anleitung erklärt den visuellen Editor, die Live-Vorschau und den Experten-CSS-Modus direkt an der vorhandenen Bearbeitungsoberfläche.</p>
  </div>
  <div class="help-hero-actions">
    <a class="admin-btn admin-btn--gold" href="<?= admin_e(app_path('/admin/homepage_blocks_edit.php')) ?>">Neuen Block anlegen</a>
    <a class="admin-btn" href="<?= admin_e(app_path('/admin/homepage_blocks.php')) ?>">Zur Blockübersicht</a>
  </div>
</div>

<div class="help-search" role="search">
  <label for="help-search-input">Anleitung durchsuchen</label>
  <div class="help-search-row">
    <input id="help-search-input" type="search" placeholder="Beispiel: Hintergrundfarbe, Bild, Vorschau oder CSS">
    <button type="button" class="admin-btn" id="help-search-reset">Suche löschen</button>
  </div>
  <p id="help-search-status" aria-live="polite">Alle Inhalte werden angezeigt.</p>
</div>

<div class="help-layout">
  <aside class="help-sidebar" aria-label="Kapitel-Navigation">
    <nav>
      <a href="#start">1. Schnellstart</a>
      <a href="#oberflaeche">2. Oberfläche</a>
      <a href="#workflow">3. Empfohlener Ablauf</a>
      <a href="#inhalt">4. Inhaltsfelder</a>
      <a href="#vorschau">5. Live-Vorschau</a>
      <a href="#speichern">6. Speichern und prüfen</a>
      <a href="#begriffe">7. Wichtige Begriffe</a>
      <a href="#fehler">8. Erste Fehlerhilfe</a>
      <a href="#farben">9. Farben und Kontraste</a>
      <a href="#farbpaletten">10. Farbpaletten</a>
      <a href="#farbfehler">11. Farbfehler vermeiden</a>
      <a href="#layout">12. Layoutsystem</a>
      <a href="#abstaende">13. Abstände</a>
      <a href="#spalten">14. Container und Spalten</a>
      <a href="#responsive-layout">15. Responsive Aufbau</a>
      <a href="#typografie">16. Typografie-Grundlagen</a>
      <a href="#schriftgroessen">17. Schriftgrößen</a>
      <a href="#zeilenhoehe">18. Zeilenhöhe und Abstände</a>
      <a href="#textausrichtung">19. Ausrichtung und Lesbarkeit</a>
      <a href="#responsive-typografie">20. Responsive Typografie</a>
      <a href="#typografie-praxis">21. Praxisvorlagen</a>
      <a href="#ausblick">22. Weitere Phasen</a>
    </nav>
  </aside>

  <article class="help-content" id="help-content">
    <section id="start" class="help-section" data-search="schnellstart block anlegen bearbeiten öffnen speichern">
      <span class="help-step">Kapitel 1</span>
      <h2>Schnellstart: Eine Block-Kachel bearbeiten</h2>
      <ol class="help-steps">
        <li><strong>Homepage-Blöcke öffnen.</strong><span>Im Adminmenü auf „Homepage-Blöcke“ klicken.</span></li>
        <li><strong>Block auswählen.</strong><span>Bei einem vorhandenen Block „Bearbeiten“ wählen oder einen neuen Block anlegen.</span></li>
        <li><strong>Inhalt eintragen.</strong><span>Titel, Text, Button und bei Bedarf ein Bild festlegen.</span></li>
        <li><strong>Gestaltung anpassen.</strong><span>Farben, Layout, Abstände, Größen und Effekte im visuellen Editor einstellen.</span></li>
        <li><strong>Vorschau prüfen.</strong><span>Desktop-, Tablet- und Mobilansicht kontrollieren.</span></li>
        <li><strong>Block speichern.</strong><span>Mit „Block speichern“ übernehmen und anschließend die Startseite kontrollieren.</span></li>
      </ol>
      <div class="help-callout help-callout--tip"><strong>Empfehlung:</strong> Ändern Sie immer nur wenige Einstellungen gleichzeitig. So ist sofort erkennbar, welche Änderung welche Wirkung hat.</div>
    </section>

    <section id="oberflaeche" class="help-section" data-search="oberfläche bereiche inhalt visueller editor experten css vorschau speichern">
      <span class="help-step">Kapitel 2</span>
      <h2>Aufbau der Bearbeitungsseite</h2>
      <p>Die Bearbeitungsseite besteht aus vier Arbeitsbereichen. Links werden Inhalt und Gestaltung bearbeitet. Rechts erscheint die Live-Vorschau.</p>
      <div class="help-ui-map" aria-label="Schematische Darstellung des Blockeditors">
        <div class="help-ui-column">
          <div class="help-ui-box"><b>A · Inhalt</b><span>Titel, Text, Button, Bild und Aktivstatus</span></div>
          <div class="help-ui-box"><b>B · Visueller Editor</b><span>Farben, Layout, Abstände, Größen und Effekte</span></div>
          <div class="help-ui-box"><b>C · Experten-CSS</b><span>Optionale zusätzliche CSS-Deklarationen</span></div>
          <div class="help-ui-box help-ui-save"><b>D · Speichern</b><span>Änderungen dauerhaft übernehmen</span></div>
        </div>
        <div class="help-ui-preview"><b>E · Live-Vorschau</b><span>Desktop, Tablet und Mobil</span><div class="help-mini-card"><i></i><div><strong>Beispieltitel</strong><small>Vorschau des Kachelinhalts</small><em>Mehr erfahren</em></div></div></div>
      </div>
      <table class="help-table">
        <thead><tr><th>Bereich</th><th>Aufgabe</th><th>Wann verwenden?</th></tr></thead>
        <tbody>
          <tr><td>Inhalt</td><td>Texte, Link und Bild verwalten</td><td>Bei jeder inhaltlichen Änderung</td></tr>
          <tr><td>Visueller Editor</td><td>Design ohne CSS-Kenntnisse einstellen</td><td>Für die normale Gestaltung</td></tr>
          <tr><td>Experten-CSS</td><td>Sondergestaltung ergänzen</td><td>Nur wenn die visuellen Regler nicht ausreichen</td></tr>
          <tr><td>Live-Vorschau</td><td>Wirkung vor dem Speichern kontrollieren</td><td>Nach jeder größeren Änderung</td></tr>
        </tbody>
      </table>
    </section>

    <section id="workflow" class="help-section" data-search="workflow ablauf reihenfolge inhalt design responsive speichern kontrollieren">
      <span class="help-step">Kapitel 3</span>
      <h2>Empfohlener Arbeitsablauf</h2>
      <div class="help-flow">
        <div><span>1</span><b>Inhalt</b><small>Texte und Bild festlegen</small></div>
        <div><span>2</span><b>Grundlayout</b><small>Bildposition und Ausrichtung wählen</small></div>
        <div><span>3</span><b>Farben</b><small>Hintergrund, Text und Button abstimmen</small></div>
        <div><span>4</span><b>Feinschliff</b><small>Abstände, Radien und Schatten setzen</small></div>
        <div><span>5</span><b>Prüfung</b><small>Alle drei Vorschaugrößen prüfen</small></div>
        <div><span>6</span><b>Speichern</b><small>Startseite anschließend aufrufen</small></div>
      </div>
      <div class="help-callout help-callout--warning"><strong>Wichtig:</strong> Der Experten-CSS-Modus sollte erst am Ende verwendet werden. Eigenes CSS kann Einstellungen des visuellen Editors überlagern.</div>
    </section>

    <section id="inhalt" class="help-section" data-search="inhalt typ titel button text url position aktiv bild upload jpeg png webp">
      <span class="help-step">Kapitel 4</span>
      <h2>Die Inhaltsfelder im Detail</h2>
      <div class="help-field-list">
        <div><h3>Typ</h3><p>Legt die inhaltliche Kategorie des Blocks fest, zum Beispiel „Neu“, „Veranstaltung“, „Gutschein“ oder „Text mit Bild“. Der Typ dient der Einordnung und kann die spätere Darstellung beeinflussen.</p><p><strong>Empfehlung:</strong> Den Typ wählen, der dem Zweck der Kachel am nächsten kommt.</p></div>
        <div><h3>Titel</h3><p>Die Hauptüberschrift der Kachel. Sie sollte den Inhalt sofort verständlich machen und möglichst kurz bleiben.</p><p><strong>Gut:</strong> „Abiturvorbereitung Mathematik“<br><strong>Ungünstig:</strong> „Hier finden Sie weitere interessante Informationen“</p></div>
        <div><h3>Text</h3><p>Der beschreibende Inhalt unterhalb des Titels. Absätze und Zeilenumbrüche werden in der Vorschau sichtbar. Lange Texte können die Kachel stark vergrößern.</p><p><strong>Richtwert:</strong> Zwei bis fünf kurze Sätze.</p></div>
        <div><h3>Button-Text</h3><p>Die sichtbare Beschriftung der Schaltfläche, beispielsweise „Mehr erfahren“, „Termin anfragen“ oder „Gutschein sichern“.</p></div>
        <div><h3>Button-URL</h3><p>Das Ziel des Buttons. Für interne Seiten wird normalerweise ein Pfad wie <code>/kontakt.php</code> verwendet. Vollständige externe Adressen beginnen mit <code>https://</code>.</p></div>
        <div><h3>Position</h3><p>Bestimmt die Reihenfolge auf der Startseite. Kleinere Zahlen werden üblicherweise vor größeren Zahlen ausgegeben.</p></div>
        <div><h3>Aktiv</h3><p>Nur aktive Blöcke werden auf der Startseite angezeigt. Ein deaktivierter Block bleibt gespeichert und kann später erneut aktiviert werden.</p></div>
        <div><h3>Bild</h3><p>Erlaubt sind JPEG-, PNG- und WebP-Dateien bis maximal 5 MB. Nach der Auswahl wird das neue Bild direkt in der Vorschau gezeigt. Ohne neues Bild bleibt beim Bearbeiten das bisherige Bild erhalten.</p></div>
      </div>
    </section>

    <section id="vorschau" class="help-section" data-search="live vorschau desktop tablet mobil breite unmittelbar aktualisiert bild text">
      <span class="help-step">Kapitel 5</span>
      <h2>Die Live-Vorschau richtig verwenden</h2>
      <p>Die Vorschau aktualisiert sich unmittelbar, sobald ein Eingabefeld oder ein Regler geändert wird. Sie zeigt die Gestaltung der Kachel, ersetzt aber nicht die abschließende Kontrolle auf der echten Startseite.</p>
      <div class="help-device-grid">
        <div><span class="device device--desktop"></span><h3>Desktop</h3><p>Prüft die Kachel bei großer Inhaltsbreite. Achten Sie besonders auf Bildbreite, Textlänge und horizontale Layouts.</p></div>
        <div><span class="device device--tablet"></span><h3>Tablet</h3><p>Zeigt eine mittlere Breite. Hier werden zu große Abstände oder überlange Titel schnell sichtbar.</p></div>
        <div><span class="device device--mobile"></span><h3>Mobil</h3><p>Prüft die schmalste Ansicht. Text und Button dürfen nicht abgeschnitten werden; Bild und Inhalt müssen gut lesbar bleiben.</p></div>
      </div>
      <div class="help-callout help-callout--info"><strong>Hinweis:</strong> Die tatsächliche Breite auf der Startseite hängt zusätzlich vom dortigen Inhaltsbereich ab. Die Vorschau zeigt daher eine sehr gute Annäherung, aber keine pixelgenaue Kopie jeder Bildschirmgröße.</div>
    </section>

    <section id="speichern" class="help-section" data-search="speichern prüfen startseite cache block aktiv datenbank">
      <span class="help-step">Kapitel 6</span>
      <h2>Speichern und Ergebnis kontrollieren</h2>
      <ol class="help-checklist">
        <li>Titel, Text und Button noch einmal lesen.</li>
        <li>Desktop-, Tablet- und Mobilvorschau öffnen.</li>
        <li>Prüfen, ob der Block auf „Aktiv“ steht.</li>
        <li>Auf „Block speichern“ klicken.</li>
        <li>Die öffentliche Startseite neu laden.</li>
        <li>Button anklicken und Zielseite kontrollieren.</li>
      </ol>
      <p>Falls eine Änderung nach dem Speichern nicht sofort sichtbar ist, kann ein Browser- oder Seitencache beteiligt sein. Laden Sie die Seite mit <kbd>Strg</kbd> + <kbd>F5</kbd> neu oder verwenden Sie im Adminbereich die Funktion zum Leeren des Caches.</p>
    </section>

    <section id="begriffe" class="help-section" data-search="begriffe padding gap radius shadow hover cover contain responsive css">
      <span class="help-step">Kapitel 7</span>
      <h2>Wichtige Begriffe</h2>
      <dl class="help-glossary">
        <div><dt>Innenabstand</dt><dd>Abstand zwischen Kachelrand und Inhalt. Im CSS wird er <code>padding</code> genannt.</dd></div>
        <div><dt>Abstand Bild/Text</dt><dd>Freiraum zwischen Bildbereich und Textbereich. Im CSS häufig <code>gap</code>.</dd></div>
        <div><dt>Eckenradius</dt><dd>Bestimmt, wie stark die Ecken einer Kachel oder eines Bildes abgerundet werden.</dd></div>
        <div><dt>Schatten</dt><dd>Optischer Tiefeneffekt unter oder um die Kachel.</dd></div>
        <div><dt>Hover-Effekt</dt><dd>Reaktion der Kachel, wenn der Mauszeiger darüber bewegt wird.</dd></div>
        <div><dt>Cover</dt><dd>Das Bild füllt den verfügbaren Bereich vollständig. Teile können dabei abgeschnitten werden.</dd></div>
        <div><dt>Contain</dt><dd>Das gesamte Bild bleibt sichtbar. Freie Flächen im Bildbereich sind möglich.</dd></div>
        <div><dt>Responsive</dt><dd>Die Darstellung passt sich automatisch an unterschiedliche Bildschirmgrößen an.</dd></div>
      </dl>
    </section>

    <section id="fehler" class="help-section" data-search="fehler bild nicht sichtbar änderung css block fehlt button url abgeschnitten">
      <span class="help-step">Kapitel 8</span>
      <h2>Erste Hilfe bei typischen Problemen</h2>
      <details><summary>Das neue Bild erscheint nicht.</summary><p>Prüfen Sie Dateityp und Dateigröße. Zulässig sind JPEG, PNG und WebP bis 5 MB. Speichern Sie den Block und laden Sie die Seite mit Strg+F5 neu.</p></details>
      <details><summary>Der Block erscheint nicht auf der Startseite.</summary><p>Prüfen Sie, ob „Aktiv“ markiert ist. Kontrollieren Sie anschließend die Position und leeren Sie bei Bedarf den Seitencache.</p></details>
      <details><summary>Eine visuelle Einstellung scheint keine Wirkung zu haben.</summary><p>Öffnen Sie den Experten-CSS-Modus. Dort vorhandene Deklarationen können Einstellungen des visuellen Editors überschreiben.</p></details>
      <details><summary>Der Button führt auf eine falsche Seite.</summary><p>Kontrollieren Sie die Button-URL. Interne Ziele sollten mit einem Schrägstrich beginnen, zum Beispiel <code>/kontakt.php</code>.</p></details>
      <details><summary>Text oder Bild wirken auf Mobilgeräten zu groß.</summary><p>Öffnen Sie die Mobilvorschau und reduzieren Sie Titelgröße, Innenabstand oder Bildhöhe. Eine spätere Phase ergänzt noch detaillierte Responsive-Einstellungen.</p></details>
    </section>


    <section id="farben" class="help-section" data-search="farben kontrast hintergrund text button rahmen farbwähler hex rgb barrierefreiheit lesbarkeit">
      <span class="help-step">Kapitel 9 · Phase 2</span>
      <h2>Farben und Kontraste sicher einstellen</h2>
      <p>Farben bestimmen, ob eine Block-Kachel ruhig, aufmerksamkeitsstark oder besonders vertrauenswürdig wirkt. Im visuellen Editor werden die wichtigsten Farben über Farbfelder gewählt. Jede Änderung erscheint unmittelbar in der Live-Vorschau.</p>

      <div class="help-color-anatomy">
        <div class="help-color-demo-card">
          <span class="help-color-label help-color-label--bg">1 · Hintergrund</span>
          <h3>Mathematik verständlich erklärt</h3>
          <p>Individuelle Nachhilfe mit klaren Lernschritten.</p>
          <a href="#farben" tabindex="-1">Mehr erfahren</a>
          <span class="help-color-label help-color-label--text">2 · Text</span>
          <span class="help-color-label help-color-label--button">3 · Button</span>
          <span class="help-color-label help-color-label--border">4 · Rahmen</span>
        </div>
        <div class="help-color-anatomy-text">
          <h3>Die vier wichtigsten Farbbereiche</h3>
          <ol>
            <li><strong>Hintergrundfarbe:</strong> bildet die Grundfläche der gesamten Kachel.</li>
            <li><strong>Textfarbe:</strong> gilt für Überschrift und Fließtext. Sie muss sich deutlich vom Hintergrund abheben.</li>
            <li><strong>Buttonfarbe:</strong> hebt die wichtigste Handlung hervor.</li>
            <li><strong>Rahmenfarbe:</strong> trennt die Kachel dezent vom Seitenhintergrund.</li>
          </ol>
        </div>
      </div>

      <h3>Farben im Editor ändern</h3>
      <ol class="help-steps">
        <li><strong>Farbfeld anklicken.</strong><span>Der Farbwähler des Browsers wird geöffnet.</span></li>
        <li><strong>Farbe auswählen.</strong><span>Die Änderung wird sofort in der Vorschau angezeigt.</span></li>
        <li><strong>Kontrast kontrollieren.</strong><span>Überschrift, Text und Button müssen klar lesbar bleiben.</span></li>
        <li><strong>Alle Geräteansichten prüfen.</strong><span>Insbesondere auf Mobilgeräten dürfen helle oder dünne Schriften nicht verschwimmen.</span></li>
      </ol>

      <div class="help-callout help-callout--warning"><strong>Wichtig:</strong> Eine schöne Farbe ist nicht automatisch eine gut lesbare Farbe. Entscheidend ist der Helligkeitsunterschied zwischen Vordergrund und Hintergrund.</div>

      <h3>Hex-Farbcodes verstehen</h3>
      <p>Farben werden häufig als sechsstelliger Hex-Code gespeichert. Ein Code beginnt mit <code>#</code>, beispielsweise <code>#073764</code>. Die ersten beiden Stellen beschreiben Rot, die mittleren Grün und die letzten Blau.</p>
      <table class="help-table help-color-code-table">
        <thead><tr><th>Farbe</th><th>Hex-Code</th><th>Geeignete Verwendung</th></tr></thead>
        <tbody>
          <tr><td><span class="help-swatch" style="--swatch:#ffffff"></span>Weiß</td><td><code>#FFFFFF</code></td><td>Hintergrund für ruhige, klare Kacheln</td></tr>
          <tr><td><span class="help-swatch" style="--swatch:#073764"></span>Dunkelblau</td><td><code>#073764</code></td><td>Überschriften, dunkle Hintergründe, Vertrauenswirkung</td></tr>
          <tr><td><span class="help-swatch" style="--swatch:#0057a4"></span>Blau</td><td><code>#0057A4</code></td><td>Buttons, Links und aktive Elemente</td></tr>
          <tr><td><span class="help-swatch" style="--swatch:#ffda58"></span>Goldgelb</td><td><code>#FFDA58</code></td><td>Akzente und Hervorhebungen</td></tr>
          <tr><td><span class="help-swatch" style="--swatch:#f4f7fa"></span>Hellgrau</td><td><code>#F4F7FA</code></td><td>Zurückhaltende Flächen und Abschnittstrennung</td></tr>
          <tr><td><span class="help-swatch" style="--swatch:#222222"></span>Anthrazit</td><td><code>#222222</code></td><td>Fließtext auf hellem Hintergrund</td></tr>
        </tbody>
      </table>
    </section>

    <section id="farbpaletten" class="help-section" data-search="farbpalette kombination blau gelb grün rot angebot gutschein information nachhilfe design beispiel">
      <span class="help-step">Kapitel 10 · Phase 2</span>
      <h2>Fertige Farbpaletten für Block-Kacheln</h2>
      <p>Eine Farbpalette ist eine abgestimmte Kombination aus Hintergrund-, Text-, Button- und Akzentfarbe. Die folgenden Paletten können direkt als Orientierung verwendet werden.</p>

      <div class="help-palette-grid">
        <article class="help-palette-card">
          <div class="help-palette-preview" style="--p-bg:#ffffff;--p-text:#073764;--p-button:#0057a4;--p-button-text:#ffffff;--p-border:#d5e2eb">
            <strong>Klassisch &amp; vertrauenswürdig</strong><span>Ideal für Fächer, Leistungen und allgemeine Informationen.</span><b>Mehr erfahren</b>
          </div>
          <div class="help-palette-values"><code>#FFFFFF</code><code>#073764</code><code>#0057A4</code><code>#D5E2EB</code></div>
        </article>

        <article class="help-palette-card">
          <div class="help-palette-preview" style="--p-bg:#fff8dc;--p-text:#5b4300;--p-button:#b86b00;--p-button-text:#ffffff;--p-border:#efd47a">
            <strong>Warm &amp; aufmerksam</strong><span>Geeignet für Aktionen, Ferienkurse und zeitlich begrenzte Angebote.</span><b>Platz sichern</b>
          </div>
          <div class="help-palette-values"><code>#FFF8DC</code><code>#5B4300</code><code>#B86B00</code><code>#EFD47A</code></div>
        </article>

        <article class="help-palette-card">
          <div class="help-palette-preview" style="--p-bg:#effaf3;--p-text:#174d2d;--p-button:#2a8c56;--p-button-text:#ffffff;--p-border:#aad7bb">
            <strong>Ruhig &amp; positiv</strong><span>Passend für Lernerfolge, Beratung und positive Rückmeldungen.</span><b>Beratung starten</b>
          </div>
          <div class="help-palette-values"><code>#EFFAF3</code><code>#174D2D</code><code>#2A8C56</code><code>#AAD7BB</code></div>
        </article>

        <article class="help-palette-card">
          <div class="help-palette-preview" style="--p-bg:#073764;--p-text:#ffffff;--p-button:#ffda58;--p-button-text:#26384a;--p-border:#2f6898">
            <strong>Dunkel &amp; hochwertig</strong><span>Für zentrale Angebote, besondere Hinweise oder starke Einstiegsblöcke.</span><b>Details ansehen</b>
          </div>
          <div class="help-palette-values"><code>#073764</code><code>#FFFFFF</code><code>#FFDA58</code><code>#2F6898</code></div>
        </article>
      </div>

      <div class="help-callout help-callout--tip"><strong>Empfehlung:</strong> Verwenden Sie pro Kachel höchstens eine dominante Grundfarbe und eine Akzentfarbe. Zu viele kräftige Farben konkurrieren miteinander und erschweren die Orientierung.</div>

      <h3>Welche Palette passt zu welchem Zweck?</h3>
      <table class="help-table">
        <thead><tr><th>Zweck</th><th>Empfohlene Wirkung</th><th>Geeignete Palette</th></tr></thead>
        <tbody>
          <tr><td>Allgemeine Leistungsbeschreibung</td><td>Sachlich, zuverlässig, ruhig</td><td>Klassisch &amp; vertrauenswürdig</td></tr>
          <tr><td>Ferienkurs oder Sonderaktion</td><td>Aktivierend, freundlich, deutlich</td><td>Warm &amp; aufmerksam</td></tr>
          <tr><td>Lernerfolg oder Beratung</td><td>Positiv, unterstützend, entspannt</td><td>Ruhig &amp; positiv</td></tr>
          <tr><td>Wichtiges Hauptangebot</td><td>Hochwertig, markant, fokussiert</td><td>Dunkel &amp; hochwertig</td></tr>
        </tbody>
      </table>
    </section>

    <section id="farbfehler" class="help-section" data-search="farbfehler kontrast schlecht lesbar neon zu viele farben rot grün farbenblind barrierefrei button">
      <span class="help-step">Kapitel 11 · Phase 2</span>
      <h2>Typische Farbfehler vermeiden</h2>
      <div class="help-compare-grid">
        <div class="help-compare help-compare--bad"><span>Ungünstig</span><div style="background:#fff9a8;color:#e7c800"><strong>Zu wenig Kontrast</strong><p>Der Text hebt sich kaum vom Hintergrund ab.</p></div></div>
        <div class="help-compare help-compare--good"><span>Gut</span><div style="background:#fff9a8;color:#4d4100"><strong>Klarer Kontrast</strong><p>Der Text bleibt auch bei kleiner Darstellung lesbar.</p></div></div>
        <div class="help-compare help-compare--bad"><span>Ungünstig</span><div class="help-rainbow-card"><strong>Zu viele Signalfarben</strong><p>Der Blick findet keinen eindeutigen Schwerpunkt.</p></div></div>
        <div class="help-compare help-compare--good"><span>Gut</span><div style="background:#eef7ff;color:#073764;border-color:#78a9cf"><strong>Eine klare Akzentfarbe</strong><p>Der Button ist eindeutig als wichtigste Handlung erkennbar.</p><b style="background:#0057a4;color:white">Mehr erfahren</b></div></div>
      </div>

      <h3>Prüfliste vor dem Speichern</h3>
      <ol class="help-checklist">
        <li>Ist die Überschrift sofort und ohne Anstrengung lesbar?</li>
        <li>Ist der Fließtext dunkler oder heller genug als der Hintergrund?</li>
        <li>Hebt sich der Button sowohl vom Hintergrund als auch vom übrigen Text ab?</li>
        <li>Werden Informationen nicht ausschließlich durch Rot oder Grün unterschieden?</li>
        <li>Wirkt die Kachel auch in der Mobilvorschau ruhig und klar?</li>
        <li>Passt die Farbwirkung zu Inhalt und Ziel der Kachel?</li>
      </ol>

      <details><summary>Warum sollte Rot nicht für normalen Fließtext verwendet werden?</summary><p>Rot wirkt wie eine Warnung oder Fehlermeldung und ermüdet bei längeren Texten. Es sollte gezielt für kritische Hinweise oder sehr kleine Akzente eingesetzt werden.</p></details>
      <details><summary>Kann ich reine Schwarz-Weiß-Kontraste verwenden?</summary><p>Ja. Reines Schwarz auf reinem Weiß kann jedoch sehr hart wirken. Für längere Texte ist ein dunkles Anthrazit wie <code>#222222</code> häufig angenehmer.</p></details>
      <details><summary>Warum sieht eine Farbe auf einem anderen Bildschirm anders aus?</summary><p>Monitore, Helligkeitseinstellungen und Umgebungslicht verändern die Farbwahrnehmung. Deshalb sollte die Lesbarkeit nicht nur von einer sehr feinen Farbabstufung abhängen.</p></details>
      <details><summary>Was überschreibt meine Farbauswahl?</summary><p>Einträge im Experten-CSS können die Farben des visuellen Editors überschreiben. Prüfen Sie dort insbesondere Deklarationen wie <code>background</code>, <code>background-color</code>, <code>color</code> und <code>border-color</code>.</p></details>
    </section>


    <section id="layout" class="help-section" data-search="layout grundlayout bild links rechts oben text container breite höhe ausrichtung block kachel phase 5">
      <span class="help-step">Kapitel 12 · Phase 5</span>
      <h2>Das Layoutsystem der Block-Kacheln</h2>
      <p>Das Layout bestimmt, wie Bild, Text und Schaltfläche innerhalb einer Kachel angeordnet werden. Wählen Sie zuerst das Grundlayout und verändern Sie erst danach Abstände, Größen und Farben. Dadurch bleibt die Gestaltung nachvollziehbar.</p>
      <div class="help-layout-examples">
        <article><div class="layout-demo layout-demo--right"><i></i><span><b>Text links</b><small>Bild rechts</small></span></div><h3>Bild rechts</h3><p>Gut für Leistungsangebote und erklärende Texte. Der Leser beginnt links mit der Überschrift und sieht anschließend das Bild.</p></article>
        <article><div class="layout-demo layout-demo--left"><i></i><span><b>Bild links</b><small>Text rechts</small></span></div><h3>Bild links</h3><p>Geeignet, wenn das Bild zuerst Aufmerksamkeit erzeugen soll. Bei vielen Kacheln sparsam einsetzen, damit die Leserichtung ruhig bleibt.</p></article>
        <article><div class="layout-demo layout-demo--top"><i></i><span><b>Bild oben</b><small>Text darunter</small></span></div><h3>Bild oben</h3><p>Besonders robust auf Smartphones. Es eignet sich für Kurse, Veranstaltungen und Kacheln mit quadratischen oder breiten Motiven.</p></article>
        <article><div class="layout-demo layout-demo--text"><span><b>Nur Text</b><small>ohne Bildbereich</small></span></div><h3>Nur Text</h3><p>Ideal für kurze Hinweise, Öffnungszeiten oder klare Handlungsaufforderungen. Der vorhandene Platz wird vollständig für Inhalt genutzt.</p></article>
      </div>
      <h3>Grundlayout im Editor auswählen</h3>
      <ol class="help-steps">
        <li><strong>Bereich „Visueller Editor“ öffnen.</strong><span>Die Layoutauswahl befindet sich bei den grundlegenden Gestaltungsfeldern.</span></li>
        <li><strong>Bildposition wählen.</strong><span>Wählen Sie links, rechts, oben oder ein Layout ohne Bild.</span></li>
        <li><strong>Live-Vorschau beobachten.</strong><span>Kontrollieren Sie, ob Titel, Text und Bild in der gewünschten Reihenfolge erscheinen.</span></li>
        <li><strong>Tablet und Mobil prüfen.</strong><span>Horizontale Layouts können auf kleinen Geräten automatisch untereinander angeordnet werden.</span></li>
      </ol>
      <div class="help-callout help-callout--tip"><strong>Gestaltungsregel:</strong> Verwenden Sie auf einer Seite möglichst nur zwei bis drei wiederkehrende Grundlayouts. Eine einheitliche Struktur wirkt professioneller als ständig wechselnde Anordnungen.</div>
    </section>

    <section id="abstaende" class="help-section" data-search="padding margin innenabstand außenabstand gap bild text abstand pixel phase 5">
      <span class="help-step">Kapitel 13 · Phase 5</span>
      <h2>Innenabstand, Außenabstand und Zwischenräume</h2>
      <p>Abstände schaffen Ruhe und trennen Inhalte voneinander. Zu kleine Abstände lassen eine Kachel gedrängt wirken; zu große Abstände verschwenden Platz und lösen zusammengehörige Elemente optisch voneinander.</p>
      <div class="help-spacing-diagram">
        <div class="spacing-outer"><span>Außenabstand</span><div class="spacing-border"><span>Kachelrand</span><div class="spacing-padding"><span>Innenabstand</span><div class="spacing-content"><b>Inhalt</b><small>Titel, Text und Button</small></div></div></div></div>
        <div class="spacing-notes">
          <h3>Die drei wichtigen Abstände</h3>
          <dl>
            <div><dt>Innenabstand / Padding</dt><dd>Abstand zwischen Kachelrand und Inhalt. Im Blockeditor ist dies der wichtigste Abstand.</dd></div>
            <div><dt>Bild-Text-Abstand / Gap</dt><dd>Freiraum zwischen Bild und Textbereich bei einem mehrteiligen Layout.</dd></div>
            <div><dt>Außenabstand / Margin</dt><dd>Abstand einer Kachel zu anderen Elementen. Dieser wird meist vom Seitenlayout gesteuert und sollte im Expertenmodus nur gezielt verändert werden.</dd></div>
          </dl>
        </div>
      </div>
      <table class="help-table">
        <thead><tr><th>Einstellung</th><th>Kompakt</th><th>Standard</th><th>Großzügig</th></tr></thead>
        <tbody>
          <tr><td>Innenabstand Desktop</td><td>16–20 px</td><td>24–32 px</td><td>36–48 px</td></tr>
          <tr><td>Innenabstand Mobil</td><td>14–16 px</td><td>18–24 px</td><td>24–30 px</td></tr>
          <tr><td>Bild-Text-Abstand</td><td>12–16 px</td><td>20–28 px</td><td>32–40 px</td></tr>
          <tr><td>Abstand Titel zu Text</td><td>6–8 px</td><td>10–14 px</td><td>16–20 px</td></tr>
          <tr><td>Abstand Text zu Button</td><td>12–16 px</td><td>18–24 px</td><td>26–32 px</td></tr>
        </tbody>
      </table>
      <h3>Empfohlene Vorgehensweise</h3>
      <ol class="help-steps">
        <li><strong>Mit 24 px Innenabstand beginnen.</strong><span>Dieser Wert ist für die meisten Standardkacheln ein guter Ausgangspunkt.</span></li>
        <li><strong>Textmenge beurteilen.</strong><span>Bei viel Text den Innenabstand nicht zusätzlich stark vergrößern.</span></li>
        <li><strong>Mobilansicht prüfen.</strong><span>Auf schmalen Bildschirmen wirkt derselbe Abstand optisch größer.</span></li>
        <li><strong>Einheitlichkeit kontrollieren.</strong><span>Ähnliche Kacheltypen sollten möglichst dieselben Abstände verwenden.</span></li>
      </ol>
      <div class="help-callout help-callout--warning"><strong>Achtung:</strong> Negative Außenabstände und extrem große Werte gehören ausschließlich in den Expertenmodus und können zu Überlagerungen oder abgeschnittenen Inhalten führen.</div>
    </section>

    <section id="spalten" class="help-section" data-search="container spalten grid flex breite maximalbreite 1 spalte 2 spalten 3 spalten kachel phase 5">
      <span class="help-step">Kapitel 14 · Phase 5</span>
      <h2>Container, Breite und Spalten verstehen</h2>
      <p>Die Block-Kachel liegt innerhalb eines Seitencontainers. Dieser Container begrenzt die maximale Breite und ordnet mehrere Blöcke in einer oder mehreren Spalten an. Die einzelne Kachel sollte sich grundsätzlich an die verfügbare Breite anpassen.</p>
      <div class="help-container-demo">
        <span class="container-label">Seitencontainer</span>
        <div class="container-row container-row--one"><i>1 Spalte</i></div>
        <div class="container-row container-row--two"><i>2A</i><i>2B</i></div>
        <div class="container-row container-row--three"><i>3A</i><i>3B</i><i>3C</i></div>
      </div>
      <table class="help-table">
        <thead><tr><th>Aufbau</th><th>Geeignet für</th><th>Hinweis</th></tr></thead>
        <tbody>
          <tr><td>Eine breite Kachel</td><td>zentrale Angebote, wichtige Hinweise, große Bild-Text-Blöcke</td><td>Textzeilen nicht übermäßig lang werden lassen.</td></tr>
          <tr><td>Zwei Spalten</td><td>zwei gleichwertige Leistungen oder Vergleichsinhalte</td><td>Ähnliche Textmengen und Bildhöhen verwenden.</td></tr>
          <tr><td>Drei Spalten</td><td>Fächer, Vorteile oder kompakte Leistungsübersichten</td><td>Kurze Titel und wenig Fließtext verwenden.</td></tr>
          <tr><td>Gemischte Breiten</td><td>redaktionelle Startseiten und hervorgehobene Angebote</td><td>Nur verwenden, wenn die visuelle Hierarchie eindeutig ist.</td></tr>
        </tbody>
      </table>
      <h3>Breitenregeln für einzelne Kacheln</h3>
      <ul class="help-checklist">
        <li>Die Kachel sollte normalerweise <code>width: 100%</code> des verfügbaren Spaltenplatzes nutzen.</li>
        <li>Eine feste Pixelbreite im Experten-CSS kann die mobile Darstellung beschädigen.</li>
        <li>Eine Mindesthöhe ist sinnvoll, wenn mehrere nebeneinanderliegende Kacheln gleich hoch wirken sollen.</li>
        <li>Sehr lange Texte sollten nicht durch eine extrem große Mindesthöhe ausgeglichen werden.</li>
        <li>Bildgrößen müssen zur tatsächlichen Spaltenbreite passen, damit keine unnötig großen Dateien geladen werden.</li>
      </ul>
    </section>

    <section id="responsive-layout" class="help-section" data-search="responsive desktop tablet mobil umbruch stacking reihenfolge bild text breite phase 5">
      <span class="help-step">Kapitel 15 · Phase 5</span>
      <h2>Responsiver Seitenaufbau auf Desktop, Tablet und Smartphone</h2>
      <p>Responsive Gestaltung bedeutet nicht nur, dass eine Kachel kleiner wird. Die Elemente dürfen ihre Anordnung ändern, damit Bild, Text und Button auf jeder Bildschirmbreite gut bedienbar bleiben.</p>
      <div class="help-responsive-flow">
        <article><span class="responsive-screen responsive-screen--desktop"><i></i><i></i><i></i></span><h3>Desktop</h3><p>Mehrere Spalten und horizontale Bild-Text-Layouts sind möglich. Großzügige Abstände können eingesetzt werden.</p></article>
        <article><span class="responsive-screen responsive-screen--tablet"><i></i><i></i></span><h3>Tablet</h3><p>Drei Spalten werden häufig zu zwei Spalten. Sehr breite Bildbereiche sollten reduziert werden.</p></article>
        <article><span class="responsive-screen responsive-screen--mobile"><i></i><i></i><i></i></span><h3>Smartphone</h3><p>Kacheln stehen normalerweise untereinander. Bild und Text werden vertikal angeordnet; Buttons sollten gut antippbar sein.</p></article>
      </div>
      <h3>Prüfliste für jedes Layout</h3>
      <ul class="help-checklist">
        <li>Kein Text ragt über den Kachelrand hinaus.</li>
        <li>Der Button ist vollständig sichtbar und mindestens etwa 44 px hoch.</li>
        <li>Das Bild verdeckt weder Titel noch Schaltfläche.</li>
        <li>Die Leserichtung bleibt auch nach dem Umbruch logisch.</li>
        <li>Zwischen zwei aufeinanderfolgenden Kacheln bleibt ein klarer Abstand.</li>
        <li>Es entsteht kein horizontaler Scrollbalken.</li>
      </ul>
      <div class="help-callout help-callout--info"><strong>Praxisregel:</strong> Eine Änderung gilt erst als abgeschlossen, wenn Desktop-, Tablet- und Mobilvorschau geprüft wurden. Anschließend sollte die echte Startseite zusätzlich in einem schmalen Browserfenster kontrolliert werden.</div>
    </section>



    <section id="typografie" class="help-section" data-search="typografie schrift schriftart font sans serif monospace gewicht fett normal lesbarkeit phase 3">
      <span class="help-step">Kapitel 16 · Phase 3</span>
      <h2>Typografie-Grundlagen für Block-Kacheln</h2>
      <p>Typografie bestimmt, wie schnell Besucher eine Kachel erfassen und welche Information zuerst wahrgenommen wird. Eine gute Kachel besitzt eine klare Reihenfolge: zuerst die Überschrift, danach der erklärende Text und zuletzt die Handlungsschaltfläche.</p>
      <div class="help-type-hierarchy">
        <article><span>1</span><div><strong class="type-title-demo">Mathematik-Nachhilfe</strong><small>Die Überschrift benennt das Thema eindeutig.</small></div></article>
        <article><span>2</span><div><strong class="type-body-demo">Verständliche Erklärungen und individuelle Lernschritte.</strong><small>Der Fließtext ergänzt nur die wichtigsten Informationen.</small></div></article>
        <article><span>3</span><div><b class="type-button-demo">Termin anfragen</b><small>Der Button zeigt die nächste Handlung.</small></div></article>
      </div>
      <h3>Welche Schriftart sollte verwendet werden?</h3>
      <table class="help-table">
        <thead><tr><th>Schriftgruppe</th><th>Wirkung</th><th>Empfehlung</th></tr></thead>
        <tbody>
          <tr><td><span class="font-demo font-demo--sans">Sans Serif</span></td><td>Klar, modern und auf Bildschirmen gut lesbar</td><td>Standardwahl für Überschriften, Texte und Buttons</td></tr>
          <tr><td><span class="font-demo font-demo--serif">Serif</span></td><td>Klassisch und redaktionell</td><td>Nur gezielt für einzelne große Überschriften</td></tr>
          <tr><td><span class="font-demo font-demo--mono">Monospace</span></td><td>Technisch; alle Zeichen sind gleich breit</td><td>Nur für Code, Werte oder technische Beispiele</td></tr>
        </tbody>
      </table>
      <div class="help-callout help-callout--tip"><strong>Empfehlung:</strong> Verwenden Sie innerhalb einer Kachel möglichst nur eine Schriftfamilie. Unterschiede sollten vor allem durch Größe, Gewicht und Abstand entstehen.</div>
    </section>

    <section id="schriftgroessen" class="help-section" data-search="schriftgröße font size desktop tablet smartphone titel text button gewicht 300 400 500 600 700 phase 3">
      <span class="help-step">Kapitel 17 · Phase 3</span>
      <h2>Schriftgrößen und Schriftstärken einstellen</h2>
      <p>Die Überschrift muss deutlich hervortreten, darf aber den Inhalt nicht verdrängen. Der Fließtext soll ohne Vergrößern lesbar sein. Für Block-Kacheln haben sich folgende Ausgangswerte bewährt:</p>
      <table class="help-table">
        <thead><tr><th>Element</th><th>Desktop</th><th>Tablet</th><th>Smartphone</th><th>Übliche Stärke</th></tr></thead>
        <tbody>
          <tr><td>Große Aktionsüberschrift</td><td>32–40 px</td><td>28–34 px</td><td>24–30 px</td><td>600–700</td></tr>
          <tr><td>Normale Kachelüberschrift</td><td>24–30 px</td><td>22–28 px</td><td>20–25 px</td><td>600–700</td></tr>
          <tr><td>Fließtext</td><td>17–19 px</td><td>16–18 px</td><td>16–18 px</td><td>400</td></tr>
          <tr><td>Button</td><td>16–18 px</td><td>16–18 px</td><td>16–18 px</td><td>600–700</td></tr>
          <tr><td>Kleine Zusatzinformation</td><td>14–16 px</td><td>14–16 px</td><td>14–16 px</td><td>400–500</td></tr>
        </tbody>
      </table>
      <div class="help-weight-scale">
        <div style="--weight:300"><span>300</span><b>Light – sparsam verwenden</b></div>
        <div style="--weight:400"><span>400</span><b>Normal – ideal für Fließtext</b></div>
        <div style="--weight:500"><span>500</span><b>Medium – dezente Hervorhebung</b></div>
        <div style="--weight:600"><span>600</span><b>Semibold – gute Überschrift</b></div>
        <div style="--weight:700"><span>700</span><b>Bold – starke Hervorhebung</b></div>
        <div style="--weight:800"><span>800</span><b>Extrabold – nur kurze Akzente</b></div>
      </div>
      <div class="help-callout help-callout--warning"><strong>Vermeiden:</strong> Den gesamten Text fett zu setzen. Wenn alles hervorgehoben ist, ist nichts mehr hervorgehoben.</div>
    </section>

    <section id="zeilenhoehe" class="help-section" data-search="zeilenhöhe line height buchstabenabstand letter spacing wortabstand absatz lesbar phase 3">
      <span class="help-step">Kapitel 18 · Phase 3</span>
      <h2>Zeilenhöhe, Zeichenabstand und Absatzlänge</h2>
      <p>Die Zeilenhöhe beschreibt den vertikalen Abstand zwischen zwei Textzeilen. Für Fließtext ist ein Wert zwischen <code>1.45</code> und <code>1.7</code> meist angenehm. Überschriften benötigen weniger Abstand.</p>
      <div class="help-lineheight-grid">
        <article class="lineheight-bad"><span>Zu eng · 1.05</span><p>Gute Nachhilfe erklärt nicht nur das Ergebnis, sondern macht den Lösungsweg verständlich und nachvollziehbar.</p></article>
        <article class="lineheight-good"><span>Empfohlen · 1.55</span><p>Gute Nachhilfe erklärt nicht nur das Ergebnis, sondern macht den Lösungsweg verständlich und nachvollziehbar.</p></article>
        <article class="lineheight-wide"><span>Zu weit · 2.1</span><p>Gute Nachhilfe erklärt nicht nur das Ergebnis, sondern macht den Lösungsweg verständlich und nachvollziehbar.</p></article>
      </div>
      <table class="help-table">
        <thead><tr><th>Einstellung</th><th>Empfohlener Bereich</th><th>Hinweis</th></tr></thead>
        <tbody>
          <tr><td>Zeilenhöhe Überschrift</td><td>1.1–1.3</td><td>Mehrzeilige Titel bleiben kompakt.</td></tr>
          <tr><td>Zeilenhöhe Fließtext</td><td>1.45–1.7</td><td>Bei kleinen Schriften eher den höheren Wert wählen.</td></tr>
          <tr><td>Zeichenabstand Fließtext</td><td>0 bis 0.02em</td><td>Normalerweise unverändert lassen.</td></tr>
          <tr><td>Zeichenabstand Großbuchstaben</td><td>0.04–0.09em</td><td>Nur bei kurzen Kennzeichnungen verwenden.</td></tr>
          <tr><td>Textlänge pro Kachel</td><td>2–5 kurze Sätze</td><td>Längere Inhalte besser auf eine Unterseite auslagern.</td></tr>
        </tbody>
      </table>
    </section>

    <section id="textausrichtung" class="help-section" data-search="textausrichtung links zentriert rechts blocksatz lesbarkeit textbreite zeilenlänge phase 3">
      <span class="help-step">Kapitel 19 · Phase 3</span>
      <h2>Textausrichtung und Lesbarkeit</h2>
      <div class="help-align-grid">
        <article class="align-left"><span>Linksbündig</span><h3>Für längere Inhalte</h3><p>Linksbündiger Text ist auf Webseiten am leichtesten zu lesen und sollte der Standard sein.</p></article>
        <article class="align-center"><span>Zentriert</span><h3>Für kurze Botschaften</h3><p>Geeignet für kompakte Aktionskacheln mit wenigen Zeilen.</p></article>
        <article class="align-right"><span>Rechtsbündig</span><h3>Nur als Gestaltungsmittel</h3><p>Bei längeren Texten entsteht eine unruhige linke Lesekante.</p></article>
      </div>
      <h3>Regeln für gut lesbare Kacheln</h3>
      <ul class="help-checklist">
        <li>Fließtext mit mehr als drei Zeilen grundsätzlich linksbündig ausrichten.</li>
        <li>Zentrierte Texte kurz halten und nicht über die gesamte Seitenbreite ziehen.</li>
        <li>Blocksatz in schmalen Kacheln vermeiden, da große Wortabstände entstehen können.</li>
        <li>Pro Zeile ungefähr 45 bis 75 Zeichen anstreben.</li>
        <li>Überschrift und Text nicht direkt an Bildkanten oder Kachelränder setzen.</li>
        <li>Kursivschrift nur für kurze Hinweise einsetzen.</li>
      </ul>
    </section>

    <section id="responsive-typografie" class="help-section" data-search="responsive typografie clamp mobil desktop tablet schrift verkleinern umbrechen phase 3">
      <span class="help-step">Kapitel 20 · Phase 3</span>
      <h2>Responsive Typografie prüfen</h2>
      <p>Auf kleineren Bildschirmen sollte die Schrift nicht einfach proportional verkleinert werden. Fließtext bleibt mindestens etwa 16 px groß; hauptsächlich Überschriften und Abstände werden angepasst.</p>
      <div class="help-responsive-type">
        <article><b>Desktop</b><strong>32 px Titel</strong><p>18 px Fließtext · großzügige Abstände</p></article>
        <article><b>Tablet</b><strong>28 px Titel</strong><p>17 px Fließtext · mittlere Abstände</p></article>
        <article><b>Smartphone</b><strong>24 px Titel</strong><p>16 px Fließtext · kompakte Abstände</p></article>
      </div>
      <ol class="help-steps">
        <li><strong>Desktopansicht prüfen.</strong><span>Stimmt die Hierarchie zwischen Titel, Text und Button?</span></li>
        <li><strong>Tabletansicht öffnen.</strong><span>Bricht der Titel an einer sinnvollen Stelle um?</span></li>
        <li><strong>Mobilansicht öffnen.</strong><span>Bleiben Text und Button ohne Zoomen lesbar?</span></li>
        <li><strong>Lange Wörter kontrollieren.</strong><span>Fachbegriffe dürfen nicht über den Kachelrand hinausragen.</span></li>
      </ol>
      <div class="help-callout help-callout--info"><strong>Expertenhinweis:</strong> Mit <code>font-size: clamp(24px, 4vw, 36px);</code> kann eine Überschrift fließend zwischen einer Mindest- und Maximalgröße skalieren.</div>
    </section>

    <section id="typografie-praxis" class="help-section" data-search="praxis typografie vorlage hero angebot info kontakt kurs css werte phase 3">
      <span class="help-step">Kapitel 21 · Phase 3</span>
      <h2>Direkt nutzbare Typografie-Vorlagen</h2>
      <div class="help-type-presets">
        <article><span>Standard-Kachel</span><h3>Mathematik verständlich lernen</h3><p>Klare Erklärungen und individuelle Unterstützung.</p><code>Titel 28 px / 700 · Text 18 px / 400 · Zeilenhöhe 1.55</code></article>
        <article><span>Aktions-Kachel</span><h3>Ferienkurs jetzt sichern</h3><p>Kompakt, aufmerksamkeitsstark und mit klarer Handlungsaufforderung.</p><code>Titel 34 px / 800 · Text 18 px / 500 · Button 17 px / 700</code></article>
        <article><span>Informations-Kachel</span><h3>So funktioniert die Anmeldung</h3><p>Ruhige Typografie für etwas ausführlichere Erläuterungen.</p><code>Titel 25 px / 600 · Text 17 px / 400 · Zeilenhöhe 1.65</code></article>
        <article><span>Kontakt-Kachel</span><h3>Persönlich beraten lassen</h3><p>Kurzer Text, deutlicher Button und gute mobile Lesbarkeit.</p><code>Titel 30 px / 700 · Text 17 px / 400 · Button 18 px / 700</code></article>
      </div>
      <h3>Abschlussprüfung Typografie</h3>
      <ul class="help-checklist">
        <li>Die Überschrift ist innerhalb von zwei bis drei Sekunden erfassbar.</li>
        <li>Fließtext ist auf dem Smartphone ohne Vergrößern lesbar.</li>
        <li>Nicht mehr als zwei bis drei verschiedene Schriftgrößen werden verwendet.</li>
        <li>Fett, Kursiv und Großbuchstaben werden sparsam eingesetzt.</li>
        <li>Der Button ist typografisch deutlich, aber nicht größer als die Überschrift.</li>
      </ul>
    </section>

    <section id="ausblick" class="help-section" data-search="weitere phasen farben typografie bilder layout abstände hover experten css beispiele faq">
      <span class="help-step">Kapitel 22</span>
      <h2>Ausbau in den nächsten Phasen</h2>
      <p>Die Grundbedienung, Farben, Layout und Typografie sind jetzt ausführlich dokumentiert. Die folgenden Phasen ergänzen die Anleitung schrittweise.</p>
      <ul class="help-roadmap">
        <li><b>Phase 2:</b> Farben, Kontraste und Farbbeispiele <strong>– abgeschlossen</strong></li>
        <li><b>Phase 3:</b> Typografie, Größen und Lesbarkeit <strong>– abgeschlossen</strong></li>
        <li><b>Phase 4:</b> Bilder, Bildausschnitt und Bildposition</li>
        <li><b>Phase 5:</b> Layout, Abstände, Container und responsive Anordnung <strong>– abgeschlossen</strong></li>
        <li><b>Phase 6:</b> Hover-Effekte und responsive Darstellung</li>
        <li><b>Phase 7:</b> Experten-CSS mit sicheren Praxisbeispielen</li>
        <li><b>Phase 8:</b> fertige Designbeispiele, Best Practices und ausführliche FAQ</li>
      </ul>
    </section>
  </article>
</div>

<a class="help-back-top" href="#top" aria-label="Zum Seitenanfang">↑</a>
<script src="<?= admin_e(app_path('/assets/js/homepage-block-help.js')) ?>" defer></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
