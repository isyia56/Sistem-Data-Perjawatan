<?php

use App\Exports\L9Export;
use App\Filament\Pages\Report;
use App\Models\Aktiviti;
use App\Models\Gred;
use App\Models\Jawatan;
use App\Models\Jawatan_Gred;
use App\Models\Pegawai;
use App\Models\Program;
use App\Models\Ptj;
use App\Models\User;
use App\Models\WaranJawatan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

beforeEach(function () {
    foreach ([
        'users',
        'waran_jawatans',
        'pegawais',
        'aktivitis',
        'program_ptj',
        'programs',
        'ptjs',
        'jawatan__greds',
        'greds',
        'jawatans',
    ] as $table) {
        Schema::dropIfExists($table);
    }

    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->unsignedBigInteger('ptj_id')->nullable();
        $table->tinyInteger('role')->default(3);
        $table->tinyInteger('status')->default(1);
        $table->timestamps();
    });

    Schema::create('jawatans', function (Blueprint $table) {
        $table->id();
        $table->string('desc_jawatan')->nullable();
        $table->timestamps();
    });

    Schema::create('greds', function (Blueprint $table) {
        $table->id();
        $table->string('kod_gred')->nullable();
        $table->string('desc_gred')->nullable();
        $table->timestamps();
    });

    Schema::create('jawatan__greds', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('jawatan_id');
        $table->unsignedBigInteger('gred_id');
        $table->unsignedBigInteger('kumpulan_id')->nullable();
        $table->timestamps();
    });

    Schema::create('ptjs', function (Blueprint $table) {
        $table->id();
        $table->string('nama_ptj')->nullable();
        $table->timestamps();
    });

    Schema::create('programs', function (Blueprint $table) {
        $table->id();
        $table->string('nama_program')->nullable();
        $table->string('desc_program')->nullable();
        $table->timestamps();
    });

    Schema::create('program_ptj', function (Blueprint $table) {
        $table->unsignedBigInteger('program_id');
        $table->unsignedBigInteger('ptj_id');
        $table->timestamps();
    });

    Schema::create('aktivitis', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('program_id')->nullable();
        $table->timestamps();
    });

    Schema::create('pegawais', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('jawatan_gred_id')->nullable();
        $table->boolean('is_tetap')->default(false);
        $table->boolean('is_kontrak_interim')->default(false);
        $table->timestamps();
        $table->softDeletes();
    });

    Schema::create('waran_jawatans', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('ptj_id')->nullable();
        $table->unsignedBigInteger('aktiviti_id')->nullable();
        $table->unsignedBigInteger('pegawai_id')->nullable();
        $table->unsignedBigInteger('jawatan_gred_id')->nullable();
        $table->json('jawatan_ids')->nullable();
        $table->json('gred_ids')->nullable();
        $table->string('status')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
});

test('l9 report follows the gred from nama penyandang instead of waran gred', function () {
    $jawatan = Jawatan::query()->create(['desc_jawatan' => 'JURURAWAT']);
    $gredU9 = Gred::query()->create(['kod_gred' => 'U9']);
    $gredU10 = Gred::query()->create(['kod_gred' => 'U10']);
    $gredU11 = Gred::query()->create(['kod_gred' => 'U11']);

    $jawatanGredU9 = Jawatan_Gred::query()->create([
        'jawatan_id' => $jawatan->id,
        'gred_id' => $gredU9->id,
    ]);
    $jawatanGredU10 = Jawatan_Gred::query()->create([
        'jawatan_id' => $jawatan->id,
        'gred_id' => $gredU10->id,
    ]);
    $jawatanGredU11 = Jawatan_Gred::query()->create([
        'jawatan_id' => $jawatan->id,
        'gred_id' => $gredU11->id,
    ]);

    $ptj = Ptj::query()->create(['nama_ptj' => 'HOSPITAL BALING']);
    $program = Program::query()->create([
        'nama_program' => 'PROGRAM 2',
        'desc_program' => 'PENGURUSAN HOSPITAL',
    ]);
    $ptj->programs()->attach($program->id);
    $aktiviti = Aktiviti::query()->create(['program_id' => $program->id]);

    $pegawaiU9 = Pegawai::query()->create([
        'jawatan_gred_id' => $jawatanGredU9->id,
        'is_tetap' => true,
    ]);
    $pegawaiU10 = Pegawai::query()->create([
        'jawatan_gred_id' => $jawatanGredU10->id,
        'is_kontrak_interim' => true,
    ]);
    $pegawaiU11 = Pegawai::query()->create([
        'jawatan_gred_id' => $jawatanGredU11->id,
        'is_tetap' => true,
    ]);

    WaranJawatan::query()->create([
        'ptj_id' => $ptj->id,
        'aktiviti_id' => $aktiviti->id,
        'pegawai_id' => $pegawaiU9->id,
        'jawatan_ids' => [$jawatan->id],
        'gred_ids' => [$gredU10->id],
        'status' => 'active',
    ]);
    WaranJawatan::query()->create([
        'ptj_id' => $ptj->id,
        'aktiviti_id' => $aktiviti->id,
        'pegawai_id' => $pegawaiU10->id,
        'jawatan_ids' => [$jawatan->id],
        'gred_ids' => [$gredU9->id],
        'status' => 'active',
    ]);
    WaranJawatan::query()->create([
        'ptj_id' => $ptj->id,
        'aktiviti_id' => $aktiviti->id,
        'pegawai_id' => $pegawaiU11->id,
        'status' => 'active',
    ]);

    $report = (new ReflectionClass(Report::class))->newInstanceWithoutConstructor();
    $gradeOptionsMethod = new ReflectionMethod(Report::class, 'l9GradeOptionsForJawatan');
    $gradeOptions = $gradeOptionsMethod->invoke($report, $jawatan->id);

    expect($gradeOptions)->toHaveKey((string) $gredU9->id, 'U9')
        ->and($gradeOptions)->toHaveKey((string) $gredU10->id, 'U10')
        ->and($gradeOptions)->toHaveKey((string) $gredU11->id, 'U11');

    $export = new L9Export($jawatan->id, [$gredU9->id]);
    $rows = $export->collection();

    expect($rows[0][0])->toBe('PROGRAM 2 : PENGURUSAN HOSPITAL')
        ->and($rows[1])->toBe([1, 'HOSPITAL BALING', 1, 1, 0])
        ->and($rows[2])->toBe(['JUMLAH PROGRAM 2', '', 1, 1, 0])
        ->and($rows[3])->toBe(['JUMLAH KESELURUHAN', '', 1, 1, 0]);

    $xlsx = Excel::raw($export, Maatwebsite\Excel\Excel::XLSX);
    expect($xlsx)->not->toBeEmpty();
});

test('role 3 L9 form options and export rows are scoped to the user PTJ', function () {
    $jawatan = Jawatan::query()->create(['desc_jawatan' => 'JURURAWAT']);
    $otherJawatan = Jawatan::query()->create(['desc_jawatan' => 'PEGAWAI PERUBATAN']);
    $gredU9 = Gred::query()->create(['kod_gred' => 'U9']);
    $gredU10 = Gred::query()->create(['kod_gred' => 'U10']);
    $gredU11 = Gred::query()->create(['kod_gred' => 'U11']);

    $jawatanGredU9 = Jawatan_Gred::query()->create([
        'jawatan_id' => $jawatan->id,
        'gred_id' => $gredU9->id,
    ]);
    $jawatanGredU10 = Jawatan_Gred::query()->create([
        'jawatan_id' => $jawatan->id,
        'gred_id' => $gredU10->id,
    ]);
    $jawatanGredU11 = Jawatan_Gred::query()->create([
        'jawatan_id' => $otherJawatan->id,
        'gred_id' => $gredU11->id,
    ]);

    $ptj = Ptj::query()->create(['nama_ptj' => 'PTJ SENDIRI']);
    $otherPtj = Ptj::query()->create(['nama_ptj' => 'PTJ LAIN']);
    $program = Program::query()->create([
        'nama_program' => 'PROGRAM 2',
        'desc_program' => 'PENGURUSAN HOSPITAL',
    ]);
    $ptj->programs()->attach($program->id);
    $otherPtj->programs()->attach($program->id);
    $aktiviti = Aktiviti::query()->create(['program_id' => $program->id]);

    $pegawaiU9 = Pegawai::query()->create([
        'jawatan_gred_id' => $jawatanGredU9->id,
        'is_tetap' => true,
    ]);
    $pegawaiOtherU9 = Pegawai::query()->create([
        'jawatan_gred_id' => $jawatanGredU9->id,
        'is_tetap' => true,
    ]);
    $pegawaiU10 = Pegawai::query()->create([
        'jawatan_gred_id' => $jawatanGredU10->id,
        'is_tetap' => true,
    ]);
    $pegawaiU11 = Pegawai::query()->create([
        'jawatan_gred_id' => $jawatanGredU11->id,
        'is_tetap' => true,
    ]);

    WaranJawatan::query()->create([
        'ptj_id' => $ptj->id,
        'aktiviti_id' => $aktiviti->id,
        'pegawai_id' => $pegawaiU9->id,
        'jawatan_ids' => [$jawatan->id],
        'status' => 'active',
    ]);
    WaranJawatan::query()->create([
        'ptj_id' => $otherPtj->id,
        'aktiviti_id' => $aktiviti->id,
        'pegawai_id' => $pegawaiOtherU9->id,
        'jawatan_ids' => [$jawatan->id],
        'status' => 'active',
    ]);
    WaranJawatan::query()->create([
        'ptj_id' => $otherPtj->id,
        'aktiviti_id' => $aktiviti->id,
        'pegawai_id' => $pegawaiU10->id,
        'jawatan_ids' => [$jawatan->id],
        'status' => 'active',
    ]);
    WaranJawatan::query()->create([
        'ptj_id' => $otherPtj->id,
        'aktiviti_id' => $aktiviti->id,
        'pegawai_id' => $pegawaiU11->id,
        'jawatan_ids' => [$otherJawatan->id],
        'status' => 'active',
    ]);

    auth()->login(User::query()->create([
        'name' => 'PTJ User',
        'email' => 'ptj-user@test.com',
        'password' => 'password',
        'ptj_id' => $ptj->id,
        'role' => 3,
        'status' => 1,
    ]));

    $report = (new ReflectionClass(Report::class))->newInstanceWithoutConstructor();
    $jawatanOptions = (new ReflectionMethod(Report::class, 'l9JawatanOptions'))
        ->invoke($report);
    $gradeOptions = (new ReflectionMethod(Report::class, 'l9GradeOptionsForJawatan'))
        ->invoke($report, $jawatan->id);

    expect($jawatanOptions)->toHaveKey((string) $jawatan->id, 'JURURAWAT')
        ->and($jawatanOptions)->not->toHaveKey((string) $otherJawatan->id)
        ->and($gradeOptions)->toBe([(string) $gredU9->id => 'U9']);

    $rows = (new L9Export($jawatan->id, [$gredU9->id]))->collection();

    expect($rows)->toHaveCount(4)
        ->and($rows[1])->toBe([1, 'PTJ SENDIRI', 1, 1, 0]);
});
