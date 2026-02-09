<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Models\Institusi; // aktifkan kalau model sudah ada
// use App\Models\Peserta;

class InstitusiController extends Controller
{
    /**
     * Daftar semua institusi
     * Route: admin.dashboard.institusi.index
     */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Contoh data (dummy)
        // $institusi = Institusi::latest()->paginate(10);

        $data = [
            'title' => 'Manajemen Institusi',
            'admin' => $admin,
            'institusi' => [], // ganti dengan $institusi
            'role' => $admin->role,
        ];

        // View: resources/views/admin/institusi/index.blade.php
        return view('admin.institusi.index', $data);
    }

    /**
     * Detail institusi
     * Route: admin.dashboard.institusi.show
     */
    public function show($id)
    {
        $admin = Auth::guard('admin')->user();

        // $institusi = Institusi::findOrFail($id);

        $data = [
            'title' => 'Detail Institusi',
            'admin' => $admin,
            'institusi' => null, // ganti $institusi
        ];

        // View: resources/views/admin/institusi/show.blade.php
        return view('admin.institusi.show', $data);
    }

    /**
     * Daftar peserta milik institusi tertentu
     * Route: admin.dashboard.institusi.peserta
     */
    public function showPeserta($id)
    {
        $admin = Auth::guard('admin')->user();

        // $institusi = Institusi::findOrFail($id);
        // $peserta = Peserta::where('institusi_id', $id)->get();

        $data = [
            'title' => 'Peserta Institusi',
            'admin' => $admin,
            'institusi' => null, // $institusi
            'peserta' => [],     // $peserta
        ];

        // View: resources/views/admin/institusi/peserta.blade.php
        return view('admin.institusi.peserta', $data);
    }
}