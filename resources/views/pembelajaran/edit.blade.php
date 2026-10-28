<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-800 leading-tight">
            ✏️ Edit Pembelajaran — {{ $dosen->nama }}
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

                    <form method="POST" action="{{ route('dosen.pembelajaran.update', [$dosen->id, $pembelajaran->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div class="mb-4 md:col-span-2">
                                <label for="nama_mk" class="block font-medium text-sm text-gray-700">Nama Mata Kuliah</label>
                                <input id="nama_mk" type="text" name="nama_mk" value="{{ old('nama_mk', $pembelajaran->nama_mk) }}" required
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
                            </div>

                            <div class="mb-4">
                                <label for="sks" class="block font-medium text-sm text-gray-700">SKS</label>
                                <input id="sks" type="number" name="sks" value="{{ old('sks', $pembelajaran->sks) }}" min="1" max="6" required
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
                            </div>

                            <div class="mb-4">
                                <label for="semester" class="block font-medium text-sm text-gray-700">Semester</label>
                                <select id="semester" name="semester" required
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                                    <option value="Ganjil" {{ old('semester', $pembelajaran->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ old('semester', $pembelajaran->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="tahun_ajaran" class="block font-medium text-sm text-gray-700">Tahun Ajaran</label>
                                <input id="tahun_ajaran" type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $pembelajaran->tahun_ajaran) }}" placeholder="Contoh: 2024/2025" required
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
                            </div>

                            <div class="mb-4">
                                <label for="kelas" class="block font-medium text-sm text-gray-700">Kelas</label>
                                <input id="kelas" type="text" name="kelas" value="{{ old('kelas', $pembelajaran->kelas) }}" placeholder="Contoh: A, TI-3A" required
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" />
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-4 gap-3">
                            <a href="{{ route('dosen.pembelajaran.index', $dosen->id) }}" class="underline text-sm text-gray-600 hover:text-gray-900">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition">Simpan Perubahan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
