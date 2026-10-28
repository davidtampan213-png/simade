<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-800 leading-tight">
            ➕ Tambah Penelitian — {{ $dosen->nama }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">

                    @if ($errors->any())
                        <div class="mb-4"><ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul></div>
                    @endif

                    <form method="POST" action="{{ route('dosen.penelitian.store', $dosen->id) }}">
                        @csrf

                        <div class="mb-4">
                            <label for="judul" class="block font-medium text-sm text-gray-700">Judul Penelitian</label>
                            <input id="judul" type="text" name="judul" value="{{ old('judul') }}" required
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
                        </div>

                        <div class="mb-4">
                            <label for="tahun" class="block font-medium text-sm text-gray-700">Tahun</label>
                            <input id="tahun" type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" min="1990" max="{{ date('Y') + 1 }}" required
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
                        </div>

                        <div class="mb-4">
                            <label for="sumber_dana" class="block font-medium text-sm text-gray-700">Sumber Dana <span class="text-gray-400">(opsional)</span></label>
                            <input id="sumber_dana" type="text" name="sumber_dana" value="{{ old('sumber_dana') }}" placeholder="Contoh: DIKTI, Mandiri, Hibah Universitas"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
                        </div>

                        <div class="flex items-center justify-end mt-4 gap-3">
                            <a href="{{ route('dosen.penelitian.index', $dosen->id) }}" class="underline text-sm text-gray-600 hover:text-gray-900">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
