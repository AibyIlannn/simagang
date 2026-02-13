<?php

namespace App\Http\Controllers\Institusi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Tampilkan halaman profil
     */
    public function index()
    {
        $institusi = Auth::user();

        return view('institusi.profil.index', compact('institusi'));
    }

    /**
     * Update data profil
     */
    public function update(Request $request)
    {
        $institusi = Auth::user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $institusi->id,
            'telepon'   => 'nullable|string|max:20',
            'alamat'    => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'logo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload logo jika ada
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/logo_institusi', $filename);

            $institusi->logo = $filename;
        }

        $institusi->name      = $request->name;
        $institusi->email     = $request->email;
        $institusi->telepon   = $request->telepon;
        $institusi->alamat    = $request->alamat;
        $institusi->deskripsi = $request->deskripsi;

        $institusi->save();

        return redirect()
            ->route('institusi.profil.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        $institusi = Auth::user();

        // Cek password lama
        if (!Hash::check($request->password_lama, $institusi->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        $institusi->password = Hash::make($request->password_baru);
        $institusi->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
