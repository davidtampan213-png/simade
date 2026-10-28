<x-adminlte-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">✏️ Edit Pembelajaran — {{ $dosen->nama }}</h1>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title mb-0">Formulir Pembelajaran</h2>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>Terdapat kesalahan input:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('dosen.pembelajaran.update', [$dosen->id, $pembelajaran->id]) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-12">
                        <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
                        <input id="nama_mk" class="form-control @error('nama_mk') is-invalid @enderror" type="text" name="nama_mk" value="{{ old('nama_mk', $pembelajaran->nama_mk) }}" required>
                        @error('nama_mk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="sks" class="form-label">SKS</label>
                        <input id="sks" class="form-control @error('sks') is-invalid @enderror" type="number" name="sks" value="{{ old('sks', $pembelajaran->sks) }}" min="1" max="6" required>
                        @error('sks')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="semester" class="form-label">Semester</label>
                        <select id="semester" name="semester" class="form-select @error('semester') is-invalid @enderror" required>
                            <option value="Ganjil" {{ old('semester', $pembelajaran->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="Genap" {{ old('semester', $pembelajaran->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                        @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                        <input id="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror" type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $pembelajaran->tahun_ajaran) }}" placeholder="Contoh: 2024/2025" required>
                        @error('tahun_ajaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input id="kelas" class="form-control @error('kelas') is-invalid @enderror" type="text" name="kelas" value="{{ old('kelas', $pembelajaran->kelas) }}" placeholder="Contoh: A, TI-3A" required>
                        @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('dosen.pembelajaran.index', $dosen->id) }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-adminlte-layout>
