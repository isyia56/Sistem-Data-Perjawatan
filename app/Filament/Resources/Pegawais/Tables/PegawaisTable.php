<?php

namespace App\Filament\Resources\Pegawais\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\View\Components\BadgeComponent;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PegawaisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('Bil')
                    ->rowIndex(),
                TextColumn::make('nama')
                    ->label('Pegawai')
                    ->formatStateUsing(
                        fn($record) =>
                        '<strong>' . ($record->nama ?? '-') . '</strong><br>' .
                            ($record->nokp ?? '-') . '<br>' .
                            ($record->emel ?? '-') . '<br>' .
                            (
                                $record->jawatan_gred
                                ? $record->jawatan_gred->jawatan->desc_jawatan .
                                ' (' . $record->jawatan_gred->gred->kod_gred . ')'
                                : '-'
                            )
                    )
                    ->html(),
                TextColumn::make('ptj')
                    ->label('Penempatan')
                    ->formatStateUsing(
                        fn($record) =>
                        '<strong>' . $record->ptj->nama_ptj . '</strong><br>' . $record->bahagian->nama_bahagian .
                            '<br>' . $record->unit->nama_unit . '<br>' . $record->subunit->nama_subunit

                    )
                    ->html(),

                TextColumn::make('is_kontrak')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Kontrak' : 'Tetap')
                    ->color(fn($state) => $state ? 'warning' : 'success')

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
