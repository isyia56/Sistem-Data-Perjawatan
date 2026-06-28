@extends('layouts.app')
@section('title', 'Letak Jawatan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Letak Jawatan</h4>
    <a href="{{ route('letak-jawatan.create') }}" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Tambah
    </a>
</div>

{{-- Search --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('letak-jawatan.index') }}">
            <div class="input-group">
                <span class="input-group-text"><i class="bx bx-search"></i></span>
                <input type="text" name="search" class="form-control"
                    placeholder="Cari nama atau no KP..."
                    value="{{ request('search') }}"
                    onkeyup="debounceSearch(this)">
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Senarai Letak Jawatan</h5>
        <small class="text-muted">Jumlah: {{ $items->total() }}</small>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th></th>
                    <th>Nama Pegawai</th>
                    <th>Jawatan / Gred</th>
                    <th>PTJ</th>
                    <th>Notis</th>
                    <th>Tarikh Kuatkuasa</th>
                    <th>Lantikan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $item)
                <tr>
                    <td>{{ $items->firstItem() + $i }}</td>
                    <td>
                        <div class="fw-semibold">{{ $item->nama }}</div>
                        <small class="text-muted">{{ $item->nokp }}</small>
                    </td>
                    <td>
                        <small>
                            {{ $item->jawatan_gred?->jawatan?->desc_jawatan ?? '-' }}
                            ({{ $item->jawatan_gred?->gred?->kod_gred ?? '-' }})
                        </small>
                    </td>
                    <td><small>{{ $item->ptj?->nama_ptj ?? '-' }}</small></td>
                    <td>
                        <span class="badge bg-label-info">{{ $item->jenis_notis }}</span>
                    </td>
                    <td>
                        <small>{{ $item->tarikh_kuatkuasa ? \Carbon\Carbon::parse($item->tarikh_kuatkuasa)->format('d M Y') : '-' }}</small>
                    </td>
                    <td><small>{{ $item->lantikan ?? '-' }}</small></td>
                    <td class="text-center">
                        <a href="{{ route('letak-jawatan.edit', $item) }}" class="text-warning me-2">
                            <i class="bx bx-edit"></i>
                        </a>
                        <a href="javascript:void(0);"
                            onclick="confirmDelete('{{ route('letak-jawatan.destroy', $item) }}', '{{ $item->nama }}')"
                            class="text-danger">
                            <i class="bx bx-trash"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Tiada rekod letak jawatan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($items->hasPages())
    <div class="card-footer d-flex justify-content-center">
        {{ $items->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function debounceSearch(input) {
    clearTimeout(window._searchTimer);
    window._searchTimer = setTimeout(() => {
        input.closest('form').submit();
    }, 500);
}
</script>
@endpush














