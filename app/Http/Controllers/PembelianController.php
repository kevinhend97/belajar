<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembelian;
use App\DetailPembelian;
use App\Supplier;
use App\Produk;
use App\Barang;
use Auth;
use Redirect;


class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('pemilik', ['except' => [
            'listData',
            'index',
            'show',
        ]]);
    }

    public function index()
    {
        $supplier = Supplier::all();
        return view('pembelian.index', compact('supplier'));
    }

    public function listData()
    {
        $pembelian = Pembelian::leftJoin('supplier', 'supplier.id_supplier', '=', 'pembelian.id_supplier')->orderBy('pembelian.id_pembelian', 'desc')->get();
        $no = 0;
        $data = array();
        foreach($pembelian as $list)
        {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $list->kode_pembelian;
            $row[] = tanggal_indonesia(substr($list->created_at, 0, 10), false);
            $row[] = $list->nama;
            $row[] = $list->total_item;
            $row[] = "Rp. ".format_uang($list->total_harga);
            $row[] = $list->diskon."%";
            $row[] = "Rp. ".format_uang($list->bayar);
            if (Auth::user()->jabatan == "Pemilik") {
                $row[] = '<div class="btn-group">
                    <a onclick="showDetail('.$list->id_pembelian.')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                    <a onclick="deleteData('.$list->id_pembelian.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                    </div>';
            }
            elseif (Auth::user()->jabatan == "Karyawan") {
                $row[] = '<div class="btn-group">
                    <a onclick="showDetail('.$list->id_pembelian.')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                    </div>';
            }
            

            $data[] = $row;
        }
        $output =array("data" => $data);
        return response()->json($output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pembelian = new Pembelian;
        $pembelian->id_supplier = $id;
        $pembelian->kode_pembelian = "";
        $pembelian->total_item = 0;
        $pembelian->total_harga = 0;
        $pembelian->diskon = 0;     
        $pembelian->bayar = 0;
        $pembelian->save();

        session(['idpembelian' => $pembelian->id_pembelian]);
        session(['idsupplier' => $id]);

        return Redirect::route('detail_pembelian.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pembelian = Pembelian::find($request['idpembelian']);
        $pembelian->kode_pembelian = $request['kodepembelian'];
        $pembelian->total_item = $request['totalitem'];
        $pembelian->total_harga = $request['total'];
        $pembelian->diskon = $request['diskon'];
        $pembelian->bayar = $request['bayar'];
        $pembelian->update();

        $detail = DetailPembelian::where('id_pembelian', '=', $request['idpembelian'])->get();

        foreach($detail as $data)
        {
            $barang = Barang::where('kode_barang', '=', $data->kode_barang)->first();
            $barang->qty += $data->jumlah;
            $barang->update();
        }

        return Redirect::route('pembelian.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = DetailPembelian::leftJoin('barang', 'barang.kode_barang', '=', 'detail_pembelian.kode_barang')->where('id_pembelian', '=', $id)->get();

        $no = 0;
        $data = array();
        foreach($detail as $list)
        {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $list->kode_barang;
            $row[] = $list->nama_barang;
            $row[] = "Rp. ".format_uang($list->harga_beli);
            $row[] = $list->jumlah;
            $row[] = "Rp. ".format_uang($list->harga_beli * $list->jumlah);

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
        $pembelian = Pembelian::find($id);
        $pembelian->delete();

        $detail = DetailPembelian::where('id_pembelian', '=', $id)->get();

        foreach ($detail as $data) {
            $barang = Barang::where('kode_barang', '=', $data->kode_barang)->first();
            $barang->qty -= $data->jumlah;
            $barang->update();
            $data->delete(); 
        }
    }
}
