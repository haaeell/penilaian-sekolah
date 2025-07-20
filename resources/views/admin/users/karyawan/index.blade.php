@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title fw-bold">Data Karyawan</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKaryawan">
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
                                <th>Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ optional($item->karyawan)->nama ?? '-' }}</td>
                                    <td>{{ optional($item->karyawan->jurusan)->nama_jurusan ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-warning btnEditKaryawan" data-bs-toggle="modal"
                                                data-bs-target="#modalEditKaryawan" data-id="{{ $item->id }}"
                                                data-email="{{ $item->email }}"
                                                data-nama="{{ optional($item->karyawan)->nama }}"
                                                data-jurusan="{{ $item->jurusan_id ?? '' }}">
                                                <i class="ti ti-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btnHapusKaryawan" data-bs-toggle="modal"
                                                data-bs-target="#modalHapusKaryawan" data-id="{{ $item->id }}">
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

    <!-- Modal Tambah Karyawan -->
    <div class="modal fade" id="modalTambahKaryawan" tabindex="-1" aria-labelledby="modalTambahKaryawanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('karyawan.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="role" value="Karyawan">

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

                        <div class="mb-3">
                            <label for="jurusan_id" class="form-label">Jurusan</label>
                            <select name="jurusan_id" class="form-select" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach ($jurusan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_jurusan }}</option>
                                @endforeach
                            </select>
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

    <!-- Modal Edit Karyawan -->
    <div class="modal fade" id="modalEditKaryawan" tabindex="-1" aria-labelledby="modalEditKaryawanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formEditKaryawan">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Karyawan</h5>
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

                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Password</label>
                            <input type="password" name="password" id="editPassword" class="form-control">
                            <small>Biarkan kosong jika tidak ingin mengganti password</small>
                        </div>

                        <div class="mb-3">
                            <label for="editJurusan" class="form-label">Jurusan</label>
                            <select name="jurusan_id" id="editJurusan" class="form-select" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach ($jurusan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_jurusan }}</option>
                                @endforeach
                            </select>
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

    <!-- Modal Hapus Karyawan -->
    <div class="modal fade" id="modalHapusKaryawan" tabindex="-1" aria-labelledby="modalHapusKaryawanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formHapusKaryawan">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus Karyawan ini?</p>
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
            $('.btnEditKaryawan').on('click', function() {
                const id = $(this).data('id');
                const email = $(this).data('email');
                const nama = $(this).data('nama');

                $('#formEditKaryawan').attr('action', `/karyawan/${id}`);
                $('#editEmail').val(email);
                $('#editNama').val(nama);

                const jurusanId = $(this).data('jurusan');
                $('#editJurusan').val(jurusanId);
            });

            $('.btnHapusKaryawan').on('click', function() {
                const id = $(this).data('id');
                $('#formHapusKaryawan').attr('action', `/karyawan/${id}`);
            });
        });
    </script>
@endpush
