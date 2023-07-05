// Service worker sürümü
const CACHE_VERSION = 'v1';

// Önbellek adı
const CACHE_NAME = 'my-pwa-cache-' + CACHE_VERSION;

// Önbelleğe alınacak dosyaların listesi
const urlsToCache = [
    '/',
    '/css/app.css',
    '/js/app.js',
    '/images/logo.png',
];

// Service worker yüklenirken çalışacak kod
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.addAll(urlsToCache);
            })
    );
});

// İstekleri ele alırken çalışacak kod
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                // Önbellekte mevcut ise önbellekten döndür
                if (response) {
                    return response;
                }
                // Ağa isteği iletmek için orijinal isteği kopyala
                const fetchRequest = event.request.clone();
                // Ağa istek yap
                return fetch(fetchRequest)
                    .then(response => {
                        // Yanıt başarılı ise yanıtı önbelleğe al
                        if (response && response.status === 200) {
                            const responseToCache = response.clone();
                            caches.open(CACHE_NAME)
                                .then(cache => {
                                    cache.put(event.request, responseToCache);
                                });
                        }
                        // Yanıtı döndür
                        return response;
                    });
            })
    );
});

// Eski önbellekleri temizle
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
