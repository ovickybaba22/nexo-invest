<x-app-layout>
    <div class="py-8 max-w-lg mx-auto px-4 space-y-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-50">Edit user</h1>
            <p class="mt-1 text-sm text-slate-400">
                Update user details and admin status.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
            @csrf

            <div class="space-y-1 text-sm">
                <label class="block text-slate-300" for="name">Name</label>
                <input id="name" name="name" type="text"
                       value="{{ old('name', $user->name) }}"
                       class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-3 py-2 text-slate-50 text-sm focus:border-sky-500 focus:outline-none" required>
            </div>

            <div class="space-y-1 text-sm">
                <label class="block text-slate-300" for="email">Email</label>
                <input id="email" name="email" type="email"
                       value="{{ old('email', $user->email) }}"
                       class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-3 py-2 text-slate-50 text-sm focus:border-sky-500 focus:outline-none" required>
            </div>

            <div class="flex items-center gap-2 text-sm">
                <input id="is_admin" name="is_admin" type="checkbox" value="1"
                       {{ old('is_admin', $user->is_admin ?? false) ? 'checked' : '' }}
                       class="h-4 w-4 rounded border-slate-700 bg-slate-900 text-sky-500 focus:ring-sky-500">
                <label for="is_admin" class="text-slate-300">Admin</label>
            </div>

            <div class="pt-2 flex items-center justify-between gap-4">
                <a href="{{ route('admin.users.index') }}"
                   class="text-sm text-slate-400 hover:text-slate-200">Cancel</a>
                <button type="submit"
                        class="inline-flex items-center rounded-lg bg-sky-500 px-4 py-2 text-sm font-medium text-slate-950 hover:bg-sky-400">
                    Save changes
                </button>
            </div>
        </form>
    </div>
</x-app-layout>