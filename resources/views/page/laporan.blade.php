<x-layout.app>
    <x-nav title="Laporan"></x-nav>
    <div class="flex flex-col gap-4 w-[1175px]">
        <div class="flex justify-between h-fit p-4 border border-line-new rounded-xs items-center gap-3 bg-li">
            <div class="flex gap-2">
                <div class="flex flex-col">
                    <div class="text-sm">STRATEGY SELECTOR</div>
                    <div class="btn">
                        Alpha-Arbitrase V4.2
                    </div>
                </div>
                <div class="flex flex-col items-start">
                    <div class="text-sm"> TIME RANGE</div>
                    <div class="flex btn gap-3">
                        <div class="btn">1M</div>
                        <div class="btn">3M</div>
                        <div class="btn bg-unggugelap">1Y</div>
                        <div class="btn">Custom</div>
                    </div>

                </div>
            </div>
            <div class="flex gap-2 rounded-xs w-fit h-fit">
                <div class="border border-line-new flex"><img src="" alt="">
                    <div class="">pdf</div>
                </div>
                <div class="border border-line-new flex"><img src="" alt="">
                    <div class="">excel</div>
                </div>
                <div class="border border-line-new flex"><img src="" alt="">
                    <div class="">csv</div>
                </div>
            </div>
        </div>
        <div class="flex rounded-xs">
            <div class="flex flex-1 gap-2 justify-between p-4 rounded-[4px] border-s-4 border-white flex-col">
                <div class="">Net profit</div>
                <div class="text-lg text-bold text-[#44E2CD]">$1,248,502.40</div>
                <div class="text-[#44E2CD]">▲ 14.2% vs Previous Period</div>
            </div>
            <div class="flex flex-1 gap-2 p-4 rounded-[4px] border-s-4 border-white flex-col">
                <div class="">GROSS PROFIT</div>
                <div class="text-lg">$2,891,044.15</div>

            </div>
            <div class="flex flex-1 gap-2 p-4 rounded-[4px] border-s-4 border-white flex-col">
                <div class="">GROSS LOSS</div>
                <div class="text-lg">($1,642,541.75)</div>

            </div>
            <div class="flex flex-1 gap-2 justify-between p-4 rounded-[4px] border-s-4 border-white flex-col">
                <div class="">PROFIT FACTOR</div>
                <div class="text-xl ">1.76</div>
                <div class=""></div>
            </div>
        </div>
        <div class="flex h-96 border border-line-new rounded-xs">
            <div class="flex bg-[#2A2A2A]/30 h-fit w-full p-4 justify-between">
                <div class="text-md">EQUITY CURVE & DRAWDOWN ANALYSIS</div>
                <div class=""></div>
            </div>
        </div>
        <div class="flex gap-4 h-96">
            {{-- PORTFOLIO SNAPSHOT (BALANCE SHEET) --}}
            <div class=" rounded-xs flex-1 flex flex-col border border-line-new font-mono">
                <div class="flex justify-between items-center px-4 py-3 border-b border-line-new">
                    <div class="text-xs uppercase tracking-widest text-white/70">Portfolio Snapshot (Balance Sheet)
                    </div>
                    <div class="text-xs uppercase tracking-widest text-white/40">Last updated: 14:02:31 UTC</div>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-xs uppercase tracking-widest text-white/40">
                                <th class="text-left font-normal px-4 py-2">Asset</th>
                                <th class="text-right font-normal px-4 py-2">Qty (Start)</th>
                                <th class="text-right font-normal px-4 py-2">Qty (Current)</th>
                                <th class="text-right font-normal px-4 py-2">Unrealized PNL</th>
                                <th class="text-right font-normal px-4 py-2">Weight %</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t border-line-new/50">
                                <td class="px-4 py-3 font-semibold text-white">BTC-USD</td>
                                <td class="px-4 py-3 text-right text-white/70">142.50</td>
                                <td class="px-4 py-3 text-right text-white/70">158.20</td>
                                <td class="px-4 py-3 text-right text-success">+$82,140.00</td>
                                <td class="px-4 py-3 text-right text-white/70">42.5%</td>
                            </tr>
                            <tr class="border-t border-line-new/50">
                                <td class="px-4 py-3 font-semibold text-white">ETH-USD</td>
                                <td class="px-4 py-3 text-right text-white/70">2,450.00</td>
                                <td class="px-4 py-3 text-right text-white/70">2,100.00</td>
                                <td class="px-4 py-3 text-right text-error">-$12,450.50</td>
                                <td class="px-4 py-3 text-right text-white/70">28.1%</td>
                            </tr>
                            <tr class="border-t border-line-new/50">
                                <td class="px-4 py-3 font-semibold text-white">SOL-USD</td>
                                <td class="px-4 py-3 text-right text-white/70">12,000.00</td>
                                <td class="px-4 py-3 text-right text-white/70">15,500.00</td>
                                <td class="px-4 py-3 text-right text-success">+$45,200.12</td>
                                <td class="px-4 py-3 text-right text-white/70">15.4%</td>
                            </tr>
                            <tr class="border-t border-line-new/50">
                                <td class="px-4 py-3 font-semibold text-white">USDT-CASH</td>
                                <td class="px-4 py-3 text-right text-white/70">2,400,000</td>
                                <td class="px-4 py-3 text-right text-white/70">1,850,000</td>
                                <td class="px-4 py-3 text-right text-white/40">—</td>
                                <td class="px-4 py-3 text-right text-white/70">14.0%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TRADE LOG (CASH FLOW) --}}
            <div class="rounded-xs flex-1 flex flex-col border border-line-new font-mono">
                <div class="flex justify-between items-center px-4 py-3 border-b border-line-new">
                    <div class="text-xs uppercase tracking-widest text-white/70">Trade Log (Cash Flow)</div>
                    <div class="flex gap-3">
                        <button class="text-white/40 hover:text-white/70">
                            <div class="size-4 bg-current [mask-size:contain] [mask-repeat:no-repeat] [mask-position:center]"
                                style="mask-image: url('{{ asset('img/icon/filter.svg') }}')"></div>
                        </button>
                        <button class="text-white/40 hover:text-white/70">
                            <div class="size-4 bg-current [mask-size:contain] [mask-repeat:no-repeat] [mask-position:center]"
                                style="mask-image: url('{{ asset('img/icon/download.svg') }}')"></div>
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-xs uppercase tracking-widest text-white/40">
                                <th class="text-left font-normal px-4 py-2">Timestamp</th>
                                <th class="text-left font-normal px-4 py-2">Pair</th>
                                <th class="text-left font-normal px-4 py-2">Side</th>
                                <th class="text-right font-normal px-4 py-2">Price</th>
                                <th class="text-right font-normal px-4 py-2">Size</th>
                                <th class="text-right font-normal px-4 py-2">Realized PNL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t border-line-new/50">
                                <td class="px-4 py-3 text-white/50">2023-11-20 14:02:11</td>
                                <td class="px-4 py-3 text-white">BTC-USD</td>
                                <td class="px-4 py-3 font-semibold text-info">BUY</td>
                                <td class="px-4 py-3 text-right text-white/70">37,452.10</td>
                                <td class="px-4 py-3 text-right text-white/70">1.45</td>
                                <td class="px-4 py-3 text-right text-white/40">—</td>
                            </tr>
                            <tr class="border-t border-line-new/50">
                                <td class="px-4 py-3 text-white/50">2023-11-20 13:45:02</td>
                                <td class="px-4 py-3 text-white">SOL-USD</td>
                                <td class="px-4 py-3 font-semibold text-error">SELL</td>
                                <td class="px-4 py-3 text-right text-white/70">58.14</td>
                                <td class="px-4 py-3 text-right text-white/70">500.00</td>
                                <td class="px-4 py-3 text-right text-success">+$1,450.20</td>
                            </tr>
                            <tr class="border-t border-line-new/50">
                                <td class="px-4 py-3 text-white/50">2023-11-20 12:30:45</td>
                                <td class="px-4 py-3 text-white">ETH-USD</td>
                                <td class="px-4 py-3 font-semibold text-error">SELL</td>
                                <td class="px-4 py-3 text-right text-white/70">2,104.55</td>
                                <td class="px-4 py-3 text-right text-white/70">15.00</td>
                                <td class="px-4 py-3 text-right text-error">-$240.15</td>
                            </tr>
                            <tr class="border-t border-line-new/50">
                                <td class="px-4 py-3 text-white/50">2023-11-20 11:15:22</td>
                                <td class="px-4 py-3 text-white">BTC-USD</td>
                                <td class="px-4 py-3 font-semibold text-info">BUY</td>
                                <td class="px-4 py-3 text-right text-white/70">37,211.00</td>
                                <td class="px-4 py-3 text-right text-white/70">0.85</td>
                                <td class="px-4 py-3 text-right text-white/40">—</td>
                            </tr>
                            <tr class="border-t border-line-new/50">
                                <td class="px-4 py-3 text-white/50">2023-11-20 10:05:01</td>
                                <td class="px-4 py-3 text-white">SOL-USD</td>
                                <td class="px-4 py-3 font-semibold text-info">BUY</td>
                                <td class="px-4 py-3 text-right text-white/70">56.22</td>
                                <td class="px-4 py-3 text-right text-white/70">1,000.00</td>
                                <td class="px-4 py-3 text-right text-white/40">—</td>
                            </tr>
                            <tr class="border-t border-line-new/50">
                                <td class="px-4 py-3 text-white/50">2023-11-20 09:00:00</td>
                                <td class="px-4 py-3 text-white">ETH-USD</td>
                                <td class="px-4 py-3 font-semibold text-error">SELL</td>
                                <td class="px-4 py-3 text-right text-white/70">2,098.30</td>
                                <td class="px-4 py-3 text-right text-white/70">50.00</td>
                                <td class="px-4 py-3 text-right text-success">+$8,442.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div
            class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-6 p-6 bg-neutral-950 border border-line-new rounded-xs">

            {{-- LEFT: Narrative Summary --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-xs font-mono tracking-widest text-neutral-400 uppercase">
                        Narrative Summary &amp; Analysis
                    </h3>
                </div>

                <p class="text-sm text-neutral-300 leading-relaxed mb-4">
                    The Alpha-Arbitrage V4.2 strategy has demonstrated robust performance over the
                    current reporting period, characterized by a steady equity curve and controlled
                    drawdown (max 4.2% observed on Oct 14). The primary alpha driver remains the
                    high-frequency mean-reversion signals on the BTC/ETH cross-exchange pair, which
                    contributed 62% of the net realized PnL.
                </p>

                <p class="text-sm text-neutral-300 leading-relaxed">
                    Execution efficiency remains high with a median slippage of
                    <code class="font-mono text-emerald-400">0.12 bps</code>.
                    However, increasing volatility in the SOL-USD market has led to tighter
                    stop-losses being triggered more frequently, slightly dampening the gross
                    profit potential in the last 7 trading days.
                </p>
            </div>

            {{-- RIGHT: Active Parameters --}}
            <div class="bg-neutral-900/60 border border-neutral-800 rounded-lg p-5 h-fit">
                <h4 class="text-xs font-mono tracking-widest text-neutral-400 uppercase mb-4">
                    Active Parameters
                </h4>

                <dl class="space-y-3 text-xs font-mono">
                    <div class="flex justify-between">
                        <dt class="text-neutral-500 uppercase tracking-wide">Leverage Cap:</dt>
                        <dd class="text-neutral-200">3.5x</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-neutral-500 uppercase tracking-wide">Sigma Threshold:</dt>
                        <dd class="text-neutral-200">2.4σ</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-neutral-500 uppercase tracking-wide">Max Position:</dt>
                        <dd class="text-neutral-200">15% NAV</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-neutral-500 uppercase tracking-wide">Execution Engine:</dt>
                        <dd class="text-neutral-200">LAVA-COREL-01</dd>
                    </div>
                </dl>
            </div>

        </div>
    </div>
</x-layout.app>
