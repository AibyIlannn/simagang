<?php

namespace App\Http\Controllers\Institusi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use App\Models\Mahasiswa;

class PesertaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Menampilkan daftar peserta yang diterima
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil pengajuan dengan status diterima milik institusi yang login
        $peserta = Pengajuan::with('mahasiswa')
                    ->where('institusi_id', $user->id)
                    ->where('status', 'diterima')
                    ->latest()
                    ->get();

        return view('institusi.peserta.index', compact('peserta'));
    }

    /**
     * Detail peserta
     */
    public function show($id)
    {
        $user = Auth::user();

        $peserta = Pengajuan::with('mahasiswa')
                    ->where('institusi_id', $user->id)
                    ->where('id', $id)
                    ->firstOrFail();

        return view('institusi.peserta.show', compact('peserta'));
    }

    /**
     * Update status peserta (misal: selesai / aktif)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:aktif,selesai'
        ]);

        $user = Auth::user();

        $peserta = Pengajuan::where('institusi_id', $user->id)
                    ->where('id', $id)
                    ->firstOrFail();

        $peserta->status = $request->status;
        $peserta->save();

        return redirect()
            ->route('institusi.peserta.index')
            ->with('success', 'Status peserta berhasil diperbarui.');
    }
}
