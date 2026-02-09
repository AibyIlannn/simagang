<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class LaporanController extends Controller
{
    /**
     * Daftar semua laporan
     * Route: admin.dashboard.laporan.index
     */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Ambil semua laporan (atau filter status)
        $laporan = Report::with('participant')
            ->latest()
            ->paginate(10);

        return view('admin.laporan.index', [
            'title'   => 'Manajemen Laporan',
            'admin'   => $admin,
            'laporan' => $laporan,
        ]);
    }

    /**
     * Detail laporan
     * Route: admin.dashboard.laporan.show
     */
    public function show($id)
    {
        $admin = Auth::guard('admin')->user();

        $laporan = Report::with('participant')->findOrFail($id);

        return view('admin.laporan.show', [
            'title'   => 'Detail Laporan',
            'admin'   => $admin,
            'laporan' => $laporan,
        ]);
    }
}