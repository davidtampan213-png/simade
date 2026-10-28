<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-800 leading-tight">
            {{ __('Dashboard Statistik Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- ===== ROW 1: STAT CARDS ===== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Card Total Dosen -->
                @if(Auth::user()->isAdmin())
                <a href="{{ route('dosen.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500 hover:shadow-md transition">
                @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                @endif
                    <div class="p-6 text-gray-900 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold mb-1">Total Dosen</p>
                            <h3 class="text-3xl font-bold text-blue-600">{{ $totalDosen }}</h3>
                        </div>
                        <div class="text-blue-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                @if(Auth::user()->isAdmin())
                </a>
                @else
                </div>
                @endif

                <!-- Card Dosen Aktif -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-emerald-500">
                    <div class="p-6 text-gray-900 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold mb-1">Dosen Aktif</p>
                            <h3 class="text-3xl font-bold text-emerald-600">{{ $totalDosenAktif }}</h3>
                        </div>
                        <div class="text-emerald-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Card Dosen Nonaktif -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500">
                    <div class="p-6 text-gray-900 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold mb-1">Dosen Nonaktif</p>
                            <h3 class="text-3xl font-bold text-red-600">{{ $totalDosenNonaktif }}</h3>
                        </div>
                        <div class="text-red-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Card Total Penelitian -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                    <div class="p-6 text-gray-900 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold mb-1">Total Penelitian</p>
                            <h3 class="text-3xl font-bold text-purple-600">{{ $totalPenelitian }}</h3>
                        </div>
                        <div class="text-purple-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Card Total Mata Kuliah -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-amber-500">
                    <div class="p-6 text-gray-900 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold mb-1">Total Mata Kuliah</p>
                            <h3 class="text-3xl font-bold text-amber-600">{{ $totalPembelajaran }}</h3>
                            <p class="text-xs text-gray-400 mt-1">{{ $totalSks }} SKS total</p>
                        </div>
                        <div class="text-amber-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Card Kinerja Terbaik -->
                @php
                    $kinerjaMap = $kinerjaPerKategori->keyBy('kategori');
                    $totalKinerja = $kinerjaPerKategori->sum('total');
                    $sangatBaik = $kinerjaMap->get('Sangat Baik')?->total ?? 0;
                @endphp
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-teal-500">
                    <div class="p-6 text-gray-900 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold mb-1">Kinerja Sangat Baik</p>
                            <h3 class="text-3xl font-bold text-teal-600">{{ $sangatBaik }}</h3>
                            <p class="text-xs text-gray-400 mt-1">dari {{ $totalKinerja }} penilaian</p>
                        </div>
                        <div class="text-teal-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ===== ROW 2: CHARTS ===== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">

                <!-- Dosen per Jurusan (Pie) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Dosen per Jurusan</h3>
                        <div class="relative h-64 w-full">
                            <canvas id="dosenJurusanChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Dosen per Jabatan (Bar) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Dosen per Jabatan</h3>
                        <div class="relative h-64 w-full">
                            <canvas id="dosenJabatanChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Kinerja per Kategori (Doughnut) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Distribusi Kinerja Dosen</h3>
                        <div class="relative h-64 w-full">
                            <canvas id="kinerjaKategoriChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Status Aktif/Nonaktif (Bar) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Dosen per Status</h3>
                        <div class="relative h-64 w-full">
                            <canvas id="dosenStatusChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.register(ChartDataLabels);

            const distinctBgColors = [
                'rgba(16, 185, 129, 0.8)',
                'rgba(59, 130, 246, 0.8)',
                'rgba(139, 92, 246, 0.8)',
                'rgba(245, 158, 11, 0.8)',
                'rgba(236, 72, 153, 0.8)',
                'rgba(14, 165, 233, 0.8)',
                'rgba(239, 68, 68, 0.8)',
            ];

            // --- Dosen Jurusan Chart (Pie) ---
            const dosenJurusanDataRaw = @json($dosenPerJurusan);
            new Chart(document.getElementById('dosenJurusanChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: dosenJurusanDataRaw.map(i => i.jurusan || 'Unknown'),
                    datasets: [{ data: dosenJurusanDataRaw.map(i => i.total), backgroundColor: distinctBgColors, borderWidth: 1 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                        datalabels: {
                            color: '#fff', font: { weight: 'bold', size: 13 },
                            formatter: (value, ctx) => {
                                let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => Number(a) + Number(b), 0);
                                return (value * 100 / sum).toFixed(1) + '%';
                            }
                        }
                    }
                }
            });

            // --- Dosen Jabatan Chart (Horizontal Bar) ---
            const dosenJabatanDataRaw = @json($dosenPerJabatan);
            new Chart(document.getElementById('dosenJabatanChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: dosenJabatanDataRaw.map(i => i.jabatan || '-'),
                    datasets: [{
                        label: 'Jumlah',
                        data: dosenJabatanDataRaw.map(i => i.total),
                        backgroundColor: 'rgba(139, 92, 246, 0.8)',
                        borderColor: 'rgba(139, 92, 246, 1)',
                        borderWidth: 1, borderRadius: 4
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true, maintainAspectRatio: false,
                    scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } },
                    plugins: {
                        legend: { display: false },
                        datalabels: { color: '#6d28d9', anchor: 'end', align: 'right', font: { weight: 'bold' } }
                    }
                }
            });

            // --- Kinerja per Kategori (Doughnut) ---
            const kinerjaDataRaw = @json($kinerjaPerKategori);
            const kinerjaColors = {
                'Sangat Baik': 'rgba(16, 185, 129, 0.8)',
                'Baik':        'rgba(59, 130, 246, 0.8)',
                'Cukup':       'rgba(245, 158, 11, 0.8)',
                'Kurang':      'rgba(239, 68, 68, 0.8)',
            };
            new Chart(document.getElementById('kinerjaKategoriChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: kinerjaDataRaw.map(i => i.kategori),
                    datasets: [{
                        data: kinerjaDataRaw.map(i => i.total),
                        backgroundColor: kinerjaDataRaw.map(i => kinerjaColors[i.kategori] || 'rgba(107,114,128,0.8)'),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                        datalabels: {
                            color: '#fff', font: { weight: 'bold', size: 13 },
                            formatter: (value, ctx) => {
                                let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => Number(a) + Number(b), 0);
                                return sum > 0 ? (value * 100 / sum).toFixed(1) + '%' : '';
                            }
                        }
                    }
                }
            });

            // --- Dosen Status Chart (Bar) ---
            const dosenStatusDataRaw = @json($dosenPerStatus);
            const statusColors = dosenStatusDataRaw.map(i => i.status === 'Aktif' ? 'rgba(16,185,129,0.8)' : 'rgba(239,68,68,0.8)');
            new Chart(document.getElementById('dosenStatusChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: dosenStatusDataRaw.map(i => i.status),
                    datasets: [{
                        label: 'Jumlah Dosen',
                        data: dosenStatusDataRaw.map(i => i.total),
                        backgroundColor: statusColors, borderWidth: 1, borderRadius: 4
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
                    plugins: {
                        legend: { display: false },
                        datalabels: { anchor: 'end', align: 'top', font: { weight: 'bold' }, formatter: v => v }
                    }
                }
            });
        });
    </script>
</x-app-layout>
