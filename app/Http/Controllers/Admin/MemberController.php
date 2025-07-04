<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Enums\UserRole;
use App\Http\Requests\Admin\MemberStoreRequest;
use App\Http\Requests\Admin\MemberUpdateRequest;
use Illuminate\Http\Request; // <-- use statement penting
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index(Request $request) // <-- Tambahkan Request $request
    {
        // Mulai query dengan eager loading
        $query = User::where('role', UserRole::MEMBER)->with('profile');

        // Terapkan filter pencarian jika ada
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Ambil hasil dengan paginasi
        $members = $query->latest()->paginate(10);

        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(MemberStoreRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => UserRole::MEMBER,
            ]);

            $profileData = [
                'user_id' => $user->id,
                'nis_nim' => $data['nis_nim'],
                'phone_number' => $data['phone_number'],
                'address' => $data['address'],
            ];

            if ($request->hasFile('profile_photo')) {
                $profileData['profile_photo_path'] = $request->file('profile_photo')->store('profile-photos', 'public');
            }
            
            UserProfile::create($profileData);

            DB::commit();

            return redirect()->route('admin.members.index')->with('success', 'Anggota baru berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')->withInput();
        }
    }

    public function edit(User $member)
    {
        $member->load('profile');
        return view('admin.members.edit', compact('member'));
    }

    public function update(MemberUpdateRequest $request, User $member)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $member->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            $profileData = [
                'nis_nim' => $data['nis_nim'],
                'phone_number' => $data['phone_number'],
                'address' => $data['address'],
            ];

            if ($request->hasFile('profile_photo')) {
                if ($member->profile && $member->profile->profile_photo_path) {
                    Storage::disk('public')->delete($member->profile->profile_photo_path);
                }
                $profileData['profile_photo_path'] = $request->file('profile_photo')->store('profile-photos', 'public');
            }

            $member->profile()->updateOrCreate(['user_id' => $member->id], $profileData);

            DB::commit();

            return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.')->withInput();
        }
    }

    public function destroy(User $member)
    {
        if ($member->profile && $member->profile->profile_photo_path) {
            Storage::disk('public')->delete($member->profile->profile_photo_path);
        }
        
        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}