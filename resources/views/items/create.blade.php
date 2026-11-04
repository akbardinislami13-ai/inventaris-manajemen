@extends('layouts.inventory')

@section('title', 'Tambah Buku')
@section('header', 'Tambah Buku')
@section('breadcrumb', 'Tambah Buku')

@section('content')

<div class="page-heading">
    <div>
        <h1>Tambah Buku</h1>
        <p>Isi data buku baru, lalu simpan.</p>
    </div>
</div>

<div class="form-panel">
    <form action="{{ route('items.store') }}" method="POST">
        @csrf
        @include('items.form', ['item' => null])

        <div class="actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('items.index') }}" class="btn btn-light">Batal</a>
        </div>
    </form>
</div>

@endsection
