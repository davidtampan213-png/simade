<x-adminlte-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">➕ Tambah Penelitian — {{ $dosen->nama }}</h1>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title mb-0">Formulir Penelitian</h2>
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

            <form method="POST" action="{{ route('dosen.penelitian.store', $dosen->id) }}">
                @csrf

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Penelitian</label>
                    <input id="judul" class="form-control @error('judul') is-invalid @enderror" type="text" name="judul" value="{{ old('judul') }}" required>
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <input id="tahun" class="form-control @error('tahun') is-invalid @enderror" type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" min="1990" max="{{ date('Y') + 1 }}" required>
                    @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="sumber_dana" class="form-label">Sumber Dana <span class="text-body-secondary">(opsional)</span></label>
                    <input id="sumber_dana" class="form-control @error('sumber_dana') is-invalid @enderror" type="text" name="sumber_dana" value="{{ old('sumber_dana') }}" placeholder="Contoh: DIKTI, Mandiri, Hibah Universitas">
                    @error('sumber_dana')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('dosen.penelitian.index', $dosen->id) }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-adminlte-layout>
