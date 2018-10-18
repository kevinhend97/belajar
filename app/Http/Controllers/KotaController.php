<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provinsi;
use App\Kota;
use DataTables;

class KotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinsi = Provinsi::all();
        return view('kota.index', compact('provinsi'));
    }

    public function listData()
    {
        $kota = Kota::leftJoin('provinsi', 'provinsi.id', '=', 'kota.provinsi_id')->orderBy('kota.provinsi_id','asc')->get();
        $no = 0;
        $data = array();
        foreach($kota as $list)
        {
            $no ++;
            $row = array();
            $row[] = "<input type='checkbox' name='id[]' value=".$list->id_kota."'>";
            $row[] = $no;
            $row[] = $list->nama_provinsi;
            $row[] = $list->nama_kota;
            $row[] = '<div class="btn-group">
               <a onclick="editForm('.$list->id_kota.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
               <a onclick="deleteData('.$list->id_kota.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';

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
        $jml = Kota::where('nama_kota', '=', $request['nama_kota'])->count();

        if($jml < 1) //cek data yang sudah pernah dibuat berdasarkan nama
        {
            $kota = new Kota;
            $kota->provinsi_id = $request['provinsi'];
            $kota->nama_kota = $request['nama_kota'];
            $kota->save();
            echo json_encode(array('msg'=>'success'));
        }
        else
        {
            echo json_encode(array(['msg'=>'errors']));   
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
        //
        $kota = Kota::find($id);
        echo json_encode($kota);
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
        $kota = Kota::find($id);
        $kota->provinsi_id = $request['provinsi'];
        $kota->nama_kota = $request['nama_kota'];
        $kota->update();
        echo json_encode(array(['msg'=>'success']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $kota = Kota::find($id);
        $kota->delete();
    }

     public function deleteSelected(Request $request)
    {
        foreach($request['id'] as $id){
            $kota = Kota::find($id);
            $kota->delete();
        }
    }
}
