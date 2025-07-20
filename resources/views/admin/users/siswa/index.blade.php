@extends('layouts.main')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Daftar Admin</h2>

        <!-- Tombol Tambah -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah Admin</button>

        <!-- Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editUserModal{{ $user->id }}">Edit</button>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Admin</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <input type="text" name="name" class="form-control mb-2"
                                            value="{{ $user->name }}" placeholder="Nama">
                                        <input type="email" name="email" class="form-control mb-2"
                                            value="{{ $user->email }}" placeholder="Email">
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('admin.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control mb-2" placeholder="Nama">
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
