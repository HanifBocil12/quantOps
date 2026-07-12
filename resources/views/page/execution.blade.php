<x-layout.app>
    <x-nav title="Execution"></x-nav>
    <div class="flex flex-col w-[1175px] gap-4">
        <div class="flex items-center border border-line-new w-fit text-sm">
            <div class="btn bg-unggugelap text-black">Testnet</div>
            <div class="btn bg-transparent">Real account</div>
        </div>
        <div class="card ">
            <div
                class="card-body flex  flex-row border border-line-new bg-linear-[150deg] from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%]">
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn">BTC/USDT ▾</div>
                    <ul tabindex="0" class="dropdown-content menu bg-base-200 rounded-box w-52 p-2 shadow">
                        <li><a>BTC/USDT</a></li>
                        <li><a>ETH/USDT</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn">Select model ▾</div>
                    <ul tabindex="0" class="dropdown-content menu bg-base-200 rounded-box w-52 p-2 shadow">
                        <li><a>MEAN REVESION</a></li>
                        <li><a>HFT</a></li>
                    </ul>
                </div>
                <div class="btn bg-green-500">
                    Run
                </div>
            </div>
        </div>
        <div class="flex gap-4">
            <div class="flex-1 card border border-line-new">
                <div class="card-body border-l">
                    <div class="text-md">SHARPE RATIO</div>
                    <div class="text-xl">2.41</div>
                </div>
            </div>
            <div class="flex-1 card border border-line-new">
                <div class="card-body border-l">
                    <div class="text-md">MAX DROWDOWN</div>
                    <div class="text-xl">90%</div>
                </div>
            </div>
            <div class="flex-1 card border border-line-new">
                <div class="card-body border-l">
                    <div class="text-md">WIN RATE</div>
                    <div class="text-xl">90%</div>
                </div>
            </div>
        </div>
        <div class="card border border-line-new h-[266px]">
            <div class="card-body">

            </div>
        </div>
        {{-- POSITIONS / ORDERS CARD --}}
        <div class="card border border-line-new">
            <div class="card-body !p-0">
                <div role="tablist" class="tabs tabs-lift px-4 pt-2">
                    <a role="tab" class="tab tab-active text-xs font-semibold">POSITIONS</a>
                    <a role="tab" class="tab text-xs font-semibold text-base-content/50">ORDERS</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="table text-xs">
                        <thead>
                            <tr class="text-base-content/50">
                                <th class="font-normal">PAIR</th>
                                <th class="font-normal">ENTRY PRICE</th>
                                <th class="font-normal">UNREALIZED PNL</th>
                                <th class="font-normal">SIZE</th>
                                <th class="font-normal text-right">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t border-line-new">
                                <td>
                                    <span class="text-success font-medium">BTC/USDT</span>
                                    <span class="text-base-content/50">(Long)</span>
                                </td>
                                <td>64,218.50</td>
                                <td class="text-success">+1,240.00</td>
                                <td>1.5</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline">CLOSE</button>
                                </td>
                            </tr>
                            <tr class="border-t border-line-new">
                                <td>
                                    <span class="text-error font-medium">ETH/USDT</span>
                                    <span class="text-base-content/50">(Short)</span>
                                </td>
                                <td>3,450.20</td>
                                <td class="text-error">-125.50</td>
                                <td>10.0</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline">CLOSE</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- PORTFOLIO BALANCE + ACTIVE STRATEGIES --}}
        <div class="flex gap-4">
            <div class="flex-1 card border border-line-new">
                <div class="card-body">
                    <div class="text-md mb-2">PORTFOLIO BALANCE</div>

                    <div class="flex justify-between text-sm py-2 border-t border-line-new">
                        <span class="text-base-content/50">Total Value</span>
                        <span class="font-medium">$124,500.00</span>
                    </div>
                    <div class="flex justify-between text-sm py-2 border-t border-line-new">
                        <span class="text-base-content/50">Available</span>
                        <span>$80,250.00</span>
                    </div>
                    <div class="flex justify-between text-sm py-2 border-t border-line-new">
                        <span class="text-base-content/50">Locked (Margin)</span>
                        <span>$44,250.00</span>
                    </div>
                </div>
            </div>

            <div class="flex-1 card border border-line-new">
                <div class="card-body">
                    <div class="text-md mb-2">ACTIVE STRATEGIES</div>

                    <div class="flex items-center justify-between py-2 border-t border-line-new">
                        <div>
                            <div class="text-sm font-medium">MEAN REVERSION_01</div>
                            <div class="text-xs text-base-content/50">BTC/USDT</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="badge badge-success badge-sm">RUNNING</span>
                            <input type="checkbox" checked class="toggle toggle-error toggle-xs" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-2 border-t border-line-new">
                        <div>
                            <div class="text-sm font-medium">TREND FOLLOWER_B</div>
                            <div class="text-xs text-base-content/50">ETH/USDT</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="badge badge-error badge-sm">STOPPED</span>
                            <input type="checkbox" class="toggle toggle-xs" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
