@extends('layouts.inventory')

@section('title', 'Kategori Buku')
@section('header', 'Kategori Buku')
@section('breadcrumb', 'Kategori Buku')

@section('content')

<div class="page-heading">
    <div>
        <h1>Kategori Buku</h1>
        <p>Kelompokkan buku agar data perpustakaan lebih teratur.</p>
    </div>

    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        ＋ Tambah Kategori
    </a>
</div>

<div class="stats-grid" style="grid-template-columns:repeat(2,minmax(0,1fr))">
    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-label">Total Kategori</div>
            <div class="stat-icon icon-purple">▧</div>
        </div>
        <div class="stat-number">{{ $categories->total() }}</div>
        <div class="stat-note">Kategori terdaftar</div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-label">Total Buku</div>
            <div class="stat-icon icon-green">▤</div>
        </div>
        <div class="stat-number">
            {{ \App\Models\Item::count() }}
        </div>
        <div class="stat-note">Buku dari semua kategori</div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h2>Daftar Kategori</h2>
            <p>Nama kategori, deskripsi, dan jumlah buku.</p>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Buku</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $categories->firstItem() + $loop->index }}</td>

                        <td>
                            <div class="item-name">{{ $category->name }}</div>
                            <div class="item-code">Kategori #{{ $category->id }}</div>
                        </td>

                        <td>{{ $category->description ?: 'Tidak ada deskripsi' }}</td>

                        <td>
                            <span class="badge badge-purple">
                                {{ $category->items_count }} buku
                            </span>
                        </td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('categories.show', $category) }}"
                                   class="btn btn-light btn-sm">Detail</a>

                                <a href="{{ route('categories.edit', $category) }}"
                                   class="btn btn-primary btn-sm">Edit</a>

                                <form action="{{ route('categories.destroy', $category) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div style="font-size:35px">🗂️</div>
                                <strong>Belum ada kategori</strong>
                                <p>Buat kategori pertama untuk mengelompokkan buku.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $categories->links() }}
    </div>
</div>

@endsection
