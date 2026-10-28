<x-guest-layout>

    {{-- Heading --}}
    <div class="mb-5">
        <h2 class="text-lg font-bold text-gray-800 leading-tight">Buat Akun Baru</h2>
        <p class="text-xs text-gray-500 mt-0.5">Isi data di bawah untuk mendaftar sebagai Dosen</p>
    </div>

    <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        {{-- Role: hidden, default dosen --}}
        <input type="hidden" name="role" value="dosen">

        {{-- Nama Lengkap --}}
        <div class="mb-4">
            <x-input-label for="name" value="Nama Lengkap" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1" />
            <x-text-input
                id="name"
                type="text"
                name="name"
                :value="old('name')"
                placeholder="Masukkan nama lengkap"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <x-input-label for="email" value="Email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1" />
            <x-text-input
                id="email"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="contoh@email.com"
                required
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <x-input-label for="password" value="Password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1" />
            <div class="relative">
                <x-text-input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Min. 8 karakter"
                    required
                    autocomplete="new-password"
                    class="pr-10"
                />
                <button
                    type="button"
                    onclick="togglePass('password', this)"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-emerald-600 transition-colors focus:outline-none"
                    tabindex="-1"
                    aria-label="Tampilkan password"
                >
                    <svg id="eyeOpen_password" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eyeClosed_password" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mb-5">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1" />
            <div class="relative">
                <x-text-input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    placeholder="Ulangi password Anda"
                    required
                    autocomplete="new-password"
                    class="pr-10"
                />
                <button
                    type="button"
                    onclick="togglePass('password_confirmation', this)"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-emerald-600 transition-colors focus:outline-none"
                    tabindex="-1"
                    aria-label="Tampilkan konfirmasi password"
                >
                    <svg id="eyeOpen_password_confirmation" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eyeClosed_password_confirmation" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        {{-- Tombol Daftar --}}
        <button
            type="submit"
            id="btn-register"
            class="w-full py-2.5 px-4 bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-700 hover:to-emerald-600 active:from-emerald-800 active:to-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 tracking-wide"
        >
            Daftar
        </button>

        {{-- Link ke Login --}}
        <p class="mt-4 text-center text-xs text-gray-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-800 font-semibold hover:underline transition-colors">
                Masuk di sini
            </a>
        </p>
    </form>

    <script>
        function togglePass(fieldId, btn) {
            const input     = document.getElementById(fieldId);
            const eyeOpen   = document.getElementById('eyeOpen_' + fieldId);
            const eyeClosed = document.getElementById('eyeClosed_' + fieldId);
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
                btn.setAttribute('aria-label', 'Sembunyikan password');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
                btn.setAttribute('aria-label', 'Tampilkan password');
            }
        }
    </script>

</x-guest-layout>
