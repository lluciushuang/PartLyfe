<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // ==========================================================
    // 1. FUNGSI BAWAAN LARAVEL BREEZE (JANGAN DIHAPUS BIAR AMAN)
    // ==========================================================

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    // ==========================================================
    // 2. FUNGSI KUSTOM E-COMMERCE PARTLYFE (TEMA TOKOPEDIA)
    // ==========================================================

    // Menampilkan halaman profil customer
    public function index()
    {
        return view('customer.profile');
    }

    // Mengubah Biodata & Kontak
    public function updateBio(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->save();

        return back()->with('success', 'Biodata diri berhasil diperbarui!');
    }

    // Mengubah Alamat Pengiriman
    public function updateAddress(Request $request)
    {
        $user = Auth::user();
        $user->address = $request->address;
        $user->save();

        return back()->with('success', 'Daftar alamat berhasil diperbarui!');
    }

    // Mengunggah Foto Profil (Avatar)
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'image|mimes:jpeg,png,jpg|max:10240', // Max 10MB
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            // Hapus foto lama dari storage jika sudah ada foto sebelumnya
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Simpan foto baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();
        }

        return back()->with('success', 'Foto profil berhasil diubah!');
    }

    // Mengubah Keamanan (Password Baru & PIN)
    public function updateSecurity(Request $request)
    {
        $user = Auth::user();
        
        // Cek apakah user mengisi password baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        // Cek apakah user mengisi PIN baru
        if ($request->filled('pin')) {
            $user->pin = Hash::make($request->pin); // Di-hash agar aman
        }
        
        $user->save();

        return back()->with('success', 'Pengaturan keamanan berhasil diperbarui!');
    }
}