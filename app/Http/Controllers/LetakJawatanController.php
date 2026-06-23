<?php

namespace App\Http\Controllers;

use App\Models\LetakJawatan;
use App\Models\Pegawai;
use App\Models\Ptj;
use App\Models\Jawatan_Gred;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LetakJawatanController extends Controller
{
    public function index(Request $request)
    {
        $query = LetakJawatan::with(['ptj', 'jawatan_gred.jawatan', 'jawatan_gred.gred']);

        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nokp', 'like', '%' . $request->search . '%');
        }

        $items = $query->latest()->paginate(10)->withQueryString();

        return view('letak-jawatan.index', compact('items'));
    }

    public function create()
    {
        $pegawais = Pegawai::orderBy('nama')->get();
        return view('letak-jawatan.create', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id'      => 'required|exists:pegawais,id',
            'jenis_notis'     => 'required|in:30 Hari,24 Jam',
            'tarikh_notis'    => 'required|date',
            'tarikh_kuatkuasa'=> 'required|date',
            'alasan'          => 'required|string',
        ]);

        $pegawai = Pegawai::with(['jawatan_gred', 'ptj'])->findOrFail($request->pegawai_id);

        LetakJawatan::create([
            'ptj_id'          => $pegawai->ptj_id,
            'jawatan_gred_id' => $pegawai->jawatan_gred_id,
            'nama'            => $pegawai->nama,
            'nokp'            => $pegawai->nokp,
            'tarikh_lantik'   => $pegawai->tarikh_lantikan,
            'lantikan'        => $pegawai->is_tetap ? 'Tetap' : ($pegawai->is_kontrak ? 'Kontrak' : ($pegawai->is_kontrak_interim ? 'Kontrak Interim' : '-')),
            'jenis_notis'     => $request->jenis_notis,
            'tarikh_notis'    => $request->tarikh_notis,
            'tarikh_kuatkuasa'=> $request->tarikh_kuatkuasa,
            'ikatan_jpa'      => $request->boolean('ikatan_jpa'),
            'ikatan_bpl'      => $request->boolean('ikatan_bpl'),
            'pinjaman_lppsa'  => $request->boolean('ikatan_lppsa'),
            'alasan'          => $request->alasan,
        ]);

        return redirect()->route('letak-jawatan.index')->with('success', 'Rekod letak jawatan berjaya ditambah.');
    }

    public function edit(LetakJawatan $letakJawatan)
    {
        return view('letak-jawatan.edit', compact('letakJawatan'));
    }

    public function update(Request $request, LetakJawatan $letakJawatan)
    {
        $request->validate([
            'jenis_notis'     => 'required|in:30 Hari,24 Jam',
            'tarikh_notis'    => 'required|date',
            'tarikh_kuatkuasa'=> 'required|date',
            'alasan'          => 'required|string',
        ]);

        $letakJawatan->update([
            'jenis_notis'     => $request->jenis_notis,
            'tarikh_notis'    => $request->tarikh_notis,
            'tarikh_kuatkuasa'=> $request->tarikh_kuatkuasa,
            'ikatan_jpa'      => $request->boolean('ikatan_jpa'),
            'ikatan_bpl'      => $request->boolean('ikatan_bpl'),
            'pinjaman_lppsa'  => $request->boolean('ikatan_lppsa'),
            'alasan'          => $request->alasan,
        ]);

        return redirect()->route('letak-jawatan.index')->with('success', 'Rekod letak jawatan berjaya dikemaskini.');
    }

    public function destroy(LetakJawatan $letakJawatan)
    {
        $letakJawatan->delete();
        return redirect()->route('letak-jawatan.index')->with('success', 'Rekod berjaya dipadam.');
    }
}