<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-extrabold text-emerald-800 tracking-tight">Pilih Akses Login Anda</h2>
        <p class="text-sm text-gray-500 mt-2">Silakan pilih role Anda untuk masuk ke sistem SIMADE.</p>
    </div>

    <!-- Error/Success Messages -->
    @if(session('error'))
        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif
    @if(session('success'))
        <div class="mb-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <!-- Card Mahasiswa -->
        <form method="POST" action="{{ route('pilih-role') }}" class="h-full">
            @csrf
            <input type="hidden" name="role" value="mahasiswa">
            <button type="submit" class="w-full h-full bg-white border-2 border-emerald-200 hover:border-emerald-500 rounded-xl p-6 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl group focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                <div class="flex flex-col items-center justify-center">
                    <div class="bg-emerald-100 p-4 rounded-full mb-4 group-hover:bg-emerald-500 transition-colors duration-300">
                        <svg class="w-10 h-10 text-emerald-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-emerald-700">Mahasiswa</h3>
                    <p class="text-xs text-gray-500 mt-2 text-center">Masuk ke dashboard akademik mahasiswa</p>
                </div>
            </button>
        </form>

        <!-- Card Dosen -->
        <form method="POST" action="{{ route('pilih-role') }}" class="h-full">
            @csrf
            <input type="hidden" name="role" value="dosen">
            <button type="submit" class="w-full h-full bg-white border-2 border-emerald-200 hover:border-emerald-500 rounded-xl p-6 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl group focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                <div class="flex flex-col items-center justify-center">
                    <div class="bg-blue-100 p-4 rounded-full mb-4 group-hover:bg-blue-500 transition-colors duration-300">
                        <svg class="w-10 h-10 text-blue-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-700">Dosen</h3>
                    <p class="text-xs text-gray-500 mt-2 text-center">Masuk ke dashboard pengajar & statistik</p>
                </div>
            </button>
        </form>
    </div>

    <!-- Optional Logout button if they want to cancel -->
    <div class="mt-8 text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-red-600 underline transition-colors">
                Batal & Logout
            </button>
        </form>
    </div>
</x-guest-layout>
