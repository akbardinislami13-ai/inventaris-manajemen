@extends('layouts.inventory')

@section('title', 'Kelola Role Pengguna')
@section('header', 'Kelola Role Pengguna')
@section('breadcrumb', 'Kelola Pengguna')

@section('content')

<div class="page-heading">
    <div>
        <h1>Kelola Role Pengguna</h1>
        <p>Halaman ini hanya bisa dibuka oleh Admin untuk mengatur role pengguna lain.</p>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h2>Daftar Pengguna</h2>
            <p>Pilih role baru lalu tekan Simpan untuk mengubah hak akses pengguna.</p>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Pengguna</th>
                    <th>Role Saat Ini</th>
                    <th>Ubah Role</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    @php($roleName = $user->roles->first()?->name)

                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>

                        <td>
                            <div class="item-name">{{ $user->name }}</div>
                            <div class="item-code">{{ $user->email }}</div>
                        </td>

                        <td>
                            <span class="badge @if ($roleName === 'Admin') badge-purple @elseif ($roleName === 'Dosen') badge-orange @else badge-green @endif">
                                {{ $roleName ?? 'Tanpa Role' }}
                            </span>
                        </td>

                        <td>
                            <form action="{{ route('users.role.update', $user) }}"
                                  method="POST"
                                  class="actions">
                                @csrf
                                @method('PUT')

                                <select name="role" class="form-control" style="width:170px">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" @selected($roleName === $role)>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <div style="font-size:35px">👤</div>
                                <strong>Belum ada pengguna</strong>
                                <p>Pengguna akan muncul setelah melakukan registrasi.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $users->links() }}
    </div>
</div>

@endsection
