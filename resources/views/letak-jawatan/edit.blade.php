@extends('layouts.app')
@section('title', 'Edit Letak Jawatan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Letak Jawatan</h4>
    <a href="{{ route('letak-jawatan.index') }}" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back me-1"></i> Kembali
    </a>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible mb-4">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form method="POST" action="{{ route('letak-jawatan.update', $letakJawatan) }}">
    @csrf
    @method('PUT')

    {{-- Maklumat Pegawai (readonly) --}}
    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Maklumat Pegawai</h5></div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">Nama Pegawai</label>
                    <input type="text" class="form-control" value="{{ $letakJawatan->nama }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">No KP</label>
                    <input type="text" class="form-control" value="{{ $letakJawatan->nokp }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jawatan / Gred</label>
                    <input type="text" class="form-control"
                        value="{{ $letakJawatan->jawatan_gred?->jawatan?->desc_jawatan }} ({{ $letakJawatan->jawatan_gred?->gred?->kod_gred }})"
                        readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tempat Bertugas</label>
                    <input type="text" class="form-control" value="{{ $letakJawatan->ptj?->nama_ptj }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lantikan</label>
                    <input type="text" class="form-control" value="{{ $letakJawatan->lantikan }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tarikh Lantikan</label>
                    <input type="text" class="form-control"
                        value="{{ $letakJawatan->tarikh_lantik ? \Carbon\Carbon::parse($letakJawatan->tarikh_lantik)->format('d M Y') : '-' }}"
                        readonly>
                </div>

            </div>
        </div>
    </div>

    {{-- Maklumat Notis --}}
    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Maklumat Notis</h5></div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Notis <span class="text-danger">*</span></label>
                    <select name="jenis_notis" id="jenisNotis" class="form-select @error('jenis_notis') is-invalid @enderror" required>
                        <option value="30 Hari" {{ old('jenis_notis', $letakJawatan->jenis_notis) == '30 Hari' ? 'selected' : '' }}>30 Hari</option>
                        <option value="24 Jam" {{ old('jenis_notis', $letakJawatan->jenis_notis) == '24 Jam' ? 'selected' : '' }}>24 Jam</option>
                    </select>
                    @error('jenis_notis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tarikh Mula Notis <span class="text-danger">*</span></label>
                    <input type="date" name="tarikh_notis" id="tarikhNotis"
                        class="form-control @error('tarikh_notis') is-invalid @enderror"
                        value="{{ old('tarikh_notis', $letakJawatan->tarikh_notis) }}" required>
                    @error('tarikh_notis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tarikh Kuatkuasa <span class="text-danger">*</span></label>
                    <input type="date" name="tarikh_kuatkuasa" id="tarikhKuatkuasa"
                        class="form-control @error('tarikh_kuatkuasa') is-invalid @enderror"
                        value="{{ old('tarikh_kuatkuasa', $letakJawatan->tarikh_kuatkuasa) }}" readonly required>
                    @error('tarikh_kuatkuasa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Alasan <span class="text-danger">*</span></label>
                    <textarea name="alasan" class="form-control @error('alasan') is-invalid @enderror"
                        rows="3" required>{{ old('alasan', $letakJawatan->alasan) }}</textarea>
                    @error('alasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Ikatan</label>
                    <div class="d-flex gap-4 flex-wrap">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ikatan_jpa" id="ikatanJpa"
                                {{ old('ikatan_jpa', $letakJawatan->ikatan_jpa) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ikatanJpa">Ikatan JPA</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ikatan_bpl" id="ikatanBpl"
                                {{ old('ikatan_bpl', $letakJawatan->ikatan_bpl) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ikatanBpl">Ikatan BPL</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ikatan_lppsa" id="ikatanLppsa"
                                {{ old('ikatan_lppsa', $letakJawatan->pinjaman_lppsa) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ikatanLppsa">Ikatan LPPSA (Perumahan)</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bx bx-save me-1"></i> Kemaskini
        </button>
        <a href="{{ route('letak-jawatan.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>

</form>
@endsection

@push('scripts')
<script>
function calculateKuatkuasa() {
    const jenis = document.getElementById('jenisNotis').value;
    const tarikh = document.getElementById('tarikhNotis').value;
    if (!jenis || !tarikh) return;

    const date = new Date(tarikh);
    if (jenis === '30 Hari') {
        date.setDate(date.getDate() + 30);
    } else if (jenis === '24 Jam') {
        date.setDate(date.getDate() + 1);
    }

    const yyyy = date.getFullYear();
    const mm = String(date.getMonth() + 1).padStart(2, '0');
    const dd = String(date.getDate()).padStart(2, '0');
    document.getElementById('tarikhKuatkuasa').value = `${yyyy}-${mm}-${dd}`;
}

document.getElementById('jenisNotis').addEventListener('change', calculateKuatkuasa);
document.getElementById('tarikhNotis').addEventListener('change', calculateKuatkuasa);
</script>
@endpush