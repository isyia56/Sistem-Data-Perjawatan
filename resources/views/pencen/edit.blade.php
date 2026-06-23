@extends('layouts.app')
@section('title', 'Edit Penamatan Perkhidmatan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Penamatan Perkhidmatan</h4>
    <a href="{{ route('pencen.index') }}" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back me-1"></i> Kembali
    </a>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible mb-4">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form method="POST" action="{{ route('pencen.update', $pencen) }}">
    @csrf
    @method('PUT')
    @include('pencen.form')
<div class="d-flex gap-2" id="formButtons">
    <button type="submit" class="btn btn-primary">
        <i class="bx bx-save me-1"></i> Kemaskini
    </button>
    <a href="{{ route('pencen.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>
</form>
@endsection