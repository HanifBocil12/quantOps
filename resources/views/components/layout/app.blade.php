<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @fonts

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @endif
</head>

<body>
    <div class="drawer lg:drawer-open bg-15">
        <input type="checkbox" id="main-drawer" class="drawer-toggle">

        <!-- Main content -->
        <div class="drawer-content flex min-h-screen">

            {{-- Top Bar --}}

            <div class="flex mt-5 rounded-tl-sm border items-center border-33 flex-col w-full bg-05 gap-3">
                {{ $slot }}
            </div>
        </div>

        {{-- Side --}}
        <x-sidebar></x-sidebar>
    </div>
</body>

</html>
