window.addEventListener('easyit:consent', event => {
  if (!event.detail?.analytics) return;

  const eventData = {
    path: location.pathname,
    referrer: document.referrer ? new URL(document.referrer).hostname : '',
    timestamp: new Date().toISOString()
  };

  // Absichtlich keine Übertragung aktiviert.
  // Hier kann später eine datenschutzkonforme, selbst gehostete Analyse angebunden werden.
  window.easyitAnalyticsPageview = eventData;
});