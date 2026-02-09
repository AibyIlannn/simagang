<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        // Determine user type and log before logout
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            $this->logActivity('ADMIN', $admin->id, 'LOGOUT', null, null, 'Admin logout', $request);
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            $this->logActivity('USER', $user->id, 'LOGOUT', null, null, ucfirst(strtolower($user->role)) . ' logout', $request);
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }

    private function logActivity($actorType, $actorId, $action, $targetTable, $targetId, $description, Request $request)
    {
        DB::table('audit_logs')->insert([
            'actor_type' => $actorType,
            'actor_id' => $actorId,
            'action' => $action,
            'target_table' => $targetTable,
            'target_id' => $targetId,
            'description' => $description,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);
    }
}
