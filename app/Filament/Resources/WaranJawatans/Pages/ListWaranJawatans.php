<?php

namespace App\Filament\Resources\WaranJawatans\Pages;

use App\Filament\Resources\WaranJawatans\WaranJawatanResource;
use App\Filament\Resources\WaranJawatans\Widgets\NamaPenyandang;
use App\Filament\Resources\WaranJawatans\Widgets\WaranJawatanStats;
use App\Models\Program;
use App\Models\WaranJawatan;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class ListWaranJawatans extends ListRecords
{
    protected static string $resource = WaranJawatanResource::class;

    public string $namaPenyandangStatus = 'all';

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make()
            //     ->label('Tambah Penyandang'),
        ];
    }

    public function getBreadcrumb(): string
    {
        return 'Senarai';
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('All'),
        ];

        foreach (Program::orderBy('nama_program')->get() as $program) {
            $tabs[$program->id] = Tab::make($program->nama_program)
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->whereRelation(
                        'aktiviti',
                        'program_id',
                        $program->id
                    )
                );
        }

        return $tabs;
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('namaPenyandangAll')
                ->label('Semua')
                ->color($this->namaPenyandangStatus === 'all' ? 'primary' : 'gray')
                ->action(function (): void {
                    $this->namaPenyandangStatus = 'all';
                    $this->resetTable();
                }),
            Action::make('namaPenyandangAda')
                ->label('Ada Penyandang')
                ->color($this->namaPenyandangStatus === 'ada' ? 'success' : 'gray')
                ->action(function (): void {
                    $this->namaPenyandangStatus = 'ada';
                    $this->resetTable();
                }),
            Action::make('namaPenyandangTiada')
                ->label('Tiada Penyandang')
                ->color($this->namaPenyandangStatus === 'tiada' ? 'warning' : 'gray')
                ->action(function (): void {
                    $this->namaPenyandangStatus = 'tiada';
                    $this->resetTable();
                }),
        ];
    }

    protected function getTableQuery(): Builder
    {
        $query = WaranJawatanResource::getEloquentQuery();

        if ($this->namaPenyandangStatus === 'ada') {
            $query->whereNotNull('waran_jawatans.pegawai_id');
        } elseif ($this->namaPenyandangStatus === 'tiada') {
            $query->whereNull('waran_jawatans.pegawai_id');
        }

        return $query;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WaranJawatanStats::class,
        ];
    }
    public function getBreadcrumbs(): array
    {
        // The back button (see getHeading()) replaces the need for a
        // breadcrumb trail on this page.
        return [];
    }
    
    public function getHeading(): string | Htmlable
    {
        return new HtmlString(
            '<a href="' . e(\App\Filament\Pages\Dashboard::getUrl()) . '" class="mystaff-back-btn" aria-label="Kembali ke Dashboard">' .
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>' .
            '</a>' .
            '<span>' . e($this->getTitle()) . '</span>'
        );
    }
}
