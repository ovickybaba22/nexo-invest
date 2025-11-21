<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Investment plans
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Choose a strategy that aligns with your funding level and time horizon.
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-medium
                      border border-gray-300 text-gray-700 bg-white hover:bg-gray-50
                      dark:border-gray-600 dark:text-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700">
                ← Back to dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow-sm sm:rounded-xl p-6 lg:p-8">
                <div class="grid gap-6 lg:grid-cols-2">
                    @forelse ($plans as $plan)
                        <div class="border border-gray-100 dark:border-gray-700 rounded-xl p-5
                                    hover:border-indigo-500/60 hover:shadow-md transition-all">
                            <div class="flex items-start justify-between">
                                @php
                                    $targetRoi = $plan->target_roi_percent;
                                    $targetRoiLabel = is_null($targetRoi)
                                        ? 'ROI disclosed on request'
                                        : 'Target ROI '.number_format($targetRoi, 2).'%';
                                @endphp
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $plan->name }}
                                    </h3>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ ucfirst($plan->category ?? 'daily') }} programme • {{ $targetRoiLabel }}
                                    </p>
                                </div>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5
                                             text-[11px] font-medium bg-indigo-50 text-indigo-700
                                             dark:bg-indigo-900/40 dark:text-indigo-200">
                                    {{ strtoupper($plan->slug) }}
                                </span>
                            </div>

                            @php
                                $minDepositCents = $plan->min_deposit_cents ?? $plan->min_deposit;
                                $minDepositLabel = $minDepositCents
                                    ? '$'.number_format($minDepositCents / 100, 2)
                                    : 'Tailored minimum';
                            @endphp
                            <dl class="mt-4 space-y-2 text-xs text-gray-500 dark:text-gray-400">
                                <div class="flex justify-between">
                                    <dt>Minimum deposit</dt>
                                    <dd class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $minDepositLabel }}
                                    </dd>
                                </div>
                                @if (! empty($plan->description))
                                    <div>
                                        <dt class="mb-1">Strategy</dt>
                                        <dd class="leading-snug">
                                            {{ $plan->description }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>

                            <div class="mt-5 flex justify-end">
                                <a href="{{ route('invest.start', $plan->slug) }}"
                                   class="inline-flex items-center justify-center px-3.5 py-1.5
                                          text-xs font-semibold rounded-md bg-indigo-600 text-white
                                          hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2
                                          focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                                    Invest / Deposit
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            No plans are available at the moment.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
