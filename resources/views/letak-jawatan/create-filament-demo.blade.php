@extends('layouts.app')
@section('title', 'Tambah Letak Jawatan (Filament Demo)')

@push('styles')
    @filamentStyles
    <link rel="stylesheet" href="{{ asset('css/filament/filament/app.css') }}">
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Tambah Letak Jawatan &mdash; Filament Form Demo</h4>
    <a href="{{ route('letak-jawatan.index') }}" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back me-1"></i> Batal
    </a>
</div>

<div class="card">
    <div class="card-body">
        @livewire('letak-jawatan-form-demo')
    </div>
</div>
@endsection

@push('scripts')
    @filamentScripts(withCore: true)
@endpush
