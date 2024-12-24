<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Kategori;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Periksa apakah pengguna adalah admin
        $isAdmin = Auth::user() && Auth::user()->role === 'admin';

        // Query untuk arsip per kategori
        $arsipPerKategori = Arsip::leftJoin('kategori', 'arsip.id_kategori', '=', 'kategori.id_kategori')
            ->selectRaw('kategori.nama_kategori as nama, COUNT(*) as total')
            ->groupBy('kategori.nama_kategori');

        if (!$isAdmin) {
            // Filter untuk user biasa: hanya data miliknya
            $arsipPerKategori->where('arsip.user_id', Auth::id());
        }

        // Urutkan data dari total tertinggi ke terendah
            $arsipPerKategori = $arsipPerKategori->orderBy('total', 'desc')->get();

        $kategoriNames = [];
        $totals = [];

        foreach ($arsipPerKategori as $item) {
            $kategoriNames[] = $item->nama ?? 'Tanpa Kategori';
            $totals[] = $item->total;
        }

        // Buat chart dengan LarapexCharts
        $chartArsip = LarapexChart::barChart()
            ->setTitle('Distribusi Arsip per Kategori')
            ->setSubtitle('Jumlah Arsip Berdasarkan Kategori')
            ->addData('Jumlah Arsip', $totals)
            ->setXAxis($kategoriNames)
            ->setToolBar(true)
            ->setDataLabels(true);

        // Data tambahan untuk dashboard
        $data = [
            'totalKategori' => count($kategoriNames), // Total kategori berdasarkan chart
            'totalArsip' => $isAdmin ? Arsip::count() : Arsip::where('user_id', Auth::id())->count(),
            'totalDataHariIni' => Arsip::whereDate('created_at', now())
                ->when(!$isAdmin, function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->count(),
            'totalPengguna' => $isAdmin ? \App\Models\User::count() : 1,
            'chartArsip' => $chartArsip,
        ];

        return view('home.home', $data);
    }

        public function generatePDF()
    {
        $arsipPerKategori = Arsip::leftJoin('kategori', 'arsip.id_kategori', '=', 'kategori.id_kategori')
            ->selectRaw('kategori.nama_kategori as nama, COUNT(*) as total')
            ->groupBy('kategori.nama_kategori')
            ->orderBy('total', 'desc')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('home.laporan', compact('arsipPerKategori'));
        return $pdf->stream('laporan-arsip.pdf');
    }

}
