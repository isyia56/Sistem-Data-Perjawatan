<?php

use App\Models\JenisPencen;

test('jenis pencen removes invisible unicode characters from the label', function () {
    $jenisPencen = new JenisPencen([
        'jenis' => "\u{2060}Persaraan Atas Sebab Kesihatan (Lembaga Perubatan)",
        'kategori' => 'Pilihan',
    ]);

    expect($jenisPencen->jenis)
        ->toBe('Persaraan Atas Sebab Kesihatan (Lembaga Perubatan)');
});
