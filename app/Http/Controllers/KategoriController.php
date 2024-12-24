<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index(Request $request)
    {
        // Cek apakah pengguna adalah admin
        $isAdmin = Auth::user() && Auth::user()->role === 'admin';

        // Query parameter pencarian
        $query = $request->get('query');

        // Filter data berdasarkan role
        $kategori = Kategori::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('nama_kategori', 'like', "%{$query}%")
                ->orWhere('keterangan', 'like', "%{$query}%");
        })
        ->when(!$isAdmin, function ($queryBuilder) {
            // Jika bukan admin, hanya tampilkan kategori yang dibuat oleh user tersebut
            return $queryBuilder->where('user_id', Auth::id());
        })
        ->paginate(5);

        // Jika request adalah AJAX, render tabel saja
        if ($request->ajax()) {
            return view('kategori.tabel', compact('kategori'))->render();
        }

        // Jika bukan AJAX, render halaman utama
        return view('kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message=[
            'unique'=>':attribute sudah digunakan',
            'required'=>':attribute tidak boleh kosong',
        ];
        $request->validate([
            'nama_kategori' => 'required|unique:kategori',
            'keterangan' => 'required',
        ], $message);

        $kategori = new Kategori();

        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->keterangan = $request->keterangan;

        $kategori->user_id = Auth::id();
        $kategori->save();

        $redirectUrl = url(Auth::user()->role . '/kategori');

        return redirect($redirectUrl)->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        // Redirect ke URL berdasarkan role pengguna
        $redirectUrl = url(Auth::user()->role . '/kategori/edit/' . $id);

        return view('kategori.edit', compact('kategori'))->with('redirectUrl', $redirectUrl);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $message = [
            'unique' => ':attribute sudah digunakan',
            'required' => ':attribute tidak boleh kosong',
        ];
        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori,' . $id . ',id_kategori',
            'keterangan' => 'required',
        ], $message);

        $kategori = Kategori::findOrFail($id);

        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->keterangan = $request->keterangan;
        $kategori->user_id = Auth::id();
        $kategori->update();

        $redirectUrl = url(Auth::user()->role . '/kategori');

        return redirect($redirectUrl)->with('success', 'Kategori berhasil diupdate');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id)->delete();
        $redirectUrl = url(Auth::user()->role . '/kategori');

        return redirect($redirectUrl)->with('success', 'Kategori berhasil dihapus');
    }
}
