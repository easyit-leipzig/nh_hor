
<div class="calculator" data-tool="units">
  <header class="calculator__header">
    <h2>Einheiten umrechnen</h2>
    <p>Wähle Kategorie, Ausgangseinheit und Zieleinheit.</p>
  </header>
  <div class="input-grid">
    <label>Kategorie<select id="unitCategory"><option value="length">Länge</option><option value="mass">Masse</option><option value="time">Zeit</option></select></label>
    <label>Wert<input type="number" id="unitValue" value="1" step="any"></label>
    <label>Von<select id="unitFrom"></select></label>
    <label>Nach<select id="unitTo"></select></label>
  </div>
  <button type="button" class="button button--gold" id="convertUnit">Umrechnen</button>
  <output class="calculator__result" id="unitResult" aria-live="polite">Ergebnis: –</output>
  <details class="formula-box"><summary>Hinweis</summary><p>Intern wird zuerst in eine Basiseinheit umgerechnet und anschließend in die gewünschte Zieleinheit.</p></details>
</div>
