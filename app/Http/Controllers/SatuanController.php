<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Satuan;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('satuan.index');
    }

    public function listData()
    {
        $satuan =Satuan::orderBy('nama_satuan', 'asc')->get();
        $no = 0;
        $data = array();
        foreach($satuan as $list)
        {
            $no ++;
            $row = array();
            $row[] = "<input type='checkbox' name='id[]' value=".$list->id_satuan."'>";
            $row[] = $no;
            $row[] = $list->nama_satuan;
            $row[] = '<div class="btn-group">
               <a onclick="editForm('.$list->id_satuan.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
               <a onclick="deleteData('.$list->id_satuan.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';

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
        $hitung = Satuan::where('nama_satuan', '=', $request['nama_satuan'])->count();
        if ($hitung < 1) {
        
            $tambah = new Satuan;
            $tambah->nama_satuan = $request['nama_satuan'];
            $tambah->save();    
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
        $satuan = Satuan::find($id);
        echo json_encode($satuan);
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
        $ubah = Satuan::find($id);
        $ubah->nama_satuan = $request['nama_satuan'];
        $ubah->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $satuan = Satuan::find($id);
        $satuan->delete();
    }

    public function deleteSelected(Request $request)
    {
        foreach($request['id'] as $id){
            $satuan = Satuan::find($id);
            $satuan->delete();
        }
    }
}
