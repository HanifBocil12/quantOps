<x-layout.app>
    <x-nav title="News"></x-nav>

    {{-- GLOBAL MARKET MAP --}}
    <div class="flex flex-col gap-4 w-full">
        <div class="card border border-line-new h-[400px]">
            <div class="card-body border-l !p-0 relative overflow-hidden">
                <div class="text-md px-4 pt-4 pb-2 z-10 relative text-base-content/70">GLOBAL MARKET MAP</div>
                <div id="market-map" class="absolute inset-0 top-10"></div>
            </div>
        </div>
    </div>

    {{-- DASHBOARD GRID LAYOUT --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4 w-full h-full">

        {{-- Row 1 --}}
        <div class="card shadow-sm border border-line-new h-[400px]">
            <div class="card-body p-4 h-full">

                <h3 class="text-sm font-semibold text-base-content/70">
                    Live Webcams
                </h3>

                <div class="tabs tabs-boxed mt-2 flex-wrap">
                    <button class="tab tab-active webcam-tab" data-region="ALL">ALL</button>
                    <button class="tab webcam-tab" data-region="Europe">Europe</button>
                    <button class="tab webcam-tab" data-region="Americas">Americas</button>
                    <button class="tab webcam-tab" data-region="Asia">Asia</button>
                    <button class="tab webcam-tab" data-region="Middle East">Middle East</button>
                    <button class="tab webcam-tab" data-region="Space">Space</button>
                </div>

                <div id="webcam-news" class="mt-2 space-y-3 flex-1 overflow-hidden">
                    <div id="webcam-grid"
                        class="max-h-[220px] overflow-y-auto pr-1 text-base-content grid grid-cols-1 gap-3">
                        <p class="text-xs text-base-content/40">Loading webcams...</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="card border border-line-new h-[400px] w-full">
            <div class="card-body p-4 h-full w-full">
                <h3 class="text-sm font-semibold text-base-content/70">Crypto news</h3>
                <div id="crypto-news" class="mt-2 space-y-3 flex-1 overflow-hidden">
                    <div id="crypto-onchain" class="max-h-[140px] overflow-y-auto pr-1"></div>
                    <div id="crypto-general" class="max-h-[140px] overflow-y-auto pr-1"></div>
                </div>
            </div>
        </div>

        <div class="card border border-line-new h-full w-full">
            <div class="card-body p-4 h-full w-full overflow-hidden">
                <h3 class="text-sm font-semibold text-base-content/70">
                    World news
                </h3>

                <div id="world-news" class="mt-2 space-y-2 flex-1 overflow-y-auto max-h-[300px] pr-1">
                    <div class="animate-pulse flex space-x-2">
                        <div class="flex-1 space-y-2">
                            <div class="h-2 bg-base-300 rounded"></div>
                            <div class="h-2 bg-base-300 rounded w-3/4"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card border border-line-new h-[400px] w-full">
            <div class="card-body p-4 h-full w-full">
                <h3 class="text-sm font-semibold text-base-content/70">Markets</h3>
                <div id="markets-news" class="mt-2 space-y-1 flex-1 overflow-y-auto">
                    <div class="animate-pulse flex space-x-2">
                        <div class="flex-1 space-y-2">
                            <div class="h-2 bg-base-300 rounded"></div>
                            <div class="h-2 bg-base-300 rounded w-3/4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 2 - Macro economic news (larger) --}}
        <div class="card border border-line-new lg:col-span-2 h-[400px] w-full">
            <div class="card-body p-4 h-full w-full">
                <h3 class="text-sm font-semibold text-base-content/70 mb-3">Macro economic news</h3>
                <div class="tabs tabs-boxed bg-base-300 mb-3">
                    <a class="tab tab-active text-xs">Government</a>
                    <a class="tab text-xs">TRUMP</a>
                </div>
                <div class="grid grid-cols-2 gap-3 h-full">
                    <div
                        class="bg-gradient-to-br from-red-900/50 to-base-200 rounded p-4 flex items-center justify-center">
                        <div class="text-xs text-base-content/70">Live news</div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-red-900/50 to-base-200 rounded p-4 flex items-center justify-center">
                        <div class="text-xs text-base-content/70">The fed live</div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-red-900/50 to-base-200 rounded p-4 flex items-center justify-center">
                        <div class="text-xs text-base-content/70">Trump live</div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-red-900/50 to-base-200 rounded p-4 flex items-center justify-center">
                        <div class="text-xs text-base-content/70">Markets</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border border-line-new h-[400px] w-full">
            <div class="card-body p-4 h-full w-full">
                <h3 class="text-sm font-semibold text-base-content/70">Onchain data</h3>
                <div id="onchain-data" class="mt-2 space-y-2 flex-1 overflow-y-auto">
                    <div class="animate-pulse flex space-x-2">
                        <div class="flex-1 space-y-2">
                            <div class="h-2 bg-base-300 rounded"></div>
                            <div class="h-2 bg-base-300 rounded w-3/4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border border-line-new h-[400px] w-full">
            <div class="card-body p-4 h-full w-full">
                <h3 class="text-sm font-semibold text-base-content/70">War</h3>
                <div class="mt-2 space-y-2 flex-1">
                    <div class="animate-pulse flex space-x-2">
                        <div class="flex-1 space-y-2">
                            <div class="h-2 bg-base-300 rounded"></div>
                            <div class="h-2 bg-base-300 rounded w-3/4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 3 - Komoditas (full width) --}}
        <div class="card border border-line-new lg:col-span-4 h-[200px] w-full">
            <div class="card-body p-4 h-full w-full">
                <h3 class="text-sm font-semibold text-base-content/70 mb-3">Komoditas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 h-full">
                    <div class="bg-base-300 rounded p-3 flex items-center justify-center">
                        <div class="text-xs text-base-content/70">Live news</div>
                    </div>
                    <div class="bg-base-300 rounded p-3 flex items-center justify-center">
                        <div class="text-xs text-base-content/70">Crypto news</div>
                    </div>
                    <div class="bg-base-300 rounded p-3 flex items-center justify-center">
                        <div class="text-xs text-base-content/70">World news</div>
                    </div>
                    <div class="bg-base-300 rounded p-3 flex items-center justify-center">
                        <div class="text-xs text-base-content/70">Markets</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #market-map {
            background: #0a0a0a;
        }

        .leaflet-tile-pane {
            filter: brightness(0.9) contrast(1.1);
        }

        .leaflet-control-attribution {
            background: transparent !important;
            color: #555 !important;
            font-size: 9px !important;
        }

        .leaflet-control-zoom a {
            background: #111 !important;
            color: #ccc !important;
            border-color: #333 !important;
        }
    </style>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            {{-- MAP --}}
            const map = L.map('market-map', {
                center: [20, 0],
                zoom: 2,
                minZoom: 2,
                maxZoom: 8,
                worldCopyJump: true,
            });
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap &copy; CARTO',
                subdomains: 'abcd',
                maxZoom: 19,
            }).addTo(map);
            const nodes = [{
                    name: 'Binance HQ',
                    lat: 1.29,
                    lng: 103.85,
                    pnl: '+1,240.00'
                },
                {
                    name: 'NYSE',
                    lat: 40.71,
                    lng: -74.01,
                    pnl: '-125.50'
                },
            ];
            const greenDot = L.divIcon({
                className: '',
                html: '<div style="width:8px;height:8px;border-radius:50%;background:#22c55e;box-shadow:0 0 6px #22c55e"></div>',
                iconSize: [8, 8],
            });
            nodes.forEach(n => {
                L.marker([n.lat, n.lng], {
                    icon: greenDot
                }).addTo(map).bindPopup(`<b>${n.name}</b><br>${n.pnl}`);
            });

            {{-- NEWS FETCH --}}

            function renderNews(el, items) {
                if (!items.length) {
                    el.innerHTML = '<p class="text-xs text-base-content/40">No news available</p>';
                    return;
                }
                el.innerHTML = items.map(item => `
                    <a href="${item.url}" target="_blank"
                       class="block border-b border-base-300 pb-2 mb-2 hover:opacity-80 transition last:border-0">
                        <p class="text-[9px] text-base-content/40 uppercase tracking-widest">${item.source}</p>
                        <p class="text-xs text-base-content/80 leading-snug">${item.title}</p>
                    </a>
                `).join('');
            }

            function renderCryptoNewsGrouped(grouped) {

                const renderSection = (el, label, items) => {

                    const itemsHtml = items.length ?
                        items.map(item => `
                        <a href="${item.url}" target="_blank"
                        class="block border-b border-base-300 pb-2 mb-2 hover:opacity-80 transition">
                            <p class="text-[9px] text-base-content/40 uppercase tracking-widest">
                                ${item.source}
                            </p>
                            <p class="text-xs text-base-content/80 leading-snug">
                                ${item.title}
                            </p>
                        </a>
                    `).join('') :
                        '<p class="text-xs text-base-content/40">No news available</p>';


                    el.innerHTML = `
                    <p class="text-[10px] font-semibold text-base-content/50 uppercase tracking-wide mb-1">
                        ${label}
                    </p>

                    ${itemsHtml}
                `;
                };


                renderSection(
                    document.getElementById('crypto-onchain'),
                    'Onchain Alert',
                    grouped.onchain_alert || []
                );


                renderSection(
                    document.getElementById('crypto-general'),
                    'General News',
                    grouped.general || []
                );
            }

            function renderOnchainData(el, items) {
                renderNews(el, items);
            }

            function renderOnchainData(el, items) {
                renderNews(el, items);
            }

            // ============ TAMBAHIN 3 FUNCTION INI DI SINI ============

            function buildSparkline(points) {
                if (!points || points.length < 2) return '';

                const min = Math.min(...points);
                const max = Math.max(...points);
                const range = max - min || 1;
                const width = 60;
                const height = 24;

                const coords = points.map((p, i) => {
                    const x = (i / (points.length - 1)) * width;
                    const y = height - ((p - min) / range) * height;
                    return `${x.toFixed(1)},${y.toFixed(1)}`;
                }).join(' ');

                const isUp = points[points.length - 1] >= points[0];
                const color = isUp ? '#22c55e' : '#ef4444';

                return `
                    <svg width="${width}" height="${height}" viewBox="0 0 ${width} ${height}" class="shrink-0">
                        <polyline points="${coords}" fill="none" stroke="${color}" stroke-width="1.5" stroke-linejoin="round" stroke-linecap="round" />
                    </svg>
                `;
            }

            function formatWatchlistPrice(price) {
                if (price >= 1000) return price.toLocaleString('en-US', {
                    maximumFractionDigits: 0
                });
                if (price >= 1) return price.toFixed(2);
                return price.toFixed(6);
            }

            function renderMarketsWatchlist(items) {
                const el = document.getElementById('markets-news');

                if (!el) return;

                if (!items.length) {
                    el.innerHTML = '<p class="text-xs text-base-content/40">No data available</p>';
                    return;
                }

                el.innerHTML = items.map(item => {
                    const isUp = item.change_pct >= 0;
                    const changeColor = isUp ? 'text-green-500' : 'text-red-500';
                    const changeSign = isUp ? '+' : '';

                    return `
                        <div class="flex items-center justify-between py-2.5 border-b border-base-300 last:border-0 hover:bg-base-300/30 transition rounded px-1 -mx-1">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium">${item.symbol}</span>
                                <span class="text-[10px] text-base-content/40 uppercase tracking-widest">${item.pair}</span>
                            </div>

                            ${buildSparkline(item.sparkline)}

                            <div class="flex flex-col items-end">
                                <span class="text-sm font-mono">$${formatWatchlistPrice(item.price)}</span>
                                <span class="text-xs font-mono ${changeColor}">${changeSign}${item.change_pct.toFixed(2)}%</span>
                            </div>
                        </div>
                    `;
                }).join('');
            }

            // ============ SAMPE SINI ============

            fetch('{{ route('news.index') }}')
                .then(r => r.json())
                .then(news => {
                    renderNews(document.getElementById('live-news'), news.live);
                })
                .catch(() => {
                    document.getElementById('live-news').innerHTML =
                        '<p class="text-xs text-base-content/40">Failed to load</p>';
                });

            fetch('{{ route('markets.watchlist') }}')
                .then(r => r.json())
                .then(items => {
                    renderMarketsWatchlist(items);
                })
                .catch(() => {
                    document.getElementById('markets-news').innerHTML =
                        '<p class="text-xs text-base-content/40">Failed to load</p>';
                });


            fetch('{{ route('news.world') }}')
                .then(r => r.json())
                .then(news => {
                    renderNews(document.getElementById('world-news'), news);
                })
                .catch(() => {
                    document.getElementById('world-news').innerHTML =
                        '<p class="text-xs text-base-content/40">Failed to load</p>';
                });

            fetch('{{ route('news.crypto') }}')
                .then(r => r.json())
                .then(grouped => {

                    // Crypto News
                    renderCryptoNewsGrouped(grouped);

                    // Onchain Data card bawah
                    renderOnchainData(
                        document.getElementById('onchain-data'),
                        grouped.onchain_alert || []
                    );

                })

            // LIVE YOUTUBE NEWS

            let webcams = [];


            fetch("{{ route('news.webcams') }}")
                .then(response => response.json())
                .then(data => {

                    webcams = data;

                    renderWebcams('ALL');

                });


            window.filterWebcams = function(region) {

                renderWebcams(region);

                document.querySelectorAll('.webcam-tab')
                    .forEach(tab => {

                        tab.classList.remove('tab-active');

                        if (tab.dataset.region === region) {
                            tab.classList.add('tab-active');
                        }

                    });

            };


            document.querySelectorAll('.webcam-tab')
                .forEach(tab => {

                    tab.addEventListener('click', function() {

                        filterWebcams(this.dataset.region);

                    });

                });



            function renderWebcams(region) {

                let filtered = region === 'ALL' ?
                    webcams :
                    webcams.filter(
                        webcam => webcam.region === region
                    );


                document.getElementById('webcam-grid').innerHTML =
                    filtered.map(webcam => `

                    <div class="bg-base-200 rounded-lg overflow-hidden">

                        <div class="p-2 text-xs font-semibold">
                            ${webcam.city}

                            <span class="opacity-50">
                                ${webcam.region}
                            </span>
                        </div>


            ${
                webcam.video_id

                ?

                `
                                                                                <iframe
                                                                                    src="https://www.youtube.com/embed/${webcam.video_id}"
                                                                                    class="w-full aspect-video"
                                                                                    frameborder="0"
                                                                                    allowfullscreen>
                                                                                </iframe>
                                                                                `

                :

                `
                                                                                <div class="aspect-video flex items-center justify-center">
                                                                                    <span class="text-xs text-error">
                                                                                        Offline
                                                                                    </span>
                                                                                </div>
                                                                                `

            }

        </div>

    `).join('');

            }
        });
    </script>
</x-layout.app>

{{-- m --}}
