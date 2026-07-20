
<div class="calculator" data-tool="percent">
  <header class="calculator__header">
    <h2>Prozentrechnung</h2>
    <p>Wähle aus, welche Größe gesucht ist.</p>
  </header>
  <label class="full-label">Gesuchte Größe
    <select id="percentMode">
      <option value="percentValue">Prozentwert W</option>
      <option value="baseValue">Grundwert G</option>
      <option value="rate">Prozentsatz p %</option>
    </select>
  </label>
  <div class="input-grid" id="percentInputs"></div>
  <button type="button" class="button button--gold" id="calculatePercent">Berechnen</button>
  <output class="calculator__result" id="percentResult" aria-live="polite">Ergebnis: –</output>
  <details class="formula-box"><summary>Formeln</summary><p>W = G × p / 100 · G = W × 100 / p · p = W × 100 / G</p></details>
</div>
