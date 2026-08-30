<x-guest-layout>
    <div class="mb-6">
        <p class="text-xs font-bold uppercase tracking-[0.22em] text-red-500">Daftar</p>
        <h2 class="mt-2 text-3xl font-black text-slate-900">Buat akun baru</h2>
        <p class="mt-2 text-sm text-slate-500">Daftar sekarang untuk menikmati promo dan pengalaman belanja yang lebih lancar.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="name" class="mt-1 block w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-red-400 focus:bg-white focus:ring-4 focus:ring-red-100" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="email" class="mt-1 block w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-red-400 focus:bg-white focus:ring-4 focus:ring-red-100" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="password" class="mt-1 block w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-red-400 focus:bg-white focus:ring-4 focus:ring-red-100"
                type="password"
                name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="password_confirmation" class="mt-1 block w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-red-400 focus:bg-white focus:ring-4 focus:ring-red-100"
                type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center rounded-2xl bg-gradient-to-r from-red-500 to-orange-400 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-red-200 transition hover:from-red-600 hover:to-orange-500">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <div class="pt-2 text-center text-sm text-slate-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-bold text-red-600 transition hover:text-red-700">Masuk sekarang</a>
        </div>
    </form>
</x-guest-layout>
