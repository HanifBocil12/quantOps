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
        <div class="card bg-base-200 border border-base-300 h-full w-full">
            <div class="card-body p-4 h-full w-full">
                <h3 class="text-sm font-semibold text-base-content/70">Live news</h3>
                <div id="live-news" class="mt-2 space-y-2 flex-1 overflow-y-auto">
                    <div class="animate-pulse flex space-x-2">
                        <div class="flex-1 space-y-2">
                            <div class="h-2 bg-base-300 rounded"></div>
                            <div class="h-2 bg-base-300 rounded w-3/4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-base-200 border border-base-300 h-full w-full">
            <div class="card-body p-4 h-full w-full">
                <h3 class="text-sm font-semibold text-base-content/70">Crypto news</h3>
                <div id="crypto-news" class="mt-2 space-y-2 flex-1 overflow-y-auto">
                    <div class="animate-pulse flex space-x-2">
                        <div class="flex-1 space-y-2">
                            <div class="h-2 bg-base-300 rounded"></div>
                            <div class="h-2 bg-base-300 rounded w-3/4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-base-200 border border-base-300 h-full w-full">
            <div class="card-body p-4 h-full w-full">
                <h3 class="text-sm font-semibold text-base-content/70">World news</h3>
                <div id="world-news" class="mt-2 space-y-2 flex-1 overflow-y-auto">
                    <div class="animate-pulse flex space-x-2">
                        <div class="flex-1 space-y-2">
                            <div class="h-2 bg-base-300 rounded"></div>
                            <div class="h-2 bg-base-300 rounded w-3/4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-base-200 border border-base-300 h-full w-full">
            <div class="card-body p-4 h-full w-full">
                <h3 class="text-sm font-semibold text-base-content/70">Markets</h3>
                <div id="markets-news" class="mt-2 space-y-2 flex-1 overflow-y-auto">
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
        <div class="card bg-base-200 border border-base-300 lg:col-span-2 h-[400px] w-full">
            <div class="card-body p-4 h-full w-full">
                <h3 class="text-sm font-semibold text-base-content/70 mb-3">Macro economic news</h3>
                <div class="tabs tabs-boxed bg-base-300 mb-3">
                    <a class="tab tab-active text-xs">Government</a>
                    <a class="tab text-xs">TRUMP</a>
                </div>
                <div class="grid grid-cols-2 gap-3 h-full">
                    <div class="bg-gradient-to-br from-red-900/50 to-base-200 rounded p-4 flex items-center justify-center">
                        <div class="text-xs text-base-content/70">Live news</div>
                    </div>
                    <div class="bg-gradient-to-br from-red-900/50 to-base-200 rounded p-4 flex items-center justify-center">
                        <div class="text-xs text-base-content/70">The fed live</div>
                    </div>
                    <div class="bg-gradient-to-br from-red-900/50 to-base-200 rounded p-4 flex items-center justify-center">
                        <div class="text-xs text-base-content/70">Trump live</div>
                    </div>
                    <div class="bg-gradient-to-br from-red-900/50 to-base-200 rounded p-4 flex items-center justify-center">
                        <div class="text-xs text-base-content/70">Markets</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-base-200 border border-base-300 h-[400px] w-full">
            <div class="card-body p-4 h-full w-full">
                <h3 class="text-sm font-semibold text-base-content/70">Onchain data</h3>
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

        <div class="card bg-base-200 border border-base-300 h-[400px] w-full">
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
        <div class="card bg-base-200 border border-base-300 lg:col-span-4 h-[200px] w-full">
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
        #market-map { background: #0a0a0a; }
        .leaflet-tile-pane { filter: brightness(0.9) contrast(1.1); }
        .leaflet-control-attribution { background: transparent !important; color: #555 !important; font-size: 9px !important; }
        .leaflet-control-zoom a { background: #111 !important; color: #ccc !important; border-color: #333 !important; }
    </style>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            {{-- MAP --}}
            const map = L.map('market-map', {
                center: [20, 0], zoom: 2, minZoom: 2, maxZoom: 8, worldCopyJump: true,
            });
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap &copy; CARTO', subdomains: 'abcd', maxZoom: 19,
            }).addTo(map);
            const nodes = [
                { name: 'Binance HQ', lat: 1.29, lng: 103.85, pnl: '+1,240.00' },
                { name: 'NYSE', lat: 40.71, lng: -74.01, pnl: '-125.50' },
            ];
            const greenDot = L.divIcon({
                className: '',
                html: '<div style="width:8px;height:8px;border-radius:50%;background:#22c55e;box-shadow:0 0 6px #22c55e"></div>',
                iconSize: [8, 8],
            });
            nodes.forEach(n => {
                L.marker([n.lat, n.lng], { icon: greenDot }).addTo(map).bindPopup(`<b>${n.name}</b><br>${n.pnl}`);
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

            fetch('{{ route("news.index") }}')
                .then(r => r.json())
                .then(news => {
                    renderNews(document.getElementById('live-news'), news);
                    renderNews(document.getElementById('crypto-news'), news.filter(n => n.source?.toLowerCase().includes('crypto')));
                    renderNews(document.getElementById('world-news'), news.filter(n => !n.source?.toLowerCase().includes('crypto')));
                    renderNews(document.getElementById('markets-news'), news.slice(0, 5));
                })
                .catch(() => {
                    ['live-news','crypto-news','world-news','markets-news'].forEach(id => {
                        document.getElementById(id).innerHTML = '<p class="text-xs text-base-content/40">Failed to load</p>';
                    });
                });
        });
    </script>
</x-layout.app>