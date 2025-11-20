<x-app-layout>
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 space-y-8">

            {{-- Page header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-slate-50">
                        Admin control center
                    </h1>
                    <p class="mt-1 text-sm text-slate-400">
                        Manage plans, users, deposits and withdrawals from one place.
                    </p>
                </div>
            </div>

            {{-- High-level stats --}}
            <div class="grid gap-4 md:grid-cols-4 text-sm">
                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-4">
                    <p class="text-[11px] text-slate-400 uppercase tracking-[0.16em]">
                        Users
                    </p>
                    <p class="mt-2 text-2xl font-semibold text-slate-50">
                        {{ number_format($totalUsers) }}
                    </p>
                </div>

                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-4">
                    <p class="text-[11px] text-slate-400 uppercase tracking-[0.16em]">
                        Plans
                    </p>
                    <p class="mt-2 text-2xl font-semibold text-slate-50">
                        {{ number_format($totalPlans) }}
                    </p>
                </div>

                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-4">
                    <p class="text-[11px] text-slate-400 uppercase tracking-[0.16em]">
                        Total deposits
                    </p>
                    <p class="mt-2 text-2xl font-semibold text-emerald-300">
                        {{ $formatMoney($totalDepositsCents ?? 0) }}
                    </p>
                </div>

                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-4">
                    <p class="text-[11px] text-slate-400 uppercase tracking-[0.16em]">
                        Total withdrawals
                    </p>
                    <p class="mt-2 text-2xl font-semibold text-sky-300">
                        {{ $formatMoney($totalWithdrawalsCents ?? 0) }}
                    </p>
                </div>
            </div>

            {{-- Management sections --}}
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 text-sm">
                <a href="{{ route('admin.deposits.index') }}"
                   class="rounded-xl bg-slate-950/60 border border-slate-800 p-4 hover:border-sky-500/70 transition">
                    <p class="text-[11px] text-slate-400 uppercase tracking-[0.16em]">
                        Deposits
                    </p>
                    <p class="mt-2 text-sm text-slate-200">
                        Review and manage all deposit requests.
                    </p>
                </a>

                <a href="{{ route('admin.withdrawals.index') }}"
                   class="rounded-xl bg-slate-950/60 border border-slate-800 p-4 hover:border-sky-500/70 transition">
                    <p class="text-[11px] text-slate-400 uppercase tracking-[0.16em]">
                        Withdrawals
                    </p>
                    <p class="mt-2 text-sm text-slate-200">
                        Approve, pay and review withdrawals.
                    </p>
                </a>

                <a href="{{ route('admin.plans.index') }}"
   class="rounded-xl bg-slate-950/60 border border-slate-800 p-4 hover:border-sky-500/70 transition">
    <p class="text-[11px] text-slate-400 uppercase tracking-[0.16em]">
        Plans &amp; ROI
    </p>
    <p class="mt-2 text-sm text-slate-200">
        Edit plan names, minimum deposits and ROI percentages.
    </p>
</a>

                <a href="{{ url('/admin/users') }}"
                   class="rounded-xl bg-slate-950/60 border border-slate-800 p-4 hover:border-sky-500/70 transition">
                    <p class="text-[11px] text-slate-400 uppercase tracking-[0.16em]">
                        Users
                    </p>
                    <p class="mt-2 text-sm text-slate-200">
                        View and manage user accounts.
                    </p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>