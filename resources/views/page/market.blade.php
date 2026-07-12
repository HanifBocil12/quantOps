<x-layout.app>
    <x-nav title="Market"></x-nav>
    <div class="flex flex-col gap-2 w-[1175px]">
        <div class="flex gap-4 h-[174px]">
            {{-- Populer --}}
            <div
                class="card flex flex-1 border border-line-new bg-linear-[150deg] from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%]">
                <div class="card-body gap-3">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold">Populer</div>
                        <div class="text-white/60 text-sm flex items-center gap-1">Lainnya <i
                                class="ph ph-caret-right"></i></div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-yellow-500 flex items-center justify-center text-[10px] font-bold">
                                    B</div>
                                <span class="text-sm">BNB</span>
                            </div>
                            <span class="text-sm">Rp10.39M</span>
                            <span class="text-sm text-red-500">-2.01%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-orange-500 flex items-center justify-center text-[10px] font-bold">
                                    B</div>
                                <span class="text-sm">BTC</span>
                            </div>
                            <span class="text-sm">Rp1.12B</span>
                            <span class="text-sm text-red-500">-1.90%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-indigo-500 flex items-center justify-center text-[10px] font-bold">
                                    E</div>
                                <span class="text-sm">ETH</span>
                            </div>
                            <span class="text-sm">Rp29.93M</span>
                            <span class="text-sm text-red-500">-3.72%</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Baru --}}
            <div
                class="card flex flex-1 border border-line-new bg-linear-[150deg] from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%]">
                <div class="card-body gap-3">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold">Baru</div>
                        <div class="text-white/60 text-sm flex items-center gap-1">Lainnya <i
                                class="ph ph-caret-right"></i></div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-gray-500 flex items-center justify-center text-[10px] font-bold">
                                    A</div>
                                <span class="text-sm">AMDB</span>
                            </div>
                            <span class="text-sm">Rp9.42M</span>
                            <span class="text-sm text-green-500">+0.75%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-sky-500 flex items-center justify-center text-[10px] font-bold">
                                    E</div>
                                <span class="text-sm">EWYB</span>
                            </div>
                            <span class="text-sm">Rp3.58M</span>
                            <span class="text-sm text-green-500">+2.10%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center text-[10px] font-bold">
                                    I</div>
                                <span class="text-sm">INTCB</span>
                            </div>
                            <span class="text-sm">Rp2.42M</span>
                            <span class="text-sm text-green-500">+4.12%</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tertinggi --}}
            <div
                class="card flex flex-1 border border-line-new bg-linear-[150deg] from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%]">
                <div class="card-body gap-3">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold">Tertinggi</div>
                        <div class="text-white/60 text-sm flex items-center gap-1">Lainnya <i
                                class="ph ph-caret-right"></i></div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center text-[10px] font-bold">
                                    H</div>
                                <span class="text-sm">HEI</span>
                            </div>
                            <span class="text-sm">Rp2.53K</span>
                            <span class="text-sm text-green-500">+69.75%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-gray-400 flex items-center justify-center text-[10px] font-bold">
                                    D</div>
                                <span class="text-sm">DYDX</span>
                            </div>
                            <span class="text-sm">Rp2.74K</span>
                            <span class="text-sm text-green-500">+16.58%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-orange-400 flex items-center justify-center text-[10px] font-bold">
                                    G</div>
                                <span class="text-sm">G</span>
                            </div>
                            <span class="text-sm">Rp53.40</span>
                            <span class="text-sm text-green-500">+12.88%</span>
                        </div>
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
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-orange-500 flex items-center justify-center text-[10px] font-bold">
                                    B</div>
                                <span class="text-sm">BTC</span>
                            </div>
                            <span class="text-sm">Rp1.12B</span>
                            <span class="text-sm text-red-500">-1.90%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-indigo-500 flex items-center justify-center text-[10px] font-bold">
                                    E</div>
                                <span class="text-sm">ETH</span>
                            </div>
                            <span class="text-sm">Rp29.93M</span>
                            <span class="text-sm text-red-500">-3.72%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-teal-500 flex items-center justify-center text-[10px] font-bold">
                                    S</div>
                                <span class="text-sm">SOL</span>
                            </div>
                            <span class="text-sm">Rp1.25M</span>
                            <span class="text-sm text-red-500">-2.74%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <div class="flex gap-2">
                <div class="">favorite</div>
                <div class="">spot</div>
                <div class="">future</div>
                <div class="">new</div>
            </div>
            <div class=""></div>
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
                kapitalisasi pasar untuk semua </div>
        </div>

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
                <tr class="text-end">
                    <td class="text-start">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center text-sm font-bold">
                                B</div>
                            <div>
                                <span class="font-bold">BTC</span>
                                <span class="text-white/50">Bitcoin</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="font-bold">63,015.52</div>
                        <div class="text-sm text-white/50">Rp1,129,308,695.78</div>
                    </td>
                    <td class="text-red-500">-1.90%</td>
                    <td>Rp531.87T</td>
                    <td>Rp22,623.76T</td>
                    <td>
                        <div class="flex items-center justify-end gap-3">
                            <button><i class="ph ph-chart-bar"></i></button>
                            <button><i class="ph ph-star"></i></button>
                        </div>
                    </td>
                </tr>

                <tr class="text-end">
                    <td class="text-start">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-sm font-bold">
                                E</div>
                            <div>
                                <span class="font-bold">ETH</span>
                                <span class="text-white/50">Ethereum</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="font-bold">1,670.48</div>
                        <div class="text-sm text-white/50">Rp29,936,872.54</div>
                    </td>
                    <td class="text-red-500">-3.72%</td>
                    <td>Rp179.36T</td>
                    <td>Rp3,614.06T</td>
                    <td>
                        <div class="flex items-center justify-end gap-3">
                            <button><i class="ph ph-chart-bar"></i></button>
                            <button><i class="ph ph-star"></i></button>
                        </div>
                    </td>
                </tr>

                <tr class="text-end">
                    <td class="text-start">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-sm font-bold">
                                U</div>
                            <div>
                                <span class="font-bold">USDT</span>
                                <span class="text-white/50">USDT</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="font-bold">1.00</div>
                        <div class="text-sm text-white/50">Rp17,921.12</div>
                    </td>
                    <td class="text-red-500">-0.02%</td>
                    <td>Rp1,097.14T</td>
                    <td>Rp3,335.09T</td>
                    <td>
                        <div class="flex items-center justify-end gap-3">
                            <button><i class="ph ph-chart-bar"></i></button>
                            <button><i class="ph ph-star"></i></button>
                        </div>
                    </td>
                </tr>

                <tr class="text-end">
                    <td class="text-start">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-full bg-yellow-500 flex items-center justify-center text-sm font-bold">
                                B</div>
                            <div>
                                <span class="font-bold">BNB</span>
                                <span class="text-white/50">Build and Build</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="font-bold">580.08</div>
                        <div class="text-sm text-white/50">Rp10,395,683.29</div>
                    </td>
                    <td class="text-red-500">-2.01%</td>
                    <td>Rp17.23T</td>
                    <td>Rp1,401.47T</td>
                    <td>
                        <div class="flex items-center justify-end gap-3">
                            <button><i class="ph ph-chart-bar"></i></button>
                            <button><i class="ph ph-star"></i></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-layout.app>
