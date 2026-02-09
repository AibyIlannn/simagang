<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Models\Peserta;
// use App\Models\Institusi;

class ValidationController extends Controller
{
    /**
     * Validasi institusi
     * Route: admin.dashboard.validasi.institusi
     */
    public function institusi()
    {
        $admin = Auth::guard('admin')->user();

        // $institusi = Institusi::where('status', 'pending')->get();

        return view('admin.validasi.index', [
            'title' => 'Validasi Institusi',
            'admin' => $admin,
            'institusi' => [],
        ]);
    }

    /**
     * Validasi peserta (list)
     * Route: admin.dashboard.validasi.peserta
     */
    public function peserta()
    {
        $admin = Auth::guard('admin')->user();

        // $peserta = Peserta::where('status', 'pending')->get();

        return view('admin.validasi.peserta', [
            'title' => 'Validasi Peserta',
            'admin' => $admin,
            'peserta' => [],
        ]);
    }

    /**
     * Detail peserta (validasi)
     * Route: admin.dashboard.validasi.peserta.show
     */
    public function pesertaShow($id)
    {
        $admin = Auth::guard('admin')->user();

        // $peserta = Peserta::findOrFail($id);

        return view('admin.validasi.peserta-show', [
            'title' => 'Detail Validasi Peserta',
            'admin' => $admin,
            'peserta' => null,
        ]);
    }

    /**
     * ACC peserta
     * Route: admin.dashboard.validasi.peserta.acc
     */
    public function accPeserta($id)
    {
        // Peserta::where('id', $id)->update(['status' => 'active']);

        return redirect()
            ->back()
            ->with('success', 'Peserta berhasil disetujui');
    }

    /**
     * Reject peserta
     * Route: admin.dashboard.validasi.peserta.reject
     */
    public function rejectPeserta($id)
    {
        // Peserta::where('id', $id)->update(['status' => 'rejected']);

        return redirect()
            ->back()
            ->with('success', 'Peserta berhasil ditolak');
    }

    /**
     * ACC institusi
     * Route: admin.dashboard.validasi.institusi.acc
     */
    public function accInstitusi($id)
    {
        // Institusi::where('id', $id)->update(['status' => 'active']);

        return redirect()
            ->back()
            ->with('success', 'Institusi berhasil disetujui');
    }

    /**
     * Reject institusi
     * Route: admin.dashboard.validasi.institusi.reject
     */
    public function rejectInstitusi($id)
    {
        // Institusi::where('id', $id)->update(['status' => 'rejected']);

        return redirect()
            ->back()
            ->with('success', 'Institusi berhasil ditolak');
    }
}