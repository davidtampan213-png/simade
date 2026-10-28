<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-800 leading-tight">
            ✏️ Edit Kinerja — {{ $dosen->nama }}
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

                    <form method="POST" action="{{ route('dosen.kinerja.update', [$dosen->id, $kinerja->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="periode" class="block font-medium text-sm text-gray-700">Periode</label>
                            <input id="periode" type="text" name="periode" value="{{ old('periode', $kinerja->periode) }}" placeholder="Contoh: Ganjil 2024/2025" required
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
                        </div>

                        <div class="mb-4">
                            <label for="kategori" class="block font-medium text-sm text-gray-700">Kategori Kinerja</label>
                            <select id="kategori" name="kategori" required
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                                @foreach(['Sangat Baik','Baik','Cukup','Kurang'] as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori', $kinerja->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="catatan" class="block font-medium text-sm text-gray-700">Catatan <span class="text-gray-400">(opsional)</span></label>
                            <textarea id="catatan" name="catatan" rows="4"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">{{ old('catatan', $kinerja->catatan) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4 gap-3">
                            <a href="{{ route('dosen.kinerja.index', $dosen->id) }}" class="underline text-sm text-gray-600 hover:text-gray-900">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition">Simpan Perubahan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
