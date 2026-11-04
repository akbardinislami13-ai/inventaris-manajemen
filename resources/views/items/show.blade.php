@extends('layouts.inventory')

@section('title', 'Detail Buku')
@section('header', 'Detail Buku')
@section('breadcrumb', 'Detail Buku')

@section('content')

<div class="page-heading">
    <div>
        <h1>{{ $item->name }}</h1>
        <p>Detail lengkap buku yang tersimpan dalam sistem.</p>
    </div>

    <div class="actions">
        @can('edit-books')
            <a href="{{ route('items.edit', $item) }}" class="btn btn-primary">
                Edit Buku
            </a>
        @endcan

        @can('delete-books')
            <form action="{{ route('items.destroy', $item) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">Hapus Buku</button>
            </form>
        @endcan
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h2>Informasi Buku</h2>
            <p>Data tersimpan untuk buku ini.</p>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <tbody>
                <tr>
                    <th>Kode Buku</th>
                    <td>{{ $item->code }}</td>
                </tr>
                <tr>
                    <th>Judul Buku</th>
                    <td>{{ $item->name }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $item->category?->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Stok</th>
                    <td>{{ number_format($item->quantity) }} unit</td>
                </tr>
                <tr>
                    <th>Harga</th>
                    <td>Rp {{ number_format((float) $item->price, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $item->description ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<a href="{{ route('items.index') }}" class="btn btn-light">Kembali ke Data Buku</a>

@endsection
