@extends('layouts.inventory')

@section('title', 'Tambah Kategori')
@section('header', 'Tambah Kategori')
@section('breadcrumb', 'Tambah Kategori')

@section('content')

<div class="page-heading">
    <div>
        <h1>Tambah Kategori</h1>
        <p>Buat kategori baru untuk mengelompokkan buku.</p>
    </div>
</div>

<div class="form-panel">
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        @include('categories.form')

        <div class="actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('categories.index') }}" class="btn btn-light">Batal</a>
        </div>
    </form>
</div>

@endsection
