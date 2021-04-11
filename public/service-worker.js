const CACHE_NAME = 'mcmcjaciekrece_20210228.0';

// List of files which are store in cache.
let CACHED_FILES = [
    '/load',
    '/css/main.css',
    '/css/main-guest.css',
    '/images/logo-full.png'
];

self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function (cache) {
            return cache.addAll(CACHED_FILES);
        }).catch(function (err) {
            // Snooze errors...
            // console.error(err);
        })
    );
});

self.addEventListener('fetch', function (event) {
    // Snooze logs...
    // console.log(event.request.url);
    event.respondWith(
        // // Firstly, send request..
        // fetch(evt.request).catch(function () {
        //     // When request failed, return file from cache...
        //     return caches.match(event.request);
        // })

        // Try the cache
        caches.match(event.request).then(function(response) {
            // Fall back to network
            return response || fetch(event.request);
        }).catch(function() {
            // If both fail, show a generic fallback:
            return caches.match('/load');
            // However, in reality you'd have many different
            // fallbacks, depending on URL & headers.
            // Eg, a fallback silhouette image for avatars.
        })
    );
});

// 1. Nowa metoda w SW
self.addEventListener('push', (event) => {
    // 2. Sprawdź wiadomośc z serwera i sparsuj do tekstu
    console.log('Otrzymałem nowe dane z serwera:', event.data.text())
    // 3. Stwórz tytuł i treśc notyfikacji. Uzyj danych z serwera
    const message = {
        data: event.data.text()
    }
    const title = 'Niesamowita sprawa!';

    // 4. Stwórz notyfikację
    const promiseChain = self.registration.showNotification(title, message);
    // 5. Wywołaj notyfikację
    event.waitUntil(promiseChain);
})