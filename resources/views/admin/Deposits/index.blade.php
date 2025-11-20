<x-app-layout>
    @php
        // Local money formatter for this view (amounts are stored in cents)
        $formatMoney = function (int $cents = 0): string {
            return '$' . number_format($cents / 100, 2);
        };
    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Admin · Deposits
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-4">
                        All deposits
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Date</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">User</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Amount</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Asset</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($deposits as $deposit)
                                    <tr>
                                        <td class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                            {{ $deposit->created_at->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                            {{ optional($deposit->user)->name ?? '—' }}
                                            <div class="text-xs text-gray-500">
                                                {{ optional($deposit->user)->email }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                            {{ $formatMoney($deposit->amount_cents ?? 0) }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                            {{ $deposit->asset ?? '—' }}
                                        </td>
                                        <td class="px-4 py-2">
                                            @php $status = $deposit->status; @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if ($status === 'completed') bg-green-100 text-green-800
                                                @elseif ($status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif ($status === 'failed' || $status === 'cancelled') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif
                                            ">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                            No deposits found yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $deposits->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>