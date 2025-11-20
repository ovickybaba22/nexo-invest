<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md px-6">
            <div class="flex flex-col items-center mb-8">
                <img src="{{ asset('img/logo_white.png') }}" alt="Nexo Invest" class="h-9 w-auto mb-3">
                <p class="text-[11px] uppercase tracking-[0.22em] text-slate-400">
                    Reset access
                </p>
            </div>

            <div class="rounded-2xl border border-white/5 bg-[#050814] px-6 py-6 shadow-[0_22px_70px_rgba(0,0,0,0.95)]">
                <h1 class="text-lg font-semibold text-white mb-1">
                    Forgot your password?
                </h1>
                <p class="text-[11px] text-slate-400 mb-5">
                    Enter your email and we’ll send a secure reset link. You’ll be back in the dashboard in minutes.
                </p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-slate-300 text-xs" />
                        <x-text-input id="email"
                                      class="block mt-1 w-full bg-slate-950/50 border-slate-700 text-slate-100"
                                      type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('login') }}" class="text-[11px] text-slate-400 hover:text-cyan-300">
                            Back to sign in
                        </a>
                        <x-primary-button class="bg-cyan-400 hover:bg-cyan-300 border-0 text-slate-900 px-4 py-2 text-xs font-semibold">
                            {{ __('Email password reset link') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
