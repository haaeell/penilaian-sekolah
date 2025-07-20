@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title fw-bold">Data Guru</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahGuru">
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
                                    <td>{{ optional($item->guru)->nama ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-warning btnEditGuru" data-bs-toggle="modal"
                                                data-bs-target="#modalEditGuru" data-id="{{ $item->id }}"
                                                data-email="{{ $item->email }}"
                                                data-nama="{{ optional($item->guru)->nama }}">
                                                <i class="ti ti-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btnHapusGuru" data-bs-toggle="modal"
                                                data-bs-target="#modalHapusGuru" data-id="{{ $item->id }}">
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

    <!-- Modal Tambah Guru -->
    <div class="modal fade" id="modalTambahGuru" tabindex="-1" aria-labelledby="modalTambahGuruLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('guru.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Guru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="role" value="Guru">

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

    <!-- Modal Edit Guru -->
    <div class="modal fade" id="modalEditGuru" tabindex="-1" aria-labelledby="modalEditGuruLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formEditGuru">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Guru</h5>
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

    <!-- Modal Hapus Guru -->
    <div class="modal fade" id="modalHapusGuru" tabindex="-1" aria-labelledby="modalHapusGuruLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formHapusGuru">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Guru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus Guru ini?</p>
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
            $('.btnEditGuru').on('click', function() {
                const id = $(this).data('id');
                const email = $(this).data('email');
                const nama = $(this).data('nama');

                $('#formEditGuru').attr('action', `/guru/${id}`);
                $('#editEmail').val(email);
                $('#editNama').val(nama);
            });

            $('.btnHapusGuru').on('click', function() {
                const id = $(this).data('id');
                $('#formHapusGuru').attr('action', `/guru/${id}`);
            });
        });
    </script>
@endpush
