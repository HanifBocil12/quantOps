<x-layout.app>
    <x-nav title="Dahboard"></x-nav>

    <div class="flex flex-col w-[1175px] gap-2">
        <div class="flex gap-6 h-[179px]">
            <div class="card flex-1">
                <div
                    class="card-body border border-line-new bg-[linear-gradient(150.09deg,_rgba(255,255,255,0.02)_16.57%,_rgba(190,206,254,0.166828)_68.58%,_rgba(175,195,254,0.2)_83.44%)] rounded-[10px] flex flex-col items-center">
                    <img src="{{ asset('img/PieLayer.png') }}" class="h-[127px] w-[192px] object-contain" alt="">
                </div>
            </div>
            <div class="card flex-1">
                <div class="card-body border border-line-new rounded-[10px]">
                    <div class="flex flex-col gap-4">
                        <div class="text-sm">GROSS PROFIT</div>

                        <div class="flex flex-col gap-1.5">
                            <div class="text-xl">$171,00</div>
                            <div class="text-[10px]">View GROSS PROFIT</div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card flex-1 f">
                <div class="card-body border flex flex-col gap-4 border-line-new rounded-[10px]">
                    <div class="text-sm ">GROSS LOSS</div>
                    <div class="flex flex-col gap-1.5">
                        <div class="text-xl">$141,00</div>
                        <div class="text-[10px]">View GROSS LOSS</div>
                    </div>
                </div>
            </div>
            <div class="card  ff flex-1">
                <div class="card-body border flex flex-col gap-4 border-line-new rounded-[10px]">
                    <div class="text-sm">WIN RATE</div>
                    <div class="flex flex-col gap-1.5">
                        <div class="text-xl">87%</div>
                        <div class="text-[10px]">View WIN RATE</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-6 h-[400px]">

            <div class="card w-[876px] wi bg-linear-[-115deg] from-15/80 from-[0%] to-05/8 to-[18%] h-full">
                <div class="card-body">
                    <div class="text-lg">Kurva equitas</div>
                    <div class="text-md text-white/70">Last 30 days</div>
                </div>
            </div>
            <div
                class="card  w-[276px] widget flex flex-col bg-linear-[150deg] from-[#FFFFFF]/2 from-[24%] via-[#BECEFE]/16 via-[74%] to-[#AFC3FE]/20 to-[96%] h-full">
                <div class="card-body">
                    <div class="flex justify-between">
                        <div class="">
                            <div class="text-md">Berita Pasar</div>
                        </div>

                        <div class="text-sm text-white/70">BARU</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-layout.app>
