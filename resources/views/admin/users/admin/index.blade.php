@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title fw-bold">Data Admin</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahAdmin">
                        <i class="ti ti-plus"></i> Tambah
                    </button>
                </div>

                <div class="card-body">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ optional($item->admin)->nama ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-warning btnEditAdmin" data-bs-toggle="modal"
                                                data-bs-target="#modalEditAdmin" data-id="{{ $item->id }}"
                                                data-email="{{ $item->email }}"
                                                data-nama="{{ optional($item->admin)->nama }}">
                                                <i class="ti ti-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btnHapusAdmin" data-bs-toggle="modal"
                                                data-bs-target="#modalHapusAdmin" data-id="{{ $item->id }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Admin -->
    <div class="modal fade" id="modalTambahAdmin" tabindex="-1" aria-labelledby="modalTambahAdminLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="role" value="admin">

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Admin -->
    <div class="modal fade" id="modalEditAdmin" tabindex="-1" aria-labelledby="modalEditAdminLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formEditAdmin">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editNama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="editNama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" name="email" id="editEmail" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus Admin -->
    <div class="modal fade" id="modalHapusAdmin" tabindex="-1" aria-labelledby="modalHapusAdminLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formHapusAdmin">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus admin ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="submit">Hapus</button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.btnEditAdmin').on('click', function() {
                const id = $(this).data('id');
                const email = $(this).data('email');
                const nama = $(this).data('nama');

                $('#formEditAdmin').attr('action', `/admin/${id}`);
                $('#editEmail').val(email);
                $('#editNama').val(nama);
            });

            $('.btnHapusAdmin').on('click', function() {
                const id = $(this).data('id');
                $('#formHapusAdmin').attr('action', `/admin/${id}`);
            });
        });
    </script>
@endpush
