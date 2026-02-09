<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Account;
use App\Models\InternshipApplication;
use App\Models\Participant;
use App\Models\ApplicationDocument;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('daftar');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:accounts,email',
            'whatsapp' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'duration_month' => 'required|in:1,2,3,6,9,12',
            'participants' => 'required|array|min:1',
            'participants.*.name' => 'required|string|max:150',
            'participants.*.participant_type' => 'required|in:SISWA,MAHASISWA',
            'participants.*.identity_number' => 'required|string|max:25',
            'participants.*.major' => 'required|string|max:100',
            'participants.*.class_or_program' => 'nullable|string|max:100',
            'participants.*.semester' => 'nullable|integer|min:1|max:14',
            'document' => 'required|file|mimes:pdf|max:5120', // 5MB max
        ]);

        DB::beginTransaction();

        try {
            // 1. Create Account (Institusi)
            $account = Account::create([
                'role' => 'INSTITUSI',
                'name' => $request->name,
                'email' => $request->email,
                'whatsapp' => $request->whatsapp,
                'password' => Hash::make($request->password),
                'status' => 'pending',
            ]);

            // 2. Create Internship Application
            $application = InternshipApplication::create([
                'institution_id' => $account->id,
                'duration_month' => $request->duration_month,
                'total_participants' => count($request->participants),
                'status' => 'pending',
            ]);

            // 3. Create Participants
            foreach ($request->participants as $participantData) {
                Participant::create([
                    'application_id' => $application->id,
                    'user_id' => null,
                    'name' => $participantData['name'],
                    'participant_type' => $participantData['participant_type'],
                    'identity_number' => $participantData['identity_number'],
                    'major' => $participantData['major'],
                    'class_or_program' => $participantData['class_or_program'] ?? null,
                    'semester' => $participantData['semester'] ?? null,
                    'division' => '-', // Will be assigned by admin
                    'room' => '-', // Will be assigned by admin
                    'floor' => 1, // Default floor
                    'status' => 'pending',
                ]);
            }

            // 4. Upload Document
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $filename = time() . '_' . $application->id . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documents/applications', $filename, 'public');

                ApplicationDocument::create([
                    'application_id' => $application->id,
                    'document_type' => 'SURAT_PENGAJUAN',
                    'file_path' => $path,
                ]);
            }

            // 5. Log Activity
            $this->logActivity('USER', $account->id, 'REGISTER', 'accounts', $account->id, 'Institusi registration successful', $request);

            DB::commit();

            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan tunggu konfirmasi dari admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.'
            ])->withInput();
        }
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