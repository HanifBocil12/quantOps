<div class="drawer-side">
    <label for="main-drawer" class="drawer-overlay"></label>
    <div class="min-h-full flex flex-col w-50 bg-none text-white ">

        <div class="p-3 flex gap-3 mt-5">
            <div class="w-full flex gap-2 p-2 rounded-[6px] h-fit bg-[#AFC3FE]/50">
                <img src="{{ asset('img/tabler_star-filled.svg') }}" alt="">
                <div class="flex flex-col">
                    <div class="text-md">Vion parker</div>
                    <div class="text-sm">Trader</div>
                </div>
            </div>

        </div>

        <ul class="menu menu-md w-full flex-1 gap-1">
            <li><a href="{{ route('dashboard')}}" class="">Dahboard</a></li>
            <li><a href="{{ route('model') }}" class="">Model</a></li>
            <li><a href="{{ route('news') }}" class="">News</a></li>
            <li><a href="{{ route('market') }}" class="">Market</a></li>
            <li><a href="{{ route('execution') }}" class="">Execution</a></li>
            <li><a href="{{ route('laporan') }}" class="">Laporan</a></li>
        </ul>
    </div>
</div>
