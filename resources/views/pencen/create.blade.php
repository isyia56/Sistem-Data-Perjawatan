@extends('layouts.app')
@section('title', 'Tambah Penamatan Perkhidmatan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Tambah Penamatan Perkhidmatan</h4>
    <a href="{{ route('pencen.index') }}" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back me-1"></i> Batal
    </a>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible mb-4">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form method="POST" action="{{ route('pencen.store') }}">
    @csrf
    @include('pencen.form')
    <div class="d-flex gap-2 d-none" id="formButtons">
        <button type="submit" class="btn btn-primary">
            <i class="bx bx-save me-1"></i> Simpan
        </button>
        <a href="{{ route('pencen.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection