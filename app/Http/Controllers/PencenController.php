<?php

namespace App\Http\Controllers;

use App\Models\Pencen;
use App\Models\Pegawai;
use App\Models\JenisPencen;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PencenController extends Controller
{
    public function index(Request $request)
    {
        $query = Pencen::with(['ptj', 'jawatan_gred.jawatan', 'jawatan_gred.gred', 'jenisPencen']);

        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nokp', 'like', '%' . $request->search . '%');
        }

        $items = $query->latest()->paginate(10)->withQueryString();

        return view('pencen.index', compact('items'));
    }

    public function create()
    {
        $pegawais = Pegawai::orderBy('nama')->get();
        $jenisPencens = JenisPencen::orderBy('jenis')->get();
        return view('pencen.create', compact('pegawais', 'jenisPencens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id'       => 'required|exists:pegawais,id',
            'jenis_pencen_id'  => 'required|exists:jenis_pencens,id',
            'tarikh_lantikan'  => 'nullable|date',
            'tarikh_sah_jawatan' => 'nullable|date',
            'catatan'          => 'nullable|string',
        ]);

        $pegawai = Pegawai::with(['jawatan_gred', 'ptj', 'opsyenPencen'])->findOrFail($request->pegawai_id);
        $jenisPencen = JenisPencen::find($request->jenis_pencen_id);

        // Calculate tarikh pencen & tempoh
        $tarikhLantikan = $request->tarikh_lantikan ?? $pegawai->tarikh_lantikan;
        $tarikhBersara = null;
        $tempoh = null;

        if ($jenisPencen?->kategori === 'Paksa') {
            $ic = $pegawai->nokp;
            $year = substr($ic, 0, 2);
            $month = substr($ic, 2, 2);
            $day = substr($ic, 4, 2);
            $fullYear = $year > date('y') ? "19$year" : "20$year";
            $birthday = Carbon::createFromDate($fullYear, $month, $day);
            $age = (int) $pegawai->opsyenPencen?->opsyen;
            $tarikhBersara = $birthday->copy()->addYears($age);

            $diff = Carbon::parse($tarikhLantikan)->diff($tarikhBersara);
            $tempoh = $diff->y . ' tahun, ' . $diff->m . ' bulan, ' . $diff->d . ' hari';
        } elseif ($jenisPencen?->kategori === 'Pilihan' && $request->tarikh_kuatkuasa) {
            $diff = Carbon::parse($tarikhLantikan)->diff(Carbon::parse($request->tarikh_kuatkuasa));
            $tempoh = $diff->y . ' tahun, ' . $diff->m . ' bulan, ' . $diff->d . ' hari';
        }

        Pencen::create([
            'ptj_id'             => $pegawai->ptj_id,
            'jawatan_gred_id'    => $pegawai->jawatan_gred_id,
            'opsyen_pencen_id'   => $pegawai->opsyenPencen?->id,
            'jenis_pencen_id'    => $request->jenis_pencen_id,
            'nama'               => $pegawai->nama,
            'nokp'               => $pegawai->nokp,
            'jenis_lantikan'     => $pegawai->is_tetap ? 'Tetap' : ($pegawai->is_kontrak ? 'Kontrak' : ($pegawai->is_kontrak_interim ? 'Kontrak Interim' : '-')),
            'tarikh_lantikan'    => $tarikhLantikan,
            'tarikh_sah_jawatan' => $request->tarikh_sah_jawatan ?? $pegawai->tarikh_sah_jawatan,
            'umur_pencen'        => $pegawai->opsyenPencen?->opsyen,
            'tarikh_pencen'      => $tarikhBersara,
            'tarikh_kuatkuasa'   => $request->tarikh_kuatkuasa,
            'tempoh_perkhidmatan'=> $tempoh,
            'catatan'            => $request->catatan,
        ]);

        return redirect()->route('pencen.index')->with('success', 'Rekod penamatan perkhidmatan berjaya ditambah.');
    }

    public function edit(Pencen $pencen)
    {
        $jenisPencens = JenisPencen::orderBy('jenis')->get();
        return view('pencen.edit', compact('pencen', 'jenisPencens'));
    }

    public function update(Request $request, Pencen $pencen)
    {
        $request->validate([
            'jenis_pencen_id'  => 'required|exists:jenis_pencens,id',
            'tarikh_lantikan'  => 'nullable|date',
            'tarikh_sah_jawatan' => 'nullable|date',
            'catatan'          => 'nullable|string',
        ]);

        $jenisPencen = JenisPencen::find($request->jenis_pencen_id);
        $tempoh = null;

        if ($jenisPencen?->kategori === 'Paksa' && $request->tarikh_pencen) {
            $diff = Carbon::parse($request->tarikh_lantikan)->diff(Carbon::parse($request->tarikh_pencen));
            $tempoh = $diff->y . ' tahun, ' . $diff->m . ' bulan, ' . $diff->d . ' hari';
        } elseif ($jenisPencen?->kategori === 'Pilihan' && $request->tarikh_kuatkuasa) {
            $diff = Carbon::parse($request->tarikh_lantikan)->diff(Carbon::parse($request->tarikh_kuatkuasa));
            $tempoh = $diff->y . ' tahun, ' . $diff->m . ' bulan, ' . $diff->d . ' hari';
        }

        $pencen->update([
            'jenis_pencen_id'    => $request->jenis_pencen_id,
            'tarikh_lantikan'    => $request->tarikh_lantikan,
            'tarikh_sah_jawatan' => $request->tarikh_sah_jawatan,
            'tarikh_pencen'      => $request->tarikh_pencen,
            'tarikh_kuatkuasa'   => $request->tarikh_kuatkuasa,
            'tempoh_perkhidmatan'=> $tempoh,
            'catatan'            => $request->catatan,
        ]);

        return redirect()->route('pencen.index')->with('success', 'Rekod berjaya dikemaskini.');
    }

    public function destroy(Pencen $pencen)
    {
        $pencen->delete();
        return redirect()->route('pencen.index')->with('success', 'Rekod berjaya dipadam.');
    }

    // API untuk get pegawai info
    public function getPegawaiInfo($id)
    {
        $pegawai = Pegawai::with(['jawatan_gred.jawatan', 'jawatan_gred.gred', 'ptj', 'opsyenPencen'])->find($id);
        if (!$pegawai) return response()->json(null);

        $ic = $pegawai->nokp;
        $year = substr($ic, 0, 2);
        $month = substr($ic, 2, 2);
        $day = substr($ic, 4, 2);
        $fullYear = $year > date('y') ? "19$year" : "20$year";
        $birthday = Carbon::createFromDate($fullYear, $month, $day);
        $age = (int) $pegawai->opsyenPencen?->opsyen;
        $retirementDate = $birthday->copy()->addYears($age);
        $tarikhLantikan = $pegawai->tarikh_lantikan;
        $diff = Carbon::parse($tarikhLantikan)->diff($retirementDate);

        return response()->json([
            'nama'               => $pegawai->nama,
            'nokp'               => $pegawai->nokp,
            'ptj'                => $pegawai->ptj?->nama_ptj,
            'jawatan'            => $pegawai->jawatan_gred?->jawatan?->desc_jawatan,
            'gred'               => $pegawai->jawatan_gred?->gred?->kod_gred,
            'jenis_lantikan'     => $pegawai->is_tetap ? 'Tetap' : ($pegawai->is_kontrak ? 'Kontrak' : ($pegawai->is_kontrak_interim ? 'Kontrak Interim' : '-')),
            'tarikh_lantikan'    => $tarikhLantikan,
            'tarikh_sah_jawatan' => $pegawai->tarikh_sah_jawatan,
            'opsyen'             => $age,
            'tarikh_pencen'      => $retirementDate->format('Y-m-d'),
            'tempoh_perkhidmatan'=> $diff->y . ' tahun, ' . $diff->m . ' bulan, ' . $diff->d . ' hari',
        ]);
    }
}