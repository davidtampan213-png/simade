<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelajaran;
use App\Models\Dosen;

class PembelajaranController extends Controller
{
    public function index($dosen_id)
    {
        $dosen = Dosen::findOrFail($dosen_id);
        $pembelajarans = Pembelajaran::where('dosen_id', $dosen_id)
            ->orderByDesc('tahun_ajaran')
            ->orderBy('semester')
            ->paginate(10)
            ->withQueryString();
        return view('pembelajaran.index', compact('dosen', 'pembelajarans'));
    }

    public function create($dosen_id)
    {
        $dosen = Dosen::findOrFail($dosen_id);
        return view('pembelajaran.create', compact('dosen'));
    }

    public function store(Request $request, $dosen_id)
    {
        $dosen = Dosen::findOrFail($dosen_id);

        $validated = $request->validate([
            'nama_mk'      => 'required|string|max:255',
            'sks'          => 'required|integer|min:1|max:6',
            'semester'     => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|string|max:20',
            'kelas'        => 'required|string|max:50',
        ]);

        $validated['dosen_id'] = $dosen->id;
        Pembelajaran::create($validated);

        return redirect()->route('dosen.pembelajaran.index', $dosen->id)
            ->with('success', 'Data pembelajaran berhasil ditambahkan.');
    }

    public function edit($dosen_id, Pembelajaran $pembelajaran)
    {
        $dosen = Dosen::findOrFail($dosen_id);
        return view('pembelajaran.edit', compact('dosen', 'pembelajaran'));
    }

    public function update(Request $request, $dosen_id, Pembelajaran $pembelajaran)
    {
        $validated = $request->validate([
            'nama_mk'      => 'required|string|max:255',
            'sks'          => 'required|integer|min:1|max:6',
            'semester'     => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|string|max:20',
            'kelas'        => 'required|string|max:50',
        ]);

        $pembelajaran->update($validated);

        return redirect()->route('dosen.pembelajaran.index', $dosen_id)
            ->with('success', 'Data pembelajaran berhasil diperbarui.');
    }

    public function destroy($dosen_id, Pembelajaran $pembelajaran)
    {
        $pembelajaran->delete();
        return redirect()->route('dosen.pembelajaran.index', $dosen_id)
            ->with('success', 'Data pembelajaran berhasil dihapus.');
    }
}
