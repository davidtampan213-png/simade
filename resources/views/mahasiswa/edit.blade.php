<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('mahasiswa.index') }}" class="text-emerald-600 hover:text-emerald-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-emerald-800 leading-tight">Edit Data Mahasiswa</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-emerald-700 px-6 py-4">
                    <h3 class="text-white font-semibold text-base">Edit: {{ $mahasiswa->nama }}</h3>
                    <p class="text-emerald-200 text-sm mt-0.5">NIM: {{ $mahasiswa->nim }}</p>
                </div>
                <div class="p-6 sm:p-8">

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                            <p class="text-sm font-semibold text-red-700 mb-2">Terdapat kesalahan input:</p>
                            <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('mahasiswa.update', $mahasiswa->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- SEKSI 1: Identitas Dasar --}}
                        <div class="border-b border-gray-100 pb-6">
                            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <span class="w-6 h-6 bg-emerald-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                Identitas Dasar
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">NIM <span class="text-red-500">*</span></label>
                                    <input id="nim" type="text" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-400 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm"/>
                                </div>
                                <div>
                                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input id="nama" type="text" name="nama" value="{{ old('nama', $mahasiswa->nama) }}" required
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-400 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm"/>
                                </div>
                                <div>
                                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" required
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-400 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
                                    <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp', $mahasiswa->no_hp) }}"
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-400 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm"/>
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                    <textarea id="alamat" name="alamat" rows="2"
                                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-400 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm">{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- SEKSI 2: Akademik --}}
                        <div class="border-b border-gray-100 pb-6">
                            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <span class="w-6 h-6 bg-emerald-600 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                Informasi Akademik
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-1">Fakultas <span class="text-red-500">*</span></label>
                                    <select id="fakultas" name="fakultas" required
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-400 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm"
                                            onchange="updateProdi(this.value)">
                                        <option value="">Pilih Fakultas</option>
                                        @foreach($daftarFakultas as $fak => $prodis)
                                            <option value="{{ $fak }}" {{ old('fakultas', $mahasiswa->fakultas) == $fak ? 'selected' : '' }}>{{ $fak }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="program_studi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi <span class="text-red-500">*</span></label>
                                    <select id="program_studi" name="program_studi" required
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-400 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm">
                                        <option value="">Pilih Prodi</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="jenjang" class="block text-sm font-medium text-gray-700 mb-1">Jenjang <span class="text-red-500">*</span></label>
                                    <select id="jenjang" name="jenjang" required
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-400 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm">
                                        @foreach(['D3','S1','S2','S3'] as $j)
                                            <option value="{{ $j }}" {{ old('jenjang', $mahasiswa->jenjang) == $j ? 'selected' : '' }}>{{ $j }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="jenis_kelas" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelas <span class="text-red-500">*</span></label>
                                    <select id="jenis_kelas" name="jenis_kelas" required
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-400 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm">
                                        <option value="Reguler"  {{ old('jenis_kelas', $mahasiswa->jenis_kelas) == 'Reguler'  ? 'selected' : '' }}>Reguler</option>
                                        <option value="Ekstensi" {{ old('jenis_kelas', $mahasiswa->jenis_kelas) == 'Ekstensi' ? 'selected' : '' }}>Ekstensi</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester <span class="text-red-500">*</span></label>
                                    <select id="semester" name="semester" required
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-400 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm">
                                        <option value="">Pilih Semester</option>
                                        @for($s = 1; $s <= 14; $s++)
                                            <option value="{{ $s }}" {{ old('semester', $mahasiswa->semester) == $s ? 'selected' : '' }}>Semester {{ $s }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <label for="tahun_akademik" class="block text-sm font-medium text-gray-700 mb-1">Tahun Akademik <span class="text-red-500">*</span></label>
                                    <input id="tahun_akademik" type="text" name="tahun_akademik"
                                           value="{{ old('tahun_akademik', $mahasiswa->tahun_akademik) }}"
                                           placeholder="contoh: 2025/2026" required
                                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-400 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm"/>
                                </div>
                            </div>
                        </div>

                        {{-- SEKSI 3: Status --}}
                        <div>
                            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <span class="w-6 h-6 bg-emerald-600 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                Status
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Mahasiswa <span class="text-red-500">*</span></label>
                                    <select id="status" name="status" required
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-400 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm">
                                        <option value="Aktif"    {{ old('status', $mahasiswa->status) == 'Aktif'    ? 'selected' : '' }}>Aktif</option>
                                        <option value="Nonaktif" {{ old('status', $mahasiswa->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        <option value="Cuti"     {{ old('status', $mahasiswa->status) == 'Cuti'     ? 'selected' : '' }}>Cuti</option>
                                    </select>
                                </div>
                                <div class="flex items-center mt-5">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input id="status_beasiswa" type="checkbox" name="status_beasiswa" value="1"
                                               class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-400"
                                               {{ old('status_beasiswa', $mahasiswa->status_beasiswa) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Penerima Beasiswa</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('mahasiswa.show', $mahasiswa->id) }}"
                               class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 text-sm font-semibold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition shadow-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    const daftarFakultas = @json($daftarFakultas);
    const savedProdi = "{{ old('program_studi', $mahasiswa->program_studi) }}";

    function updateProdi(fakultas) {
        const sel = document.getElementById('program_studi');
        sel.innerHTML = '<option value="">Pilih Prodi</option>';
        const list = daftarFakultas[fakultas] ?? [];
        list.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p;
            opt.textContent = p;
            if (p === savedProdi) opt.selected = true;
            sel.appendChild(opt);
        });
    }

    // Init: jika tidak ada di list, tambahkan opsi manual
    function initProdi() {
        const savedFak = "{{ old('fakultas', $mahasiswa->fakultas) }}";
        updateProdi(savedFak);
        // Jika prodi tidak ada di daftar (data lama), tambahkan manual
        const sel = document.getElementById('program_studi');
        const exists = Array.from(sel.options).some(o => o.value === savedProdi);
        if (!exists && savedProdi) {
            const opt = document.createElement('option');
            opt.value = savedProdi;
            opt.textContent = savedProdi + ' (data lama)';
            opt.selected = true;
            sel.appendChild(opt);
        }
    }
    initProdi();
    </script>
</x-app-layout>
