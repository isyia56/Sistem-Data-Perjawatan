<?php

namespace App\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Livewire\Component;

class LetakJawatanExportButton extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    protected function months(): array
    {
        return [
            '1' => 'Januari', '2' => 'Februari', '3' => 'Mac', '4' => 'April',
            '5' => 'Mei', '6' => 'Jun', '7' => 'Julai', '8' => 'Ogos',
            '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember',
        ];
    }

    public function exportAction(): Action
    {
        return Action::make('export')
            ->label('Export Excel')
            ->form([
                Grid::make(2)->schema([
                    Select::make('from_month')
                        ->label('Dari Bulan')
                        ->options($this->months())
                        ->required()
                        ->searchable()
                        ->preload(),
                    Select::make('from_year')
                        ->label('Dari Tahun')
                        ->options(
                            collect(range(now()->year - 2, now()->year + 2))
                                ->mapWithKeys(fn ($year) => [$year => $year])
                                ->toArray()
                        )
                        ->required()
                        ->searchable()
                        ->preload(),
                ]),
                Grid::make(2)->schema([
                    Select::make('to_month')
                        ->label('Hingga Bulan')
                        ->options($this->months())
                        ->required()
                        ->searchable()
                        ->preload(),
                    Select::make('to_year')
                        ->label('Hingga Tahun')
                        ->options(
                            collect(range(now()->year - 5, now()->year + 5))
                                ->mapWithKeys(fn ($year) => [$year => $year])
                                ->toArray()
                        )
                        ->required()
                        ->searchable()
                        ->preload(),
                ]),
            ])
            ->action(function (array $data) {
                return redirect()->route('export.letakJawatan', [
                    'from_month' => $data['from_month'],
                    'from_year' => $data['from_year'],
                    'to_month' => $data['to_month'],
                    'to_year' => $data['to_year'],
                ]);
            });
    }

    public function render()
    {
        return view('livewire.letak-jawatan-export-button');
    }
}
