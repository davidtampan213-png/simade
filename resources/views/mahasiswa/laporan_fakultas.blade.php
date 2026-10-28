<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('mahasiswa.laporan') }}" class="text-emerald-600 hover:text-emerald-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-emerald-800 leading-tight">{{ $fakultas }}</h2>
                    <p class="text-sm text-emerald-600">Laporan Detail Fakultas</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('mahasiswa.laporan.export', array_merge(request()->query(), ['format'=>'excel','fakultas'=>$fakultas])) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-2 bg-teal-600 text-white text-sm rounded-lg hover:bg-teal-700 transition font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                    Excel
                </a>
                <a href="{{ route('mahasiswa.laporan.export', array_merge(request()->query(), ['format'=>'pdf','fakultas'=>$fakultas])) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-2 bg-rose-600 text-white text-sm rounded-lg hover:bg-rose-700 transition font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Filter --}}
            <div class="bg-white rounded-2xl shadow-sm p-5">
                <form method="GET" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Tahun Akademik</label>
                        <select name="tahun_akademik" class="rounded-lg border-gray-300 text-sm focus:ring-emerald-400 focus:border-emerald-400 shadow-sm">
                            <option value="">Semua</option>
                            @foreach($tahunList as $ta)
                                <option value="{{ $ta }}" {{ $tahunAkademik == $ta ? 'selected' : '' }}>{{ $ta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Semester</label>
                        <select name="semester" class="rounded-lg border-gray-300 text-sm focus:ring-emerald-400 focus:border-emerald-400 shadow-sm">
                            <option value="">Semua</option>
                            @for($s=1; $s<=14; $s++)
                                <option value="{{ $s }}" {{ $semester == $s ? 'selected' : '' }}>Semester {{ $s }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Filter Prodi</label>
                        <select name="program_studi" class="rounded-lg border-gray-300 text-sm focus:ring-emerald-400 focus:border-emerald-400 shadow-sm">
                            <option value="">Semua Prodi</option>
                            @foreach($daftarProdi as $p)
                                <option value="{{ $p }}" {{ $prodiFilter == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700 transition font-medium">Terapkan</button>
                    <a href="{{ route('mahasiswa.laporan.fakultas', $fakultas) }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300 transition font-medium">Reset</a>
                </form>
            </div>

            {{-- Kartu Statistik Fakultas --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                @php $statCards = [
                    ['label'=>'Total','value'=>$totalAll,      'color'=>'emerald'],
                    ['label'=>'Aktif','value'=>$totalAktif,    'color'=>'green'],
                    ['label'=>'Nonaktif','value'=>$totalNonaktif,'color'=>'red'],
                    ['label'=>'Cuti','value'=>$totalCuti,      'color'=>'yellow'],
                ]; @endphp
                @foreach($statCards as $c)
                <div class="bg-white rounded-2xl shadow-sm p-5 border-t-4 border-{{ $c['color'] }}-500">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">{{ $c['label'] }}</p>
                    <h3 class="text-3xl font-extrabold text-{{ $c['color'] }}-600">{{ $c['value'] }}</h3>
                </div>
                @endforeach
            </div>

            {{-- Statistik per Program Studi --}}
            @if($statsPerProdi->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-700">Statistik per Program Studi</h3>
                    <span class="text-xs text-gray-400">{{ $statsPerProdi->count() }} program studi</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Program Studi</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aktif</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Nonaktif</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Cuti</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Distribusi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($statsPerProdi as $p)
                            @php
                                $pTotal = $p->total ?: 1;
                                $wA = round($p->aktif / $pTotal * 100);
                                $wN = round($p->nonaktif / $pTotal * 100);
                                $wC = round($p->cuti / $pTotal * 100);
                            @endphp
                            <tr class="hover:bg-gray-50 transition cursor-pointer"
                                onclick="window.location='{{ route('mahasiswa.laporan.fakultas', urlencode($fakultas)) }}?program_studi={{ urlencode($p->program_studi) }}&tahun_akademik={{ $tahunAkademik }}&semester={{ $semester }}'">
                                <td class="px-5 py-3 font-medium text-emerald-700 hover:underline">{{ $p->program_studi }}</td>
                                <td class="px-5 py-3 text-center font-bold text-gray-700">{{ $p->total }}</td>
                                <td class="px-5 py-3 text-center">
                                    <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded-full text-xs font-semibold">{{ $p->aktif }}</span>
                                </td>
                                <td class="px-5 py-3 text-center">
                                    <span class="px-2 py-0.5 bg-red-100 text-red-800 rounded-full text-xs font-semibold">{{ $p->nonaktif }}</span>
                                </td>
                                <td class="px-5 py-3 text-center">
                                    <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">{{ $p->cuti }}</span>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex h-3 rounded-full overflow-hidden w-32 bg-gray-100">
                                        @if($wA > 0)<div class="bg-green-500" style="width:{{ $wA }}%"></div>@endif
                                        @if($wN > 0)<div class="bg-red-400"   style="width:{{ $wN }}%"></div>@endif
                                        @if($wC > 0)<div class="bg-yellow-400" style="width:{{ $wC }}%"></div>@endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Daftar Mahasiswa --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-700">
                        Daftar Mahasiswa{{ $prodiFilter ? ' — ' . $prodiFilter : '' }}
                    </h3>
                    <span class="text-sm text-gray-400">{{ $mahasiswas->total() }} mahasiswa</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-emerald-700 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">NIM</th>
                                <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Program Studi</th>
                                <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Jenjang</th>
                                <th class="px-4 py-3 text-center font-semibold text-xs uppercase tracking-wider">Semester</th>
                                <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-center font-semibold text-xs uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($mahasiswas as $mhs)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-mono text-gray-700 whitespace-nowrap">{{ $mhs->nim }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">{{ $mhs->nama }}</td>
                                <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ $mhs->program_studi ?? '-' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded text-xs font-medium">{{ $mhs->jenjang }}</span>
                                </td>
                                <td class="px-4 py-3 text-center text-gray-600 whitespace-nowrap">{{ $mhs->semester ?? '-' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($mhs->status == 'Aktif')
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aktif</span>
                                    @elseif($mhs->status == 'Cuti')
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Cuti</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center whitespace-nowrap">
                                    <a href="{{ route('mahasiswa.show', $mhs->id) }}" class="text-emerald-600 hover:text-emerald-900 text-xs font-medium">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-400 text-sm">Tidak ada data mahasiswa yang sesuai.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($mahasiswas->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $mahasiswas->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
