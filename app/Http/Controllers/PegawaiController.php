<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pegawai;
use DataTables;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = pegawai::get();
        if($request->ajax()) {
            return datatables()->of($data)->addColumn('aksi', function($data){
                $button = "<button class='edit btn btn-primary' id='".$data->id."'>Edit</button>";
                $button .= "<button class='hapus btn btn-danger' id='".$data->id."'>hapus</button>";
                return $button;
            })->rawColumns(['aksi'])->make(true);
        }
        return view('home');
     
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
        $data = new Pegawai();
        $data->nama = $request->nama;
        $data->nip = $request->nip;
        $data->tgl_lahir = $request->tgl_lahir;
        $simpan = $data->save();
        if ($simpan) {
            return response()->json(['data' => $data, 'text' => 'data berhasil disimpan'],200);
        }else{
            return response()->json(['data' => $data, 'text' => 'data berhasil disimpan']);
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
    public function edit(Request $request)
    {
        $id = $request->id;
        $data = pegawai::find($id);
        return response()->json(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $id = $request->id;
        $datas = [
            'nama' => $request->nama,
            'nip' => $request->nip,
            'tgl_lahir' => $request->tgl_lahir
        ];
        $data = pegawai::find($id);
        $simpan =  $data->update($datas);
        if ($simpan) {
            return response()->json(['text' => 'berhasil disimpan'], 200);
        }else{
            return response()->json(['text' => 'gagal disimpan'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $id = $request->id;
        $data = pegawai::find($id);
        $data->delete();
        return response()->json(['text' => 'berhasil dihapus'], 200);
    }
}
