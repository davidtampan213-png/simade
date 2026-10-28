<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'dosen') {
            session()->put('active_role', 'mahasiswa');
            return redirect()->route('dashboard.mahasiswa');
        }

        return view('auth.pilih-role');
    }

    public function setRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:mahasiswa,dosen',
        ]);

        $role = $request->role;
        
        // Dosen is only allowed to access Mahasiswa section
        if (auth()->user()->role === 'dosen') {
            $role = 'mahasiswa';
        }

        $request->session()->put('active_role', $role);

        if ($role === 'mahasiswa') {
            return redirect()->route('dashboard.mahasiswa')->with('success', 'Berhasil masuk sebagai Mahasiswa.');
        }

        return redirect()->route('dashboard.dosen')->with('success', 'Berhasil masuk sebagai Dosen.');
    }
}
