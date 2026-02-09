<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Account;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('masuk');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
        $loginIdentifier = $request->input('email');

        // Try login as Admin first
        $admin = Admin::where('email', $loginIdentifier)
            ->orWhere('name', $loginIdentifier)
            ->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            if ($admin->status !== 'active') {
                return back()->withErrors([
                    'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                ])->withInput();
            }

            Auth::guard('admin')->login($admin, $remember);
            
            // Log to audit_logs
            $this->logActivity('ADMIN', $admin->id, 'LOGIN', null, null, 'Admin login successful', $request);

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // Try login as Account (Institusi/Peserta)
        $account = Account::where('email', $loginIdentifier)
            ->orWhere('name', $loginIdentifier)
            ->first();

        if ($account && Hash::check($credentials['password'], $account->password)) {
            if ($account->status === 'pending') {
                return back()->withErrors([
                    'email' => 'Akun Anda masih dalam proses validasi. Mohon tunggu konfirmasi dari admin.',
                ])->withInput();
            }

            if ($account->status === 'rejected') {
                return back()->withErrors([
                    'email' => 'Akun Anda ditolak. Silakan hubungi administrator untuk informasi lebih lanjut.',
                ])->withInput();
            }

            if ($account->status !== 'active') {
                return back()->withErrors([
                    'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                ])->withInput();
            }

            Auth::guard('web')->login($account, $remember);
            
            // Log to audit_logs
            $this->logActivity('USER', $account->id, 'LOGIN', null, null, ucfirst(strtolower($account->role)) . ' login successful', $request);

            $request->session()->regenerate();

            // Redirect based on role
            if ($account->role === 'INSTITUSI') {
                return redirect()->intended(route('institusi.dashboard'));
            } elseif ($account->role === 'PESERTA') {
                return redirect()->intended(route('peserta.dashboard'));
            }
        }

        // Login failed
        return back()->withErrors([
            'email' => 'Email/Username atau kata sandi salah.',
        ])->withInput();
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
