@extends('layouts.inventory')

@section('title', 'Detail Kategori')
@section('header', 'Detail Kategori')
@section('breadcrumb', 'Detail Kategori')

@section('content')

<div class="page-heading">
    <div>
        <h1>{{ $category->name }}</h1>
        <p>{{ $category->description ?? 'Tidak ada deskripsi' }}</p>
    </div>

    <div class="actions">
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">
            Edit Kategori
        </a>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h2>Buku dalam Kategori</h2>
            <p>Daftar buku yang termasuk kategori ini.</p>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul Buku</th>
                    <th>Kode</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($category->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="item-name">{{ $item->name }}</div>
                        </td>
                        <td>
                            <div class="item-code">{{ $item->code }}</div>
                        </td>
                        <td>
                            <a href="{{ route('items.show', $item) }}"
                               class="btn btn-light btn-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <div style="font-size:35px">📚</div>
                                <strong>Belum ada buku</strong>
                                <p>Belum ada buku pada kategori ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<a href="{{ route('categories.index') }}" class="btn btn-light">Kembali</a>

@endsection
