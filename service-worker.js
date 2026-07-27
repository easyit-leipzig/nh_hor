const CACHE_VERSION = 'easyit-assets-3-17-header-half';
const CORE_ASSETS = [
  'assets/img/subjects/latein.svg',
  'assets/img/subjects/spanisch.svg',
  'assets/img/subjects/franzoesisch.svg',
  'assets/img/subjects/englisch.svg',
  'assets/img/subjects/deutsch.svg',
  'assets/img/subjects/informatik.svg',
  'assets/img/subjects/chemie.svg',
  'assets/img/subjects/physik.svg',
  'assets/img/subjects/mathe.svg',
  'assets/img/lern-stud.svg',
  'assets/img/stud-lern.svg',
  './',
  'assets/css/main.a58c73c19cb9.css',
  'assets/css/header.56eb2f6e7ed4.css',
  'assets/css/sidebar.0ea8ee0a632a.css',
  'assets/css/content.701997f4d583.css',
  'assets/css/footer.664f675d327e.css',
  'assets/js/app.8f5604aebdb8.js',
  'assets/img/brand-logo.svg',
  'assets/img/social-preview-1200x630.png',
  'assets/img/favicon.svg',
  'offline.php'
];

self.addEventListener('install', event => {
  event.waitUntil(caches.open(CACHE_VERSION).then(cache => cache.addAll(CORE_ASSETS)));
  self.skipWaiting();
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(keys.filter(key => key !== CACHE_VERSION).map(key => caches.delete(key)))
    )
  );
  self.clients.claim();
});

self.addEventListener('fetch', event => {
  if (event.request.method !== 'GET') return;

  event.respondWith(
    fetch(event.request)
      .then(response => {
        const clone = response.clone();
        caches.open(CACHE_VERSION).then(cache => cache.put(event.request, clone));
        return response;
      })
      .catch(() =>
        caches.match(event.request).then(cached =>
          cached || (event.request.mode === 'navigate' ? caches.match('offline.php') : undefined)
        )
      )
  );
});
