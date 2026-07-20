document.addEventListener('DOMContentLoaded', () => {
  const format = value => new Intl.NumberFormat('de-DE', {maximumFractionDigits: 4}).format(value);

  // Notenrechner
  const gradeRows = document.getElementById('gradeRows');
  document.getElementById('addGradeRow')?.addEventListener('click', () => {
    const count = gradeRows.querySelectorAll('.grade-row').length + 1;
    const row = document.createElement('div');
    row.className = 'grade-row';
    row.innerHTML = `<label>Note ${count}<input type="number" min="1" max="6" step="0.01" value="2" class="grade-value"></label>
      <label>Gewichtung<input type="number" min="0.1" step="0.1" value="1" class="grade-weight"></label>
      <button type="button" class="remove-row" aria-label="Zeile entfernen">×</button>`;
    gradeRows.appendChild(row);
  });
  gradeRows?.addEventListener('click', event => {
    if (event.target.classList.contains('remove-row') && gradeRows.children.length > 1) {
      event.target.closest('.grade-row').remove();
    }
  });
  document.getElementById('calculateGrades')?.addEventListener('click', () => {
    let weighted = 0, weights = 0, valid = true;
    gradeRows.querySelectorAll('.grade-row').forEach(row => {
      const grade = Number(row.querySelector('.grade-value').value);
      const weight = Number(row.querySelector('.grade-weight').value);
      if (!Number.isFinite(grade) || grade < 1 || grade > 6 || !Number.isFinite(weight) || weight <= 0) valid = false;
      weighted += grade * weight;
      weights += weight;
    });
    const out = document.getElementById('gradeResult');
    out.textContent = valid && weights > 0 ? `Gewichtete Gesamtnote: ${format(weighted / weights)}` : 'Bitte gültige Noten von 1 bis 6 und positive Gewichtungen eingeben.';
  });

  // Prozentrechner
  const percentMode = document.getElementById('percentMode');
  const percentInputs = document.getElementById('percentInputs');
  const renderPercentInputs = () => {
    if (!percentMode || !percentInputs) return;
    const configs = {
      percentValue: [['Grundwert G','base'],['Prozentsatz p %','rate']],
      baseValue: [['Prozentwert W','value'],['Prozentsatz p %','rate']],
      rate: [['Prozentwert W','value'],['Grundwert G','base']]
    };
    percentInputs.innerHTML = configs[percentMode.value].map(([label,id]) =>
      `<label>${label}<input type="number" step="any" id="percent-${id}"></label>`).join('');
  };
  percentMode?.addEventListener('change', renderPercentInputs);
  renderPercentInputs();
  document.getElementById('calculatePercent')?.addEventListener('click', () => {
    const mode = percentMode.value;
    const n = id => Number(document.getElementById(`percent-${id}`)?.value);
    let result;
    if (mode === 'percentValue') result = n('base') * n('rate') / 100;
    if (mode === 'baseValue') result = n('value') * 100 / n('rate');
    if (mode === 'rate') result = n('value') * 100 / n('base');
    document.getElementById('percentResult').textContent =
      Number.isFinite(result) ? `Ergebnis: ${format(result)}${mode === 'rate' ? ' %' : ''}` : 'Bitte gültige Werte eingeben. Division durch 0 ist nicht möglich.';
  });

  // Einheitenrechner
  const units = {
    length: {m:1, km:1000, cm:.01, mm:.001},
    mass: {kg:1, g:.001, mg:.000001, t:1000},
    time: {s:1, min:60, h:3600, d:86400}
  };
  const unitCategory = document.getElementById('unitCategory');
  const unitFrom = document.getElementById('unitFrom');
  const unitTo = document.getElementById('unitTo');
  const renderUnits = () => {
    if (!unitCategory) return;
    const opts = Object.keys(units[unitCategory.value]).map(u => `<option value="${u}">${u}</option>`).join('');
    unitFrom.innerHTML = opts;
    unitTo.innerHTML = opts;
    unitTo.selectedIndex = Math.min(1, unitTo.options.length - 1);
  };
  unitCategory?.addEventListener('change', renderUnits);
  renderUnits();
  document.getElementById('convertUnit')?.addEventListener('click', () => {
    const value = Number(document.getElementById('unitValue').value);
    const cat = unitCategory.value;
    const result = value * units[cat][unitFrom.value] / units[cat][unitTo.value];
    document.getElementById('unitResult').textContent =
      Number.isFinite(result) ? `${format(value)} ${unitFrom.value} = ${format(result)} ${unitTo.value}` : 'Bitte einen gültigen Wert eingeben.';
  });

  // Lernzeitplaner
  const examDate = document.getElementById('examDate');
  if (examDate) {
    const d = new Date();
    d.setDate(d.getDate() + 14);
    examDate.value = d.toISOString().slice(0,10);
  }
  document.getElementById('calculateStudyPlan')?.addEventListener('click', () => {
    const exam = new Date(`${examDate.value}T12:00:00`);
    const today = new Date(); today.setHours(12,0,0,0);
    const days = Math.ceil((exam - today) / 86400000);
    const hours = Number(document.getElementById('studyHours').value);
    const daysPerWeek = Number(document.getElementById('studyDaysPerWeek').value);
    const maxMinutes = Number(document.getElementById('maxMinutes').value);
    const result = document.getElementById('studyResult');
    const plan = document.getElementById('studyPlan');
    if (days <= 0 || hours <= 0 || daysPerWeek < 1 || daysPerWeek > 7 || maxMinutes < 15) {
      result.textContent = 'Bitte ein zukünftiges Datum und gültige Werte eingeben.';
      plan.innerHTML = '';
      return;
    }
    const possibleDays = Math.max(1, Math.floor(days / 7 * daysPerWeek));
    const neededMinutes = hours * 60;
    const sessions = Math.ceil(neededMinutes / maxMinutes);
    const actualSessions = Math.max(sessions, Math.min(possibleDays, sessions));
    const minutesPerSession = Math.ceil(neededMinutes / actualSessions);
    result.textContent = `${days} Tage verbleiben. Plane etwa ${actualSessions} Lerneinheiten mit jeweils ungefähr ${minutesPerSession} Minuten.`;
    plan.innerHTML = `<div class="plan-stat"><strong>${days}</strong><span>Tage</span></div>
      <div class="plan-stat"><strong>${actualSessions}</strong><span>Lerneinheiten</span></div>
      <div class="plan-stat"><strong>${minutesPerSession}</strong><span>Minuten je Einheit</span></div>`;
  });
});