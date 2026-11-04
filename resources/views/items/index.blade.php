@extends('layouts.inventory')

@section('title', 'Data Buku')
@section('header', 'Data Buku')
@section('breadcrumb', 'Data Buku')

@section('content')

<div class="page-heading">
    <div>
        <h1>Data Buku</h1>
        <p>Kelola seluruh buku, harga, kategori, dan jumlah stok.</p>
    </div>

    @can('create-books')
        <a href="{{ route('items.create') }}" class="btn btn-primary">
            ＋ Tambah Buku
        </a>
    @endcan
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h2>Daftar Buku</h2>
            <p>Data buku yang tersimpan dalam sistem.</p>
        </div>

        <input
            type="search"
            id="searchBuku"
            class="search-input"
            placeholder="Cari judul atau kode buku..."
            aria-label="Cari buku"
        >
    </div>

    <div class="table-wrap">
        <table id="tabelBuku">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Informasi Buku</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $items->firstItem() + $loop->index }}</td>

                        <td>
                            <div class="item-name">{{ $item->name }}</div>
                            <div class="item-code">{{ $item->code }}</div>
                        </td>

                        <td>
                            <span class="badge badge-purple">
                                {{ $item->category?->name ?? '-' }}
                            </span>
                        </td>

                        <td>{{ number_format($item->quantity) }} unit</td>

                        <td>
                            Rp {{ number_format((float) $item->price, 0, ',', '.') }}
                        </td>

                        <td>
                            @if ($item->quantity <= 0)
                                <span class="badge badge-red">Habis</span>
                            @elseif ($item->quantity <= 5)
                                <span class="badge badge-orange">Menipis</span>
                            @else
                                <span class="badge badge-green">Tersedia</span>
                            @endif
                        </td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('items.show', $item) }}"
                                   class="btn btn-light btn-sm"
                                   title="Detail">Detail</a>

                                @can('edit-books')
                                    <a href="{{ route('items.edit', $item) }}"
                                       class="btn btn-primary btn-sm"
                                       title="Edit">Edit</a>
                                @endcan

                                @can('delete-books')
                                    <form action="{{ route('items.destroy', $item) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div style="font-size:35px">📚</div>
                                <strong>Data buku masih kosong</strong>
                                <p>Tambahkan buku agar muncul di tabel ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $items->links() }}
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('searchBuku').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();

        document.querySelectorAll('#tabelBuku tbody tr').forEach(function (row) {
            row.style.display = row.innerText.toLowerCase().includes(keyword)
                ? ''
                : 'none';
        });
    });
</script>
@endpush
