
<div class="calculator" data-tool="grades">
  <header class="calculator__header">
    <h2>Gewichtete Gesamtnote berechnen</h2>
    <p>Trage Noten und Gewichtungen ein. Die Gewichtung kann beispielsweise 1, 2 oder 3 betragen.</p>
  </header>
  <div class="grade-rows" id="gradeRows">
    <div class="grade-row">
      <label>Note 1<input type="number" min="1" max="6" step="0.01" value="2" class="grade-value"></label>
      <label>Gewichtung<input type="number" min="0.1" step="0.1" value="1" class="grade-weight"></label>
      <button type="button" class="remove-row" aria-label="Zeile entfernen">×</button>
    </div>
    <div class="grade-row">
      <label>Note 2<input type="number" min="1" max="6" step="0.01" value="3" class="grade-value"></label>
      <label>Gewichtung<input type="number" min="0.1" step="0.1" value="1" class="grade-weight"></label>
      <button type="button" class="remove-row" aria-label="Zeile entfernen">×</button>
    </div>
  </div>
  <div class="calculator__actions">
    <button type="button" class="button button--blue" id="addGradeRow">Weitere Note</button>
    <button type="button" class="button button--gold" id="calculateGrades">Berechnen</button>
  </div>
  <output class="calculator__result" id="gradeResult" aria-live="polite">Ergebnis: –</output>
  <details class="formula-box"><summary>Wie wird gerechnet?</summary><p>Gewichtete Note = Summe aus Note × Gewichtung, geteilt durch die Summe aller Gewichtungen.</p></details>
</div>
