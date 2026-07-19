const CACHE_VERSION = 'easyit-phase10-images-v1';
const CORE_ASSETS = [
  '/assets/img/subjects/latein.svg',
  '/assets/img/subjects/spanisch.svg',
  '/assets/img/subjects/franzoesisch.svg',
  '/assets/img/subjects/englisch.svg',
  '/assets/img/subjects/deutsch.svg',
  '/assets/img/subjects/informatik.svg',
  '/assets/img/subjects/chemie.svg',
  '/assets/img/subjects/physik.svg',
  '/assets/img/subjects/mathe.svg',
  '/assets/img/lern-stud.svg',
  '/assets/img/stud-lern.svg',
  '/',
  '/assets/css/main.css',
  '/assets/css/header.css',
  '/assets/css/sidebar.css',
  '/assets/css/content.css',
  '/assets/css/footer.css',
  '/assets/js/nojquery_3.1.1.js',
  '/assets/js/app.js',
  '/assets/img/logo.svg',
  '/assets/img/favicon.svg',
  '/offline.php'
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
          cached || (event.request.mode === 'navigate' ? caches.match('/offline.php') : undefined)
        )
      )
  );
});
