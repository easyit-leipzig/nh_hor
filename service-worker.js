const CACHE_VERSION = 'easyit-phase10-images-v1';
const CORE_ASSETS = [
  '/nh_hor/assets/img/subjects/latein.svg',
  '/nh_hor/assets/img/subjects/spanisch.svg',
  '/nh_hor/assets/img/subjects/franzoesisch.svg',
  '/nh_hor/assets/img/subjects/englisch.svg',
  '/nh_hor/assets/img/subjects/deutsch.svg',
  '/nh_hor/assets/img/subjects/informatik.svg',
  '/nh_hor/assets/img/subjects/chemie.svg',
  '/nh_hor/assets/img/subjects/physik.svg',
  '/nh_hor/assets/img/subjects/mathe.svg',
  '/nh_hor/assets/img/lern-stud.svg',
  '/nh_hor/assets/img/stud-lern.svg',
  '/nh_hor/',
  '/nh_hor/assets/css/main.css',
  '/nh_hor/assets/css/header.css',
  '/nh_hor/assets/css/sidebar.css',
  '/nh_hor/assets/css/content.css',
  '/nh_hor/assets/css/footer.css',
  '/nh_hor/assets/js/nojquery_3.1.1.js',
  '/nh_hor/assets/js/app.js',
  '/nh_hor/assets/img/logo.svg',
  '/nh_hor/assets/img/favicon.svg',
  '/nh_hor/offline.php'
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
          cached || (event.request.mode === 'navigate' ? caches.match('/nh_hor/offline.php') : undefined)
        )
      )
  );
});
