<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provinsi;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('provinsi.index');
    }

     public function listData()
    {
        $provinsi = Provinsi::orderBy('nama_provinsi', 'asc')->get();
        $no = 0;
        $data = array();
        foreach($provinsi as $list)
        {
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nama_provinsi;
            $row[] = '<div class="btn-group">
               <a onclick="editForm('.$list->id.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
               <a onclick="deleteData('.$list->id.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';

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
        //
        $count = Provinsi::where('nama_provinsi', '=', $request['nama_provinsi'])->count();

        if ($count < 1) 
        {
            # code...
            $tambah = new Provinsi;
            $tambah->nama_provinsi = $request['nama_provinsi'];
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
        //
         $provinsi = Provinsi::find($id);
        echo json_encode($provinsi);
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
        $ubah = Provinsi::find($id);
        $ubah->nama_provinsi = $request['nama_provinsi'];
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
        //
        $provinsi = Provinsi::find($id);
        $provinsi->delete();

    }
}
