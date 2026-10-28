<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="font-semibold text-xl text-emerald-800 leading-tight">Data Mahasiswa</h2>
            <div class="flex flex-wrap gap-2">
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('mahasiswa.create') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700 transition font-medium shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Mahasiswa
                    </a>
                @endif
                <a href="{{ route('mahasiswa.export', array_merge(request()->query(), ['format'=>'excel'])) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-teal-600 text-white text-sm rounded-lg hover:bg-teal-700 transition font-medium shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Excel
                </a>
                <a href="{{ route('mahasiswa.export', array_merge(request()->query(), ['format'=>'pdf'])) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-600 text-white text-sm rounded-lg hover:bg-rose-700 transition font-medium shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    PDF
                </a>
                <a href="{{ route('mahasiswa.laporan') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition font-medium shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Laporan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg mb-5" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                {{-- Filter Bar --}}
                <div class="bg-gray-50 border-b border-gray-200 p-5">
                    <form method="GET" action="{{ route('mahasiswa.index') }}" class="flex flex-wrap gap-3 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Cari NIM / Nama</label>
                            <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}"
                                   class="w-full rounded-lg border-gray-300 text-sm focus:ring-emerald-400 focus:border-emerald-400 shadow-sm"/>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Fakultas</label>
                            <select name="fakultas" class="rounded-lg border-gray-300 text-sm focus:ring-emerald-400 focus:border-emerald-400 shadow-sm"
                                    onchange="updateProdi(this.value)">
                                <option value="">Semua Fakultas</option>
                                @foreach(array_keys($daftarFakultas) as $fak)
                                    <option value="{{ $fak }}" {{ request('fakultas') == $fak ? 'selected' : '' }}>{{ $fak }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Program Studi</label>
                            <select name="program_studi" id="prodiSelect" class="rounded-lg border-gray-300 text-sm focus:ring-emerald-400 focus:border-emerald-400 shadow-sm">
                                <option value="">Semua Prodi</option>
                                @foreach($daftarProdi as $prodi)
                                    <option value="{{ $prodi }}" {{ request('program_studi') == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Jenjang</label>
                            <select name="jenjang" class="rounded-lg border-gray-300 text-sm focus:ring-emerald-400 focus:border-emerald-400 shadow-sm">
                                <option value="">Semua</option>
                                @foreach(['D3','S1','S2','S3'] as $j)
                                    <option value="{{ $j }}" {{ request('jenjang') == $j ? 'selected' : '' }}>{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Semester</label>
                            <select name="semester" class="rounded-lg border-gray-300 text-sm focus:ring-emerald-400 focus:border-emerald-400 shadow-sm">
                                <option value="">Semua</option>
                                @for($s=1; $s<=14; $s++)
                                    <option value="{{ $s }}" {{ request('semester') == $s ? 'selected' : '' }}>Sem {{ $s }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Status</label>
                            <select name="status" class="rounded-lg border-gray-300 text-sm focus:ring-emerald-400 focus:border-emerald-400 shadow-sm">
                                <option value="">Semua</option>
                                <option value="Aktif"    {{ request('status') == 'Aktif'    ? 'selected' : '' }}>Aktif</option>
                                <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                <option value="Cuti"     {{ request('status') == 'Cuti'     ? 'selected' : '' }}>Cuti</option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700 transition font-medium">
                                Filter
                            </button>
                            <a href="{{ route('mahasiswa.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300 transition font-medium">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                {{-- Info hasil filter --}}
                <div class="px-6 py-3 bg-white border-b border-gray-100 flex items-center justify-between text-sm text-gray-500">
                    <span>Menampilkan <strong class="text-gray-800">{{ $mahasiswas->total() }}</strong> mahasiswa</span>
                    @if(request()->hasAny(['search','status','fakultas','program_studi','jenjang','semester','jenis_kelamin']))
                        <a href="{{ route('mahasiswa.index') }}" class="text-red-500 hover:text-red-700 text-xs">✕ Hapus semua filter</a>
                    @endif
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-emerald-700 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">NIM</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">JK</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Fakultas</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Program Studi</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Jenjang</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Sem</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tahun Akademik</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($mahasiswas as $mhs)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm font-mono text-gray-700 whitespace-nowrap">{{ $mhs->nim }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $mhs->nama }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
                                    {{ $mhs->jenis_kelamin ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 max-w-[160px] truncate" title="{{ $mhs->fakultas }}">
                                    {{ $mhs->fakultas ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 max-w-[160px] truncate" title="{{ $mhs->program_studi }}">
                                    {{ $mhs->program_studi ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
                                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded font-medium text-xs">{{ $mhs->jenjang }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-center text-gray-600 whitespace-nowrap">{{ $mhs->semester ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">{{ $mhs->tahun_akademik ?? '-' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($mhs->status == 'Aktif')
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aktif</span>
                                    @elseif($mhs->status == 'Cuti')
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Cuti</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('mahasiswa.show', $mhs->id) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Detail
                                        </a>
                                        @if(Auth::user()->isAdmin())
                                        <a href="{{ route('mahasiswa.edit', $mhs->id) }}" class="text-emerald-600 hover:text-emerald-900" title="Edit">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('mahasiswa.destroy', $mhs->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Hapus data {{ addslashes($mhs->nama) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-6 py-16 text-center">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-gray-400 text-sm">Data tidak ditemukan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $mahasiswas->links() }}
                </div>
            </div>

        </div>
    </div>

    <script>
    // Filter prodi berdasarkan fakultas
    const daftarFakultas = @json($daftarFakultas);
    const allProdi = @json($daftarProdi);
    const currentProdi = "{{ request('program_studi') }}";

    function updateProdi(fakultas) {
        const sel = document.getElementById('prodiSelect');
        sel.innerHTML = '<option value="">Semua Prodi</option>';
        const list = fakultas ? (daftarFakultas[fakultas] ?? []) : allProdi;
        list.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p;
            opt.textContent = p;
            if (p === currentProdi) opt.selected = true;
            sel.appendChild(opt);
        });
    }

    // Init on load
    updateProdi("{{ request('fakultas') }}");
    </script>
</x-app-layout>
