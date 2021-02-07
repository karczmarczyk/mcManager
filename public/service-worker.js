const CACHE_NAME = 'mcmcjaciekrece_20210207.1';

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
            return caches.match('/offline.html');
            // However, in reality you'd have many different
            // fallbacks, depending on URL & headers.
            // Eg, a fallback silhouette image for avatars.
        })
    );
});
