<x-adminlte-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">➕ Tambah Kinerja — {{ $dosen->nama }}</h1>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title mb-0">Formulir Kinerja</h2>
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

            <form method="POST" action="{{ route('dosen.kinerja.store', $dosen->id) }}">
                @csrf

                <div class="mb-3">
                    <label for="periode" class="form-label">Periode</label>
                    <input id="periode" class="form-control @error('periode') is-invalid @enderror" type="text" name="periode" value="{{ old('periode') }}" placeholder="Contoh: Ganjil 2024/2025" required>
                    @error('periode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori Kinerja</label>
                    <select id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(['Sangat Baik','Baik','Cukup','Kurang'] as $kat)
                            <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                    @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan <span class="text-body-secondary">(opsional)</span></label>
                    <textarea id="catatan" class="form-control @error('catatan') is-invalid @enderror" name="catatan" rows="4">{{ old('catatan') }}</textarea>
                    @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('dosen.kinerja.index', $dosen->id) }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-adminlte-layout>
