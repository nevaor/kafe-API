<?php

namespace App\Http\Controllers;

use App\Models\Kafe;
use Illuminate\Http\Request;
//import
use App\Helpers\ApiFormatter;
use Exception;


class KafeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //ambil data dari key search nama bagian paramps nya postman
        $search = $request->nama;
        //ambil daata dari key limit bagian params nya potsman 
        $limit = $request->limit;
        //cari data berdasarkan searxh
        $Kafes = Kafe::where('nama','LIKE','%'.$search.'%')->limit($limit)->get();
        //ambil semua data melalui model
        if ($Kafes){
            return ApiFormatter::createAPI(200, 'success', $Kafes);
        }else{
            return ApiFormatter::createAPI(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a Kafe created resource in storage.
     */
    public function store(Request $request)
    {
    try{
        $request->validate([
            'nama' => 'required|min:3',
            'pesanan' => 'required',
            'level' => 'required',
            'jumlah' => 'required',
            'tanggal_pembelian' => 'required',
        ]);
 //ngirim data baru ke table Students lewat model Student
        $Kafes = Kafe::create([
            'nama' => $request->nama,
            'pesanan' => $request->pesanan,
            'level' => $request->level,
            'jumlah' => $request->jumlah,
            'tanggal_pembelian' => now(),
        ]);
        //cari data baru yng berhasil di simpen cari berdasarkan id lewat data id dari $Kafes yang di atas
        $hasilTambahData = Kafe::where('id', $Kafes->id)->first();
        if ($hasilTambahData){
            return ApiFormatter::createAPI(200, 'succes', $Kafes);
        }else {
            return ApiFormatter::createAPI(400, 'failed');
        }
    }catch(Exception $error) {
        //munculin deskripsi error 
        return ApiFormatter::createAPI(400, 'error', $error->getMessage());
    }
}

    public function createToken()
    {
        return csrf_token();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //cobalah baris kode di dalam try
        try{
            //ambil data dari table Student yang id nya samakaya $id dari path routnya
            $Kafes = Kafe::find($id);
            if($Kafes){
                //kalau data berhasil di ambil tampilkan data dari $Kafes nya dengan tanda status code 200
                return ApiFormatter::createAPI(200,'success', $Kafes);
            }else {
                //kalau data gagal di ambil / data gada yang dikembalikan status code 400 
                return ApiFormatter::createAPI(400, 'failed');
            }
        }catch (Exception $error) {
            //kalau pas try ada error,deskripsi error nya di tampilin dengan status code 400
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kafe $Kafes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        try {
            $request->validate([
                'nama' => 'required|min:3',
                'pesanan' => 'required',
                'level' => 'required',
                'jumlah' => 'required',
                'tanggal_pembelian'=>'required',
            ]);
            //ambil data yang akan di ubah
            $Kafes = Kafe::find($id);
            //update data yang telah di ambil di atas
            $Kafes->update([
                'nama' => $request->nama,
                'pesanan' => $request->pesanan,
                'level' => $request->level,
                'jumlah' => $request->jumlah,
                'tanggal_pembelian'=> \Carbon\Carbon::parse($request->tanggal_pembelian)->format('Y-m-d'),
            ]);
            $dataTerbaru = Kafe::where('id', $Kafes->id)->first();
            if ($dataTerbaru){
                //jika update berhasil tampilkan dari updateStudent di atas data (data yang sudah berhasil di ubah)
                return ApiFormatter::createAPI(200, 'success',$dataTerbaru);
            }else {
                //kalau data gagal di ambil / data gada yang dikembalikan status code 400 
                return ApiFormatter::createAPI(400, 'failed');
            }

        }catch(Exception $error){
            //jika di baris kode try ada troble error di munculkn dengan desc data error yang dengan status kode 400
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            //ambil data yg mau dihapus
            $Kafes = Kafe::find($id);
            //hapus data yg diambil diatas
            $cekBerhasil = $Kafes->delete();
            if ($cekBerhasil) {
                //kalau berhasil hapus, data yg dimuculin teks konfirm dengan status code 200
                return ApiFormatter::createAPI(200, 'success', 'Data terhapus');
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }catch (Exception $error) {
            //kalau ada trouble di baris kode dalem try, error decs nya dimunculin
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
}
    }

public function trash()
{
    try{
        //ambil data yang sudah di hapus sementara
        $Kafes = Kafe::onlyTrashed()->get();
        if($Kafes){
            //kalau data berhasil tertampil tampilkan status dengan data dari  Kafe
            return ApiFormatter::createAPI(200, 'succsess', $Kafes);
        }else {
            return ApiFormatter::createAPI(400, 'failed');
        }
    }catch(Exception $error){
        //jika di baris kode try ada troble error di munculkn dengan desc data error yang dengan status kode 400
        return ApiFormatter::createAPI(400, 'error', $error->getMessage());
    
    }
}
public function restore($id)
{
    try{
        //ambil data yang akan di batal hapus di ambil berdasarkan id dari route nya
        $Kafes = Kafe::onlyTrashed()->where('id',$id);
        //kembalikan data
        $Kafes->restore();
        //ambil kembali data yang sudah di restore
        $dataKembali = Kafe::where('id',$id)->first();
        if('$dataKembali'){
            return ApiFormatter::createAPI(200, 'succsess', $dataKembali);
        }else {
            return ApiFormatter::createAPI(400, 'failed');
        }
    }catch (Exception $error){
        return ApiFormatter::createAPI(400, 'error', $error->getMessage());
    }
}

public function permanentDelete($id)
{
    try{
        //ambil data yang akan di hapus
        $Kafes = Kafe::onlyTrashed()->where('id',$id);
        //hapus permanent data yang di ambil
        $proses = $Kafes->forceDelete();
        if('prosess'){
            return ApiFormatter::createAPI(200, 'succsess','berhasil hapus permanen!');
        }else {
            return ApiFormatter::createAPI(400, 'failed');
        }
    }catch (Exception $error){
        return ApiFormatter::createAPI(400, 'error', $error->getMessage());
    }
}
}