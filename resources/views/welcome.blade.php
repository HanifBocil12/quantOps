<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @fonts

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @endif
</head>

<body class="bg-[#050505]">
    <div class="h-[1105px] bg-[radial-gradient(97.74%_97.74%_at_51.67%_100%,_#050505_76.99%,_#4C6FFF_100%)]">
        {{-- nav --}}
        <div class="navbar bg-base-300 shadow-sm">
            <div class="navbar-start">
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h8m-8 6h16" />
                        </svg>
                    </div>
                    <ul tabindex="-1"
                        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                        <li><a href="">feature</a></li>
                        <li><a href="">news</a></li>
                        <li><a href="">support</a></li>
                    </ul>
                </div>
                <a class="btn btn-ghost text-xl">QuantOps</a>
            </div>
            <div class="navbar-center hidden lg:flex">
                <div class="menu menu-horizontal px-1">
                    <li><a class="text-[16px]" href="">feature</a></li>
                    <li><a class="text-[16px]" href="">news</a></li>
                    <li><a class="text-[16px]" href="">support</a></li>
                </div>
            </div>
            <div class="flex navbar-end gap-2">
                <a class="btn-cus btn bg-none border border-ungguterang text-ungguterang rounded-2xl">Login</a>
                <a href="{{ route('dashboard') }}" class="btn-cus btn text-black bg-ungguterang rounded-2xl">SignUp</a>
            </div>
        </div>

        <main class="w-full gap-3.5 py-8 flex flex-col items-center justify-center">
            <div class="bg-ungguterang/50 border border-whi py-1.5 px-2 rounded-md text-md">Free · Global intelligence ·
                Quant models · Live
                portfolio tracking</div>
            <div class="gap-2 flex flex-col items-center justify-center">
                <div class="text-center">
                    <div class="text-3xl  text-white [text-shadow:0px_0px_15px_#A5B8FF] grow-0">Build your strategy. Track markets.</div>
                    <div class="text-3xl text-[#A5B8FF]  [text-shadow:0px_0px_15px_#A5B8FF] flex-none order-1 grow-0">Trade smarter.</div>
                </div>
                <div class="text-md w-[646px] h-[52px] text-center">
                    QuantOps Pro combines real-time market intelligence,
                    professional quant models, and custom
                    strategy integration — connected directly to your live portfolio.
                </div>
            </div>

            <a href="{{ route('dashboard') }}" class="btn-cus btn bg-ungguterang text-black rounded-2xl">SignUp</a>
            <div
                class="mt-6 w-[900px] rounded-2xl overflow-hidden border border-white/10 
              shadow-[0_0_100px_rgba(99,102,241,0.25)] backdrop-blur-xl">

                <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=1600"
                    class="w-full h-[520px] object-cover scale-105 group-hover:scale-110 transition duration-700" />
            </div>
        </main>

        <footer class="footer"></footer>
    </div>
    <div class="h-[950px] gap-16 flex flex-col justify-center items-center border-t border-[#666666]">
        <div class="text-center">
            <div class="text-2xl bg-gradient-to-r from-white to-white/60 bg-clip-text text-transparent">Every figure is
                recorded. Total transparency.</div>
            <div class="text-md text-white/80">A professional report designed for serious traders.</div>
        </div>

        <div class="flex w-fit gap-8">
            <div
                class="w-[288.67px] h-[431px] rounded-sm border gap-4 border-white/25 bg-linear-[-35deg] from-[#AFC3FE]/20 to-white/2 grid grid-rows-12">
                <div class="row-span-2 px-4 pt-4 text-sm items-center flex"><span
                        class="bg-[#3E3E3E] rounded-sm px-2 py-1">portofolio</span></div>
                <div class="row-span-5">
                    <img src="{{ asset('img/Frame 15.svg') }}" alt="" class="w-full h-full object-cover">
                </div>
                <div class="row-span-5 px-4 pb-4 text-md">Dari kepemilikan aset hingga nilai bersih (NAV) yang melacak
                    kekayaanmu hingga hitungan detik. Every asset. One view.
                </div>
            </div>
            <div
                class="w-[288.67px] h-[431px] rounded-sm border gap-4 border-white/25 bg-linear-[-35deg] from-[#AFC3FE]/20 to-white/2 grid grid-rows-12">
                <div class="row-span-2 px-4 pt-4 text-sm items-center flex"><span
                        class="bg-[#3E3E3E] rounded-sm px-2 py-1">Laporan P&L</span></div>
                <div class="row-span-5">
                    <img src="{{ asset('img/Frame 15.svg') }}" alt="" class="w-full h-full object-cover">
                </div>
                <div class="row-span-5 px-4 pb-4 text-md">Laporan P&L transparan yang mencatat setiap performa trade
                    secara akurat. Every gain, fully accounted.
                </div>
            </div>
            <div
                class="w-[288.67px] h-[431px] rounded-sm border gap-4 border-white/25 bg-linear-[-35deg] from-[#AFC3FE]/20 to-white/2 grid grid-rows-12">
                <div class="row-span-2 px-4 pt-4 text-sm items-center flex"><span
                        class="bg-[#3E3E3E] rounded-sm px-2 py-1">Analisis Risiko</span></div>
                <div class="row-span-5">
                    <img src="{{ asset('img/Frame 15.svg') }}" alt="" class="w-full h-full object-cover">
                </div>
                <div class="row-span-5 px-4 pb-4 text-md">Deteksi potensi kerugian lebih awal dengan analisis risiko
                    berbasis data, dan berita berita terkini.
                </div>
            </div>
        </div>
    </div>

    <div class="h-[950px] gap-10 flex flex-col justify-center items-center border-t border-[#666666]">
        <div class="text-center">
            <div class="text-2xl bg-gradient-to-r from-white to-white/60 bg-clip-text text-transparent">Quantpro trade
                with data and mathematic</div>
            <div class="text-md text-white/80">Trade with mathematics. Not intuition.</div>

            <div class="grid grid-cols-2 text-start gap-4 p-4">
                {{-- CARD 1: Model Library --}}
                <div class="card border border-white/10 rounded-md overflow-hidden relative w-[507px] min-h-[277px]">
                    <img src="{{ asset('img/ataskiri.svg') }}" class="absolute inset-0 w-full h-full object-cover z-0"
                        alt="">
                    <div class="card-body relative z-10">
                        <h2 class="card-title text-white font-normal text-lg">Model Library</h2>
                        <p class="text-white/50 w-[400px] text-md">Trade using Markov, mean reversion, and models
                            already built for the edge.</p>
                    </div>
                </div>

                {{-- CARD 2: Model Custom --}}
                <div class="card border border-white/10 rounded-md overflow-hidden relative w-[507px] min-h-[277px]">
                    <img src="{{ asset('img/ataskanan.svg') }}" class="absolute inset-0 w-full h-full object-cover z-0"
                        alt="">
                    <div class="card-body relative z-10">
                        <h2 class="card-title text-white font-normal text-lg">Model Custom</h2>
                        <p class="text-white/50 w-[400px] text-md">You built the strategy. We run it. Import your Python
                            model and deploy it directly to live.</p>
                    </div>
                </div>

                {{-- CARD 3: Model Backtest --}}
                <div class="card border border-white/10 rounded-md overflow-hidden relative w-[507px] min-h-[277px]">
                    <img src="{{ asset('img/bawahkiri.svg') }}" class="absolute inset-0 w-full h-full object-cover z-0"
                        alt="">
                    <div class="card-body relative z-10">
                        <h2 class="card-title text-white font-normal text-lg">Model Backtest</h2>
                        <p class="text-white/50 w-[400px] text-md">Every strategy has a history. Find out what yours
                            would have done.</p>
                    </div>
                </div>

                {{-- CARD 4: Model Deploy --}}
                <div class="card border border-white/10 rounded-md overflow-hidden relative w-[507px] min-h-[277px]">
                    {{-- Background image --}}
                    <img src="{{ asset('img/bawahkanan.svg') }}"
                        class="absolute inset-0 w-full h-full object-cover z-0" alt="">

                    {{-- Content --}}
                    <div class="card-body relative z-10">
                        <h2 class="card-title text-white font-normal text-lg">Model Deploy</h2>
                        <p class="text-white/50 w-[400px] text-sm">From backtest to live in one step. No export. No
                            rebuild. The same model, now trading.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="h-[950px] gap-10 flex items-center flex-col justify-center border-t border-[#666666]">
        <div class="text-2xl w-[706px] text-center">Connect your analysis models directly to any crypto pair</div>
        <div class="flex gap-12">
            <div class="card border border-[#636363] h-[612px]">
                <div class="card-body">
                    <div class="card-title text-lg">Market</div>
                    <div class=" text-md w-[430px] h-[50.5px] text-white/80">There are signals and
                        opportunities,
                        directly
                        connect the model.</div>
                </div>
                <figure class="bg-linear-180 from-[#181818] to-unggugelap ps-8 pt-10 h-[486px]">
                    <img src="{{ asset('img/Frame 60.svg') }}" alt="">
                </figure>
            </div>
            <div class="card border border-[#636363] h-[612px]">
                <div class="card-body">
                    <div class="card-title text-lg">Market</div>
                    <div class="text-md w-[430px] h-[50.5px] text-white/80">Same model. Testnet first. One
                        toggle to go live.</div>
                </div>
                <figure class="bg-linear-180 from-purple-600 to-[#181818] ps-8 pt-10 h-[486px]">
                    <img src="{{ asset('img/Frame 60.svg') }}" alt="">
                </figure>
            </div>
        </div>
    </div>

    <div class="h-[950px] gap-10 flex items-center flex-col justify-center border-t border-[#666666]">
        <div class="text-2xl bg-gradient-to-r from-white to-white/60 bg-clip-text text-transparent">Your safety is our
            absolute priority.</div>
        <div class="text-md text-white/80">We built this system on the philosophy that your assets and data belong
            entirely to you. Without compromise.</div>

        <div class="w-[1109px] gap-5 flex flex-col">
            <div class="grid-cols-12 grid gap-5">
                <div class="card border border-white/10 rounded-md overflow-hidden relative col-span-7 min-h-[257px]">
                    <img src="{{ asset('img/Frame 62.svg') }}"
                        class="absolute inset-0 w-full h-full object-cover z-0" alt="">
                    <div class="card-body">
                        <div class="card-title text-white">Non-Custodial</div>
                        <div class=" text-white w-[453px]">Your keys. Your assets. Always. We never hold your funds or
                            private keys.</div>
                    </div>
                </div>
                <div class="card border border-white/10 rounded-md overflow-hidden relative col-span-5 min-h-[257px]">
                    <img src="{{ asset('img/Frame 63.svg') }}"
                        class="absolute inset-0 w-full h-full object-cover z-0" alt="">
                    <div class="card-body">
                        <div class="card-title text-white">Enkripsi</div>
                        <div class=" text-white w-[453px]">Encrypted end-to-end. Nobody reads but you. All your data is
                            locked tight instantly.</div>
                    </div>
                </div>
            </div>
            <div class="grid-cols-12 grid gap-5">
                <div class="card border border-white/10 rounded-md overflow-hidden relative col-span-5 min-h-[257px]">
                    <img src="{{ asset('img/Frame 62 (1).svg') }}"
                        class="absolute inset-0 w-full h-full object-cover z-0" alt="">
                    <div class="card-body">
                        <div class="card-title text-white">Isolasi API</div>
                        <div class=" text-white w-[453px]">Your Binance credentials never leave your device. Keys are
                            stored locally, with no withdrawal access.</div>
                    </div>
                </div>
                <div class="card border border-white/10 rounded-md overflow-hidden relative col-span-7 min-h-[257px]">
                    <img src="{{ asset('img/Frame 63 (1).svg') }}"
                        class="absolute inset-0 w-full h-full object-cover z-0" alt="">
                    <div class="card-body z-1">
                        <div class="pl-8">
                            <div class="card-title text-white">Permission</div>
                            <div class="text-white w-[453px]">You decide who sees what. Easily grant or revoke data
                                access with one click.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="h-[950px] text-center gap-10 flex items-center flex-col justify-center border-t border-[#666666]">
      <div class="text-3xl w-[620px]">Build your strategy and track market.</div>
    </div>

</body>

</html>
