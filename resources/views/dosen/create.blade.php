<x-adminlte-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Tambah Data Dosen</h1>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title mb-0">Formulir Data Dosen</h2>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>Terdapat kesalahan input:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('dosen.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="nip" class="form-label">NIP</label>
                        <input id="nip" class="form-control @error('nip') is-invalid @enderror" type="text" name="nip" value="{{ old('nip') }}" required autofocus>
                        @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input id="nama" class="form-control @error('nama') is-invalid @enderror" type="text" name="nama" value="{{ old('nama') }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <select id="jabatan" name="jabatan" class="form-select @error('jabatan') is-invalid @enderror">
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach(['Rektor','Dekan','Kepala Prodi','Guru Besar','Lektor Kepala','Lektor','Asisten Ahli'] as $jab)
                                <option value="{{ $jab }}" {{ old('jabatan') == $jab ? 'selected' : '' }}>{{ $jab }}</option>
                            @endforeach
                        </select>
                        @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <input id="prodi" class="form-control @error('prodi') is-invalid @enderror" type="text" name="prodi" value="{{ old('prodi') }}" placeholder="Contoh: S1 Teknik Informatika">
                        @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <select id="jurusan" name="jurusan" class="form-select @error('jurusan') is-invalid @enderror" required>
                            <option value="">Pilih Jurusan</option>
                            @foreach(['Teknik Informatika','Teknik Mesin','Manajemen Informatika','Arsitek','Teknik Sipil'] as $jur)
                                <option value="{{ $jur }}" {{ old('jurusan') == $jur ? 'selected' : '' }}>{{ $jur }}</option>
                            @endforeach
                        </select>
                        @error('jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" type="text" name="no_hp" value="{{ old('no_hp') }}">
                        @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="3">{{ old('alamat') }}</textarea>
                        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('dosen.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-adminlte-layout>
