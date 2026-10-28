<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-800 leading-tight">
            📚 Pembelajaran — {{ $dosen->nama }}
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
                        <p class="text-sm text-gray-500">Total SKS: <strong>{{ $pembelajarans->sum('sks') }}</strong></p>
                        <div class="flex gap-2">
                            <a href="{{ route('dosen.show', $dosen->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 transition">← Kembali</a>
                            <a href="{{ route('dosen.pembelajaran.create', $dosen->id) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition">+ Tambah MK</a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Kuliah</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKS</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Semester</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun Ajaran</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pembelajarans as $i => $pb)
                                <tr>
                                    <td class="px-4 py-3">{{ $pembelajarans->firstItem() + $i }}</td>
                                    <td class="px-4 py-3">{{ $pb->nama_mk }}</td>
                                    <td class="px-4 py-3">{{ $pb->sks }}</td>
                                    <td class="px-4 py-3">{{ $pb->semester }}</td>
                                    <td class="px-4 py-3">{{ $pb->tahun_ajaran }}</td>
                                    <td class="px-4 py-3">{{ $pb->kelas }}</td>
                                    <td class="px-4 py-3 flex gap-2">
                                        <a href="{{ route('dosen.pembelajaran.edit', [$dosen->id, $pb->id]) }}" class="text-emerald-600 hover:text-emerald-900">Edit</a>
                                        <form action="{{ route('dosen.pembelajaran.destroy', [$dosen->id, $pb->id]) }}" method="POST" onsubmit="return confirm('Hapus data pembelajaran ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-4 text-center text-gray-400 italic">Belum ada data pembelajaran.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $pembelajarans->links() }}</div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
