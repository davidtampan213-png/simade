<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penelitian;
use App\Models\Dosen;

class PenelitianController extends Controller
{
    public function index($dosen_id)
    {
        $dosen = Dosen::findOrFail($dosen_id);
        $penelitians = Penelitian::where('dosen_id', $dosen_id)
            ->orderByDesc('tahun')
            ->paginate(10)
            ->withQueryString();
        return view('penelitian.index', compact('dosen', 'penelitians'));
    }

    public function create($dosen_id)
    {
        $dosen = Dosen::findOrFail($dosen_id);
        return view('penelitian.create', compact('dosen'));
    }

    public function store(Request $request, $dosen_id)
    {
        $dosen = Dosen::findOrFail($dosen_id);

        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'tahun'       => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'sumber_dana' => 'nullable|string|max:255',
        ]);

        $validated['dosen_id'] = $dosen->id;
        Penelitian::create($validated);

        return redirect()->route('dosen.penelitian.index', $dosen->id)
            ->with('success', 'Data penelitian berhasil ditambahkan.');
    }

    public function edit($dosen_id, Penelitian $penelitian)
    {
        $dosen = Dosen::findOrFail($dosen_id);
        return view('penelitian.edit', compact('dosen', 'penelitian'));
    }

    public function update(Request $request, $dosen_id, Penelitian $penelitian)
    {
        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'tahun'       => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'sumber_dana' => 'nullable|string|max:255',
        ]);

        $penelitian->update($validated);

        return redirect()->route('dosen.penelitian.index', $dosen_id)
            ->with('success', 'Data penelitian berhasil diperbarui.');
    }

    public function destroy($dosen_id, Penelitian $penelitian)
    {
        $penelitian->delete();
        return redirect()->route('dosen.penelitian.index', $dosen_id)
            ->with('success', 'Data penelitian berhasil dihapus.');
    }
}
