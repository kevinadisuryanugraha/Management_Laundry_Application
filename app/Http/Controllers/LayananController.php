<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::all();
        return view('admin.layanan.index', compact('layanans'));
    }

    public function create()
    {
        return view('admin.layanan.create');
    }

    public function show($id)
    {
        //
    }

    public function store(Request $request)
    {
        $rulles = [
            'nama_layanan' => ['required'],
            'harga' => ['required', 'numeric'],
            'satuan' => ['required'],
            'deskripsi' => ['required'],
        ];

        $validators = Validator::make($request->all(), $rulles);

        if ($validators->fails()) {
            return back()->withErrors($validators)->withInput()
                ->with('error', 'Data gagal disimpan, cek inputan!');
        }

        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'harga' => $request->harga,
            'satuan' => $request->satuan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->to(path: 'layanan/index')->with('success', 'Data berhasil disimpan!');
    }

    public function softDelete(string $id)
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            return redirect()->to('layanan/index')->with('error', 'Data tidak ditemukan!');
        }

        $layanan->delete();
        return redirect()->to('layanan/index')->with('success', 'Data berhasil dihapus sementara!');
    }

    public function indexRestore()
    {
        $layanan_r = Layanan::onlyTrashed()->get();
        return view('admin.layanan.restore.restore', compact('layanan_r'));
    }

    public function restore(string $id)
    {
        $layanan = Layanan::withTrashed()->find($id);

        if (!$layanan) {
            return redirect()->to('layanan/index')->with('error', 'Data tidak ditemukan!');
        }

        $layanan->restore();
        return redirect()->to('layanan/index')->with('success', 'Data berhasil direstore!');
    }


    public function edit(string $id)
    {
        $layanan = Layanan::find($id);
        return view('admin.layanan.edit', compact('layanan'));
    }

    public function update(Request $request, string $id)
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            return redirect()->to('layanan/index')->with('error', 'Data tidak ditemukan!');
        }

        $rulles = [
            'nama_layanan' => ['required'],
            'harga' => ['required', 'numeric'],
            'satuan' => ['required'],
            'deskripsi' => ['required', 'string'],
        ];

        $validators = Validator::make($request->all(), $rulles);

        if ($validators->fails()) {
            return back()->withErrors($validators)->withInput()
                ->with('error', 'Data gagal diupdate, cek inputan!');
        }

        $layanan->update($request->all());

        return redirect()->to('layanan/index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $layanan = Layanan::withTrashed()->find($id);

        if (!$layanan) {
            return redirect()->to('layanan/index')->with('error', 'Data tidak ditemukan!');
        }

        $layanan->forceDelete();
        return redirect()->to('layanan/index')->with('success', 'Data berhasil dihapus permanen!');
    }
}
