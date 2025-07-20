@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title fw-bold">Data Users</h4>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                                    <i class="ti ti-plus"></i> Tambah
                                </button>
                            </div>
                            <div>
                                <form method="GET" class="mb-3 d-flex gap-2 align-items-center">
                                    <label for="filterRole" class="form-label mb-0">Filter Role:</label>
                                    <select name="role" id="filterRole" class="form-select w-auto"
                                        onchange="this.form.submit()">
                                        <option value="">Semua</option>
                                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru
                                        </option>
                                        <option value="karyawan" {{ request('role') == 'karyawan' ? 'selected' : '' }}>
                                            Karyawan
                                        </option>
                                        <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa
                                        </option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->role }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-warning btnEditUser" data-bs-toggle="modal"
                                                data-bs-target="#modalEditUser" data-id="{{ $item->id }}"
                                                data-email="{{ $item->email }}" data-role="{{ $item->role }}"
                                                data-nama="{{ optional($item->{$item->role})->nama ?? '' }}"
                                                data-jurusan="{{ $item->jurusan_id ?? '' }}"
                                                data-kelas="{{ $item->kelas_id ?? '' }}">
                                                <i class="ti ti-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btnHapusUser"
                                                data-bs-toggle="modal" data-bs-target="#modalHapusUser"
                                                data-id="{{ $item->id }}">
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

    <!-- Modal Tambah User -->
    <div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahUserLabel">Tambah User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="roleSelect" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="guru">Guru</option>
                                <option value="karyawan">Karyawan</option>
                                <option value="siswa">Siswa</option>
                            </select>
                        </div>

                        <!-- Nama -->
                        <div class="mb-3" id="namaWrapper">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control">
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <!-- Jurusan -->
                        <div class="mb-3 d-none" id="jurusanWrapper">
                            <label for="jurusan_id" class="form-label">Jurusan</label>
                            <select name="jurusan_id" class="form-select">
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Kelas -->
                        <div class="mb-3 d-none" id="kelasWrapper">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select name="kelas_id" class="form-select">
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="formEditUser" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditUserLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Role -->
                        <div class="mb-3">
                            <label for="editRole" class="form-label">Role</label>
                            <select name="role" id="editRole" class="form-select" required disabled>
                                <option value="admin">Admin</option>
                                <option value="guru">Guru</option>
                                <option value="karyawan">Karyawan</option>
                                <option value="siswa">Siswa</option>
                            </select>
                        </div>

                        <!-- Nama -->
                        <div class="mb-3" id="editNamaWrapper">
                            <label for="editNama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="editNama" class="form-control">
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" name="email" id="editEmail" class="form-control" required>
                        </div>

                        <!-- Jurusan -->
                        <div class="mb-3 d-none" id="editJurusanWrapper">
                            <label for="editJurusan" class="form-label">Jurusan</label>
                            <select name="jurusan_id" id="editJurusan" class="form-select">
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Kelas -->
                        <div class="mb-3 d-none" id="editKelasWrapper">
                            <label for="editKelas" class="form-label">Kelas</label>
                            <select name="kelas_id" id="editKelas" class="form-select">
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus User -->
    <div class="modal fade" id="modalHapusUser" tabindex="-1" aria-labelledby="modalHapusUserLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="formHapusUser" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus user ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            // Role toggle tambah
            $('#roleSelect').on('change', function() {
                var role = $(this).val();
                $('#jurusanWrapper, #kelasWrapper').addClass('d-none');
                if (role === 'karyawan') $('#jurusanWrapper').removeClass('d-none');
                if (role === 'siswa') $('#jurusanWrapper, #kelasWrapper').removeClass('d-none');
            });

            // Edit Modal
            $('.btnEditUser').on('click', function() {
                const id = $(this).data('id');
                const email = $(this).data('email');
                const role = $(this).data('role');
                const nama = $(this).data('nama');
                const jurusan = $(this).data('jurusan');
                const kelas = $(this).data('kelas');

                $('#formEditUser').attr('action', `/users/${id}`);
                $('#editEmail').val(email);
                $('#editRole').val(role);
                $('#editNama').val(nama);

                $('#editJurusanWrapper, #editKelasWrapper').addClass('d-none');
                if (role === 'karyawan') {
                    $('#editJurusanWrapper').removeClass('d-none');
                    $('#editJurusan').val(jurusan);
                }
                if (role === 'siswa') {
                    $('#editJurusanWrapper, #editKelasWrapper').removeClass('d-none');
                    $('#editJurusan').val(jurusan);
                    $('#editKelas').val(kelas);
                }
            });

            // Hapus Modal
            $('.btnHapusUser').on('click', function() {
                const id = $(this).data('id');
                $('#formHapusUser').attr('action', `/users/${id}`);
            });
        });
    </script>
@endpush
