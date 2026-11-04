@extends('layouts.inventory')

@section('title', 'Edit Buku')
@section('header', 'Edit Buku')
@section('breadcrumb', 'Edit Buku')

@section('content')

<div class="page-heading">
    <div>
        <h1>Edit Buku</h1>
        <p>Perbarui data buku lalu simpan perubahan.</p>
    </div>
</div>

<div class="form-panel">
    <form action="{{ route('items.update', $item) }}" method="POST">
        @csrf
        @method('PUT')
        @include('items.form', ['item' => $item])

        <div class="actions">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('items.index') }}" class="btn btn-light">Batal</a>
        </div>
    </form>
</div>

@endsection
