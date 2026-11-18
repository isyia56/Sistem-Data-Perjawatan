<?php

namespace App\Http\Controllers;

use App\Exports\L9Export;
use App\Models\Gred;
use App\Models\WaranJawatan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class L9ExportController extends Controller
{
    public function export(Request $request): BinaryFileResponse
    {
        $validated = $request->validate([
            'jawatan_id' => ['required', 'integer', 'exists:jawatans,id'],
            'gred_combination' => ['required', 'string', 'regex:/^\d+(,\d+)*$/'],
        ]);

        $gredIds = array_values(array_unique(array_map(
            'intval',
            explode(',', $validated['gred_combination']),
        )));
        sort($gredIds);

        if (count($gredIds) !== count(explode(',', $validated['gred_combination']))
            || Gred::query()->whereIn('id', $gredIds)->count() !== count($gredIds)) {
            throw ValidationException::withMessages([
                'gred_combination' => 'The selected grade combination is invalid.',
            ]);
        }

        $hasCombination = WaranJawatan::query()
            ->listed()
            ->with('pegawai.jawatan_gred')
            ->whereJsonContains('jawatan_ids', (int) $validated['jawatan_id'])
            ->get()
            ->contains(function (WaranJawatan $waran) use ($gredIds): bool {
                $pegawaiGredId = (int) ($waran->pegawai?->jawatan_gred?->gred_id ?? 0);

                return $pegawaiGredId > 0
                    && $this->normalizedGredIds([$pegawaiGredId]) === $gredIds;
            });

        if (! $hasCombination) {
            throw ValidationException::withMessages([
                'gred_combination' => 'The selected grade combination is not available for this jawatan.',
            ]);
        }

        return Excel::download(
            new L9Export((int) $validated['jawatan_id'], $gredIds),
            'L9.xlsx'
        );
    }

    /**
     * @param  list<int>  $gredIds
     * @return list<int>
     */
    protected function normalizedGredIds(array $gredIds): array
    {
        $ids = array_values(array_unique(array_map('intval', $gredIds)));
        sort($ids);

        return $ids;
    }
}
