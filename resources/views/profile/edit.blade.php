<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 sm:p-8 bg-[#050814]/95 border border-slate-800/80 shadow-[0_16px_55px_rgba(0,0,0,0.9)] sm:rounded-2xl">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="p-6 sm:p-8 bg-[#050814]/95 border border-slate-800/80 shadow-[0_16px_55px_rgba(0,0,0,0.9)] sm:rounded-2xl">
                @include('profile.partials.update-password-form')
            </div>

            <div class="p-6 sm:p-8 bg-[#050814]/95 border border-slate-800/80 shadow-[0_16px_55px_rgba(0,0,0,0.9)] sm:rounded-2xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>