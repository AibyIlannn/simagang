<?php

namespace App\Http\Controllers\Institusi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;

class PendaftaranController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Menampilkan semua pendaftaran ke institusi ini
     */
    public function index()
    {
        $user = Auth::user();

        $pendaftaran = Pengajuan::with('mahasiswa', 'lowongan')
                        ->where('institusi_id', $user->id)
                        ->latest()
                        ->get();

        return view('institusi.pendaftaran.index', compact('pendaftaran'));
    }

    /**
     * Detail pendaftaran
     */
    public function show($id)
    {
        $user = Auth::user();

        $pendaftaran = Pengajuan::with('mahasiswa', 'lowongan')
                        ->where('institusi_id', $user->id)
                        ->where('id', $id)
                        ->firstOrFail();

        return view('institusi.pendaftaran.show', compact('pendaftaran'));
    }

    /**
     * Terima pendaftaran
     */
    public function terima($id)
    {
        $user = Auth::user();

        $pendaftaran = Pengajuan::where('institusi_id', $user->id)
                        ->where('id', $id)
                        ->firstOrFail();

        $pendaftaran->status = 'diterima';
        $pendaftaran->save();

        return redirect()
            ->route('institusi.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil diterima.');
    }

    /**
     * Tolak pendaftaran
     */
    public function tolak($id)
    {
        $user = Auth::user();

        $pendaftaran = Pengajuan::where('institusi_id', $user->id)
                        ->where('id', $id)
                        ->firstOrFail();

        $pendaftaran->status = 'ditolak';
        $pendaftaran->save();

        return redirect()
            ->route('institusi.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil ditolak.');
    }
}
