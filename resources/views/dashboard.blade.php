@extends('layouts.inventory')

@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

@php($user = auth()->user())
@php($roleName = $user->getRoleNames()->first() ?? 'Tanpa Role')

<div class="page-heading">
    <div>
        <h1>Selamat datang, {{ $user->name }}</h1>
        <p>
            Kamu masuk sebagai <strong>{{ $roleName }}</strong>.
            Menu dan tombol di bawah menyesuaikan hak akses role tersebut.
        </p>
    </div>

    @can('create-books')
        <a href="{{ route('items.create') }}" class="btn btn-primary">
            ＋ Tambah Buku
        </a>
    @endcan
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-label">Total Buku</div>
            <div class="stat-icon icon-purple">▤</div>
        </div>
        <div class="stat-number">{{ \App\Models\Item::count() }}</div>
        <div class="stat-note">Buku terdaftar</div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-label">Total Kategori</div>
            <div class="stat-icon icon-green">▧</div>
        </div>
        <div class="stat-number">{{ \App\Models\Category::count() }}</div>
        <div class="stat-note">Kategori buku</div>
    </div>

    @can('manage-users')
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-label">Total Pengguna</div>
                <div class="stat-icon icon-blue">👤</div>
            </div>
            <div class="stat-number">{{ \App\Models\User::count() }}</div>
            <div class="stat-note">Pengguna terdaftar</div>
        </div>
    @endcan

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-label">Role Saya</div>
            <div class="stat-icon icon-orange">★</div>
        </div>
        <div class="stat-number" style="font-size:22px">{{ $roleName }}</div>
        <div class="stat-note">Hak akses aktif saat ini</div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h2>Hak Akses Role {{ $roleName }}</h2>
            <p>Daftar izin yang dimiliki akun ini, dipakai untuk memutuskan akses di server.</p>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Permission</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach (\Database\Seeders\RolePermissionSeeder::PERMISSIONS as $permission)
                    <tr>
                        <td>{{ $permission }}</td>
                        <td>
                            @if ($user->can($permission))
                                <span class="badge badge-green">Diizinkan</span>
                            @else
                                <span class="badge badge-red">Tidak diizinkan</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
