<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Pembelian;
use App\Supplier;
use App\Barang;
use App\DetailPembelian;


class DetailPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();
        $idPembelian = session('idpembelian');
        $supplier = Supplier::find(session('idsupplier'));
        return view('detail_pembelian.index', compact('barang', 'idPembelian', 'supplier'));
    }

    public function listData($id)
    {
        $detail = DetailPembelian::leftJoin('barang', 'barang.kode_barang', '=', 'detail_pembelian.kode_barang')
        ->where('id_pembelian', '=', $id)
        ->get();

        $no = 0;
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach($detail as $list)
        {
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = $list->kode_barang;
            $row[] = $list->nama_barang;
            $row[] = "Rp. ".format_uang($list->harga_beli);
            $row[] = "<input type='number' class='form-control' name='jumlah_$list->id_detail_pembelian' value='$list->jumlah' onChange='changeCount($list->id_detail_pembelian)'>";
            $row[] = "Rp. ".format_uang($list->harga_beli * $list->jumlah);
            $row[] = '<a onclick="deleteItem('.$list->id_detail_pembelian.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            $data[] = $row;

            $total += $list->harga_beli * $list->jumlah;
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
        $detail = new DetailPembelian;
        $detail->id_pembelian = $request['idpembelian'];
        $detail->kode_barang = $barang->kode_barang;
        $detail->harga_beli = $barang->harga_beli;
        $detail->jumlah = 1;
        $detail->sub_total = $barang->harga_beli;
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
        $detail = DetailPembelian::find($id);
        $detail->jumlah = $request[$nama_input];
        $detail->sub_total = $detail->harga_beli * $request[$nama_input];
        $detail->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = DetailPembelian::find($id);
        $detail->delete();
    }

    public function loadForm($diskon, $total){
     $bayar = $total - ($diskon / 100 * $total);
     $data = array(
        "totalrp" => format_uang($total),
        "bayar" => $bayar,
        "bayarrp" => format_uang($bayar),
        "terbilang" => ucwords(terbilang($bayar))." Rupiah"
      );
     return response()->json($data);
   }
}
