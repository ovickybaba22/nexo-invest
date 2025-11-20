<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Request withdrawal
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Available balance: <span class="font-semibold">${{ $availableBalanceUsd }}</span>.
                        Withdrawals stay in “pending” until an admin approves them for payout.
                    </p>

                    <form method="POST" action="{{ route('withdrawals.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium mb-2" for="amount">
                                Amount
                            </label>
                            <input
                                id="amount"
                                name="amount"
                                type="number"
                                step="0.01"
                                min="10"
                                value="{{ old('amount', '50.00') }}"
                                required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-sky-500 focus:ring-sky-500"
                            >
                            @error('amount')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2" for="method">
                                Preferred method (optional)
                            </label>
                            <input
                                id="method"
                                name="method"
                                type="text"
                                value="{{ old('method') }}"
                                placeholder="USDT wallet, bank wire, etc."
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-sky-500 focus:ring-sky-500"
                            >
                            @error('method')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white">
                                Cancel
                            </a>
                            <x-primary-button type="submit">
                                Submit request
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
