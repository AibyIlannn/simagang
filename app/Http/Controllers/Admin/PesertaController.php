<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Models\Peserta;

class PesertaController extends Controller
{
    /**
     * Daftar semua peserta
     * Route: admin.dashboard.peserta.index
     */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // $peserta = Peserta::latest()->paginate(10);

        $data = [
            'title' => 'Manajemen Peserta',
            'admin' => $admin,
            'peserta' => [], // ganti $peserta
            'role' => $admin->role,
        ];

        return view('admin.peserta.index', $data);
    }

    /**
     * Detail peserta
     * Route: admin.dashboard.peserta.show
     */
    public function show($id)
    {
        $admin = Auth::guard('admin')->user();

        // $peserta = Peserta::findOrFail($id);

        $data = [
            'title' => 'Detail Peserta',
            'admin' => $admin,
            'peserta' => null, // $peserta
        ];

        return view('admin.peserta.show', $data);
    }
}