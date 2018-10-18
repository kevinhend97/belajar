<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\Barang;
use App\Pelanggan;
use App\DetailPenjualan;
use Carbon\Carbon;

class PiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('piutang.index');
    }

    public function listData()
   {
   
     $penjualan = Penjualan::leftJoin('users', 'users.id', '=', 'penjualan.id_user')
        ->select('users.*', 'penjualan.*', 'tgl_tempo')
        ->where('status', '=', 'Kredit')
        ->orderBy('penjualan.id_penjualan', 'desc')
        ->get();
     $no = 0;
     $data = array();

     foreach($penjualan as $list){
       $no ++;
       $row = array();
       $row[] = $no;
       $row[] = $list->kode_penjualan;
       $row[] = tanggal_indonesia($list->tgl_tempo);
       $row[] = $list->kode_pelanggan;
       $row[] = $list->total_item;
       $row[] = "Rp. ".format_uang($list->total_harga, false);
       $row[] ="Rp. ".format_uang($list->piutang);
       $row[] = "Rp. ".format_uang($list->diterima);
       $row[] = $list->name;
       $row[] = '<div class="btn-group">
               <a onclick="showDetail('.$list->id_penjualan.')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
               <a onclick="editForm('.$list->id_penjualan.')" class="btn btn-success btn-sm"><i class="fa fa-money"></i></a>
               <a onclick="deleteData('.$list->id_penjualan.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
              </div>';
       $data[] = $row;
     }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = DetailPenjualan::leftJoin('barang', 'barang.kode_barang', '=', 'detail_penjualan.kode_barang')
        ->where('id_penjualan', '=', $id)
        ->get();
        $no = 0;
        $data = array();
        foreach($detail as $list){
           $no ++;
           $row = array();
           $row[] = $no;
           $row[] = $list->kode_barang;
           $row[] = $list->nama_barang;
           $row[] = "Rp. ".format_uang($list->harga_jual);
           $row[] = $list->jumlah;
           $row[] = "Rp. ".format_uang($list->sub_total);
           $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $piutang = Penjualan::find($id);
      echo json_encode($piutang);
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
        $penjualan = Penjualan::find($id);
        $penjualan->diterima += $request['bayar'];
        if ($request['bayar'] > $penjualan->piutang) 
        {
          $bayarUtang = ($penjualan->diterima - $penjualan->diterima) + ($request['bayar'] - $penjualan->piutang);
          $penjualan->piutang -= $bayarUtang;
        }
        else if($request['bayar'] <= $penjualan->piutang)
        {
          $penjualan->piutang -= $request['bayar'];
        }
        if ($penjualan->diterima >= $penjualan->bayar) {
          $penjualan->status = "Lunas";
        }
        $penjualan->update(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        $penjualan->delete();

        $detail = DetailPenjualan::where('id_penjualan', '=', $id)->get();
        foreach($detail as $data){
            $produk = Barang::where('kode_barang', '=', $data->kode_barang)->first();
            $produk->qty += $data->jumlah;
            $produk->update();
            $data->delete();
        }
    }
}
