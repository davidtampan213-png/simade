<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-800 leading-tight">
            🔬 Penelitian — {{ $dosen->nama }}
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
                        <div>
                            <p class="text-sm text-gray-500">Total penelitian: <strong>{{ $penelitians->total() }}</strong></p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('dosen.show', $dosen->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 transition">← Kembali</a>
                            <a href="{{ route('dosen.penelitian.create', $dosen->id) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition">+ Tambah Penelitian</a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Penelitian</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sumber Dana</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($penelitians as $i => $p)
                                <tr>
                                    <td class="px-4 py-3">{{ $penelitians->firstItem() + $i }}</td>
                                    <td class="px-4 py-3">{{ $p->judul }}</td>
                                    <td class="px-4 py-3">{{ $p->tahun }}</td>
                                    <td class="px-4 py-3">{{ $p->sumber_dana ?? '-' }}</td>
                                    <td class="px-4 py-3 flex gap-2">
                                        <a href="{{ route('dosen.penelitian.edit', [$dosen->id, $p->id]) }}" class="text-emerald-600 hover:text-emerald-900">Edit</a>
                                        <form action="{{ route('dosen.penelitian.destroy', [$dosen->id, $p->id]) }}" method="POST" onsubmit="return confirm('Hapus penelitian ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-400 italic">Belum ada data penelitian.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $penelitians->links() }}</div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
