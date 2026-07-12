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
        <div class="card border border-line-new h-[182px]">
            <div class="card-body"></div>
        </div>
    </div>
</x-layout.app>
