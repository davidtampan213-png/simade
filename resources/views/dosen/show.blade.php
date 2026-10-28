<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-800 leading-tight">
            {{ __('Detail Data Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ===================== IDENTITAS ===================== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-emerald-700 mb-4">🪪 Identitas Dosen</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">NIP</p>
                            <p class="text-gray-900 font-medium">{{ $dosen->nip }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Nama Lengkap</p>
                            <p class="text-gray-900 font-medium">{{ $dosen->nama }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Jabatan</p>
                            <p class="text-gray-900 font-medium">{{ $dosen->jabatan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Program Studi</p>
                            <p class="text-gray-900 font-medium">{{ $dosen->prodi ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Jurusan</p>
                            <p class="text-gray-900 font-medium">{{ $dosen->jurusan }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Status</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $dosen->status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $dosen->status }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">No HP</p>
                            <p class="text-gray-900 font-medium">{{ $dosen->no_hp ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs text-gray-500 font-semibold uppercase">Alamat</p>
                            <p class="text-gray-900 font-medium">{{ $dosen->alamat ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('dosen.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 transition">Kembali</a>
                        <a href="{{ route('dosen.edit', $dosen->id) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition">Edit Data</a>
                    </div>
                </div>
            </div>

            {{-- ===================== PENELITIAN ===================== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-emerald-700">🔬 Penelitian
                            <span class="ml-2 text-sm font-normal text-gray-500">(Total: {{ $dosen->penelitians->count() }})</span>
                        </h3>
                        <a href="{{ route('dosen.penelitian.create', $dosen->id) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition">+ Tambah</a>
                    </div>
                    @if($dosen->penelitians->isEmpty())
                        <p class="text-sm text-gray-400 italic">Belum ada data penelitian.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Sumber Dana</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($dosen->penelitians->sortByDesc('tahun') as $i => $p)
                                    <tr>
                                        <td class="px-4 py-2">{{ $i + 1 }}</td>
                                        <td class="px-4 py-2">{{ $p->judul }}</td>
                                        <td class="px-4 py-2">{{ $p->tahun }}</td>
                                        <td class="px-4 py-2">{{ $p->sumber_dana ?? '-' }}</td>
                                        <td class="px-4 py-2 flex gap-2">
                                            <a href="{{ route('dosen.penelitian.edit', [$dosen->id, $p->id]) }}" class="text-emerald-600 hover:text-emerald-900">Edit</a>
                                            <form action="{{ route('dosen.penelitian.destroy', [$dosen->id, $p->id]) }}" method="POST" onsubmit="return confirm('Hapus penelitian ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ===================== PEMBELAJARAN ===================== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-emerald-700">📚 Pembelajaran per Semester
                            <span class="ml-2 text-sm font-normal text-gray-500">(Total SKS: {{ $dosen->pembelajarans->sum('sks') }})</span>
                        </h3>
                        <a href="{{ route('dosen.pembelajaran.create', $dosen->id) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition">+ Tambah</a>
                    </div>
                    @if($dosen->pembelajarans->isEmpty())
                        <p class="text-sm text-gray-400 italic">Belum ada data pembelajaran.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mata Kuliah</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">SKS</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Semester</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tahun Ajaran</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($dosen->pembelajarans->sortByDesc('tahun_ajaran') as $i => $pb)
                                    <tr>
                                        <td class="px-4 py-2">{{ $i + 1 }}</td>
                                        <td class="px-4 py-2">{{ $pb->nama_mk }}</td>
                                        <td class="px-4 py-2">{{ $pb->sks }}</td>
                                        <td class="px-4 py-2">{{ $pb->semester }}</td>
                                        <td class="px-4 py-2">{{ $pb->tahun_ajaran }}</td>
                                        <td class="px-4 py-2">{{ $pb->kelas }}</td>
                                        <td class="px-4 py-2 flex gap-2">
                                            <a href="{{ route('dosen.pembelajaran.edit', [$dosen->id, $pb->id]) }}" class="text-emerald-600 hover:text-emerald-900">Edit</a>
                                            <form action="{{ route('dosen.pembelajaran.destroy', [$dosen->id, $pb->id]) }}" method="POST" onsubmit="return confirm('Hapus data pembelajaran ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ===================== KINERJA ===================== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-emerald-700">📊 Kinerja Dosen</h3>
                        <a href="{{ route('dosen.kinerja.create', $dosen->id) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition">+ Tambah</a>
                    </div>
                    @if($dosen->kinerjaDosens->isEmpty())
                        <p class="text-sm text-gray-400 italic">Belum ada data kinerja.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($dosen->kinerjaDosens->sortByDesc('created_at') as $i => $k)
                                    @php
                                        $badgeColor = match($k->kategori) {
                                            'Sangat Baik' => 'bg-green-100 text-green-800',
                                            'Baik'        => 'bg-blue-100 text-blue-800',
                                            'Cukup'       => 'bg-yellow-100 text-yellow-800',
                                            'Kurang'      => 'bg-red-100 text-red-800',
                                            default       => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-2">{{ $i + 1 }}</td>
                                        <td class="px-4 py-2">{{ $k->periode }}</td>
                                        <td class="px-4 py-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColor }}">
                                                {{ $k->kategori }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">{{ $k->catatan ?? '-' }}</td>
                                        <td class="px-4 py-2 flex gap-2">
                                            <a href="{{ route('dosen.kinerja.edit', [$dosen->id, $k->id]) }}" class="text-emerald-600 hover:text-emerald-900">Edit</a>
                                            <form action="{{ route('dosen.kinerja.destroy', [$dosen->id, $k->id]) }}" method="POST" onsubmit="return confirm('Hapus data kinerja ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
