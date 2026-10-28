<x-adminlte-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary btn-sm" title="Kembali">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 mb-0">Tambah Data Mahasiswa</h1>
                <small class="text-body-secondary">Formulir pendaftaran dan pencatatan mahasiswa baru</small>
            </div>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="bi bi-person-plus me-2"></i>Formulir Data Mahasiswa Baru
                    </h5>
                    <small class="text-white-50">Isi semua field yang bertanda bintang (*) dengan data yang valid</small>
                </div>
                <div class="card-body p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-exclamation-octagon-fill fs-5"></i>
                                <strong class="fs-6">Terdapat kesalahan pengisian data:</strong>
                            </div>
                            <ul class="mb-0 ps-3 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('mahasiswa.store') }}" novalidate>
                        @csrf

                        {{-- SEKSI 1: Identitas Dasar --}}
                        <div class="mb-4 pb-3 border-bottom">
                            <h6 class="fw-bold text-success text-uppercase mb-3 d-flex align-items-center gap-2">
                                <span class="badge text-bg-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">1</span>
                                Identitas Dasar
                            </h6>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="nim" class="form-label small fw-semibold">NIM <span class="text-danger">*</span></label>
                                    <input id="nim" type="text" name="nim" value="{{ old('nim') }}" required autofocus
                                           class="form-control form-control-sm @error('nim') is-invalid @enderror"
                                           placeholder="Contoh: 2021150001"/>
                                    @error('nim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="nama" class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required
                                           class="form-control form-control-sm @error('nama') is-invalid @enderror"
                                           placeholder="Masukkan nama lengkap"/>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="jenis_kelamin" class="form-label small fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" required
                                            class="form-select form-select-sm @error('jenis_kelamin') is-invalid @enderror">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="no_hp" class="form-label small fw-semibold">No HP</label>
                                    <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}"
                                           class="form-control form-control-sm @error('no_hp') is-invalid @enderror"
                                           placeholder="Contoh: 08123456789"/>
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="alamat" class="form-label small fw-semibold">Alamat</label>
                                    <textarea id="alamat" name="alamat" rows="2"
                                              class="form-control form-control-sm @error('alamat') is-invalid @enderror"
                                              placeholder="Alamat lengkap tempat tinggal">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- SEKSI 2: Akademik --}}
                        <div class="mb-4 pb-3 border-bottom">
                            <h6 class="fw-bold text-success text-uppercase mb-3 d-flex align-items-center gap-2">
                                <span class="badge text-bg-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">2</span>
                                Informasi Akademik
                            </h6>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="fakultas" class="form-label small fw-semibold">Fakultas <span class="text-danger">*</span></label>
                                    <select id="fakultas" name="fakultas" required
                                            class="form-select form-select-sm @error('fakultas') is-invalid @enderror"
                                            onchange="updateProdi(this.value)">
                                        <option value="">Pilih Fakultas</option>
                                        @foreach($daftarFakultas as $fak => $prodis)
                                            <option value="{{ $fak }}" {{ old('fakultas') == $fak ? 'selected' : '' }}>{{ $fak }}</option>
                                        @endforeach
                                    </select>
                                    @error('fakultas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="program_studi" class="form-label small fw-semibold">Program Studi <span class="text-danger">*</span></label>
                                    <select id="program_studi" name="program_studi" required
                                            class="form-select form-select-sm @error('program_studi') is-invalid @enderror">
                                        <option value="">Pilih Prodi</option>
                                    </select>
                                    @error('program_studi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="jenjang" class="form-label small fw-semibold">Jenjang <span class="text-danger">*</span></label>
                                    <select id="jenjang" name="jenjang" required
                                            class="form-select form-select-sm @error('jenjang') is-invalid @enderror">
                                        @foreach(['D3','S1','S2','S3'] as $j)
                                            <option value="{{ $j }}" {{ old('jenjang', 'S1') == $j ? 'selected' : '' }}>{{ $j }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenjang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="jenis_kelas" class="form-label small fw-semibold">Jenis Kelas <span class="text-danger">*</span></label>
                                    <select id="jenis_kelas" name="jenis_kelas" required
                                            class="form-select form-select-sm @error('jenis_kelas') is-invalid @enderror">
                                        <option value="Reguler" {{ old('jenis_kelas') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                                        <option value="Ekstensi" {{ old('jenis_kelas') == 'Ekstensi' ? 'selected' : '' }}>Ekstensi</option>
                                    </select>
                                    @error('jenis_kelas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="semester" class="form-label small fw-semibold">Semester <span class="text-danger">*</span></label>
                                    <select id="semester" name="semester" required
                                            class="form-select form-select-sm @error('semester') is-invalid @enderror">
                                        <option value="">Pilih Semester</option>
                                        @for($s = 1; $s <= 14; $s++)
                                            <option value="{{ $s }}" {{ old('semester') == $s ? 'selected' : '' }}>Semester {{ $s }}</option>
                                        @endfor
                                    </select>
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="tahun_akademik" class="form-label small fw-semibold">Tahun Akademik <span class="text-danger">*</span></label>
                                    <input id="tahun_akademik" type="text" name="tahun_akademik"
                                           value="{{ old('tahun_akademik', $tahunAkademikSekarang) }}"
                                           placeholder="contoh: 2025/2026" required
                                           class="form-control form-control-sm @error('tahun_akademik') is-invalid @enderror"/>
                                    @error('tahun_akademik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- SEKSI 3: Status --}}
                        <div class="mb-4">
                            <h6 class="fw-bold text-success text-uppercase mb-3 d-flex align-items-center gap-2">
                                <span class="badge text-bg-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">3</span>
                                Status Mahasiswa
                            </h6>
                            <div class="row g-3 align-items-center">
                                <div class="col-12 col-md-6">
                                    <label for="status" class="form-label small fw-semibold">Status Keaktifan <span class="text-danger">*</span></label>
                                    <select id="status" name="status" required
                                            class="form-select form-select-sm @error('status') is-invalid @enderror">
                                        <option value="Aktif"    {{ old('status', 'Aktif') == 'Aktif'    ? 'selected' : '' }}>Aktif</option>
                                        <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        <option value="Cuti"     {{ old('status') == 'Cuti'     ? 'selected' : '' }}>Cuti</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-check mt-md-4 pt-md-2">
                                        <input id="status_beasiswa" type="checkbox" name="status_beasiswa" value="1"
                                               class="form-check-input"
                                               {{ old('status_beasiswa') ? 'checked' : '' }}>
                                        <label for="status_beasiswa" class="form-check-label small fw-semibold">
                                            Penerima Beasiswa
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary btn-sm px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success btn-sm px-4">
                                <i class="bi bi-save me-1"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    const daftarFakultas = @json($daftarFakultas);
    const savedProdi = "{{ old('program_studi') }}";

    function updateProdi(fakultas) {
        const sel = document.getElementById('program_studi');
        sel.innerHTML = '<option value="">Pilih Prodi</option>';
        if (daftarFakultas[fakultas]) {
            daftarFakultas[fakultas].forEach(p => {
                const opt = document.createElement('option');
                opt.value = p;
                opt.textContent = p;
                if (p === savedProdi) opt.selected = true;
                sel.appendChild(opt);
            });
        }
    }

    // Init
    const savedFak = "{{ old('fakultas') }}";
    if (savedFak) updateProdi(savedFak);
    </script>
</x-adminlte-layout>
