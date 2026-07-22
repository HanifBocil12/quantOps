<x-layout.app>
    <x-nav title="Market"></x-nav>
    <div class="flex flex-col gap-2 w-[1175px]">

        {{-- 4 Cards Atas --}}
        <div class="flex gap-4 h-[174px]">

            {{-- Populer (volume tertinggi) --}}
            <div
                class="card flex flex-1 border border-line-new bg-linear-[150deg] from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%]">
                <div class="card-body gap-3">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold">Populer</div>
                        <div class="text-white/60 text-sm flex items-center gap-1">Lainnya <i
                                class="ph ph-caret-right"></i></div>
                    </div>
                    <div class="flex flex-col gap-3">
                        @foreach (collect($markets)->sortByDesc('volume_usdt')->take(3) as $coin)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-6 h-6 rounded-full bg-indigo-500 flex items-center justify-center text-[10px] font-bold">
                                        {{ substr($coin['symbol'], 0, 1) }}
                                    </div>
                                    <span class="text-sm">{{ $coin['symbol'] }}</span>
                                </div>
                                <span class="text-sm">Rp{{ number_format($coin['price'] * 16000, 0, ',', '.') }}</span>
                                <span
                                    class="text-sm {{ $coin['change_pct'] >= 0 ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $coin['change_pct'] > 0 ? '+' : '' }}{{ number_format($coin['change_pct'], 2) }}%
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Baru (change terbaru — pakai yang change_pct kecil sebagai proxy "baru listing") --}}
            <div
                class="card flex flex-1 border border-line-new bg-linear-[150deg] from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%]">
                <div class="card-body gap-3">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold">Baru</div>
                        <div class="text-white/60 text-sm flex items-center gap-1">Lainnya <i
                                class="ph ph-caret-right"></i></div>
                    </div>
                    <div class="flex flex-col gap-3">
                        @foreach (collect($markets)->sortBy('volume_usdt')->take(3) as $coin)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-6 h-6 rounded-full bg-sky-500 flex items-center justify-center text-[10px] font-bold">
                                        {{ substr($coin['symbol'], 0, 1) }}
                                    </div>
                                    <span class="text-sm">{{ $coin['symbol'] }}</span>
                                </div>
                                <span class="text-sm">Rp{{ number_format($coin['price'] * 16000, 0, ',', '.') }}</span>
                                <span
                                    class="text-sm {{ $coin['change_pct'] >= 0 ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $coin['change_pct'] > 0 ? '+' : '' }}{{ number_format($coin['change_pct'], 2) }}%
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Tertinggi (change_pct terbesar) --}}
            <div
                class="card flex flex-1 border border-line-new bg-linear-[150deg] from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%]">
                <div class="card-body gap-3">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold">Tertinggi</div>
                        <div class="text-white/60 text-sm flex items-center gap-1">Lainnya <i
                                class="ph ph-caret-right"></i></div>
                    </div>
                    <div class="flex flex-col gap-3">
                        @foreach (collect($markets)->sortByDesc('change_pct')->take(3) as $coin)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center text-[10px] font-bold">
                                        {{ substr($coin['symbol'], 0, 1) }}
                                    </div>
                                    <span class="text-sm">{{ $coin['symbol'] }}</span>
                                </div>
                                <span class="text-sm">Rp{{ number_format($coin['price'] * 16000, 0, ',', '.') }}</span>
                                <span class="text-sm text-green-500">
                                    +{{ number_format($coin['change_pct'], 2) }}%
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Volume Teratas --}}
            <div
                class="card flex flex-1 border border-line-new bg-linear-[150deg] from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%]">
                <div class="card-body gap-3">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold">Volume Teratas</div>
                        <div class="text-white/60 text-sm flex items-center gap-1">Lainnya <i
                                class="ph ph-caret-right"></i></div>
                    </div>
                    <div class="flex flex-col gap-3">
                        @foreach (collect($markets)->sortByDesc('volume_usdt')->take(3) as $coin)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-6 h-6 rounded-full bg-orange-500 flex items-center justify-center text-[10px] font-bold">
                                        {{ substr($coin['symbol'], 0, 1) }}
                                    </div>
                                    <span class="text-sm">{{ $coin['symbol'] }}</span>
                                </div>
                                <span class="text-sm">Rp{{ number_format($coin['price'] * 16000, 0, ',', '.') }}</span>
                                <span
                                    class="text-sm {{ $coin['change_pct'] >= 0 ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $coin['change_pct'] > 0 ? '+' : '' }}{{ number_format($coin['change_pct'], 2) }}%
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        {{-- Tab Filter --}}
        <div class="flex justify-between mt-6">
            <div class="flex gap-2">
                <div>favorite</div>
                <div>spot</div>
                <div>future</div>
                <div>new</div>
            </div>
        </div>

        <div class="flex items-center gap-2 text-md">
            <button class="btn btn-sm bg-blue-500 border-0 text-white rounded-xs px-4">Semua</button>
            <button class="btn btn-sm btn-ghost text-white/60 rounded-xs px-4">BSC</button>
            <button class="btn btn-sm btn-ghost text-white/60 rounded-xs px-4">Solana</button>
            <button class="btn btn-sm btn-ghost text-white/60 rounded-xs px-4">RWA</button>
            <button class="btn btn-sm btn-ghost text-white/60 rounded-xs px-4">MEME</button>
            <button class="btn btn-sm btn-ghost text-white/60 rounded-xs px-4">Pembayaran</button>
            <button class="btn btn-sm btn-ghost text-white/60 rounded-xs px-4">AI</button>
            <button class="btn btn-sm btn-ghost text-white/60 rounded-xs px-4">Lapisan 1 / Lapisan 2</button>
            <button class="btn btn-sm btn-ghost text-white/60 rounded-xs px-4">Seed</button>
            <button class="btn btn-sm btn-ghost text-white/60 rounded-xs px-4">Launchpool</button>
            <button class="btn btn-sm btn-ghost text-white/60 rounded-xs px-4">Megadrop</button>
            <button class="btn btn-sm btn-ghost text-white/60 rounded-xs px-4">Game</button>
        </div>

        <div class="">
            <div class="text-md">Token Teratas berdasarkan Kapitalisasi Pasar</div>
            <div class="text-sm text-white/70">Dapatkan snapshot komprehensif dari semua mata uang kripto yang tersedia
                di Binance. Halaman ini menampilkan harga terkini, volume perdagangan 24 jam, perubahan harga, dan
                kapitalisasi pasar untuk semua</div>
        </div>

        {{-- Tabel Dynamic --}}
        <table class="table">
            <thead>
                <tr class="text-end">
                    <th class="text-start">Pair</th>
                    <th>Harga</th>
                    <th>Perubahan</th>
                    <th>Volume 24jam</th>
                    <th>Kap Pasar</th>
                    <th>Tindak</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($markets as $coin)
                    <tr class="text-end hover:bg-white/5 transition">
                        <td class="text-start">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-sm font-bold">
                                    {{ substr($coin['symbol'], 0, 1) }}
                                </div>
                                <div>
                                    <span class="font-bold">{{ $coin['symbol'] }}</span>
                                    <span class="text-white/50 text-sm ml-1">{{ $coin['pair'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="font-bold">{{ \App\Http\Controllers\BinanceController::formatPrice($coin['price']) }}</div>
                            <div class="text-sm text-white/50">Rp{{ number_format($coin['price'] * 16000, 2) }}</div>
                        </td>
                        <td class="{{ $coin['change_pct'] >= 0 ? 'text-green-500' : 'text-red-500' }}">
                            {{ $coin['change_pct'] > 0 ? '+' : '' }}{{ number_format($coin['change_pct'], 2) }}%
                        </td>
                        <td>Rp{{ number_format($coin['volume_usdt'] * 16000, 0, ',', '.') }}</td>
                        <td>-</td>
                        <td>
                            <div class="flex items-center justify-end gap-3">
                                <button><i class="ph ph-chart-bar"></i></button>
                                <button><i class="ph ph-star"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-layout.app>