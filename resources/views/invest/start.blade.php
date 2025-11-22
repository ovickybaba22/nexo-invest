<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Start investment – {{ $plan->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <p class="mb-4">
                        You’re about to start an investment in the
                        <strong>{{ $plan->name }}</strong> plan.
                    </p>

                    @php
                        $availableBalanceRaw = ($availableBalanceCents ?? 0) / 100;
                        $availableBalanceUsd = number_format($availableBalanceRaw, 2);

                        $minInvestRaw = isset($plan->min_deposit_cents)
                            ? ($plan->min_deposit_cents / 100)
                            : 0;

                        $minInvestUsd = number_format($minInvestRaw, 2);
                        $maxInvestRaw = max($availableBalanceRaw, 0);
                        $maxInvestUsd = number_format($maxInvestRaw, 2);
                    @endphp

                    <div class="mb-4 rounded-md bg-gray-50 dark:bg-gray-900 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                        <p>
                            <span class="font-semibold">Available balance:</span>
                            <span class="text-emerald-600 dark:text-emerald-400">
                                ${{ $availableBalanceUsd }}
                            </span>
                        </p>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Minimum for this plan:
                            <span class="font-semibold">${{ $minInvestUsd }}</span>
                            @if ($availableBalanceRaw < $minInvestRaw)
                                &mdash; you’ll need to top up before you can start this investment.
                            @endif
                        </p>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            This investment will be funded from your Nexo Invest balance.
                            If you need to add more funds, please make a crypto deposit
                            from your dashboard before starting this investment.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('invest.store', $plan->slug) }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" for="amount">
                                Amount to invest
                            </label>

                            <input
                                id="amount"
                                name="amount"
                                type="number"
                                step="0.01"
                                min="{{ $minInvestRaw > 0 ? $minInvestRaw : 10 }}"
                                value="{{ old('amount') }}"
                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                                       focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                required
                            >

                            @error('amount')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror

                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Min: ${{ $minInvestUsd }} &mdash;
                                Max: ${{ $maxInvestUsd }}
                                based on your available balance.
                            </p>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('dashboard') }}"
                               class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white mr-4">
                                Cancel
                            </a>

                            <x-primary-button type="submit">
                                Start investment
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
