<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <p class="text-xs font-bold uppercase tracking-[0.22em] text-red-500">Masuk</p>
        <h2 class="mt-2 text-3xl font-black text-slate-900">Selamat datang kembali</h2>
        <p class="mt-2 text-sm text-slate-500">Silakan masuk untuk melanjutkan belanja Anda.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="email" class="mt-1 block w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-red-400 focus:bg-white focus:ring-4 focus:ring-red-100" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="password" class="mt-1 block w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-red-400 focus:bg-white focus:ring-4 focus:ring-red-100"
                type="password"
                name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-3 pt-2">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-red-600 shadow-sm focus:ring-red-500" name="remember">
                <span class="ml-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-red-600 transition hover:text-red-700" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center rounded-2xl bg-gradient-to-r from-red-500 to-orange-400 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-red-200 transition hover:from-red-600 hover:to-orange-500">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="pt-2 text-center text-sm text-slate-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-bold text-red-600 transition hover:text-red-700">Daftar sekarang</a>
        </div>
    </form>
</x-guest-layout>
