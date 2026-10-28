<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('mahasiswa.index') }}" class="text-emerald-600 hover:text-emerald-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h2 class="font-semibold text-xl text-emerald-800 leading-tight">Detail Mahasiswa</h2>
            </div>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700 transition font-medium shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Kartu Identitas --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                {{-- Header kartu --}}
                <div class="bg-gradient-to-r from-emerald-700 to-emerald-600 px-6 py-6 flex items-center gap-5">
                    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-white text-2xl font-bold">
                        {{ mb_strtoupper(mb_substr($mahasiswa->nama, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-white text-xl font-bold">{{ $mahasiswa->nama }}</h3>
                        <p class="text-emerald-200 text-sm font-mono mt-0.5">{{ $mahasiswa->nim }}</p>
                        <div class="mt-2">
                            @if($mahasiswa->status == 'Aktif')
                                <span class="px-3 py-0.5 rounded-full text-xs font-bold bg-green-400 text-white">✓ Aktif</span>
                            @elseif($mahasiswa->status == 'Cuti')
                                <span class="px-3 py-0.5 rounded-full text-xs font-bold bg-yellow-400 text-white">⏸ Cuti</span>
                            @else
                                <span class="px-3 py-0.5 rounded-full text-xs font-bold bg-red-400 text-white">✕ Nonaktif</span>
                            @endif
                            @if($mahasiswa->status_beasiswa)
                                <span class="ml-2 px-3 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white">🎓 Beasiswa</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Informasi detail --}}
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
                    @php
                        $fields = [
                            ['label' => 'Jenis Kelamin',    'value' => $mahasiswa->jenis_kelamin_label],
                            ['label' => 'Fakultas',          'value' => $mahasiswa->fakultas ?? '-'],
                            ['label' => 'Program Studi',     'value' => $mahasiswa->program_studi ?? '-'],
                            ['label' => 'Jenjang',           'value' => $mahasiswa->jenjang ?? '-'],
                            ['label' => 'Semester',          'value' => $mahasiswa->semester ? 'Semester ' . $mahasiswa->semester : '-'],
                            ['label' => 'Tahun Akademik',    'value' => $mahasiswa->tahun_akademik ?? '-'],
                            ['label' => 'Jenis Kelas',       'value' => $mahasiswa->jenis_kelas],
                            ['label' => 'No HP',             'value' => $mahasiswa->no_hp ?? '-'],
                        ];
                    @endphp

                    @foreach($fields as $f)
                    <div class="border-b border-gray-100 pb-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">{{ $f['label'] }}</p>
                        <p class="text-sm font-medium text-gray-800">{{ $f['value'] }}</p>
                    </div>
                    @endforeach

                    <div class="sm:col-span-2 border-b border-gray-100 pb-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Alamat</p>
                        <p class="text-sm text-gray-800">{{ $mahasiswa->alamat ?? '-' }}</p>
                    </div>

                    <div class="sm:col-span-2 text-xs text-gray-400">
                        Ditambahkan: {{ $mahasiswa->created_at ? $mahasiswa->created_at->format('d M Y H:i') : '-' }} &bull;
                        Diperbarui: {{ $mahasiswa->updated_at ? $mahasiswa->updated_at->format('d M Y H:i') : '-' }}
                    </div>
                </div>
            </div>

            {{-- Riwayat Status --}}
            @if($riwayat->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-700">Riwayat Status per Semester</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        @foreach($riwayat as $r)
                        <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                            <div class="flex items-center gap-4">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center">
                                    <span class="text-xs font-bold text-emerald-700">{{ $r->semester }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Semester {{ $r->semester }}</p>
                                    <p class="text-xs text-gray-400">{{ $r->tahun_akademik }}</p>
                                </div>
                            </div>
                            @if($r->status == 'Aktif')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aktif</span>
                            @elseif($r->status == 'Cuti')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Cuti</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Nonaktif</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Tombol aksi --}}
            @if(Auth::user()->isAdmin())
            <div class="flex justify-end gap-3">
                <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}"
                   class="px-5 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition shadow-sm">
                    Edit Data
                </a>
                <form action="{{ route('mahasiswa.destroy', $mahasiswa->id) }}" method="POST"
                      onsubmit="return confirm('Hapus data {{ addslashes($mahasiswa->nama) }}? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition shadow-sm">
                        Hapus Data
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
