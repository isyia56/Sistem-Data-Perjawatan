@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
<style>
    /* Flatpickr - match Sneat theme */
    .flatpickr-calendar {
        background: var(--bs-paper-bg);
        box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        border-radius: 8px;
    }
    .flatpickr-day.selected,
    .flatpickr-day.selected:hover,
    .flatpickr-day.selected:focus {
        background: var(--bs-primary);
        border-color: var(--bs-primary);
    }
    .flatpickr-day.today {
        border-color: var(--bs-primary);
    }
    .flatpickr-day.today:hover,
    .flatpickr-day.today:focus {
        background: var(--bs-primary);
        border-color: var(--bs-primary);
        color: #fff;
    }
    .flatpickr-day:hover {
        background: rgba(var(--bs-primary-rgb), 0.1);
    }
    .flatpickr-calendar,
    .flatpickr-current-month,
    .flatpickr-current-month .flatpickr-monthDropdown-months,
    .flatpickr-current-month input.cur-year,
    .flatpickr-weekday,
    .flatpickr-day {
        font-family: inherit;
    }
    .flatpickr-current-month .flatpickr-monthDropdown-months,
    .flatpickr-current-month input.cur-year {
        font-size: 16px !important;
    }
    html.dark-style .flatpickr-calendar {
        background: #2b2c40;
        color: #e4e6eb;
    }
    html.dark-style .flatpickr-months .flatpickr-month,
    html.dark-style .flatpickr-current-month input.cur-year,
    html.dark-style .flatpickr-weekday {
        background: #2b2c40;
        color: #e4e6eb;
        fill: #e4e6eb;
    }
    html.dark-style .flatpickr-day {
        color: #e4e6eb;
    }
    html.dark-style .flatpickr-day.flatpickr-disabled,
    html.dark-style .flatpickr-day.prevMonthDay,
    html.dark-style .flatpickr-day.nextMonthDay {
        color: #4b5563;
    }
    html.dark-style .numInputWrapper span.arrowUp:after {
        border-bottom-color: #e4e6eb;
    }
    html.dark-style .numInputWrapper span.arrowDown:after {
        border-top-color: #e4e6eb;
    }
</style>
<style>
    .wizard-steps {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
    }
    .wizard-step {
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .wizard-step-number {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        background: #e0e0e0;
        color: #666;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }
    .wizard-step.active .wizard-step-number {
        background: var(--bs-primary);
        color: #fff;
    }
    .wizard-step.done .wizard-step-number {
        background: rgba(var(--bs-primary-rgb), 0.65);
        color: #fff;
        font-size: 18px;
    }
    .wizard-step-label {
        font-size: 13px;
        color: #888;
        transition: all 0.3s ease;
    }
    .wizard-step.active .wizard-step-label {
        color: var(--bs-primary);
        font-weight: 600;
    }
    .wizard-step.done .wizard-step-label {
        color: rgba(var(--bs-primary-rgb), 0.65);
    }

    .wizard-line {
        width: 60px !important;
        flex: unset !important;
        height: 2px;
        background: #d0d0d0;
        margin: 0 16px;
        transition: all 0.3s ease;
    }
    #formButtons {
        gap: 12px !important;
        margin-top: 8px;
    }
    .wizard-line.done {
        background: rgba(var(--bs-primary-rgb), 0.65);
    }
    .wizard-section {
        display: none;
        animation: fadeSlide 0.3s ease;
    }
    .wizard-section.active {
        display: block;
    }

    /* Fix Select2 dark mode */
.select2-container--bootstrap-5 .select2-selection {
    background-color: var(--bs-body-bg) !important;
    border-color: var(--bs-border-color) !important;
    color: var(--bs-body-color) !important;
}
.select2-container--bootstrap-5 .select2-selection__rendered {
    color: var(--bs-body-color) !important;
}
.select2-dropdown {
    background-color: var(--bs-body-bg) !important;
    border-color: var(--bs-border-color) !important;
}
.select2-results__option {
    color: var(--bs-body-color) !important;
}
.select2-results__option--highlighted {
    background-color: var(--bs-primary) !important;
    color: #fff !important;
}
    @keyframes fadeSlide {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    html.dark-style .wizard-step-number { background: #3b3b5c; color: #a6adc8; }
    html.dark-style .wizard-line { background: #3b3b5c; }
    html.dark-style .wizard-step-label { color: #a6adc8; }
</style>
@endpush

{{-- Wizard Steps Indicator --}}
<div class="wizard-steps mb-4">
    <div class="wizard-step {{ isset($pencen) ? 'done' : 'active' }}" id="stepIndicator1">
        <div class="wizard-step-number" id="step1Number">{{ isset($pencen) ? '✓' : '1' }}</div>
        <div class="wizard-step-label">Maklumat Pegawai</div>
    </div>
    <div class="wizard-line {{ isset($pencen) ? 'done' : '' }}" id="wizardLine"></div>
    <div class="wizard-step {{ isset($pencen) ? 'active' : '' }}" id="stepIndicator2">
        <div class="wizard-step-number">2</div>
        <div class="wizard-step-label">Maklumat Persaraan</div>
    </div>
</div>

{{-- Step 1 --}}
<div class="wizard-section {{ isset($pencen) ? '' : 'active' }}" id="step1">
    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Maklumat Pegawai</h5></div>
        <div class="card-body">
            <div class="row g-3">
                @if(isset($pencen))
                    <div class="col-12">
                        <label class="form-label">Nama Pegawai</label>
                        <input type="text" class="form-control" value="{{ $pencen->nama }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No KP</label>
                        <input type="text" class="form-control" value="{{ $pencen->nokp }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">PTJ</label>
                        <input type="text" class="form-control" value="{{ $pencen->ptj?->nama_ptj }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jawatan</label>
                        <input type="text" class="form-control" value="{{ $pencen->jawatan_gred?->jawatan?->desc_jawatan }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Gred</label>
                        <input type="text" class="form-control" value="{{ $pencen->jawatan_gred?->gred?->kod_gred }}" readonly>
                    </div>
                @else
                    <div class="col-12">
                        <label class="form-label">Nama Pegawai <span class="text-danger">*</span></label>
                        <select name="pegawai_id" id="pegawaiSelect" class="form-select @error('pegawai_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawais as $pegawai)
                            <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
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
                        <label class="form-label">PTJ</label>
                        <input type="text" id="ptjDisplay" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jawatan</label>
                        <input type="text" id="jawatanDisplay" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Gred</label>
                        <input type="text" id="gredDisplay" class="form-control" readonly>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary" id="btnNext">
            Seterusnya <i class="bx bx-chevron-right ms-1"></i>
        </button>
    </div>
</div>

{{-- Step 2 --}}
<div class="wizard-section {{ isset($pencen) ? 'active' : '' }}" id="step2">
    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Maklumat Persaraan</h5></div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Tarikh Lantikan</label>
                    <div class="input-group flatpickr-wrap">
                        <input type="text" name="tarikh_lantikan" id="tarikhLantikan"
                            class="form-control flatpickr-date" data-input
                            value="{{ old('tarikh_lantikan', $pencen->tarikh_lantikan ?? '') }}" >
                        <span class="input-group-text" data-toggle style="cursor:pointer;">
                            <i class="bx bx-calendar"></i>
                        </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tarikh Sah Jawatan</label>
                    <div class="input-group flatpickr-wrap">
                        <input type="text" name="tarikh_sah_jawatan" id="tarikhSahJawatan"
                            class="form-control flatpickr-date" data-input
                            value="{{ old('tarikh_sah_jawatan', $pencen->tarikh_sah_jawatan ?? '') }}">
                        <span class="input-group-text" data-toggle style="cursor:pointer;">
                            <i class="bx bx-calendar"></i>
                        </span>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Jenis Penamatan Perkhidmatan <span class="text-danger">*</span></label>
                    <select name="jenis_pencen_id" id="jenisPencenSelect"
                        class="form-select @error('jenis_pencen_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis --</option>
                        @foreach($jenisPencens as $jp)
                        <option value="{{ $jp->id }}"
                            data-kategori="{{ $jp->kategori }}"
                            {{ old('jenis_pencen_id', $pencen->jenis_pencen_id ?? '') == $jp->id ? 'selected' : '' }}>
                            {{ $jp->jenis }}
                        </option>
                        @endforeach
                    </select>
                    @error('jenis_pencen_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Paksa --}}
                <div id="paksaFields" style="display:none;" class="col-12">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Opsyen (Umur Bersara)</label>
                            <input type="text" id="opsyenDisplay" class="form-control"
                                value="{{ $pencen->umur_pencen ?? '' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tarikh Bersara</label>
                            <input type="text" name="tarikh_pencen" id="tarikhPencenDisplay"
                                class="form-control"
                                value="{{ old('tarikh_pencen', $pencen->tarikh_pencen ?? '') }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempoh Perkhidmatan</label>
                            <input type="text" id="tempohDisplay" class="form-control"
                                value="{{ $pencen->tempoh_perkhidmatan ?? '' }}" readonly>
                        </div>
                    </div>
                </div>

                {{-- Pilihan --}}
                <div id="pilihanFields" style="display:none;" class="col-12">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tarikh Kuatkuasa</label>
                            <div class="input-group flatpickr-wrap">
                                <input type="text" name="tarikh_kuatkuasa" id="tarikhKuatkuasa"
                                    class="form-control flatpickr-date" data-input
                                    value="{{ old('tarikh_kuatkuasa', $pencen->tarikh_kuatkuasa ?? '') }}">
                                <span class="input-group-text" data-toggle style="cursor:pointer;">
                                    <i class="bx bx-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempoh Perkhidmatan</label>
                            <input type="text" id="tempohPilihanDisplay" class="form-control"
                                value="{{ $pencen->tempoh_perkhidmatan ?? '' }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $pencen->catatan ?? '') }}</textarea>
                </div>

            </div>
        </div>
    </div>

<div class="d-flex justify-content-between align-items-center mt-2">
    <button type="button" class="btn btn-outline-secondary" id="btnPrev">
            <i class="bx bx-chevron-left me-1"></i> Kembali
        </button>
        {{-- Submit button dari create/edit blade --}}
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
$(document).ready(function() {

    // Flatpickr date inputs
    $('.flatpickr-wrap').flatpickr({
        wrap: true,
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'd/m/Y',
        allowInput: true,
    });

    function setFlatpickrValue(id, value) {
        const el = document.getElementById(id);
        if (el && el._flatpickr) {
            el._flatpickr.setDate(value, true);
        } else if (el) {
            el.value = value;
        }
    }

    // Wizard navigation
    $('#btnNext').on('click', function() {
        $('#step1Number').html('✓');
        $('#step1').removeClass('active');
        $('#step2').addClass('active');
        $('#stepIndicator1').removeClass('active').addClass('done');
        $('#stepIndicator2').addClass('active');
        $('#wizardLine').addClass('done');
        $('#formButtons').removeClass('d-none');
    });

    $('#btnPrev').on('click', function() {
        $('#step1Number').html('1');
        $('#step2').removeClass('active');
        $('#step1').addClass('active');
        $('#stepIndicator1').removeClass('done').addClass('active');
        $('#stepIndicator2').removeClass('active');
        $('#wizardLine').removeClass('done');
        $('#formButtons').addClass('d-none');
    });

    // Select2
    if ($('#pegawaiSelect').length) {
        $('#pegawaiSelect').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Pilih Pegawai --',
            allowClear: true
        });

        $('#pegawaiSelect').on('change', function() {
            const id = $(this).val();
            if (!id) {
                $('#nokpDisplay, #ptjDisplay, #jawatanDisplay, #gredDisplay').val('');
                setFlatpickrValue('tarikhLantikan', '');
                $('#opsyenDisplay, #tempohDisplay').val('');
                return;
            }
            $.get("{{ url('pencen-pegawai-info') }}/" + id, function(data) {
                        if (!data) return;
                $('#nokpDisplay').val(data.nokp);
                $('#ptjDisplay').val(data.ptj);
                $('#jawatanDisplay').val(data.jawatan);
                $('#gredDisplay').val(data.gred);
                setFlatpickrValue('tarikhLantikan', data.tarikh_lantikan);
                setFlatpickrValue('tarikhSahJawatan', data.tarikh_sah_jawatan);
                $('#tarikhPencenDisplay').val(data.tarikh_pencen);
                $('#opsyenDisplay').val(data.opsyen + ' Tahun');
                $('#tempohDisplay').val(data.tempoh_perkhidmatan);
            });
        });
    }

    // Jenis pencen
    function showKategoriFields(kategori) {
        $('#paksaFields').hide();
        $('#pilihanFields').hide();
        if (kategori === 'Paksa') $('#paksaFields').show();
        else if (kategori === 'Pilihan') $('#pilihanFields').show();
    }

    const currentKategori = $('#jenisPencenSelect').find(':selected').data('kategori');
    if (currentKategori) showKategoriFields(currentKategori);

    $('#jenisPencenSelect').on('change', function() {
        showKategoriFields($(this).find(':selected').data('kategori'));
    });

    // Tempoh Pilihan
    $('#tarikhKuatkuasa').on('change', function() {
        const lantikan = $('#tarikhLantikan').val();
        const kuatkuasa = $(this).val();
        if (!lantikan || !kuatkuasa) return;
        const d1 = new Date(lantikan);
        const d2 = new Date(kuatkuasa);
        let years = d2.getFullYear() - d1.getFullYear();
        let months = d2.getMonth() - d1.getMonth();
        let days = d2.getDate() - d1.getDate();
        if (days < 0) { months--; days += 30; }
        if (months < 0) { years--; months += 12; }
        $('#tempohPilihanDisplay').val(years + ' tahun, ' + months + ' bulan, ' + days + ' hari');
    });


});
</script>
@endpush