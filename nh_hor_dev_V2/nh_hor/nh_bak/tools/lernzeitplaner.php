
<div class="calculator" data-tool="study">
  <header class="calculator__header">
    <h2>Lernzeit bis zur Prüfung planen</h2>
    <p>Der Plan verteilt die Gesamtlernzeit auf die verfügbaren Lerntage.</p>
  </header>
  <div class="input-grid">
    <label>Prüfungsdatum<input type="date" id="examDate"></label>
    <label>Gesamter Lernaufwand in Stunden<input type="number" id="studyHours" min="1" step="0.5" value="12"></label>
    <label>Lerntage pro Woche<input type="number" id="studyDaysPerWeek" min="1" max="7" value="5"></label>
    <label>Maximal pro Lerntag in Minuten<input type="number" id="maxMinutes" min="15" step="15" value="90"></label>
  </div>
  <button type="button" class="button button--gold" id="calculateStudyPlan">Plan berechnen</button>
  <output class="calculator__result" id="studyResult" aria-live="polite">Ergebnis: –</output>
  <div class="study-plan" id="studyPlan"></div>
  <details class="formula-box"><summary>Planungsprinzip</summary><p>Die verbleibende Zeit wird in mögliche Lerntage umgerechnet. Der Plan ist eine Orientierung und sollte Pausen sowie Wiederholungstage enthalten.</p></details>
</div>
