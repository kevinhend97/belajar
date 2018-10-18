<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\AutoNumber;
use Auth;
use PDF;
use App\Penjualan;
use App\Barang;
use App\Pelanggan;
use App\DetailPenjualan;
use Carbon\Carbon;
use App\Notifications\PeringatanBarangHabis;

class DetailPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::where('qty', '>=', 1)->get();
        $pelanggan = Pelanggan::all();
        $unknown = Pelanggan::where('nama', '=', 'Unknown')->first();
        $tgl = Carbon::now()->format('Y-m-d');

        if(!empty(session('idpenjualan'))){
            $idpenjualan = session('idpenjualan');
            return view('detail_penjualan.index', compact('barang', 'pelanggan', 'idpenjualan', 'tgl', 'unknown'));
        }
        else{
            return Redirect::route('home');  
        }
    }

    public function listData($id)
   {
     $detail = DetailPenjualan::leftJoin('barang', 'barang.kode_barang', '=', 'detail_penjualan.kode_barang')
        ->where('id_penjualan', '=', $id)
        ->get();
     $no = 0;
     $data = array();
     $total = 0;
     $total_item = 0;
     foreach($detail as $list){
       $no ++;
       $row = array();
       $row[] = $no;
       $row[] = $list->kode_barang;
       $row[] = $list->nama_barang;
       $row[] = "Rp. ".format_uang($list->harga_jual);
       $row[] = "<input type='number' id='jml' class='form-control' name='jumlah_$list->id_detail_penjualan' value='$list->jumlah' onChange='changeCount($list->id_detail_penjualan)'>";
       //$row[] = $list->diskon."%";
       $row[] = "Rp. ".format_uang($list->sub_total);
       $row[] = '<div class="btn-group">
               <a onclick="deleteItem('.$list->id_detail_penjualan.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
       $data[] = $row;

       $total += $list->harga_jual * $list->jumlah;
       $total_item += $list->jumlah;
     }

     $data[] = array("<span class='hide total'>$total</span><span class='hide totalitem'>$total_item</span>", "", "", "", "", "", "");
    
     $output = array("data" => $data);
     return response()->json($output);
   }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $barang = Barang::where('id_barang', '=', $request['kode'])->first();

        $detail = new DetailPenjualan;
        $detail->id_penjualan = $request['idpenjualan'];
        $detail->kode_barang = $barang->kode_barang;
        $detail->harga_jual = $barang->harga_jual;
        $detail->jumlah = 1;
        //$detail->diskon = $request['kode'];
        $detail->sub_total = $barang->harga_jual;
        $detail->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nama_input = "jumlah_".$id;
        $detail = DetailPenjualan::find($id);
        $barang = Barang::where('kode_barang', '=', $detail->kode_barang)->first();
        $cekStok = $barang->qty - $request[$nama_input];

        if ($cekStok > 0) {
          $total_harga = $request[$nama_input] * $detail->harga_jual;
          $detail->jumlah = $request[$nama_input];
          $detail->sub_total = $total_harga;
          $detail->update();  
          echo json_encode(array('msg'=>'success'));
        }
        else if ($cekStok <= 0) {
          echo json_encode(array('msg'=>'error'));
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = DetailPenjualan::find($id);
        $detail->delete();
    }

    public function getNewInvoiceNo()
    {
        $table="penjualan";
        $primary="kode_penjualan";
        $prefix="TR-";
        $kodePenjualan=Autonumber::autonumber($table,$primary,$prefix);

        return $kodePenjualan;
    }

    public function saveData(Request $request)
   {
      $piutang = $request['diterima'] - $request['bayar'];
      $bulan = substr($request['tglbayar'], 0, 2);
      $tanggal = substr($request['tglbayar'], 3, 2);
      $tahun = substr($request['tglbayar'], 6, 4);
      $penjualan = Penjualan::find($request['idpenjualan']);
      $penjualan->kode_pelanggan = $request['member'];

      if ($request['diterima'] >= $request['bayar']) {
        $penjualan->status = "Lunas";
      }
      else if($request['diterima'] < $request['bayar'] && empty($request['tanggal']))
      {
        $penjualan->status = "Kredit";
        $penjualan->tgl_tempo = date('Y-m-d');
      }

      $penjualan->total_item = $request['totalitem'];
      $penjualan->total_harga = $request['total'];
      $penjualan->diskon = $request['diskon'];
      $penjualan->bayar = $request['bayar'];

      if($piutang < 0){
        $penjualan->piutang = $piutang * (-1);
      }
      if ($request['status'] == "Kredit") {
       $penjualan->tgl_tempo = $request['tanggal']; 
      }
      
      $penjualan->diterima = $request['diterima'];
      $penjualan->update();

      $detail = DetailPenjualan::where('id_penjualan', '=', $request['idpenjualan'])->get();
      foreach($detail as $data){
        $barang = Barang::where('kode_barang', '=', $data->kode_barang)->first();
        $barang->qty -= $data->jumlah;
        $barang->update();

        //notification
        //auth()->user()->notify(new PeringatanBarangHabis());
      }
      //return Redirect::route('transaksi.cetak');
      return view('detail_penjualan.selesai');
   }

    public function newSession()
    {
      $penjualan = new Penjualan;
      $penjualan->kode_penjualan = $this->getNewInvoiceNo(); 
      $penjualan->kode_pelanggan = 0;    
      $penjualan->total_item = 0;    
      $penjualan->total_harga = 0;
      $penjualan->piutang = 0;       
      $penjualan->bayar = 0;
      $penjualan->diskon = 0;    
      $penjualan->diterima = 0;    
      $penjualan->id_user = Auth::user()->id;    
      $penjualan->save();
      
      session(['idpenjualan' => $penjualan->id_penjualan]);

      return Redirect::route('transaksi.index');    
    }

    public function notaPDF(){
     $detail = DetailPenjualan::leftJoin('barang', 'barang.kode_barang', '=', 'detail_penjualan.kode_barang')
        ->where('id_penjualan', '=', session('idpenjualan'))
        ->get();

      $penjualan = Penjualan::find(session('idpenjualan'));
      $no = 0;
     
     $pdf = PDF::loadView('detail_penjualan.notaPDF', compact('detail', 'penjualan', 'no'));
     $pdf->setPaper(array(0,0,550,440), 'potrait');      
      return $pdf->stream();
    }

    public function loadForm($diskon, $total, $diterima){
     $bayar = $total - ($diskon / 100 * $total);
     $kembali = ($diterima != 0) ? $diterima - $bayar : 0;

     $data = array(
        "totalrp" => format_uang($total),
        "bayar" => $bayar,
        "bayarrp" => format_uang($bayar),
        "terbilang" => ucwords(terbilang($bayar))." Rupiah",
        "kembalirp" => format_uang($kembali),
        "kembaliterbilang" => ucwords(terbilang($kembali))." Rupiah"
      );
     return response()->json($data);
   }

   public function printNota()
   {
      $detail = DetailPenjualan::leftJoin('barang', 'barang.kode_barang', '=', 'detail_penjualan.kode_barang')
        ->where('id_penjualan', '=', session('idpenjualan'))
        ->get();

      $penjualan = Penjualan::find(session('idpenjualan'));
      
        $handle = printer_open(); 
        printer_start_doc($handle, "Nota");
        printer_start_page($handle);

        $font = printer_create_font("Consolas", 100, 80, 600, false, false, false, 0);
        printer_select_font($handle, $font);
        
        printer_draw_text($handle, "Toko Besi Wuni", 400, 100);

        $font = printer_create_font("Consolas", 72, 48, 400, false, false, false, 0);
        printer_select_font($handle, $font);
        printer_draw_text($handle, "Jalan Wuni no.17, RT.02 RW.10", 50, 200);

        printer_draw_text($handle, date('Y-m-d'), 0, 400);
        printer_draw_text($handle, substr("             ".Auth::user()->name, -15), 600, 400);

        printer_draw_text($handle, "No : ".substr("00000000".$penjualan->id_penjualan, -8), 0, 500);

        printer_draw_text($handle, "============================", 0, 600);
        
        $y = 700;
        
        foreach($detail as $list){           
           printer_draw_text($handle, $list->kode_barang." ".$list->nama_barang, 0, $y+=100);
           printer_draw_text($handle, $list->jumlah." x ".format_uang($list->harga_jual), 0, $y+=100);
           printer_draw_text($handle, substr("                ".format_uang($list->harga_jual*$list->jumlah), -10), 850, $y);

           if($list->diskon != 0){
              printer_draw_text($handle, "Diskon", 0, $y+=100);
              printer_draw_text($handle, substr("                      -".format_uang($list->diskon/100*$list->sub_total), -10),  850, $y);
           }
        }
        
        printer_draw_text($handle, "----------------------------", 0, $y+=100);

        printer_draw_text($handle, "Total Harga: ", 0, $y+=100);
        printer_draw_text($handle, substr("           ".format_uang($penjualan->total_harga), -10), 850, $y);

        printer_draw_text($handle, "Total Item: ", 0, $y+=100);
        printer_draw_text($handle, substr("           ".$penjualan->total_item, -10), 850, $y);

        printer_draw_text($handle, "Diskon Member: ", 0, $y+=100);
        printer_draw_text($handle, substr("           ".$penjualan->diskon."%", -10), 850, $y);

        printer_draw_text($handle, "Total Bayar: ", 0, $y+=100);
        printer_draw_text($handle, substr("            ".format_uang($penjualan->bayar), -10), 850, $y);

        printer_draw_text($handle, "Diterima: ", 0, $y+=100);
        printer_draw_text($handle, substr("            ".format_uang($penjualan->diterima), -10), 850, $y);

        printer_draw_text($handle, "Kembali: ", 0, $y+=100);
        printer_draw_text($handle, substr("            ".format_uang($penjualan->diterima-$penjualan->bayar), -10), 850, $y);
        

        printer_draw_text($handle, "============================", 0, $y+=100);
        printer_draw_text($handle, "-= TERIMA KASIH =-", 250, $y+=100);
        printer_delete_font($font);
        
        printer_end_page($handle);
        printer_end_doc($handle);
        printer_close($handle);
       
      return view('penjualan_detail.selesai');
   }

}
