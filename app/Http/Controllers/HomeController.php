<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\User;
use Carbon\Carbon;
use app\Kategori;
use App\Supplier;
use App\Barang;
use App\Penjualan;
use Auth;
use App\Pelanggan;
use App\DetailPenjualan;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
        

    public function index()
    {
        //MembuT Grafik
        $awal = date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y')));
        $akhir = date('Y-m-d');
        $tanggal2 = $awal;
        $data_tanggal = array();
        $data_pendapatan = array();

        while (strtotime($tanggal2) <= strtotime($akhir)) {
            $data_tanggal[] = (int)substr($tanggal2, 8,2);
            $pendapatan = Penjualan::where('created_at', 'LIKE', "$tanggal2%")->sum('bayar');
            $data_pendapatan[] = (int) $pendapatan;
            $tanggal2 = date('Y-m-d', strtotime("+1 day", strtotime($tanggal2)));
        }

        //penghitung top 10 Barang Laris Perbulan
            // $topTen = ;

        //Penghitung Data Penjualan
        $tanggal = Carbon::now()->format('Y-m-d');
        $penjualan = Penjualan::where('created_at', 'LIKE', "$tanggal%")->where('status', '=', 'Lunas');
        
        $peringatanBarangHabis = Barang::where('qty', '=', 'hampir_habis')->orWhere('qty', '=', 'wajib_beli')->get();
        //Penghitung Data pengguna, supplier, barang, dan pelanggan
        $user = User::all();
        $supplier = Supplier::all();
        $barang = Barang::all();
        $pelanggan = Pelanggan::all();

        $hitungTop = DB::select(DB::raw("SELECT barang.nama_barang, detail_penjualan.kode_barang, detail_penjualan.harga_jual, COUNT(*) AS jumlah FROM barang, detail_penjualan WHERE barang.kode_barang = detail_penjualan.kode_barang GROUP BY detail_penjualan.kode_barang, barang.nama_barang, detail_penjualan.harga_jual ORDER BY jumlah DESC LIMIT 10"));
        


        //Bagian Tampil pada Halaman Utama
        if (Auth::user()->jabatan == "Pemilik") {
            return view('Master.main', compact('user', 'supplier', 'barang', 'pelanggan', 'penjualan', 'peringatanBarangHabis', 'awal', 'akhir', 'data_pendapatan', 'data_tanggal', 'hitungTop'));
        }
        else if (Auth::user()->jabatan == "Kasir") {
            return view('Master.kasir');
        }
        else if (Auth::user()->jabatan == "Karyawan") {
            return view('Master.karyawan');
        }

        
    }
}
