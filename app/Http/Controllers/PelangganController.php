<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggan;
use App\Provinsi;
use App\Kota;
use App\AutoNumber;
use PDF;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        return view('pelanggan.index', compact('provinsi', 'kota'));
    }

    public function getNewInvoiceNo()
    {
        $table="pelanggan";
        $primary="kode_pelanggan";
        $prefix="PEL-";
        $kodeBarang=Autonumber::autonumber($table,$primary,$prefix);
        echo json_encode($kodeBarang);
    }

    //mengambil data kota
    public function ambilDataKota($id)
    {
        $cities = Kota::where("provinsi_id",$id)->pluck("nama_kota","id_kota");
        return json_encode($cities);
    }

    //mengambil data ajax
    public function listData()
    {
        $pelanggan = Pelanggan::leftJoin('provinsi', 'provinsi.id', '=', 'pelanggan.provinsi_id')
                    ->leftJoin('kota', 'kota.id_kota', '=', 'pelanggan.kota_id')
                    ->orderBy('pelanggan.kode_pelanggan','asc')->get();
        $no = 0;
        $data = array();
        foreach($pelanggan as $list)
        {
            $no ++;
            $row = array();
            $row[] = "<input type='checkbox' name='id[]' value=".$list->id_pelanggan."'>";
            $row[] = $no;
            $row[] = $list->kode_pelanggan;
            $row[] = $list->nama;
            $row[] = $list->telp;
            $row[] = $list->alamat;
            $row[] = $list->nama_kota;
            $row[] = $list->nama_provinsi;
            $row[] = '<div class="btn-group"> 
               <a onclick="editForm('.$list->id_pelanggan.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
               <a onclick="deleteData('.$list->id_pelanggan.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
               <a onclick="showDetail('.$list->id_pelanggan.')" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a></div>';

            $data[] = $row;   
        }
        $output = array("data"=> $data);
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
        $tambah = new Pelanggan;
        $tambah->kode_pelanggan= $request['kode'];
        $tambah->nama= $request['nama'];
        $tambah->alamat= $request['alamat'];
        $tambah->telp= $request['noTelp'];
        $tambah->provinsi_id= $request['provinsi'];
        $tambah->kota_id= $request['kota'];
        $tambah->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pelanggan = Pelanggan::find($id);
        echo json_encode($pelanggan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pelanggan = Pelanggan::find($id);
        echo json_encode($pelanggan);
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
        $ubah = Pelanggan::find($id);
        $ubah->nama= $request['nama'];
        $ubah->alamat= $request['alamat'];
        $ubah->telp= $request['noTelp'];
        $ubah->provinsi_id= $request['provinsi'];
        $ubah->kota_id= $request['kota'];
        $ubah->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = Pelanggan::find($id);
        $hapus->delete();
    }

    public function deleteSelected(Request $request)
    {
        foreach($request['id'] as $id){
            $pelanggan = Pelanggan::find($id);
            $pelanggan->delete();
        }
    }

    public function makePDF()
    {
        $tanggal = date('dmY');
        $pelanggan = Pelanggan::leftJoin('provinsi', 'provinsi.id', '=', 'pelanggan.provinsi_id')
        ->leftJoin('kota', 'kota.id_kota', '=', 'pelanggan.kota_id')->where('nama', '!=', 'Unknown')
        ->orderBy('pelanggan.nama','asc')->get();

        $no = 0;
        $pdf = PDF::loadView('pelanggan.viewPDF', compact('pelanggan', 'no'));
        $pdf->setPaper('a4', 'portait');

        return $pdf->stream('Laporan Pelanggan'.$tanggal.'.pdf');
    }
}
