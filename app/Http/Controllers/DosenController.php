<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $query = Dosen::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
        }

        $dosens = $query->paginate(10)->withQueryString();
        return view('dosen.index', compact('dosens'));
    }

    public function create()
    {
        return view('dosen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip'     => 'required|unique:dosens,nip|max:20',
            'nama'    => 'required|max:255',
            'jabatan' => 'nullable|in:Rektor,Dekan,Kepala Prodi,Guru Besar,Lektor Kepala,Lektor,Asisten Ahli',
            'prodi'   => 'nullable|string|max:255',
            'jurusan' => 'required|in:Teknik Informatika,Teknik Mesin,Manajemen Informatika,Arsitek,Teknik Sipil',
            'status'  => 'required|in:Aktif,Nonaktif',
            'no_hp'   => 'nullable|string|max:20',
            'alamat'  => 'nullable|string',
        ]);

        Dosen::create($validated);
        return redirect()->route('dosen.index')->with('success', 'Data Dosen berhasil ditambahkan.');
    }

    public function show(Dosen $dosen)
    {
        $dosen->load(['penelitians', 'pembelajarans', 'kinerjaDosens']);
        return view('dosen.show', compact('dosen'));
    }

    public function edit(Dosen $dosen)
    {
        return view('dosen.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $validated = $request->validate([
            'nip'     => 'required|max:20|unique:dosens,nip,' . $dosen->id,
            'nama'    => 'required|max:255',
            'jabatan' => 'nullable|in:Rektor,Dekan,Kepala Prodi,Guru Besar,Lektor Kepala,Lektor,Asisten Ahli',
            'prodi'   => 'nullable|string|max:255',
            'jurusan' => 'required|in:Teknik Informatika,Teknik Mesin,Manajemen Informatika,Arsitek,Teknik Sipil',
            'status'  => 'required|in:Aktif,Nonaktif',
            'no_hp'   => 'nullable|string|max:20',
            'alamat'  => 'nullable|string',
        ]);

        $dosen->update($validated);
        return redirect()->route('dosen.index')->with('success', 'Data Dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen)
    {
        $dosen->delete();
        return redirect()->route('dosen.index')->with('success', 'Data Dosen berhasil dihapus.');
    }
}
