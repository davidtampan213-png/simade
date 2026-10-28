<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-800 leading-tight">
            {{ __('Tambah Data Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('dosen.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <!-- NIP -->
                            <div class="mb-4">
                                <label for="nip" class="block font-medium text-sm text-gray-700">NIP</label>
                                <input id="nip" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" type="text" name="nip" value="{{ old('nip') }}" required autofocus />
                            </div>

                            <!-- Nama -->
                            <div class="mb-4">
                                <label for="nama" class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
                                <input id="nama" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" type="text" name="nama" value="{{ old('nama') }}" required />
                            </div>

                            <!-- Jabatan -->
                            <div class="mb-4">
                                <label for="jabatan" class="block font-medium text-sm text-gray-700">Jabatan</label>
                                <select id="jabatan" name="jabatan" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach(['Rektor','Dekan','Kepala Prodi','Guru Besar','Lektor Kepala','Lektor','Asisten Ahli'] as $jab)
                                        <option value="{{ $jab }}" {{ old('jabatan') == $jab ? 'selected' : '' }}>{{ $jab }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Prodi -->
                            <div class="mb-4">
                                <label for="prodi" class="block font-medium text-sm text-gray-700">Program Studi</label>
                                <input id="prodi" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" type="text" name="prodi" value="{{ old('prodi') }}" placeholder="Contoh: S1 Teknik Informatika" />
                            </div>

                            <!-- Jurusan -->
                            <div class="mb-4">
                                <label for="jurusan" class="block font-medium text-sm text-gray-700">Jurusan</label>
                                <select id="jurusan" name="jurusan" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" required>
                                    <option value="">Pilih Jurusan</option>
                                    @foreach(['Teknik Informatika','Teknik Mesin','Manajemen Informatika','Arsitek','Teknik Sipil'] as $jur)
                                        <option value="{{ $jur }}" {{ old('jurusan') == $jur ? 'selected' : '' }}>{{ $jur }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                                <select id="status" name="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" required>
                                    <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>

                            <!-- No HP -->
                            <div class="mb-4">
                                <label for="no_hp" class="block font-medium text-sm text-gray-700">No HP</label>
                                <input id="no_hp" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" type="text" name="no_hp" value="{{ old('no_hp') }}" />
                            </div>

                            <!-- Alamat -->
                            <div class="mb-4 md:col-span-2">
                                <label for="alamat" class="block font-medium text-sm text-gray-700">Alamat</label>
                                <textarea id="alamat" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" name="alamat" rows="3">{{ old('alamat') }}</textarea>
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('dosen.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:border-emerald-900 focus:ring ring-emerald-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Simpan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
