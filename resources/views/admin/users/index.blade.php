<x-app-layout>
    <div class="py-8 max-w-5xl mx-auto px-4 space-y-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-50">Users</h1>
            <p class="mt-1 text-sm text-slate-400">
                View and manage user accounts.
            </p>
        </div>

        <div class="rounded-xl bg-slate-950/60 border border-slate-800 overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-900/70 text-slate-400 text-xs uppercase tracking-[0.16em]">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-center">Admin</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach ($users as $user)
                        <tr class="hover:bg-slate-900/40">
                            <td class="px-4 py-3 text-slate-400">{{ $user->id }}</td>
                            <td class="px-4 py-3 text-slate-100">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-slate-300">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-center">
                                @if ($user->is_admin ?? false)
                                    <span class="inline-flex items-center rounded-full bg-emerald-500/15 px-2.5 py-0.5 text-[11px] font-medium text-emerald-300">Admin</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-slate-500/15 px-2.5 py-0.5 text-[11px] font-medium text-slate-300">User</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="text-xs font-medium text-sky-300 hover:text-sky-200">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>