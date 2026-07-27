<x-layout.app>
    <x-nav title="Market"></x-nav>
    <div class="flex flex-col gap-2 w-[1175px]">

        {{-- Top Bar: Symbol Info --}}
        <div
            class="flex items-center gap-6 border border-line-new bg-linear-[150deg] from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%] px-4 py-3 text-sm">
            <div class="flex items-center gap-2">
                <i class="ph ph-star text-white/40"></i>
                <div class="w-6 h-6 rounded-full bg-orange-500 flex items-center justify-center text-[10px] font-bold">B
                </div>
                <div>
                    <div class="font-bold">{{ $coin['symbol'] }} <span class="text-white/40 font-normal">Perp</span></div>
                </div>
                <i class="ph ph-caret-down text-white/40"></i>
            </div>

            <div>
                <div class="text-lg font-bold text-green-500">{{ $coin['price'] }}</div>
                <div class="text-xs text-white/50">512,6 {{ $coin['change_pct'] }}%</div>
            </div>

            <div>
                <div class="text-white/50 text-xs">Mark</div>
                <div>{{ $coin['price'] }}</div>
            </div>

            <div>
                <div class="text-white/50 text-xs">Indeks</div>
                <div>{{ $coin['price'] }}</div>
            </div>

            <div>
                <div class="text-white/50 text-xs">Pendanaan (8 jam) / Hitung mundur</div>
                <div class="text-red-500">0,00718% <span class="text-white/70">/ 03:37:57</span></div>
            </div>

            <div>
                <div class="text-white/50 text-xs">High 24Jam</div>
                <div>{{ $coin['highPrice'] }}</div>
            </div>

            <div>
                <div class="text-white/50 text-xs">Low 24Jam</div>
                <div>{{ $coin['lowPrice'] }}</div>
            </div>

            <div>
                <div class="text-white/50 text-xs">Vol. 24 Jam(BTC)</div>
                <div>{{ $coin['lowPrice'] }}</div>
            </div>

            <div>
                <div class="text-white/50 text-xs">Vol. 24 Jam(USDT)</div>
                <div>5.936.622.018,55</div>
            </div>
        </div>

        {{-- Main Grid: Chart | Order Book | Trade Panel --}}
        <div class="grid grid-cols-12 gap-2">

            {{-- Chart --}}
            <div class="col-span-7 border border-line-new bg-black/40 h-[600px]">
                <div id="tv_chart_container" class="w-full h-full"></div>
            </div>

            {{-- Order Book + Trades --}}
            <div class="col-span-2 flex flex-col gap-2">
                <div
                    class="border border-line-new bg-linear-[150deg] from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%] p-2 h-[350px] overflow-hidden">
                    <div class="text-sm font-semibold mb-2">Order Book</div>
                    <div class="flex justify-between text-xs text-white/50 mb-1">
                        <span>Harga (USDT)</span>
                        <span>Jumlah (USDT)</span>
                    </div>
                    <div class="flex flex-col gap-[2px] text-xs">
                        @foreach ($asks ?? [] as $ask)
                            <div class="flex justify-between text-red-500">
                                <span>{{ number_format($ask['price'], 1) }}</span>
                                <span>{{ $ask['amount'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-lg font-bold text-green-500 my-2">
                        {{ $lastPrice ?? '65.033,2' }} <i class="ph ph-arrow-up text-sm"></i>
                    </div>

                    <div class="flex flex-col gap-[2px] text-xs">
                        @foreach ($bids ?? [] as $bid)
                            <div class="flex justify-between text-green-500">
                                <span>{{ number_format($bid['price'], 1) }}</span>
                                <span>{{ $bid['amount'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div
                    class="border border-line-new bg-linear-[150deg] from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%] p-2 flex-1 overflow-hidden">
                    <div class="flex gap-4 text-sm mb-2">
                        <span class="font-semibold border-b-2 border-blue-500 pb-1">Perdagangan</span>
                        <span class="text-white/50">Top Mover</span>
                    </div>
                    <div class="flex justify-between text-xs text-white/50 mb-1">
                        <span>Harga (USDT)</span>
                        <span>Jumlah (USDT)</span>
                        <span>Waktu</span>
                    </div>
                    <div class="flex flex-col gap-[2px] text-xs">
                        @foreach ($trades ?? [] as $trade)
                            <div
                                class="flex justify-between {{ $trade['side'] === 'sell' ? 'text-red-500' : 'text-green-500' }}">
                                <span>{{ number_format($trade['price'], 1) }}</span>
                                <span>{{ $trade['amount'] }}</span>
                                <span class="text-white/50">{{ $trade['time'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Trade Panel --}}
            <div
                class="col-span-3 border border-line-new bg-linear-[150deg] from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%] p-3">
                <div class="flex gap-2 mb-3">
                    <button class="flex-1 btn btn-sm bg-blue-500 border-0 text-white">Buka</button>
                    <button class="flex-1 btn btn-sm btn-ghost text-white/60">Tutup</button>
                </div>

                <div class="flex gap-4 text-sm mb-3 border-b border-line-new pb-2">
                    <span class="text-white/50">Limit</span>
                    <span class="font-semibold border-b-2 border-blue-500 pb-2 -mb-2">Pasar</span>
                    <span class="text-white/50">Bersyarat <i class="ph ph-caret-down"></i></span>
                </div>

                <div class="text-xs text-white/50 mb-1">Tersedia</div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm">0,00 USDT</span>
                    <i class="ph ph-arrows-clockwise text-white/40"></i>
                </div>

                <label class="text-xs text-white/50 mb-1 block">Jumlah</label>
                <div class="flex items-center justify-between border border-line-new rounded px-3 py-2 mb-3">
                    <span class="text-white/40 text-sm">USDT</span>
                </div>

                <label class="flex items-center gap-2 text-xs mb-3">
                    <input type="checkbox" checked class="checkbox checkbox-xs">
                    TP/SL
                </label>

                <div class="grid grid-cols-2 gap-2 mb-3">
                    <div>
                        <label class="text-xs text-white/50 mb-1 block">Take Profit</label>
                        <div class="border border-line-new rounded px-3 py-2 text-sm text-white/40">Harga</div>
                    </div>
                    <div>
                        <label class="text-xs text-white/50 mb-1 block">Stop Loss</label>
                        <div class="border border-line-new rounded px-3 py-2 text-sm text-white/40">Harga</div>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button class="flex-1 btn bg-green-500 border-0 text-white">Buka long</button>
                    <button class="flex-1 btn bg-red-500 border-0 text-white">Buka short</button>
                </div>

                <div class="grid grid-cols-2 gap-y-1 text-xs text-white/50 mt-3">
                    <span>Harga Lik.</span><span class="text-end text-white">-- USDT</span>
                    <span>CostBiaya</span><span class="text-end text-white">0,00 USDT</span>
                    <span>Maks</span><span class="text-end text-white">0,00 USDT</span>
                </div>
            </div>
        </div>

        {{-- Bottom Tabs: Posisi / Order / dll --}}
        <div
            class="border border-line-new bg-linear-[150deg] from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%] p-3">
            <div class="flex gap-4 text-sm mb-3 border-b border-line-new pb-2">
                <span
                    class="font-semibold border-b-2 border-blue-500 pb-2 -mb-2">Posisi({{ count($positions ?? []) }})</span>
                <span class="text-white/50">Transaksi terbuka(0)</span>
                <span class="text-white/50">Riwayat Order</span>
                <span class="text-white/50">Riwayat Perdagangan</span>
                <span class="text-white/50">Riwayat Transaksi</span>
                <span class="text-white/50">Riwayat Posisi</span>
                <span class="text-white/50">Bot</span>
                <span class="text-white/50">Aset</span>
            </div>

            <table class="table w-full text-sm">
                <thead>
                    <tr class="text-white/50 text-xs">
                        <th class="text-start">Simbol</th>
                        <th>Ukuran</th>
                        <th>Harga Masuk</th>
                        <th>Harga Impas</th>
                        <th>Harga Mark</th>
                        <th>Harga.Lik</th>
                        <th>Rasio Margin</th>
                        <th>Margin</th>
                        <th>PNL(%ROI)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($positions ?? [] as $pos)
                        <tr>
                            <td>{{ $pos['symbol'] }}</td>
                            <td>{{ $pos['size'] }}</td>
                            <td>{{ $pos['entry_price'] }}</td>
                            <td>{{ $pos['break_even'] }}</td>
                            <td>{{ $pos['mark_price'] }}</td>
                            <td>{{ $pos['liq_price'] }}</td>
                            <td>{{ $pos['margin_ratio'] }}</td>
                            <td>{{ $pos['margin'] }}</td>
                            <td class="{{ $pos['pnl'] >= 0 ? 'text-green-500' : 'text-red-500' }}">
                                {{ $pos['pnl'] }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-white/40 py-4">Tidak ada posisi terbuka</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- TradingView Widget --}}
    <script src="https://s3.tradingview.com/tv.js"></script>
    <script>
        new TradingView.widget({
            "container_id": "tv_chart_container",
            "width": "100%",
            "height": "100%",
            "symbol": "BINANCE:{{ str_replace('_', '', $pair ?? 'BTCUSDT') }}",
            "interval": "240",
            "timezone": "Asia/Jakarta",
            "theme": "dark",
            "style": "1",
            "locale": "id",
            "toolbar_bg": "#0e0e11",
            "enable_publishing": false,
            "hide_side_toolbar": false,
            "allow_symbol_change": false,
            "studies": ["MASimple@tv-basicstudies"],
        });
    </script>
</x-layout.app>
