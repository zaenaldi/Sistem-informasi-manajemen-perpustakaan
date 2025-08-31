<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengunjung;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;

class PetugasController extends Controller
{
    /**
     * Dashboard Petugas
     */
    public function dashboard()
    {
        $totalBuku = Buku::count();
        $totalPengunjung = Pengunjung::count();
        $peminjamanHariIni = Peminjaman::whereDate('tanggal_pinjam', today())->count();
        $peminjamanTerbaru = Peminjaman::with(['buku', 'pengunjung'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('petugas.dashboard', compact(
            'totalBuku',
            'totalPengunjung',
            'peminjamanHariIni',
            'peminjamanTerbaru'
        ));
    }

    /**
     * Menampilkan daftar petugas
     */
    public function index()
    {
        $petugas = User::where('role', 'petugas')->paginate(10);
        return view('admin.petugas.index', compact('petugas'));
    }

    /**
     * Menampilkan form tambah petugas
     */
    public function create()
    {
        return view('admin.petugas.create');
    }

    /**
     * Menyimpan petugas baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'petugas';

        User::create($validated);

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil ditambahkan');
    }

    /**
     * Menampilkan form edit petugas
     */
    public function edit($id)
    {
        $petugas = User::findOrFail($id);
        return view('admin.petugas.edit', compact('petugas'));
    }

    /**
     * Mengupdate data petugas
     */
    public function update(Request $request, $id)
{
    $petugas = User::findOrFail($id);

    // Validasi data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique('users')->ignore($petugas->id)
        ],
        'password' => 'nullable|string|min:8|confirmed',
    ], [
        'email.unique' => 'Email ini sudah digunakan oleh pengguna lain',
        'password.confirmed' => 'Konfirmasi password tidak cocok'
    ]);

    try {
        // Persiapkan data untuk update
        $updateData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email']
        ];

        // Update password hanya jika diisi
        if (!empty($validatedData['password'])) {
            $updateData['password'] = bcrypt($validatedData['password']);
        }

        // Lakukan update
        $petugas->update($updateData);

        return redirect()->route('admin.petugas.index')
               ->with('success', 'Data petugas berhasil diperbarui');

    } catch (\Exception $e) {
        return back()->withInput()
               ->with('error', 'Gagal menyimpan perubahan: '.$e->getMessage());
    }
}

    /**
     * Menghapus petugas
     */
    public function destroy($id)
    {
        $petugas = User::findOrFail($id);
        $petugas->delete();

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil dihapus');
    }

    /**
     * Fungsi tambahan untuk petugas
     */
    public function peminjaman()
    {
        $peminjaman = Peminjaman::with(['buku', 'pengunjung'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('petugas.peminjaman', compact('peminjaman'));
    }

    // Profile Methods
    public function editProfile(Request $request): View
    {
        return view('petugas.profile.edit', [
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

        return redirect()->route('petugas.profile.edit')->with('status', 'Profil berhasil diperbarui');
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