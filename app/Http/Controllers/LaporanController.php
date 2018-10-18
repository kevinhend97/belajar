<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembelian;
use App\Penjualan;
use Carbon\Carbon;
use PDF;

class LaporanController extends Controller
{
    public function index($jenis)
    {
    	$awal = date('Y-m-d', mktime(0,0,0,date('m'), 1, date('Y')));
    	$akhir = date('Y-m-d');
        $judul = $jenis;
        if ($jenis == "Pembelian") {
            return view('laporan.pembelian', compact('awal', 'akhir', 'judul'));
        }
        else if($jenis == "Penjualan")
        {
            return view('laporan.penjualan', compact('awal', 'akhir', 'judul'));
        }
        else if($jenis == "Pendapatan")
        {
            return view('laporan.pendapatan', compact('awal', 'akhir', 'judul'));
        }
    	
    }

    protected function getData($awal, $akhir, $judul)
    {
    	$no = 0;
    	$data = array();
        $total = 0;
        $jumlah_item = 0;
        $pendapatan = 0;
        $total_pendapatan = 0;

        if ($judul == "Pembelian") {
            while(strtotime($awal) <= strtotime($akhir))
            {
                $tanggal = $awal;
                $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));
                
                    $pembelian = Pembelian::where('created_at', 'LIKE', "$tanggal%")->sum('bayar');
                    $total_item = Pembelian::where('created_at', 'LIKE', "$tanggal%")->sum('total_item');
                    $total += $pembelian;
                    $jumlah_item += $total_item;

                        $no++;
                        $row = array();
                        $row[] = $no;
                        $row[] = tanggal_indonesia($tanggal, false);
                        $row[] = $total_item;
                        $row[] = "Rp. ".format_uang($pembelian);
                        $data[] = $row;
            }
        
            $data[] = array("<b>Total<b>","", "<b>".$jumlah_item."<b>", "<b>Rp. ".format_uang($total)."<b>");
    	   return $data;
        }
        else if($judul == "Penjualan")
        {
            while(strtotime($awal) <= strtotime($akhir))
            {
                $tanggal = $awal;
                $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));
                    $penjualan = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('bayar');
                    $total_item = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('total_item');
                    $total += $penjualan;
                    $jumlah_item += $total_item;

                        $no++;
                        $row = array();
                        $row[] = $no;
                        $row[] = tanggal_indonesia($tanggal, false);
                        $row[] = $total_item;
                        $row[] = "Rp. ".format_uang($penjualan);
                        $data[] = $row;
            }
        
            $data[] = array("<b>Total<b>","", "<b>".$jumlah_item."<b>", "<b>Rp. ".format_uang($total)."<b>");
           return $data;   
        }
        else if($judul == "Pendapatan")
        {
            while(strtotime($awal) <= strtotime($akhir))
            {
                $tanggal = $awal;
                $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));
                $penjualan = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('bayar');
                $pembelian = Pembelian::where('created_at', 'LIKE', "$tanggal%")->sum('bayar'); 
                    
                $pendapatan = $penjualan - $pembelian;
                $total_pendapatan += $pendapatan;

                        $no++;
                        $row = array();
                        $row[] = $no;
                        $row[] = tanggal_indonesia($tanggal, false);
                        $row[] = "Rp. ".format_uang($pembelian);
                        $row[] = "Rp. ".format_uang($penjualan);
                        $row[] = "Rp. ".format_uang($pendapatan);
                        $data[] = $row;
            }
        
            $data[] = array("Total","", "", "", "Rp. ".format_uang($total_pendapatan)."");
           return $data;   
        }
    }

    public function listData($judul, $awal, $akhir )
    {
    	$data = $this->getData($awal, $akhir, $judul);

    	$output = array("data" => $data);
    	return response()->json($output);
    }

    public function refresh(Request $request, $jenis)
    {
    	$awal = $request['awal'];
    	$akhir = $request['akhir'];
        $judul = $request['jenis'];
        if ($judul == "Pembelian") {
            return view('laporan.pembelian', compact('awal', 'akhir', 'judul'));    
        }
        else if ($judul == "Penjualan") {
            return view('laporan.penjualan', compact('awal', 'akhir', 'judul'));
        }
        else if ($judul == "Pendapatan") {
            return view('laporan.pendapatan', compact('awal', 'akhir', 'judul'));
        }
    	
    }

    public function exportPDF($judul, $awal, $akhir){
     $tanggal_awal = $awal;
     $tanggal_akhir = $akhir;
     $jenis = $judul;
     $data = $this->getData($awal, $akhir, $judul);

     $pdf = PDF::loadView('laporan.pdf', compact('jenis', 'tanggal_awal', 'tanggal_akhir', 'data', 'jenis'));
     $pdf->setPaper('a4', 'potrait');
     
     return $pdf->stream();
   }
}
