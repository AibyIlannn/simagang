<?php

namespace App\Http\Controllers\Institusi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Menampilkan semua laporan milik institusi
     */
    public function index()
    {
        $user = Auth::user();

        $laporan = Laporan::with('mahasiswa')
                    ->where('institusi_id', $user->id)
                    ->latest()
                    ->get();

        return view('institusi.laporan.index', compact('laporan'));
    }

    /**
     * Detail laporan
     */
    public function show($id)
    {
        $user = Auth::user();

        $laporan = Laporan::with('mahasiswa')
                    ->where('institusi_id', $user->id)
                    ->where('id', $id)
                    ->firstOrFail();

        return view('institusi.laporan.show', compact('laporan'));
    }

    /**
     * Verifikasi laporan
     */
    public function verifikasi($id)
    {
        $user = Auth::user();

        $laporan = Laporan::where('institusi_id', $user->id)
                    ->where('id', $id)
                    ->firstOrFail();

        $laporan->status = 'disetujui';
        $laporan->save();

        return redirect()
            ->route('institusi.laporan.index')
            ->with('success', 'Laporan berhasil diverifikasi.');
    }

    /**
     * Tolak laporan
     */
    public function tolak($id)
    {
        $user = Auth::user();

        $laporan = Laporan::where('institusi_id', $user->id)
                    ->where('id', $id)
                    ->firstOrFail();

        $laporan->status = 'ditolak';
        $laporan->save();

        return redirect()
            ->route('institusi.laporan.index')
            ->with('success', 'Laporan berhasil ditolak.');
    }
}
