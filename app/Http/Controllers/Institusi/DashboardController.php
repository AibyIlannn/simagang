<?php

namespace App\Http\Controllers\Institusi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\Lowongan;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $user = Auth::user();

        // Total mahasiswa yang mendaftar ke institusi ini
        $totalMahasiswa = Mahasiswa::where('institusi_id', $user->id)->count();

        // Total pengajuan magang
        $totalPengajuan = Pengajuan::where('institusi_id', $user->id)->count();

        // Pengajuan yang masih pending
        $pendingPengajuan = Pengajuan::where('institusi_id', $user->id)
                            ->where('status', 'pending')
                            ->count();

        // Total lowongan yang dibuat institusi
        $totalLowongan = Lowongan::where('institusi_id', $user->id)->count();

        return view('institusi.dashboard', compact(
            'totalMahasiswa',
            'totalPengajuan',
            'pendingPengajuan',
            'totalLowongan'
        ));
    }
}
