@extends('layouts.inventory')

@section('title', 'Edit Kategori')
@section('header', 'Edit Kategori')
@section('breadcrumb', 'Edit Kategori')

@section('content')

<div class="page-heading">
    <div>
        <h1>Edit Kategori</h1>
        <p>Perbarui data kategori lalu simpan perubahan.</p>
    </div>
</div>

<div class="form-panel">
    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        @include('categories.form')

        <div class="actions">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('categories.index') }}" class="btn btn-light">Batal</a>
        </div>
    </form>
</div>

@endsection
