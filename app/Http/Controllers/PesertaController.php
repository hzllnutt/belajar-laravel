<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;

class PesertaController extends Controller
{
    //
    public function index()
    {
        //GET
        //select * from peserta
        $pesertas = Peserta::get();
        $title = "Data Peserta";
        return view('peserta.index', compact('pesertas', 'title'));
    }

    public function create()
    {
        $title = 'Tambah Peserta Baru';
        return view('peserta.create', compact('title'));
    }

    //post
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'email' => 'required|email|unique:pesertas,email',
            'umur' => 'required',
            'address' => 'nullable'
        ]);
        //INSERT INTO pesertas () VALUES ()
        Peserta::create([
            'name' => $request->nama,
            'email' => $request->email,
            'age' => $request->umur,
            'address' => $request->address
        ]);
        return redirect()->to('peserta');
    }
    
    public function edit(string $id) 
    {
        $title = 'Edit';
        //select * from pesertas WHERE id=$id
        $peserta = Peserta::find($id);
        return view('peserta.edit', compact('peserta', 'title'));
    }

        public function update(string $id, Request $request) 
    {
        //select * from pesertas WHERE id=$id
        $peserta = Peserta::findOrFail($id);
        $peserta->name = $request->nama;
        $peserta->age = $request->umur;
        $peserta->email = $request->email;
        $peserta->address = $request->address;
        $peserta->save();

        return redirect()->to('peserta');
    }

        public function delete(string $id) 
    {
        //select * from pesertas WHERE id=$id
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();


        return redirect()->to('peserta');
    }

}