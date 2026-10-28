<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KinerjaDosen;
use App\Models\Dosen;

class KinerjaDosenController extends Controller
{
    public function index($dosen_id)
    {
        $dosen = Dosen::findOrFail($dosen_id);
        $kinerjaDosens = KinerjaDosen::where('dosen_id', $dosen_id)
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();
        return view('kinerja.index', compact('dosen', 'kinerjaDosens'));
    }

    public function create($dosen_id)
    {
        $dosen = Dosen::findOrFail($dosen_id);
        return view('kinerja.create', compact('dosen'));
    }

    public function store(Request $request, $dosen_id)
    {
        $dosen = Dosen::findOrFail($dosen_id);

        $validated = $request->validate([
            'periode'  => 'required|string|max:50',
            'kategori' => 'required|in:Sangat Baik,Baik,Cukup,Kurang',
            'catatan'  => 'nullable|string',
        ]);

        $validated['dosen_id'] = $dosen->id;
        KinerjaDosen::create($validated);

        return redirect()->route('dosen.kinerja.index', $dosen->id)
            ->with('success', 'Data kinerja berhasil ditambahkan.');
    }

    public function edit($dosen_id, KinerjaDosen $kinerja)
    {
        $dosen = Dosen::findOrFail($dosen_id);
        return view('kinerja.edit', compact('dosen', 'kinerja'));
    }

    public function update(Request $request, $dosen_id, KinerjaDosen $kinerja)
    {
        $validated = $request->validate([
            'periode'  => 'required|string|max:50',
            'kategori' => 'required|in:Sangat Baik,Baik,Cukup,Kurang',
            'catatan'  => 'nullable|string',
        ]);

        $kinerja->update($validated);

        return redirect()->route('dosen.kinerja.index', $dosen_id)
            ->with('success', 'Data kinerja berhasil diperbarui.');
    }

    public function destroy($dosen_id, KinerjaDosen $kinerja)
    {
        $kinerja->delete();
        return redirect()->route('dosen.kinerja.index', $dosen_id)
            ->with('success', 'Data kinerja berhasil dihapus.');
    }
}
