const CACHE_NAME = 'mcmcjaciekrece_20210207';

// List of files which are store in cache.
let CACHED_FILES = [
    '/load',
    '/css/main.css',
    '/css/main-guest.css',
    '/images/logo-full.png'
];

self.addEventListener('install', function (evt) {
    evt.waitUntil(
        caches.open(CACHE_NAME).then(function (cache) {
            return cache.addAll(CACHED_FILES);
        }).catch(function (err) {
            // Snooze errors...
            // console.error(err);
        })
    );
});

self.addEventListener('fetch', function (evt) {
    // Snooze logs...
    // console.log(event.request.url);
    evt.respondWith(
        // Firstly, send request..
        fetch(evt.request).catch(function () {
            // When request failed, return file from cache...
            return caches.match(evt.request);
        })
    );
});
