<?php

namespace App\Http\Controllers;

use App\Models\Waran;
use App\Models\Pegawai;
use App\Models\Ptj;
use App\Models\Jawatan;
use App\Models\Aktiviti;
use App\Models\Program;
use App\Models\WaranJawatan;

class DashboardController extends Controller
{
    public function index()
    {
        $allWarans = Waran::with(['waranJawatan'])->get();

        $totalWaran    = $allWarans->count();
        $totalLebih    = $allWarans->filter(fn($w) => $w->status_jik === 'Lebih')->count();
        $totalKurang   = $allWarans->filter(fn($w) => $w->status_jik === 'Kurang')->count();
        $totalSeimbang = $allWarans->filter(fn($w) => $w->status_jik === 'Seimbang')->count();

        $recentWarans = Waran::with(['waranJawatan'])
            ->latest()
            ->take(10)
            ->get();

        $waranByProgram = collect();
        $programs = Program::with('aktiviti')->get();
        foreach ($programs as $program) {
            $count = WaranJawatan::whereIn('aktiviti_id', $program->aktiviti->pluck('id'))->count();
            if ($count > 0) {
                $waranByProgram->push((object)[
                    'nama_program' => $program->nama_program,
                    'desc_program' => $program->desc_program,
                    'waran_count'  => $count,
                ]);
            }
        }
        $waranByProgram = $waranByProgram->sortByDesc('waran_count')->values();

        return view('dashboard', compact(
            'totalWaran',
            'totalLebih',
            'totalKurang',
            'totalSeimbang',
            'recentWarans',
            'waranByProgram'
        ));
    }
}