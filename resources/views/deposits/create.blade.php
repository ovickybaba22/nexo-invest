<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Deposit funds
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
                        Enter the amount you would like to deposit. After submitting you’ll be redirected
                        to the NOWPayments checkout to complete the payment securely.
                    </p>

                    @if ($errors->has('deposit'))
                        <div class="mb-4 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first('deposit') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('deposits.store') }}" class="space-y-6">
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
                                min="1"
                                value="{{ old('amount', '100.00') }}"
                                required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-sky-500 focus:ring-sky-500"
                            >
                            @error('amount')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        @php
                            $currencyOptions = [
                                'usd' => 'US Dollar (USD)',
                                'eur' => 'Euro (EUR)',
                                'gbp' => 'British Pound (GBP)',
                            ];
                            $selectedCurrency = strtolower(old('currency', 'usd'));
                        @endphp

                        <div>
                            <label class="block text-sm font-medium mb-2" for="currency">
                                Currency (you’ll choose the crypto on NOWPayments)
                            </label>
                            <select
                                id="currency"
                                name="currency"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-sky-500 focus:ring-sky-500"
                            >
                                @foreach ($currencyOptions as $code => $label)
                                    <option value="{{ $code }}" {{ $selectedCurrency === $code ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('currency')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <a
                                href="{{ route('dashboard') }}"
                                class="text-sm text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white"
                            >
                                Cancel
                            </a>
                            <x-primary-button type="submit">
                                Continue to payment
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
