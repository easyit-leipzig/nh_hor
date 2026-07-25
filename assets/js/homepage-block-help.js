(() => {
  'use strict';
  const input = document.getElementById('help-search-input');
  const reset = document.getElementById('help-search-reset');
  const status = document.getElementById('help-search-status');
  const sections = [...document.querySelectorAll('.help-section')];
  const links = [...document.querySelectorAll('.help-sidebar a')];
  if (!input || !reset || !status) return;

  const normalize = value => value.toLocaleLowerCase('de-DE').normalize('NFD').replace(/[\u0300-\u036f]/g, '');
  const filter = () => {
    const term = normalize(input.value.trim());
    let visible = 0;
    sections.forEach(section => {
      const haystack = normalize(`${section.textContent || ''} ${section.dataset.search || ''}`);
      const show = !term || haystack.includes(term);
      section.hidden = !show;
      if (show) visible += 1;
    });
    status.textContent = term ? `${visible} von ${sections.length} Kapiteln gefunden.` : 'Alle Inhalte werden angezeigt.';
  };
  input.addEventListener('input', filter);
  reset.addEventListener('click', () => { input.value = ''; filter(); input.focus(); });

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(entries => {
      const current = entries.filter(entry => entry.isIntersecting).sort((a,b) => b.intersectionRatio - a.intersectionRatio)[0];
      if (!current) return;
      links.forEach(link => link.classList.toggle('is-active', link.getAttribute('href') === `#${current.target.id}`));
    }, {rootMargin: '-15% 0px -70% 0px', threshold: [0,.2,.5]});
    sections.forEach(section => observer.observe(section));
  }
})();
