document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('siteSearchInput');
  const results = document.getElementById('siteSearchResults');
  if (!input || !results || !window.EASYIT_SEARCH_INDEX) return;

  const normalize = value => value.toLocaleLowerCase('de-DE')
    .normalize('NFD').replace(/\p{Diacritic}/gu, '');

  input.addEventListener('input', () => {
    const query = normalize(input.value.trim());
    if (query.length < 2) {
      results.innerHTML = '';
      results.hidden = true;
      return;
    }

    const tokens = query.split(/\s+/).filter(Boolean);
    const matches = window.EASYIT_SEARCH_INDEX.filter(item => {
      const haystack = normalize(`${item.title} ${item.keywords}`);
      return tokens.every(token => haystack.includes(token));
    }).slice(0, 8);

    results.innerHTML = matches.length
      ? matches.map(item => `<li><a href="${item.url}"><strong>${item.title}</strong><span>${item.url}</span></a></li>`).join('')
      : '<li class="search-empty">Keine passende Seite gefunden.</li>';

    results.hidden = false;
  });

  document.addEventListener('click', event => {
    if (!event.target.closest('.site-search')) {
      results.hidden = true;
    }
  });

  input.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
      results.hidden = true;
      input.blur();
    }
  });
});