<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-800 leading-tight">
            📊 Kinerja — {{ $dosen->nama }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded mb-4">
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">

                    <div class="flex justify-between items-center mb-4">
                        <p class="text-sm text-gray-500">Riwayat kinerja dosen</p>
                        <div class="flex gap-2">
                            <a href="{{ route('dosen.show', $dosen->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 transition">← Kembali</a>
                            <a href="{{ route('dosen.kinerja.create', $dosen->id) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition">+ Tambah Kinerja</a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($kinerjaDosens as $i => $k)
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
                                    <td class="px-4 py-3">{{ $kinerjaDosens->firstItem() + $i }}</td>
                                    <td class="px-4 py-3">{{ $k->periode }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColor }}">
                                            {{ $k->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $k->catatan ?? '-' }}</td>
                                    <td class="px-4 py-3 flex gap-2">
                                        <a href="{{ route('dosen.kinerja.edit', [$dosen->id, $k->id]) }}" class="text-emerald-600 hover:text-emerald-900">Edit</a>
                                        <form action="{{ route('dosen.kinerja.destroy', [$dosen->id, $k->id]) }}" method="POST" onsubmit="return confirm('Hapus data kinerja ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-400 italic">Belum ada data kinerja.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $kinerjaDosens->links() }}</div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
