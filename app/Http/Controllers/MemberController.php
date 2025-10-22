<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf; // gunakan Facade, bukan class PDF biasa
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::all();
        return view('admin.member.index', compact('members'));
    }

    public function laporan(Request $request)
    {
        $query = Member::query();

        // Filter berdasarkan tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $members = $query->orderBy('created_at', 'desc')->get();

        return view('admin.member.index', compact('members'));
    }

    /**
     * Cetak PDF member, bisa menggunakan filter tanggal.
     */
    public function cetak(Request $request)
    {
        $query = Member::query();

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $members = $query->orderBy('created_at', 'desc')->get();

        // Gunakan Facade statik, jangan pakai "new Pdf()"
        $pdf = Pdf::loadView('admin.member.laporan_pdf', compact('members'));

        return $pdf->download('laporan-member.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastId = DB::table('members')->max('id') ?? 0;
        $newId = $lastId + 1;

        $pref = 'MEMBER';
        $date = now()->format('d-m-Y');
        $counter = str_pad($newId, 5, '0', STR_PAD_LEFT);
        $code = "{$pref}-{$date}-{$counter}";

        return view('admin.member.create', compact('code'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rulles = [
            'nomor_member' => ['required'],
            'nik' => ['required', 'numeric'],
            'nama_member' => ['required'],
            'no_hp' => ['required', 'unique:members'],
            'email' => ['required', 'unique:members'],
        ];

        $validators = Validator::make($request->all(), $rulles);

        if ($validators->fails()) {
            return back()->withErrors($validators)->withInput()
                ->with('error', 'Data gagal disimpan, cek inputan!');
        }

        Member::create([
            'nomor_member' => $request->nomor_member,
            'nik' => $request->nik,
            'nama_member' => $request->nama_member,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
        ]);

        return redirect()->route('member.index')->with('success', 'Data berhasil disimpan!');
    }

    public function softDelete(string $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return redirect()->route('member.index')->with('error', 'Data tidak ditemukan!');
        }

        $member->delete();
        return redirect()->route('member.index')->with('success', 'Data berhasil dihapus sementara!');
    }

    public function indexRestore()
    {
        $member_r = Member::onlyTrashed()->get();
        return view('admin.member.restore.restore', compact('member_r'));
    }

    public function restore(string $id)
    {
        $member = Member::withTrashed()->find($id);

        if (!$member) {
            return redirect()->route('member.index')->with('error', 'Data tidak ditemukan!');
        }

        $member->restore();
        return redirect()->route('member.index')->with('success', 'Data berhasil direstore!');
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
        //IBARATNYA : SELECT * FROM members WHERE id = $id
        $member = Member::find($id);
        return view('admin.member.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return redirect()->route('member.index')->with('error', 'Data tidak ditemukan!');
        }

        $rulles = [
            'nomor_member' => ['required'],
            'nik' => ['required', 'numeric'],
            'nama_member' => ['required'],
            'no_hp' => ['required'],
            'email' => ['required'],
        ];

        $validators = Validator::make($request->all(), $rulles);

        if ($validators->fails()) {
            return back()->withErrors($validators)->withInput()
                ->with('error', 'Data gagal diupdate, cek inputan!');
        }

        $member->update($request->all());

        return redirect()->route('member.index')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = Member::withTrashed()->find($id);

        if (!$member) {
            return redirect()->route('member.index')->with('error', 'Data tidak ditemukan!');
        }

        $member->forceDelete();
        return redirect()->route('member.index')->with('success', 'Data berhasil dihapus permanen!');
    }
}
