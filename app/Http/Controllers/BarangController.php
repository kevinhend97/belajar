<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\Kategori;
use App\Satuan;
use DataTables;
use App\AutoNumber;
use Auth;
use PDF;

class BarangController extends Controller
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
        ]]);
    }

    public function getNewInvoiceNo()
    {
        $table="barang";
        $primary="kode_barang";
        $prefix="BRG-";
        $kodeBarang=Autonumber::autonumber($table,$primary,$prefix);
        echo json_encode($kodeBarang);
    }

    public function index()
    {
        $kategori = Kategori::all();
        $satuan = Satuan::all();
        return view('barang.index', compact('kategori', 'satuan', 'kode_otomatis'));
    }

    //mengambil data ajax
    public function listData()
    {
        $barang = Barang::leftJoin('kategori', 'kategori.id_kategori', '=', 'barang.id_kategori')
                    ->leftJoin('satuan', 'satuan.id_satuan', '=', 'barang.id_satuan')
                    ->orderBy('barang.kode_barang','asc')->get();
        $no = 0;
        $data = array();
        foreach($barang as $list)
        {
            $no ++;
            $row = array();
            if (Auth::user()->jabatan == "Pemilik") {
                $row[] = "<input type='checkbox' name='id[]' value=".$list->id_barang."'>";
            }
            $row[] = $no;
            $row[] = $list->kode_barang;
            $row[] = $list->nama_barang;
            $row[] = $list->nama_kategori;
            $row[] = $list->merk;
            $row[] = $list->qty;
            $row[] = $list->nama_satuan;
            $row[] = "Rp ".format_uang($list->harga_beli);
            $row[] = "Rp ".format_uang($list->harga_jual);
            if(Auth::user()->jabatan == "Pemilik"){
            $row[] = '<div class="btn-group"> 
               <a onclick="editForm('.$list->id_barang.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a> 

               <a onclick="deleteData('.$list->id_barang.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
            }

            $data[] = $row;   
        }
        return DataTables::of($data)->escapeColumns([])->make(true);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jumlah = Barang::where('nama_barang', '=', $request['nama_barang'])->count();
        if ($jumlah < 1) {
            $tambah = new Barang;
            $tambah->kode_barang = $request['kode_barang'];
            $tambah->nama_barang = $request['nama_barang'];
            $tambah->id_kategori = $request['kategori'];
            $tambah->merk = $request['merk'];
            $tambah->qty = $request['qty'];
            $tambah->wajib_beli = $request['batas1'];
            $tambah->batas_habis = $request['batas2'];
            $tambah->id_satuan = $request['satuan'];
            $tambah->harga_beli = $request['harga_beli'];
            $tambah->harga_jual = $request['harga_jual'];
            $tambah->save();    
            echo json_encode(array('msg'=>'success'));
        }
        else
        {
            echo json_encode(array('msg'=>'error'));
        }
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
        $barang = Barang::find($id);
        echo json_encode($barang);
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
        $ubah = Barang::find($id);
        $jumlah = Barang::where('nama_barang', '=', $request['nama_barang'])->count();
        if ($jumlah < 1) {
            $ubah->nama_barang = $request['nama_barang'];
            $ubah->id_kategori = $request['kategori'];
            $ubah->merk = $request['merk'];
            $ubah->qty = $request['qty'];
            $ubah->id_satuan = $request['satuan'];
            $ubah->harga_beli = $request['harga_beli'];
            $ubah->harga_jual = $request['harga_jual'];
            $ubah->update();
            echo json_encode(array('msg' => 'success'));
        }
        else
        {
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
        $barang = Barang::find($id);
        $barang->delete();
    }

     public function deleteSelected(Request $request)
    {
        foreach($request['id'] as $id){
            $barang = Barang::find($id);
            $barang->delete();
        }
    }

    public function makePDF()
    {
        $tanggal = date('dmY');
        $tanggalKertas = date('d-m-Y');
        $barang = Barang::leftJoin('kategori', 'kategori.id_kategori', '=', 'barang.id_kategori')
        ->leftJoin('satuan', 'satuan.id_satuan', '=', 'barang.id_satuan')
        ->orderBy('barang.kode_barang','asc')->get();

        $no = 0;
        $pdf = PDF::loadView('barang.pdf', compact('barang', 'no', 'tanggalKertas'));
        $pdf->setPaper('a4', 'portait');

        return $pdf->stream('Laporan Barang'.$tanggal.'.pdf');
    }
}
