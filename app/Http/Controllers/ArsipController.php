<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Cek apakah pengguna adalah admin
        $isAdmin = Auth::user() && Auth::user()->role === 'admin';

        // Jika ada parameter pencarian
        $query = $request->get('query');

        $arsip = Arsip::when($query, function($queryBuilder) use ($query) {
            return $queryBuilder->where('nomor_surat', 'like', "%{$query}%")
                ->orWhere('judul', 'like', "%{$query}%")
                ->orWhereHas('kategori', function ($q) use ($query) {
                    $q->where('nama_kategori', 'like', "%{$query}%");
                });
        })
        ->when(!$isAdmin, function ($queryBuilder) {
            // Jika bukan admin, hanya tampilkan arsip milik user
            return $queryBuilder->where('user_id', Auth::id());
        })
        ->paginate(5);

        return view('arsip_surat.index', compact('arsip'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        $role = Auth::user()->role; // Ambil peran pengguna saat ini
        return view('arsip_surat.create', compact('kategori', 'role'));
    }

    public function download(string $id)
    {
        $arsip = Arsip::findOrFail($id); // Gunakan findOrFail untuk validasi
        $redirectUrl = url(Auth::user()->role . '/arsip');

        // Simpan pesan ke dalam session untuk digunakan setelah redirect
        session()->flash('success', 'File berhasil diunduh.');

        // Return file untuk di-download
        return Storage::download($arsip->file_pdf);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message=[
            'unique'=>':attribute sudah digunakan',
            'required'=>':attribute tidak boleh kosong',
            'mimes'=>':attribute harus berformat pdf',
            'max'=>':attribute harus berukuran kurang dari 3mb',
        ];
        $request->validate([
            'no_surat' => 'required|unique:arsip,nomor_surat',
            'kategori' => 'required',
            'judul' => 'required',
            'file_surat' => 'required|file|mimes:pdf|max:3048',
        ], $message);

        $arsip = new Arsip();

        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $fileName = $request->no_surat.'_'.$request->judul.'.pdf';
            $filePath = $file->storeAs('arsip', $fileName, 'public');
            $arsip->file_pdf = $filePath;
        }

        $arsip->nomor_surat = $request->no_surat;
        $arsip->id_kategori = $request->kategori;
        $arsip->judul = $request->judul;
        $arsip->user_id = Auth::id();
        $arsip->save();

        $redirectUrl = url(Auth::user()->role . '/arsip');

        return redirect($redirectUrl)->with('success', 'Arsip berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $arsip = Arsip::findOrFail($id);
        $redirectUrl = url(Auth::user()->role . '/arsip/show'. $id);
        return view('arsip_surat.show', compact('arsip'))->with('redirectUrl', $redirectUrl);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $arsip = Arsip::findOrFail($id);
        $kategori = Kategori::all();

        $redirectUrl = url(Auth::user()->role . '/arsip/edit'. $id);
        return view('arsip_surat.edit', compact('arsip', 'kategori'))->with('redirectUrl', $redirectUrl);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $message=[
            'unique'=>':attribute sudah digunakan',
            'required'=>':attribute tidak boleh kosong',
            'mimes'=>':attribute harus berformat pdf',
            'max'=>':attribute harus berukuran kurang dari 3mb',
        ];
        $request->validate([
            'no_surat' => 'required|unique:arsip,nomor_surat,'. $id .',id_arsip',
            'kategori' => 'required',
            'judul' => 'required',
            'file_surat' => 'nullable|file|max:3048',
        ], $message);
        $arsip = Arsip::findOrFail($id);

        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $fileName = $request->no_surat . '_' . $request->judul.'.pdf';
            $filePath = $file->storeAs('arsip', $fileName, 'public');
            $arsip->file_pdf = $filePath;
        }

        $arsip->nomor_surat = $request->no_surat;
        $arsip->id_kategori = $request->kategori;
        $arsip->judul = $request->judul;
        $arsip->update();
        $redirectUrl = url(Auth::user()->role . '/arsip');

        return redirect($redirectUrl)->with('success', 'Arsip berhasil diupdate');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $arsip = Arsip::findOrFail($id);

        if (Storage::exists($arsip->file_pdf)) {
            Storage::delete($arsip->file_pdf);
            $arsip->delete();
        } else{
            $arsip->delete();
        }
        $redirectUrl = url(Auth::user()->role . '/arsip');
        return redirect($redirectUrl)->with('success', 'Arsip berhasil dihapus');
    }
}
