<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#020617]">
        <div class="w-full max-w-md px-6">
            <div class="flex flex-col items-center mb-8">
                <img src="{{ asset('img/logo_white.png') }}" alt="Nexo Invest" class="h-9 w-auto mb-3">
                <p class="text-[11px] uppercase tracking-[0.22em] text-slate-400">
                    Nexo Invest
                </p>
            </div>

            <div class="bg-[#050814] border border-white/5
                        shadow-[0_22px_70px_rgba(0,0,0,0.95)] rounded-2xl px-6 py-6">
                <h1 class="text-lg font-semibold text-slate-50 mb-1">
                    Sign in to your dashboard
                </h1>
                <p class="text-[11px] text-slate-400 mb-5">
                    Secure access to your portfolio, plans and payouts.
                </p>

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-slate-300 text-xs" />
                        <x-text-input id="email"
                                      class="block mt-1 w-full bg-slate-950/50 border-slate-700 text-slate-100"
                                      type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-slate-300 text-xs" />
                        <x-text-input id="password"
                                      class="block mt-1 w-full bg-slate-950/50 border-slate-700 text-slate-100"
                                      type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Remember me --}}
                    <div class="flex items-center justify-between mt-1">
                        <label class="flex items-center gap-2 text-[11px] text-slate-400">
                            <input id="remember_me" type="checkbox" class="rounded border-slate-700 bg-slate-900 text-cyan-400 focus:ring-cyan-400" name="remember">
                            <span>{{ __('Keep me signed in') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-[11px] text-slate-400 hover:text-cyan-300"
                               href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-5 flex items-center justify-between">
                        <a href="{{ route('register') }}"
                           class="text-[11px] text-slate-400 hover:text-cyan-300">
                            {{ __('New here? Create an account') }}
                        </a>

                        <x-primary-button
                            class="bg-cyan-400 hover:bg-cyan-300 border-0 text-slate-950 px-5 py-2 text-xs font-semibold">
                            {{ __('Sign in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
