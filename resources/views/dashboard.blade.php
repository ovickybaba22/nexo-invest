<x-app-layout>
    @php
    // Money helper (same as before)
    $formatMoney = $formatMoney ?? function (?int $cents): string {
        $amount = ($cents ?? 0) / 100;
        return '$' . number_format($amount, 2);
    };
@endphp

   

    <div class="bg-gradient-to-b from-[#0B0E13] via-[#0B1118] to-[#070A0F] text-slate-50 min-h-screen">
            {{-- HERO STRIP – WELCOME + PORTFOLIO SNAPSHOT --}}
    <div class="border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 
                    grid gap-8 md:grid-cols-[minmax(0,2fr),minmax(0,1.35fr)] items-stretch">

            {{-- LEFT: welcome + quick stats + actions --}}
            <div class="space-y-5 flex flex-col justify-between">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 text-[11px] uppercase tracking-[0.18em] text-slate-400">
                        <img src="{{ asset('img/logo_white.png') }}" alt="Nexo Invest" class="h-5 w-auto">
                        <span>Nexo Invest</span>
                    </div>

                    <h1 class="text-2xl md:text-3xl font-semibold leading-snug text-slate-50">
                        Welcome back, <span class="text-sky-400">{{ auth()->user()->name ?? 'Investor' }}</span>
                    </h1>
                    <div class="mt-3 h-[2px] w-24 bg-gradient-to-r from-sky-500/70 to-transparent rounded-full"></div>

                    <p class="text-xs md:text-sm text-slate-400 max-w-xl">
                        Monitor live portfolio performance, fund your wallet, start new plans and request withdrawals in a single, institutional-grade interface.
                    </p>
                </div>

                @php
                    $canWithdraw = ($walletBalanceCents ?? 0) > 0;
                @endphp
                {{-- quick actions --}}
<div class="flex flex-wrap gap-3 text-[11px]">
    {{-- Deposit funds -> NOWPayments flow --}}
    <a href="{{ route('deposits.create') }}"
       class="inline-flex items-center justify-center rounded-full bg-sky-500 px-4 py-1.5 font-medium text-white hover:bg-sky-400">
        Deposit funds
    </a>

    {{-- Withdraw -> withdrawal form --}}
    <a href="{{ $canWithdraw ? route('withdrawals.index') : '#' }}"
       class="inline-flex items-center justify-center rounded-full border border-slate-700 bg-slate-900 px-4 py-1.5 font-medium text-slate-100 {{ $canWithdraw ? 'hover:bg-slate-800' : 'opacity-50 cursor-not-allowed pointer-events-none' }}"
       aria-disabled="{{ $canWithdraw ? 'false' : 'true' }}"
       title="{{ $canWithdraw ? 'Submit a withdrawal request' : 'Wallet balance must be positive to withdraw' }}">
        Withdraw
    </a>

    {{-- Keep your "Start a new plan" anchor as-is --}}
    <a href="#available-plans"
       class="inline-flex items-center justify-center rounded-full border border-slate-700 bg-slate-900 px-4 py-1.5 font-medium text-slate-100">
        Start a new plan
    </a>
</div>

                {{-- three tiny stat chips --}}
                <div class="flex flex-wrap gap-3 sm:gap-4 text-[11px] sm:text-xs">
                    <div class="rounded-xl bg-slate-900/80 border border-slate-800 px-4 py-3 min-w-[150px]">
                        <p class="text-slate-400">Total portfolio</p>
                        <p class="mt-1 text-lg font-semibold text-slate-50">
                            {{ $formatMoney($totalBalanceCents ?? 0) }}
                        </p>
                    </div>
                    <div class="rounded-xl bg-slate-900/80 border border-slate-800 px-4 py-3 min-w-[150px]">
                        <p class="text-slate-400">Available to invest</p>
                        <p class="mt-1 text-lg font-semibold text-sky-400">
                            {{ $formatMoney($availableToInvestCents ?? 0) }}
                        </p>
                    </div>
                    <div class="rounded-xl bg-slate-900/80 border border-slate-800 px-4 py-3 min-w-[150px]">
                        <p class="text-slate-400">Pending withdrawals</p>
                        <p class="mt-1 text-lg font-semibold text-amber-300">
                            {{ $formatMoney($pendingWithdrawalCents ?? 0) }}
                        </p>
                    </div>
                </div>

                {{-- cycle profit summary --}}
                <div class="grid gap-3 sm:grid-cols-3 text-[11px] sm:text-xs">
                    <div class="rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                        <p class="text-slate-400">Daily yield profit (lifetime)</p>
                        <p class="mt-1 text-lg font-semibold text-emerald-300">{{ $formatMoney($categoryProfitCents['daily'] ?? 0) }}</p>
                        <p class="text-[10px] text-slate-500">Includes {{ $formatMoney($todayProfitCents ?? 0) }} today</p>
                    </div>
                    <div class="rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                        <p class="text-slate-400">Weekly growth profit</p>
                        <p class="mt-1 text-lg font-semibold text-indigo-300">{{ $formatMoney($categoryProfitCents['weekly'] ?? 0) }}</p>
                        <p class="text-[10px] text-slate-500">This week {{ $formatMoney($thisWeekProfitCents ?? 0) }}</p>
                    </div>
                    <div class="rounded-xl bg-white/5 border border-white/10 px-4 py-3">
                        <p class="text-slate-400">APY portfolios profit</p>
                        <p class="mt-1 text-lg font-semibold text-cyan-300">{{ $formatMoney($categoryProfitCents['apy'] ?? 0) }}</p>
                        <p class="text-[10px] text-slate-500">Managed balance {{ $formatMoney($apyPortfolioCents ?? 0) }}</p>
                    </div>
                </div>
            </div>

            {{-- RIGHT: portfolio snapshot “card” (no external image) --}}
            <div class="relative">
                {{-- glow blobs --}}
                <div class="absolute -inset-6 bg-sky-500/20 blur-3xl opacity-50"></div>
                <div class="absolute -bottom-10 -right-6 h-32 w-32 rounded-full bg-emerald-400/20 blur-3xl opacity-60"></div>

                <div class="relative h-full rounded-3xl bg-gradient-to-br from-slate-900 via-slate-950 to-sky-950
                            border border-slate-800 shadow-[0_24px_80px_rgba(0,0,0,0.85)]
                            px-6 py-5 flex flex-col justify-between
                            transition transform hover:-translate-y-0.5 hover:shadow-[0_26px_90px_rgba(0,0,0,0.95)]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.16em] text-slate-400">
                                Portfolio snapshot
                            </p>
                            <h3 class="mt-1 text-sm font-semibold text-slate-50">
                                Nexo Invest app
                            </h3>
                        </div>
                    </div>

                    {{-- big number + “sparkline” bar --}}
                    <div class="mt-4 space-y-3">
                        @php
                            $todayChangeCents = $totalProfitCents ?? 0; // for now, show total profit as "today"
                        @endphp
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl font-semibold tracking-tight text-slate-50">
                                {{ $formatMoney($totalBalanceCents ?? 0) }}
                            </span>
                            <span class="text-xs font-medium {{ $todayChangeCents >= 0 ? 'text-emerald-300' : 'text-red-300' }}">
                                {{ $todayChangeCents >= 0 ? '+' : '' }}{{ $formatMoney($todayChangeCents) }} today
                            </span>
                        </div>
                        <div class="relative h-10 w-full rounded-xl bg-[#0B1017]/80 border border-slate-800 overflow-hidden shadow-[inset_0_0_40px_rgba(0,150,255,0.15)]">
                            {{-- Static gradient base --}}
                            <div class="absolute inset-0 bg-gradient-to-r from-sky-500/30 via-emerald-400/25 to-sky-500/5 opacity-80"></div>
                            {{-- Soft pulse overlay to suggest live movement --}}
                            <div class="absolute inset-0 bg-gradient-to-r from-sky-500/0 via-sky-500/40 to-sky-500/0 opacity-40 animate-pulse"></div>
                        </div>
                    </div>

                    {{-- allocation chips --}}
                    @if(isset($allocation) && $allocation->count())
                        <div class="mt-4 flex flex-wrap gap-2 text-[11px]">
                            @foreach($allocation as $slice)
                                @php
                                    $dotColor = match($slice['color'] ?? 'sky') {
                                        'emerald' => 'bg-emerald-400',
                                        'indigo' => 'bg-indigo-400',
                                        'amber' => 'bg-amber-300',
                                        'rose' => 'bg-rose-400',
                                        default => 'bg-sky-400',
                                    };
                                @endphp
                                @php
                                    $percentLabel = rtrim(rtrim(number_format($slice['percent'], 1), '0'), '.');
                                @endphp
                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-900/80 border border-slate-700 px-2.5 py-1">
                                    <span class="h-2 w-2 rounded-full {{ $dotColor }}"></span>
                                    {{ $slice['plan_name'] }} · {{ $percentLabel }}%
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4 text-[11px] text-slate-500">
                            No active investments yet. Start a plan to see your portfolio allocation.
                        </p>
                    @endif

                    <p class="mt-3 text-[10px] text-slate-500 max-w-xs">
                        Bank-grade encryption, multi-layer security and automated portfolio rebalancing – visualized just like in the Nexo app.
                    </p>
                </div>
            </div>
        </div>
    </div>
        {{-- MAIN CONTENT --}}
        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

                {{-- Section label: portfolio metrics --}}
<div class="flex items-center justify-between text-[11px] uppercase tracking-[0.18em] text-slate-400">
    <span>Portfolio metrics</span>
    <span class="hidden sm:inline text-slate-500">Live read on your balances</span>
</div>

                {{-- SUMMARY CARDS ROW --}}
                <div class="mt-4 grid gap-6 md:grid-cols-3">
                    {{-- MAIN PORTFOLIO METRICS CARD --}}
                    <div class="bg-gradient-to-b from-[#050814]/90 via-[#050814]/92 to-[#050814]/98 border border-slate-800/80 shadow-[0_16px_55px_rgba(0,0,0,0.9)] rounded-2xl p-6 flex flex-col justify-between">
                        <div>
                            <p class="text-xs font-medium text-slate-300">
                                Portfolio value
                            </p>

                            <p class="mt-2 text-3xl font-semibold tracking-tight">
                                {{ $formatMoney($totalBalanceCents ?? 0) }}
                            </p>

                            <p class="mt-2 text-[11px] text-slate-400">
                                Total profit:
                                <span class="font-medium text-emerald-300">
                                    {{ $formatMoney($totalProfitCents ?? 0) }}
                                </span>
                            </p>

                            <p class="mt-1 text-[11px] text-slate-400">
                                Available to invest:
                                <span class="font-medium text-sky-400">
                                    {{ $formatMoney($availableToInvestCents ?? 0) }}
                                </span>
                            </p>
                        </div>

                        {{-- Performance chips + tiny allocation bar --}}
                        @php
                            $seven = $sevenDayChangePercent ?? 0;
                            $ytd   = $ytdChangePercent ?? 0;
                            $segments = $allocation ?? [];
                        @endphp

                        <div class="mt-4 space-y-3 text-[11px] text-slate-400">
                            <div class="flex items-center gap-2">
                                {{-- 7d chip --}}
                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5
                                             {{ $seven >= 0 ? 'bg-emerald-500/10 text-emerald-300' : 'bg-red-500/10 text-red-300' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $seven >= 0 ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                                    {{ $seven >= 0 ? '+' : '' }}{{ number_format($seven, 2) }}%
                                    <span class="text-slate-400">7d</span>
                                </span>

                                {{-- YTD chip --}}
                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5
                                             {{ $ytd >= 0 ? 'bg-sky-500/10 text-sky-300' : 'bg-red-500/10 text-red-300' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $ytd >= 0 ? 'bg-sky-400' : 'bg-red-400' }}"></span>
                                    {{ $ytd >= 0 ? '+' : '' }}{{ number_format($ytd, 2) }}%
                                    <span class="text-slate-400">YTD</span>
                                </span>
                            </div>

                            {{-- Allocation bar --}}
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] uppercase tracking-[0.16em] text-slate-500">
                                    Allocation
                                </span>
                                <div class="flex-1 h-2.5 rounded-full bg-slate-950/70 border border-slate-800 overflow-hidden flex">
                                    @forelse ($segments as $segment)
                                        <div
                                            class="h-full"
                                            style="width: {{ max(2, $segment['percent']) }}%;"
                                        >
                                            <div class="h-full w-full opacity-80"
                                                 @class([
                                                     'bg-sky-500' => ($segment['color'] ?? '') === 'sky',
                                                     'bg-emerald-400' => ($segment['color'] ?? '') === 'emerald',
                                                     'bg-indigo-400' => ($segment['color'] ?? '') === 'indigo',
                                                     // fallback
                                                     'bg-slate-500' => ! in_array(($segment['color'] ?? ''), ['sky','emerald','indigo']),
                                                 ])>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="h-full w-full bg-slate-700/40"></div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- GROWTH MOMENTUM --}}
                    <div class="bg-gradient-to-b from-[#050814]/90 via-[#050814]/88 to-[#050814]/95 border border-slate-800/80 shadow-[0_16px_55px_rgba(0,0,0,0.9)] rounded-2xl p-6 flex flex-col justify-between transition transform hover:-translate-y-0.5 hover:border-emerald-500/55 hover:shadow-[0_20px_70px_rgba(0,0,0,0.98)]">
                        <p class="text-xs font-medium text-slate-300">
                            Growth momentum
                        </p>

                        @php
                            $growthStats = [
                                ['label' => 'Today', 'value' => $todayProfitCents ?? 0],
                                ['label' => '7 days', 'value' => $sevenDayProfitCents ?? 0],
                                ['label' => 'Year to date', 'value' => $ytdProfitCents ?? 0],
                            ];
                            $balanceForRatio = max(1, $totalBalanceCents ?? 1);
                        @endphp

                        <div class="mt-4 space-y-4">
                            @foreach ($growthStats as $stat)
                                @php
                                    $isPositive = $stat['value'] >= 0;
                                    $ratio = min(100, max(5, (abs($stat['value']) / $balanceForRatio) * 400));
                                @endphp
                                <div>
                                    <div class="flex items-center justify-between text-[11px] uppercase tracking-[0.16em] text-slate-500">
                                        <span>{{ $stat['label'] }}</span>
                                        <span class="text-sm font-semibold {{ $isPositive ? 'text-emerald-300' : 'text-red-300' }}">
                                            {{ $isPositive ? '+' : '' }}{{ $formatMoney($stat['value']) }}
                                        </span>
                                    </div>
                                    <div class="mt-2 h-1.5 rounded-full bg-slate-900/70 border border-slate-800 overflow-hidden">
                                        <div class="h-full {{ $isPositive ? 'bg-emerald-400' : 'bg-red-400' }}" style="width: {{ $ratio }}%;"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <p class="mt-4 text-[11px] text-slate-400">
                            {{ ($activeInvestments ?? collect())->count() }} active positions generating daily profit.
                        </p>
                    </div>

                    {{-- PLAN ALLOCATION CARD --}}
                    <div class="bg-gradient-to-b from-[#050814]/90 via-[#050814]/88 to-[#050814]/95 border border-slate-800/80 shadow-[0_16px_55px_rgba(0,0,0,0.9)] rounded-2xl p-6 flex flex-col justify-between transition transform hover:-translate-y-0.5 hover:border-sky-500/55 hover:shadow-[0_20px_70px_rgba(0,0,0,0.98)]">
                        <p class="text-xs font-medium text-slate-300">
                            Plan allocation
                        </p>

                        <div class="mt-4 space-y-3 text-sm text-slate-200">
                            @forelse (($allocation ?? []) as $segment)
                                @php
                                    $color = $segment['color'] ?? 'sky';
                                    $colorClass = match ($color) {
                                        'emerald' => 'bg-emerald-400',
                                        'indigo' => 'bg-indigo-400',
                                        'amber' => 'bg-amber-300',
                                        default => 'bg-sky-400',
                                    };
                                @endphp
                                <div class="flex items-center justify-between gap-4">
                                    @php
                                        $percentLabel = rtrim(rtrim(number_format($segment['percent'], 1), '0'), '.');
                                    @endphp
                                    <div>
                                        <p class="font-medium">{{ $segment['plan_name'] }}</p>
                                        <p class="text-[11px] text-slate-500">{{ $formatMoney($segment['amount_cents'] ?? 0) }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[11px] text-slate-400">{{ $percentLabel }}%</span>
                                        <div class="w-20 h-1.5 rounded-full bg-slate-900/70 border border-slate-800 overflow-hidden">
                                            <div class="h-full {{ $colorClass }}" style="width: {{ max(4, $segment['percent']) }}%;"></div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-[12px] text-slate-500">Start an investment to see your allocation diversify.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Earnings chart + insights --}}
                <div class="mt-8 grid gap-6 lg:grid-cols-[minmax(0,1.15fr),minmax(0,0.85fr)]">
                    <div class="rounded-2xl border border-slate-800/70 bg-[#050814]/90 p-5">
                        <div class="flex items-center justify-between text-sm text-slate-300">
                            <span>30-day earnings</span>
                            <span class="text-[11px] text-slate-500">Live compounding from all plans</span>
                        </div>
                        <div class="mt-4">
                            <canvas id="earningsChart" height="220"></canvas>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-slate-800/70 bg-[#050814]/90 p-5 space-y-4 text-sm text-slate-300">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-[0.2em]">Performance</p>
                            <p class="mt-1 text-lg font-semibold text-white">{{ $formatMoney($todayProfitCents ?? 0) }}</p>
                            <p class="text-[11px] text-slate-500">Profit credited today</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-[0.2em]">This week</p>
                            <p class="mt-1 text-lg font-semibold text-white">{{ $formatMoney($thisWeekProfitCents ?? 0) }}</p>
                            <p class="text-[11px] text-slate-500">Includes all weekly cycles</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-[0.2em]">Year to date</p>
                            <p class="mt-1 text-lg font-semibold text-white">{{ $formatMoney($ytdProfitCents ?? 0) }}</p>
                            <p class="text-[11px] text-slate-500">Vs invested {{ number_format($ytdChangePercent ?? 0, 2) }}%</p>
                        </div>
                    </div>
                </div>

                {{-- Active investments grouped --}}
                <div class="mt-10 space-y-8">
                    @foreach($investmentsByCategory as $category => $group)
                        @php
                            $label = $categoryLabels[$category] ?? ucfirst($category);
                            $iconColor = match($category) {
                                'weekly' => 'text-emerald-300',
                                'apy' => 'text-indigo-300',
                                default => 'text-cyan-300',
                            };
                        @endphp
                        <div class="rounded-2xl border border-slate-800 bg-[#050814]/90 p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.3em] text-slate-500">{{ $label }}</p>
                                    <p class="mt-1 text-lg font-semibold text-white">{{ $group->count() }} active {{ Str::plural('plan', $group->count()) }}</p>
                                </div>
                                <span class="inline-flex items-center rounded-full border border-white/10 px-3 py-1 text-xs {{ $iconColor }}">
                                    Next credit cadence: {{ $category === 'weekly' ? 'Weekly' : ($category === 'apy' ? 'Monthly' : 'Daily') }}
                                </span>
                            </div>
                            <div class="mt-4 overflow-x-auto">
                                <table class="min-w-full text-left text-sm text-slate-300">
                                    <thead class="text-xs uppercase tracking-wide text-slate-500">
                                        <tr>
                                            <th class="py-2 pr-4">Plan</th>
                                            <th class="py-2 pr-4">Principal</th>
                                            <th class="py-2 pr-4">Profit to date</th>
                                            <th class="py-2 pr-4">Last payout</th>
                                            <th class="py-2">Next payout</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800 text-sm">
                                        @foreach($group as $investment)
                                            @php
                                                $plan = $investment->plan;
                                                $principal = $formatMoney($investment->amount_cents ?? 0);
                                                $profit = $formatMoney($investment->accrued_profit_cents ?? 0);
                                            @endphp
                                            <tr>
                                                <td class="py-3 pr-4">
                                                    <p class="font-semibold text-white">{{ $plan->name ?? 'Plan' }}</p>
                                                    <p class="text-xs text-slate-500">{{ $plan->term_label ?? 'Flexible term' }}</p>
                                                </td>
                                                <td class="py-3 pr-4">{{ $principal }}</td>
                                                <td class="py-3 pr-4 text-emerald-300">{{ $profit }}</td>
<td class="py-3 pr-4 text-slate-400">
@php
    $lastDate = $investment->last_payout_at ?? $investment->last_yield_at;
    $nextDate = $investment->next_payout_at ?? $investment->next_yield_at;
@endphp

<td class="px-4 py-3 text-xs text-slate-400">
    {{ $lastDate ? $lastDate->timezone(config('app.timezone'))->format('M j, Y') : '—' }}
</td>
<td class="px-4 py-3 text-xs text-slate-400">
    {{ $nextDate ? $nextDate->timezone(config('app.timezone'))->format('M j, Y') : 'Queued' }}
</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- GRID: LEFT (plans + activity) / RIGHT (available plans + wallet) --}}
               <div class="flex items-center justify-between text-[11px] uppercase tracking-[0.18em] text-slate-400">
    <span>Positions &amp; activity</span>
    <span class="hidden sm:inline text-slate-500">Where your money is working</span>
</div>
                <div class="grid gap-6 lg:grid-cols-3">
                    {{-- LEFT COLUMN --}}
                    <div class="space-y-6 lg:col-span-2">
                        {{-- Your investment plans --}}
                        <div class="bg-[#050814]/95 border border-slate-800/80 shadow-[0_16px_55px_rgba(0,0,0,0.9)] rounded-2xl p-6 transition transform hover:-translate-y-0.5 hover:border-sky-500/50 hover:shadow-[0_20px_70px_rgba(0,0,0,0.98)]">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-sm font-semibold text-slate-50">
                                        Your investment plans
                                    </h3>
                                    <p class="mt-1 text-[11px] text-slate-400">
                                        Live view of where your money is invested.
                                    </p>
                                </div>
                            </div>

                            @forelse(($plansSummary ?? []) as $summary)
                                @php
                                    $plan = $summary['plan'] ?? null;
                                    $amountCents = $summary['total_amount_cents'] ?? 0;
                                    $currentValueCents = $summary['computed_current_cents']
                                        ?? $summary['current_value_cents']
                                        ?? $amountCents;
                                    $profitCents = $summary['profit_cents'] ?? ($currentValueCents - $amountCents);
                                    $progress = min(100, max(0, $summary['progress_percent'] ?? 0));
                                    $profitPositive = $profitCents >= 0;
                                    $positions = $summary['investment_count'] ?? 1;
                                @endphp
                                <div class="border border-slate-800 rounded-xl px-4 py-3 mb-3 bg-slate-900/80">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-slate-50">
                                                {{ $plan->name ?? 'Plan' }}
                                            </p>
                                            <p class="text-[11px] text-slate-400">
                                                {{ $positions }} {{ \Illuminate\Support\Str::plural('position', $positions) }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[10px] uppercase tracking-wide text-slate-400">
                                                Invested
                                            </p>
                                            <p class="text-sm font-semibold">
                                                {{ $formatMoney($amountCents) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex items-center justify-between text-sm">
                                        <div class="text-slate-300">
                                            <span class="text-[11px] uppercase tracking-[0.16em] text-slate-500">Current</span>
                                            <p class="font-semibold">
                                                {{ $formatMoney($currentValueCents) }}
                                                <span class="text-[10px] text-slate-500">(
                                                    <span class="{{ $profitPositive ? 'text-emerald-300' : 'text-red-300' }}">
                                                        {{ $profitPositive ? '+' : '' }}{{ $formatMoney($profitCents) }}
                                                    </span>
                                                )</span>
                                            </p>
                                        </div>
                                        <div class="text-right text-[11px] uppercase tracking-[0.16em] text-slate-500">
                                            Term progress
                                            <p class="text-xs text-slate-300 font-semibold">
                                                {{ rtrim(rtrim(number_format($progress, 1), '0'), '.') }}%
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-2 h-1.5 rounded-full bg-slate-900/70 border border-slate-800 overflow-hidden">
                                        <div class="h-full bg-sky-400" style="width: {{ $progress }}%;"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400">
                                    You don’t have any active investments yet.
                                    <a href="#available-plans" class="text-sky-400 hover:text-sky-300 font-medium">
                                        Start a plan on the right →
                                    </a>
                                </p>
                            @endforelse

                            <p class="mt-4 text-[11px] text-slate-500">
                                Profit accrues every day based on each plan’s target ROI. Once a term finishes the position closes automatically and the principal plus profit move back into your wallet balance.
                            </p>
                        </div>

                        {{-- Recent activity --}}
                        <div class="bg-[#050814]/95 border border-slate-800/80 shadow-[0_16px_55px_rgba(0,0,0,0.9)] rounded-2xl p-6 transition transform hover:-translate-y-0.5 hover:border-sky-500/50 hover:shadow-[0_20px_70px_rgba(0,0,0,0.98)]">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-sm font-semibold text-slate-50">
                                        Recent activity
                                    </h3>
                                    <p class="mt-1 text-[11px] text-slate-400">
                                        History of your deposits, investments and withdrawals.
                                    </p>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full text-xs">
                                    <thead>
                                        <tr class="text-[11px] font-medium uppercase tracking-wide text-slate-400 border-b border-slate-800">
                                            <th class="py-2 pr-4 text-left">Date</th>
                                            <th class="py-2 pr-4 text-left">Type</th>
                                            <th class="py-2 pr-4 text-left">Plan</th>
                                            <th class="py-2 pr-4 text-right">Amount</th>
                                            <th class="py-2 pl-4 text-right">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800">
@forelse($recentActivity ?? [] as $item)
    @php
        $isArray = is_array($item);

        $createdAt = $isArray
            ? ($item['created_at'] ?? ($item['date'] ?? null))
            : ($item->created_at ?? $item->date ?? null);
        $type = $isArray ? ($item['type'] ?? null) : ($item->type ?? null);
        $planName = $isArray
            ? ($item['plan_name'] ?? null)
            : ($item->plan_name ?? ($item->plan->name ?? null));
        $amountCents = $isArray ? ($item['amount_cents'] ?? null) : ($item->amount_cents ?? null);
        $status = strtolower($isArray ? ($item['status'] ?? '') : ($item->status ?? ''));

        $createdAtFormatted = '—';
        if ($createdAt instanceof \Carbon\CarbonInterface) {
            $createdAtFormatted = $createdAt->format('Y-m-d');
        } elseif (!empty($createdAt)) {
            $createdAtFormatted = substr((string) $createdAt, 0, 10);
        }
    @endphp
    <tr>
        <td class="py-2 pr-4 text-[11px] text-slate-400">
            {{ $createdAtFormatted }}
        </td>
        <td class="py-2 pr-4 text-[11px] font-medium text-slate-50">
            {{ ucfirst($type ?? '—') }}
        </td>
        <td class="py-2 pr-4 text-[11px] text-slate-400">
            {{ $planName ?? '—' }}
        </td>
        <td class="py-2 pr-4 text-[11px] text-right text-slate-50">
            {{ $formatMoney($amountCents ?? 0) }}
        </td>
        <td class="py-2 pl-4 text-[11px] text-right">
            <span
                @class([
                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-medium',
                    'bg-emerald-500/10 text-emerald-300' => in_array($status, ['completed','confirmed','approved','active']),
                    'bg-amber-500/10 text-amber-300' => in_array($status, ['pending','waiting']),
                    'bg-red-500/10 text-red-300' => in_array($status, ['failed','rejected','cancelled']),
                    'bg-slate-700 text-slate-200' => ! $status,
                ])>
                {{ ucfirst($status ?: '—') }}
            </span>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="py-4 text-[11px] text-slate-400">
            No activity yet. Your transactions will appear here.
        </td>
    </tr>
@endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="space-y-6">
                        {{-- Available plans --}}
                        <div id="available-plans" class="bg-[#050814]/95 border border-slate-800/80 shadow-[0_16px_55px_rgba(0,0,0,0.9)] rounded-2xl p-6 transition transform hover:-translate-y-0.5 hover:border-sky-500/50 hover:shadow-[0_20px_70px_rgba(0,0,0,0.98)]">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-semibold text-slate-50">
                                    Available plans
                                </h3>
                                <a href="{{ route('plans.index') }}"
                                   class="text-[11px] font-medium text-sky-400 hover:text-sky-300">
                                    View all
                                </a>
                            </div>

                            <div class="space-y-4">
                                @forelse($availablePlans ?? [] as $plan)
                                    @php
                                        $planMinDepositCents = $plan->min_deposit_cents ?? $plan->min_deposit ?? 0;
                                    @endphp
                                    <div class="border border-slate-800 rounded-xl px-4 py-3 bg-slate-900/80
                                             transition hover:border-sky-500/40 hover:bg-slate-900 hover:shadow-lg">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-slate-50">
                                                    {{ $plan->name }}
                                                </p>
                                                <p class="mt-1 text-[11px] text-slate-400">
                                                    Min deposit {{ $formatMoney($planMinDepositCents) }}
                                                    • Target ROI {{ number_format($plan->target_roi_percent ?? 0, 2) }}%
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <a href="{{ route('invest.start', $plan->slug) }}"
                                               class="inline-flex w-full items-center justify-center rounded-lg bg-sky-500 px-3 py-1.5 text-[11px] font-medium text-white hover:bg-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:ring-offset-slate-900">
                                                Start this plan
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-slate-400">
                                        No plans are currently available.
                                    </p>
                                @endforelse
                            </div>
                        </div>

                        {{-- Wallet quick stats --}}
                        <div class="bg-[#050814]/95 border border-slate-800/80 shadow-[0_16px_55px_rgba(0,0,0,0.9)] rounded-2xl p-6 space-y-3 text-xs transition transform hover:-translate-y-0.5 hover:border-sky-500/50 hover:shadow-[0_20px_70px_rgba(0,0,0,0.98)]">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Available to invest</span>
                                <span class="font-semibold text-sky-400">
                                    {{ $formatMoney($availableToInvestCents ?? 0) }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Withdrawable wallet</span>
                                <span class="font-semibold text-emerald-300">
                                    {{ $formatMoney($withdrawableWalletCents ?? 0) }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Pending withdrawals</span>
                                <span class="font-semibold text-amber-300">
                                    {{ $formatMoney($pendingWithdrawalCents ?? 0) }}
                                </span>
                            </div>

                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('deposits.create') }}"
                                   class="flex-1 inline-flex items-center justify-center rounded-lg bg-sky-500 px-3 py-1.5 text-[11px] font-medium text-white hover:bg-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:ring-offset-slate-900">
                                    Deposit funds
                                </a>
                                <a href="{{ route('withdrawals.index') }}"
                                   class="flex-1 inline-flex items-center justify-center rounded-lg border border-slate-700 bg-slate-900 px-3 py-1.5 text-[11px] font-medium text-slate-100 hover:bg-slate-800">
                                    Withdraw
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FUNDING SECTION + TRUST STRIP --}}
                <section class="mt-10 space-y-6">
                    <div class="flex items-center justify-between text-[11px] uppercase tracking-[0.18em] text-slate-400">
                        <span>Funding &amp; safety</span>
                        <span class="hidden sm:inline text-slate-500">Move money in and out with confidence</span>
                    </div>
                    {{-- Deposit / withdraw card --}}
                    <div id="deposit"
                         class="bg-[#050814]/95 border border-slate-800/80 shadow-[0_16px_55px_rgba(0,0,0,0.9)] rounded-2xl p-6 transition transform hover:-translate-y-0.5 hover:border-sky-500/50 hover:shadow-[0_20px_70px_rgba(0,0,0,0.98)]">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-sm font-semibold text-slate-50">
                                    Fund &amp; withdraw
                                </h3>
                                <p class="mt-1 text-[11px] text-slate-400">
                                    Top up your balance with crypto deposits and request withdrawals from the same place.
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 grid gap-3 text-[11px] text-slate-300">
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-sky-400"></span>
                                Instant crypto deposits via NOWPayments with live FX quotes.
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                                Same-dashboard withdrawal requests with admin review in minutes.
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                                Dedicated desk for bank wires above $25k & OTC settlement.
                            </div>
                        </div>
                    </div>

                    {{-- Trust / reassurance strip --}}
                    <div class="grid gap-4 md:grid-cols-3 text-[11px]">
                        <div class="rounded-2xl border border-slate-800/80 bg-[#050814]/95 px-4 py-3 flex items-start gap-3 shadow-[0_14px_40px_rgba(0,0,0,0.8)] transition hover:border-sky-500/45 hover:shadow-[0_18px_55px_rgba(0,0,0,0.9)]">
                            <div class="mt-1 h-6 w-6 rounded-full bg-emerald-500/10 flex items-center justify-center">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                            </div>
                            <div>
                                <p class="font-medium text-slate-50">Bank‑grade security</p>
                                <p class="mt-1 text-slate-400">
                                    Multi‑layer encryption, withdrawal reviews and device‑level protection on every account.
                                </p>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-800/80 bg-[#050814]/95 px-4 py-3 flex items-start gap-3 shadow-[0_14px_40px_rgba(0,0,0,0.8)] transition hover:border-sky-500/45 hover:shadow-[0_18px_55px_rgba(0,0,0,0.9)]">
                            <div class="mt-1 h-6 w-6 rounded-full bg-sky-500/10 flex items-center justify-center">
                                <span class="h-2.5 w-2.5 rounded-full bg-sky-400"></span>
                            </div>
                            <div>
                                <p class="font-medium text-slate-50">Institutional yield engine</p>
                                <p class="mt-1 text-slate-400">
                                    Structured strategies targeting consistent returns, visualized in your portfolio snapshot.
                                </p>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-800/80 bg-[#050814]/95 px-4 py-3 flex items-start gap-3 shadow-[0_14px_40px_rgba(0,0,0,0.8)] transition hover:border-sky-500/45 hover:shadow-[0_18px_55px_rgba(0,0,0,0.9)]">
                            <div class="mt-1 h-6 w-6 rounded-full bg-indigo-500/10 flex items-center justify-center">
                                <span class="h-2.5 w-2.5 rounded-full bg-indigo-400"></span>
                            </div>
                            <div>
                                <p class="font-medium text-slate-50">24/7 human support</p>
                                <p class="mt-1 text-slate-400">
                                    Need help with a large deposit or payout? Reach out and a specialist will review it in minutes.
                                </p>
                            </div>
                        </div>
                    </div>
                                </section>

                {{-- TICKER BAR – mirrors landing page feel --}}
                <div class="mt-10 border-t border-slate-800/80 bg-slate-950/95">
                    @php
                        $tickerPlans = ($availablePlans ?? collect())->take(4);
                    @endphp
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 text-[11px] text-slate-300 flex items-center gap-6 overflow-x-auto whitespace-nowrap">
                        @forelse($tickerPlans as $plan)
                            @php
                                $roi = number_format((float) ($plan->target_roi_percent ?? 0), 1);
                            @endphp
                            <div class="flex items-center gap-1">
                                <span class="font-semibold text-emerald-300">+{{ $roi }}% APY</span>
                                <span class="text-slate-500">• {{ $plan->name }}</span>
                            </div>
                        @empty
                            <div class="flex items-center gap-1">
                                <span class="font-semibold text-emerald-300">Instant payouts</span>
                                <span class="text-slate-500">• Secure yield</span>
                            </div>
                        @endforelse
                        <div class="flex items-center gap-1">
                            <span class="font-semibold text-emerald-300">{{ ($activeInvestments ?? collect())->count() }}</span>
                            <span class="text-slate-500">• Active plans</span>
                        </div>
                    </div>
                </div>

                {{-- FOOTER / LEGAL STRIP --}}
                <footer class="border-t border-slate-800/80 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-[11px] text-slate-500">
                        <div class="space-y-1 max-w-xl">
                            <p class="text-slate-400">
                                ©{{ now()->year }} Nexo Invest. All rights reserved.
                            </p>
                            <p class="text-slate-500/80">
                                This financial promotion has been approved by Gateway 21 Limited on 1 February 2024.
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                            <a href="{{ route('terms') }}" class="hover:text-sky-400">
                                Terms of Service
                            </a>
                            <span class="text-slate-700">•</span>
                            <a href="{{ route('privacy') }}" class="hover:text-sky-400">
                                Privacy Policy
                            </a>
                            <span class="hidden md:inline text-slate-700">•</span>
                            <span class="text-slate-500/80">
                                Built for modern wealth platforms.
                            </span>
                        </div>
                    </div>
                </footer>
            
            </div>
        </div>
    </div>
</x-app-layout>

@once
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('earningsChart');
            if (!canvas || typeof Chart === 'undefined') return;

            const dataset = @json($profitSeries ?? []);
            const labels = dataset.map(point => point.date);
            const values = dataset.map(point => (point.amount ?? 0) / 100);

            new Chart(canvas, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Profit (USD)',
                        data: values,
                        borderColor: '#22d3ee',
                        backgroundColor: 'rgba(34,211,238,0.15)',
                        borderWidth: 2,
                        fill: true,
                        pointRadius: 0,
                        tension: 0.35,
                    }],
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#94a3b8', maxTicksLimit: 6 },
                        },
                        y: {
                            grid: { color: 'rgba(148,163,184,0.1)' },
                            ticks: {
                                color: '#94a3b8',
                                callback: value => `$${value.toLocaleString()}`,
                            },
                        },
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: context => `Profit: $${context.parsed.y.toLocaleString()}`,
                            },
                        },
                    },
                },
            });
        });
    </script>
@endonce
