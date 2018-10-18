<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Penjualan;
use App\Barang;
use App\Pelanggan;
use App\DetailPenjualan;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('penjualan.index');
    }

    public function listData()
   {
   
     $penjualan = Penjualan::leftJoin('users', 'users.id', '=', 'penjualan.id_user')
        ->select('users.*', 'penjualan.*', 'penjualan.created_at as tanggal')
        ->where('status', '=', 'Lunas')
        ->orderBy('penjualan.id_penjualan', 'desc')
        ->get();
     $no = 0;
     $data = array();

     foreach($penjualan as $list){
       $no ++;
       $row = array();
       $row[] = $no;
       $row[] = $list->kode_penjualan;
       $row[] = tanggal_indonesia(substr($list->tanggal, 0, 10), false);
       $row[] = $list->kode_pelanggan;
       $row[] = $list->total_item;
       $row[] = "Rp. ".format_uang($list->total_harga);
       $row[] = $list->diskon."%";
       $row[] = "Rp. ".format_uang($list->bayar);
       $row[] = $list->name;
       $row[] = '<div class="btn-group">
               <a onclick="showDetail('.$list->id_penjualan.')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
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

    public function saveData(Request $request)
   {
      $penjualan = Penjualan::find($request['idpenjualan']);
      $penjualan->kode_pelanggan = $request['member'];
      $penjualan->total_item = $request['totalitem'];
      $penjualan->total_harga = $request['total'];
      $penjualan->diskon = $request['diskon'];
      $penjualan->bayar = $request['bayar'];
      $penjualan->diterima = $request['diterima'];
      $penjualan->update();

      $detail = DetailPenjualan::where('id_penjualan', '=', $request['idpenjualan'])->get();
      foreach($detail as $data){
        $barang = Barang::where('kode_barang', '=', $data->kode_barang)->first();
        $barang->qty -= $data->jumlah;
        $barang->update();
      }
      return Redirect::route('transaksi.cetak');
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
        //
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
