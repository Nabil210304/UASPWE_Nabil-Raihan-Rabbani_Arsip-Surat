<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Menampilkan halaman profil pengguna
    public function index(Request $request)
    {
        $query = $request->get('query');

        $users = User::when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('name', 'like', "%{$query}%")
                    ->orWhere('prodi', 'like', "%{$query}%")
                    ->orWhere('nim', 'like', "%{$query}%");
            })
            ->where('id', Auth::id()) // Filter hanya data pengguna yang login
            ->paginate(5);

        if ($request->ajax()) {
            return view('about.table', compact('users'))->render();
        }

        return view('about.index', compact('users'));
    }

    // Menampilkan form edit profil pengguna
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        // Cek apakah ID pengguna yang diakses adalah pengguna yang sedang login
        if ($user->id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses data ini.');
        }

        return view('about.edit', compact('user'));
    }

    // Memperbarui data profil pengguna
    public function update(Request $request, string $id)
    {
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'max' => ':attribute melebihi panjang maksimal',
            'image' => ':attribute harus berupa file gambar',
        ];

        $request->validate([
            'name' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:20048',
        ], $message);

        $user = User::findOrFail($id);

        // Cek apakah ID pengguna yang diakses adalah pengguna yang sedang login
        if ($user->id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses data ini.');
        }

        if ($request->hasFile('profile_picture')) {
            // Hapus gambar lama jika ada
            if ($user->profile_picture && file_exists(public_path('images/' . $user->profile_picture))) {
                unlink(public_path('images/' . $user->profile_picture));
            }

            // Simpan gambar baru
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);

            $user->profile_picture = $filename;
        }

        $user->name = $request->name;
        $user->prodi = $request->prodi;
        $user->nim = $request->nim;
        $user->birth_date = $request->birth_date;
        $user->save();

        return redirect(url(Auth::user()->role . '/about'))->with('success', 'Profil berhasil diperbarui');
    }
}
