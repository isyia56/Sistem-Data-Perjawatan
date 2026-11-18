<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPencen extends Model
{
    protected $fillable = [
        'jenis',
        'kategori'
    ];

    public function setJenisAttribute(string $value): void
    {
        $cleanValue = preg_replace(
            '/[\x{200B}-\x{200D}\x{2060}\x{FEFF}]/u',
            '',
            trim($value),
        );

        $this->attributes['jenis'] = $cleanValue ?? trim($value);
    }
}
