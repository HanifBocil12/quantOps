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
        document.addEventListener('DOMContentLoaded', function () {
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
                L.marker([n.lat, n.lng], { icon: greenDot })
                    .addTo(map)
                    .bindPopup(`<b>${n.name}</b><br>${n.pnl}`);
            });
        });
    </script>
</x-layout.app>