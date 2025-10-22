<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Roles::all(); // model pake di ujung nya
        $title = 'Management Role';
        return view('admin.role.index', compact('title', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorie = Roles::all();
        $title = 'Tambah Management Role';
        return view('admin.role.create', compact('title', 'categorie'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Roles::create([
            'name' => $request->name
        ]);

        Alert::success('Berhasil!!', 'Data berhasil ditambah!');
        // Alert::success('Berhasil!!', 'Transaksi berhasil di buat');
        return redirect()->to('role');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = Roles::find($id);
        $title = 'Ubah Management Role';
        return view('admin.role.edit', compact('edit', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $roles = Roles::find($id);
        $roles->name = $request->name;
        $roles->save();

        Alert::success('Berhail!', 'Data berhasil di ubah!');
        return redirect()->to('role');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Roles::find($id)->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');
        return redirect()->to('role');
    }
}
