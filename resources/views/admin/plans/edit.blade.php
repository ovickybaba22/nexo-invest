<x-app-layout>
    <div class="py-8 max-w-lg mx-auto px-4 space-y-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-50">Edit plan</h1>
            <p class="mt-1 text-sm text-slate-400">
                Update name, minimum deposit and ROI.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.plans.update', $plan) }}" class="space-y-4">
            @csrf

            <div class="space-y-1 text-sm">
                <label class="block text-slate-300" for="name">Name</label>
                <input id="name" name="name" type="text"
                       value="{{ old('name', $plan->name) }}"
                       class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-3 py-2 text-slate-50 text-sm focus:border-sky-500 focus:outline-none" required>
            </div>

            <div class="space-y-1 text-sm">
                <label class="block text-slate-300" for="min_deposit">Minimum deposit ($)</label>
                <input id="min_deposit" name="min_deposit" type="number" step="0.01"
                       value="{{ old('min_deposit', $plan->min_deposit) }}"
                       class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-3 py-2 text-slate-50 text-sm focus:border-sky-500 focus:outline-none" required>
            </div>

            <div class="space-y-1 text-sm">
                <label class="block text-slate-300" for="target_roi_percent">Target ROI (%)</label>
                <input id="target_roi_percent" name="target_roi_percent" type="number" step="0.01"
                       value="{{ old('target_roi_percent', $plan->target_roi_percent) }}"
                       class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-3 py-2 text-slate-50 text-sm focus:border-sky-500 focus:outline-none" required>
            </div>

            <div class="pt-2 flex items-center justify-between gap-4">
                <a href="{{ route('admin.plans.index') }}"
                   class="text-sm text-slate-400 hover:text-slate-200">Cancel</a>
                <button type="submit"
                        class="inline-flex items-center rounded-lg bg-sky-500 px-4 py-2 text-sm font-medium text-slate-950 hover:bg-sky-400">
                    Save changes
                </button>
            </div>
        </form>
    </div>
</x-app-layout>