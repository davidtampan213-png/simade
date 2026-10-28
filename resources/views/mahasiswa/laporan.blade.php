<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard.mahasiswa') }}" class="text-emerald-600 hover:text-emerald-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h2 class="font-semibold text-xl text-emerald-800 leading-tight">Laporan Mahasiswa per Fakultas</h2>
            </div>
            {{-- Tombol Ekspor --}}
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('mahasiswa.laporan.export', array_merge(request()->query(), ['format'=>'excel'])) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-teal-600 text-white text-sm rounded-lg hover:bg-teal-700 transition font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                    Ekspor Excel
                </a>
                <a href="{{ route('mahasiswa.laporan.export', array_merge(request()->query(), ['format'=>'pdf'])) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-600 text-white text-sm rounded-lg hover:bg-rose-700 transition font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Ekspor PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-7">

            {{-- Filter --}}
            <div class="bg-white rounded-2xl shadow-sm p-5">
                <form method="GET" action="{{ route('mahasiswa.laporan') }}" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Tahun Akademik</label>
                        <select name="tahun_akademik" class="rounded-lg border-gray-300 text-sm focus:ring-emerald-400 focus:border-emerald-400 shadow-sm">
                            <option value="">Semua Tahun</option>
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
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700 transition font-medium">Terapkan</button>
                    <a href="{{ route('mahasiswa.laporan') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300 transition font-medium">Reset</a>
                </form>
                @if($tahunAkademik || $semester)
                <p class="mt-3 text-xs text-emerald-700 bg-emerald-50 rounded-lg px-3 py-2">
                    Filter aktif:
                    @if($tahunAkademik) Tahun Akademik <strong>{{ $tahunAkademik }}</strong> @endif
                    @if($semester) &bull; <strong>Semester {{ $semester }}</strong> @endif
                </p>
                @endif
            </div>

            {{-- Kartu Ringkasan Global --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                @php $cards = [
                    ['label'=>'Total Mahasiswa','value'=>$totalAll,      'color'=>'emerald','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['label'=>'Aktif',           'value'=>$totalAktif,   'color'=>'green', 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['label'=>'Nonaktif',        'value'=>$totalNonaktif,'color'=>'red',   'icon'=>'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636'],
                    ['label'=>'Cuti',            'value'=>$totalCuti,    'color'=>'yellow','icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ]; @endphp
                @foreach($cards as $c)
                <div class="bg-white rounded-2xl shadow-sm p-5 border-t-4 border-{{ $c['color'] }}-500">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">{{ $c['label'] }}</p>
                    <h3 class="text-3xl font-extrabold text-{{ $c['color'] }}-600">{{ number_format($c['value']) }}</h3>
                </div>
                @endforeach
            </div>

            {{-- Grafik Batang Perbandingan per Fakultas --}}
            @if($statsPerFakultas->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-5">Perbandingan Status per Fakultas</h3>
                <div class="relative" style="height: {{ max(200, $statsPerFakultas->count() * 60) }}px">
                    <canvas id="fakultasChart"></canvas>
                </div>
            </div>
            @endif

            {{-- Tabel Statistik per Fakultas --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-700">Statistik per Fakultas</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Klik nama fakultas untuk melihat detail per program studi</p>
                </div>

                @if($statsPerFakultas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-emerald-700 text-white">
                            <tr>
                                <th class="px-5 py-3 text-left font-semibold">Fakultas</th>
                                <th class="px-5 py-3 text-center font-semibold">Total</th>
                                <th class="px-5 py-3 text-center font-semibold">Aktif</th>
                                <th class="px-5 py-3 text-center font-semibold">Nonaktif</th>
                                <th class="px-5 py-3 text-center font-semibold">Cuti</th>
                                <th class="px-5 py-3 text-center font-semibold">% Aktif</th>
                                <th class="px-5 py-3 text-center font-semibold">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($statsPerFakultas as $f)
                            @php $pct = $f->total > 0 ? round($f->aktif / $f->total * 100) : 0; @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-4 font-medium text-gray-800">{{ $f->fakultas }}</td>
                                <td class="px-5 py-4 text-center font-bold text-gray-700">{{ $f->total }}</td>
                                <td class="px-5 py-4 text-center">
                                    <span class="px-2.5 py-0.5 bg-green-100 text-green-800 rounded-full font-semibold text-xs">{{ $f->aktif }}</span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="px-2.5 py-0.5 bg-red-100 text-red-800 rounded-full font-semibold text-xs">{{ $f->nonaktif }}</span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="px-2.5 py-0.5 bg-yellow-100 text-yellow-800 rounded-full font-semibold text-xs">{{ $f->cuti }}</span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-gray-100 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $pct }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-600 w-9 text-right">{{ $pct }}%</span>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('mahasiswa.laporan.fakultas', urlencode($f->fakultas)) }}?tahun_akademik={{ $tahunAkademik }}&semester={{ $semester }}"
                                       class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-lg hover:bg-emerald-100 transition text-xs font-semibold">
                                        Detail →
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="p-16 text-center">
                    <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-400 text-sm">Belum ada data yang sesuai filter.</p>
                </div>
                @endif
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const data = @json($statsPerFakultas);
        if (!data.length) return;

        new Chart(document.getElementById('fakultasChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: data.map(d => d.fakultas),
                datasets: [
                    {
                        label: 'Aktif',
                        data: data.map(d => d.aktif),
                        backgroundColor: 'rgba(34,197,94,0.8)',
                        borderRadius: 4,
                    },
                    {
                        label: 'Nonaktif',
                        data: data.map(d => d.nonaktif),
                        backgroundColor: 'rgba(239,68,68,0.8)',
                        borderRadius: 4,
                    },
                    {
                        label: 'Cuti',
                        data: data.map(d => d.cuti),
                        backgroundColor: 'rgba(234,179,8,0.8)',
                        borderRadius: 4,
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    x: { beginAtZero: true, stacked: false, ticks: { stepSize: 1 } },
                    y: { ticks: { font: { size: 12 } } }
                },
                plugins: {
                    legend: { position: 'top' },
                    datalabels: { display: false }
                }
            }
        });
    });
    </script>
</x-app-layout>
