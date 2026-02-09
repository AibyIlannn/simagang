<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard Admin
     * Guard: admin
     * Role: ADMIN, SUPERADMIN
     */
    public function index(Request $request)
    {
        // Ambil user admin yang sedang login
        $admin = Auth::guard('admin')->user();

        // Data statistik (contoh, bisa kamu ganti query asli)
        $data = [
            'title' => 'Dashboard Admin',
            'admin' => $admin,

            // Statistik dummy (nanti tinggal ganti model)
            'total_institusi' => 0,
            'total_peserta'   => 0,
            'total_laporan'   => 0,

            // Role & akses
            'role' => $admin->role,
        ];

        // View ke: resources/views/admin/dashboard/index.blade.php
        return view('admin.dashboard.index', $data);
    }

    /**
     * Refresh data dashboard (optional - AJAX / future use)
     */
    public function refresh()
    {
        return response()->json([
            'status' => true,
            'message' => 'Data dashboard berhasil diperbarui',
        ]);
    }
}