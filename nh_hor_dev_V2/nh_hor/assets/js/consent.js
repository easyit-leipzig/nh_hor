document.addEventListener('DOMContentLoaded', () => {
  const STORAGE_KEY = 'easyit.consent.v1';
  const existing = localStorage.getItem(STORAGE_KEY);

  const applyConsent = consent => {
    document.documentElement.dataset.analyticsConsent = consent.analytics ? 'granted' : 'denied';
    window.dispatchEvent(new CustomEvent('easyit:consent', {detail: consent}));
  };

  if (existing) {
    try { applyConsent(JSON.parse(existing)); } catch (_) {}
    return;
  }

  const banner = document.createElement('section');
  banner.className = 'consent-banner';
  banner.setAttribute('aria-label', 'Datenschutzeinstellungen');
  banner.innerHTML = `
    <div>
      <strong>Datensparsame Website</strong>
      <p>Notwendige Funktionen laufen ohne Tracking. Optionale anonyme Reichweitenmessung ist nur mit Zustimmung vorgesehen.</p>
    </div>
    <div class="consent-actions">
      <button type="button" class="button button--blue" data-consent="necessary">Nur notwendig</button>
      <button type="button" class="button button--gold" data-consent="all">Alle erlauben</button>
    </div>`;
  document.body.appendChild(banner);

  banner.addEventListener('click', event => {
    const choice = event.target.dataset.consent;
    if (!choice) return;
    const consent = {
      necessary: true,
      analytics: choice === 'all',
      timestamp: new Date().toISOString()
    };
    localStorage.setItem(STORAGE_KEY, JSON.stringify(consent));
    applyConsent(consent);
    banner.remove();
  });
});