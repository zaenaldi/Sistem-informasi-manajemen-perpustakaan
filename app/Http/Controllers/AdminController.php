<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Pengunjung;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalPengunjung = Pengunjung::count();
        $totalBuku = Buku::count();
        $totalPeminjaman = Peminjaman::count();
        
        $aktivitasTerbaru = Peminjaman::with(['buku', 'pengunjung', 'petugas'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.dashboard', compact(
            'totalPetugas',
            'totalPengunjung',
            'totalBuku',
            'totalPeminjaman',
            'aktivitasTerbaru'
        ));
    }

    public function aktivitas()
    {
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalPengunjung = Pengunjung::count();
        $totalBuku = Buku::count();
        $totalPeminjaman = Peminjaman::count();
        
        $aktivitasTerbaru = Peminjaman::with(['buku', 'pengunjung', 'petugas'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.aktivitas', compact(
            'totalPetugas',
            'totalPengunjung',
            'totalBuku',
            'totalPeminjaman',
            'aktivitasTerbaru'
        ));
    }

    // Profile Methods
    public function editProfile(Request $request): View
    {
        return view('admin.profile.edit', [
            'user' => $request->user()
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$request->user()->id,
        ]);

        $request->user()->update($validated);

        return redirect()->route('admin.profile.edit')->with('status', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password'])
        ]);

        return back()->with('status', 'Password berhasil diubah');
    }

    public function destroyProfile(Request $request): RedirectResponse
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
}