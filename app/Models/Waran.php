<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waran extends Model
{
    protected $fillable = [
        'no_waran',
        'puncakuasa',
        'jik',
        'catatan'
    ];

    // public function ptj()
    // {
    //     return $this->hasMany(Ptj::class);
    // }

    public function waranJawatan()
{
    return $this->hasMany(WaranJawatan::class);
}

public function getAktivitiListAttribute()
{
    return $this->waranJawatan
        ->pluck('aktiviti.nama_aktiviti')
        ->filter()
        ->unique()
        ->join('<br>');
}

public function getPenempatanListAttribute()
{
    return $this->waranJawatan
        ->groupBy(fn ($wj) => $wj->ptj?->nama_ptj)
        ->map(function ($items, $ptjName) {
            return $ptjName . ' (' . $items->count() . ')';
        })
        ->filter()
        ->join('<br>');
}

public function getButiranListAttribute()
{
    return $this->waranJawatan
        ->groupBy(fn ($wj) => $wj->butiran)
        ->map(function ($items, $butiran) {
            return $butiran . ' (' . $items->count() . ')';
        })
        ->filter()
        ->join('<br>');
}
}
