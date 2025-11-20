<x-app-layout>
    <div class="py-8 max-w-5xl mx-auto px-4 space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-slate-50">Plans &amp; ROI</h1>
                <p class="mt-1 text-sm text-slate-400">
                    Edit plan names, minimum deposits and ROI percentages.
                </p>
            </div>

            <a href="{{ route('admin.plans.create') }}"
               class="inline-flex items-center rounded-lg bg-sky-500 px-4 py-2 text-sm font-medium text-slate-950 hover:bg-sky-400">
                Add plan
            </a>
        </div>

        <div class="rounded-xl bg-slate-950/60 border border-slate-800 overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-900/70 text-slate-400 text-xs uppercase tracking-[0.16em]">
                    <tr>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-right">Min deposit</th>
                        <th class="px-4 py-3 text-right">Target ROI %</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach ($plans as $plan)
                        <tr class="hover:bg-slate-900/40">
                            <td class="px-4 py-3 text-slate-100">
                                {{ $plan->name }}
                            </td>
                            <td class="px-4 py-3 text-right text-slate-100">
                                ${{ number_format($plan->min_deposit, 2) }}
                            </td>
                            <td class="px-4 py-3 text-right text-slate-100">
                                {{ number_format($plan->target_roi_percent, 2) }}%
                            </td>
                            <td class="px-4 py-3 text-right">
                                {{-- IMPORTANT: this is the new route, do NOT hard-code /admin/plans/... --}}
                                <a href="{{ route('admin.plans.edit', $plan) }}"
                                   class="text-xs font-medium text-sky-300 hover:text-sky-200">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>