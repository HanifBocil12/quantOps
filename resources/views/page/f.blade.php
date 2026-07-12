<x-layout.app>
    {{-- resources/views/binance/portfolio.blade.php --}}
    
        <div class="max-w-4xl mx-auto p-6">

            <div class="flex items-center justify-between mb-6">
                <h1 class="text-lg font-mono tracking-wide text-neutral-200">Portfolio</h1>
                <div class="text-right">
                    <p class="text-xs text-neutral-500 uppercase tracking-widest">Total Value</p>
                    <p class="text-2xl font-mono text-emerald-400">
                        ${{ number_format($total_usdt, 2) }}
                    </p>
                </div>
            </div>

            @if ($error)
                <div class="bg-red-950/40 border border-red-900 text-red-400 text-sm p-4 rounded-lg font-mono">
                    {{ $error }}
                </div>
            @else
                <div class="bg-neutral-900/60 border border-neutral-800 rounded-lg overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-neutral-500 uppercase text-xs tracking-widest border-b border-neutral-800">
                                <th class="text-left px-4 py-3 font-mono">Asset</th>
                                <th class="text-right px-4 py-3 font-mono">Amount</th>
                                <th class="text-right px-4 py-3 font-mono">Price</th>
                                <th class="text-right px-4 py-3 font-mono">Value (USDT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($holdings as $h)
                                <tr class="border-b border-neutral-800/60 last:border-0 hover:bg-neutral-800/30">
                                    <td class="px-4 py-3 font-mono text-neutral-200">{{ $h['asset'] }}</td>
                                    <td class="px-4 py-3 text-right font-mono text-neutral-300">
                                        {{ rtrim(rtrim(number_format($h['total'], 8), '0'), '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-mono text-neutral-400">
                                        ${{ number_format($h['price_usdt'], 4) }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-mono text-neutral-200">
                                        ${{ number_format($h['value_usdt'], 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-neutral-500 font-mono text-sm">
                                        Gak ada holdings.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

        </div>



</x-layout.app>
