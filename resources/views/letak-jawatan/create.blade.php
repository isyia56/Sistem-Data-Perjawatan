@extends('layouts.app')
@section('title', 'Tambah Letak Jawatan')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Tambah Letak Jawatan</h4>
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

<form method="POST" action="{{ route('letak-jawatan.store') }}">
    @csrf

    {{-- Maklumat Pegawai --}}
    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Maklumat Pegawai</h5></div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">Nama Pegawai <span class="text-danger">*</span></label>
                    <select name="pegawai_id" id="pegawaiSelect" class="form-select @error('pegawai_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach($pegawais as $pegawai)
                        <option value="{{ $pegawai->id }}"
                            data-nokp="{{ $pegawai->nokp }}"
                            data-jawatan="{{ $pegawai->jawatan_gred?->jawatan?->desc_jawatan }} ({{ $pegawai->jawatan_gred?->gred?->kod_gred }})"
                            data-ptj="{{ $pegawai->ptj?->nama_ptj }}"
                            data-lantikan="{{ $pegawai->is_tetap ? 'Tetap' : ($pegawai->is_kontrak ? 'Kontrak' : ($pegawai->is_kontrak_interim ? 'Kontrak Interim' : '-')) }}"
                            data-tarikh="{{ $pegawai->tarikh_lantikan }}"
                            {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                            {{ $pegawai->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('pegawai_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">No KP</label>
                    <input type="text" id="nokpDisplay" class="form-control" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jawatan / Gred</label>
                    <input type="text" id="jawatanDisplay" class="form-control" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tempat Bertugas</label>
                    <input type="text" id="ptjDisplay" class="form-control" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lantikan</label>
                    <input type="text" id="lantikanDisplay" class="form-control" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tarikh Lantikan</label>
                    <input type="text" id="tarikhLantikDisplay" class="form-control" readonly>
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
                        <option value="">-- Pilih Notis --</option>
                        <option value="30 Hari" {{ old('jenis_notis') == '30 Hari' ? 'selected' : '' }}>30 Hari</option>
                        <option value="24 Jam" {{ old('jenis_notis') == '24 Jam' ? 'selected' : '' }}>24 Jam</option>
                    </select>
                    @error('jenis_notis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tarikh Mula Notis <span class="text-danger">*</span></label>
                    <input type="date" name="tarikh_notis" id="tarikhNotis"
                        class="form-control @error('tarikh_notis') is-invalid @enderror"
                        value="{{ old('tarikh_notis') }}" required>
                    @error('tarikh_notis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tarikh Kuatkuasa <span class="text-danger">*</span></label>
                    <input type="date" name="tarikh_kuatkuasa" id="tarikhKuatkuasa"
                        class="form-control @error('tarikh_kuatkuasa') is-invalid @enderror"
                        value="{{ old('tarikh_kuatkuasa') }}" readonly required>
                    @error('tarikh_kuatkuasa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Alasan <span class="text-danger">*</span></label>
                    <textarea name="alasan" class="form-control @error('alasan') is-invalid @enderror"
                        rows="3" required>{{ old('alasan') }}</textarea>
                    @error('alasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Ikatan</label>
                    <div class="d-flex gap-4 flex-wrap">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ikatan_jpa" id="ikatanJpa"
                                {{ old('ikatan_jpa') ? 'checked' : '' }}>
                            <label class="form-check-label" for="ikatanJpa">Ikatan JPA</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ikatan_bpl" id="ikatanBpl"
                                {{ old('ikatan_bpl') ? 'checked' : '' }}>
                            <label class="form-check-label" for="ikatanBpl">Ikatan BPL</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ikatan_lppsa" id="ikatanLppsa"
                                {{ old('ikatan_lppsa') ? 'checked' : '' }}>
                            <label class="form-check-label" for="ikatanLppsa">Ikatan LPPSA (Perumahan)</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bx bx-save me-1"></i> Simpan
        </button>
        <a href="{{ route('letak-jawatan.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>

</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#pegawaiSelect').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Pilih Pegawai --',
        allowClear: true
    });

    $('#pegawaiSelect').on('change', function() {
        const selected = $(this).find(':selected');
        $('#nokpDisplay').val(selected.data('nokp') || '');
        $('#jawatanDisplay').val(selected.data('jawatan') || '');
        $('#ptjDisplay').val(selected.data('ptj') || '');
        $('#lantikanDisplay').val(selected.data('lantikan') || '');
        $('#tarikhLantikDisplay').val(selected.data('tarikh') || '');
    });

    function calculateKuatkuasa() {
        const jenis = $('#jenisNotis').val();
        const tarikh = $('#tarikhNotis').val();
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
        $('#tarikhKuatkuasa').val(`${yyyy}-${mm}-${dd}`);
    }

    $('#jenisNotis, #tarikhNotis').on('change', calculateKuatkuasa);
});
</script>
@endpush