<?php

namespace App\Livewire;

use App\Filament\Resources\LetakJawatans\Schemas\LetakJawatanForm;
use App\Models\LetakJawatan;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;

class LetakJawatanFormDemo extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return LetakJawatanForm::configure($schema)
            ->operation('create')
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        LetakJawatan::create([
            'ptj_id'           => $state['ptj_id'],
            'jawatan_gred_id'  => $state['jawatan_gred_id'],
            'nama'             => $state['nama'],
            'nokp'             => $state['nokp'],
            'tarikh_lantik'    => $state['tarikh_lantik'],
            'lantikan'         => $state['lantikan'],
            'jenis_notis'      => $state['jenis_notis'],
            'tarikh_notis'     => $state['tarikh_notis'],
            'tarikh_kuatkuasa' => $state['tarikh_kuatkuasa'],
            'ikatan_jpa'       => $state['ikatan_jpa'] ?? false,
            'ikatan_bpl'       => $state['ikatan_bpl'] ?? false,
            'pinjaman_lppsa'   => $state['ikatan_lppsa'] ?? false,
            'alasan'           => $state['alasan'],
        ]);

        session()->flash('success', 'Rekod letak jawatan berjaya ditambah (Filament demo).');

        $this->redirectRoute('letak-jawatan.index');
    }

    public function render()
    {
        return view('livewire.letak-jawatan-form-demo');
    }
}
