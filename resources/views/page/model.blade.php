<x-layout.app>
    <x-nav title="Model"></x-nav>
    <div class="items-center flex flex-col gap-6 w-[1175px]">
        <div class="flex gap-6 w-full">
            <div
                class="card flex-1 bg-linear-[150deg] border border-line-new from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%] ">
                <div class="card-body">
                    <div class="text-sm">mdd</div>
                    <div class="text-xl">22</div>
                </div>
            </div>
            <div
                class="card flex-1 bg-linear-[150deg] border border-line-new from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%] ">
                <div class="card-body">
                    <div class="text-sm">mdd</div>
                    <div class="text-xl">22</div>
                </div>
            </div>
            <div
                class="card flex-1 bg-linear-[150deg] border border-line-new from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%] ">
                <div class="card-body">
                    <div class="text-sm">mdd</div>
                    <div class="text-xl">22</div>
                </div>
            </div>
            <div
                class="card flex-1 bg-linear-[150deg] border border-line-new from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%] ">
                <div class="card-body">
                    <div class="text-sm">mdd</div>
                    <div class="text-xl">22</div>
                </div>
            </div>
        </div>

        <div class="flex gap-6 w-full h-[490px]">
            {{-- LEFT: Active Models --}}
            <div class="card border border-line-new h-full w-[275.23px]">
                <div class="card-body flex flex-col gap-4 p-4">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-sm">Active Models</span>
                        <span class="badge badge-sm bg-green-500/10 text-green-400 border-none font-medium">5
                            ONLINE</span>
                    </div>

                    <div class="flex flex-col gap-2 overflow-y-auto">
                        {{-- Active/selected item --}}
                        <div class="relative bg-white/5 p-3 cursor-pointer">
                            <div class="absolute left-0 top-0 h-full w-[3px] bg-primary"></div>
                            <div class="flex items-center justify-between">
                                <span class="text-primary font-semibold text-sm">Trend Analysis</span>
                                <span class="text-xs text-white/40 font-mono">v2.4.1</span>
                            </div>
                            <p class="text-xs text-white/50 mt-1 leading-relaxed">
                                Multi-timeframe directional bias detection with volatility filtering.
                            </p>
                            <div class="flex items-center justify-between mt-3">
                                <span class="flex items-center gap-1 text-xs text-green-400">
                                    <i class="ph ph-check-circle"></i> Last Run: 2m ago
                                </span>
                                <span class="text-xs text-white/40">LAT: 12ms</span>
                            </div>
                        </div>

                        {{-- Inactive item --}}
                        <div class="p-3 cursor-pointer hover:bg-white/5">
                            <div class="flex items-center justify-between">
                                <span class="text-white font-semibold text-sm">Trend Analysis</span>
                                <span class="text-xs text-white/40 font-mono">v2.4.1</span>
                            </div>
                            <p class="text-xs text-white/50 mt-1 leading-relaxed">
                                Multi-timeframe directional bias detection with volatility filtering.
                            </p>
                            <div class="flex items-center justify-between mt-3">
                                <span class="flex items-center gap-1 text-xs text-green-400">
                                    <i class="ph ph-check-circle"></i> Last Run: 2m ago
                                </span>
                                <span class="text-xs text-white/40">LAT: 12ms</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Configure Trend Analysis --}}
            <div class="card border border-line-new h-full w-[872.88px]">
                <div class="card-body flex flex-col gap-6 p-6">
                    <div>
                        <h2 class="text-xl font-bold">Configure Trend Analysis</h2>
                        <p class="text-sm text-white/50 mt-1">
                            Adjust parameters for real-time market structure scanning. Ensure symbol connectivity before
                            initializing the run.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-semibold text-primary tracking-wide">SYMBOL / DATA</label>
                            <div class="flex items-center gap-2 border border-line-new rounded-xs px-3 py-2.5">
                                <i class="ph ph-database text-primary"></i>
                                <span class="text-sm">BTCUSDT.PERP</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-semibold text-primary tracking-wide">ANALYSIS TYPE</label>
                            <div
                                class="flex items-center justify-between border border-line-new rounded-xs px-3 py-2.5 cursor-pointer">
                                <span class="text-sm">Standard Regression</span>
                                <i class="ph ph-caret-down text-white/50"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-primary tracking-wide">PERIOD</label>
                        <div
                            class="flex items-center justify-between border border-line-new rounded-xs px-3 py-2.5 cursor-pointer">
                            <span class="text-sm">Past 30 Days</span>
                            <i class="ph ph-caret-down text-white/50"></i>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-primary tracking-wide">INTERVAL</label>
                        <div
                            class="flex items-center justify-between border border-line-new rounded-xs px-3 py-2.5 cursor-pointer">
                            <span class="text-sm">15 Minutes</span>
                            <i class="ph ph-caret-down text-white/50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="h-[498px] w-full border border-line-new"></div>
    </div>
</x-layout.app>
