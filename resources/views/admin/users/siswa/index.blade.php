```blade
@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title fw-bold">Data Siswa</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
                        <i class="ti ti-plus"></i> Tambah
                    </button>
                </div>

                <div class="card-body">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Jurusan</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->siswa->nama ?? '-' }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->siswa->jurusan->nama_jurusan ?? '-' }}</td>
                                    <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-warning"
                                                data-bs-target="#modalEditSiswa{{ $item->id }}" data-bs-toggle="modal">
                                                <i class="ti ti-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalHapusSiswa{{ $item->id }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit Siswa -->
                                <div class="modal fade" id="modalEditSiswa{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalEditSiswa{{ $item->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('siswa.update', $item->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Siswa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="editNama{{ $item->id }}"
                                                            class="form-label">Nama</label>
                                                        <input type="text" name="name"
                                                            id="editNama{{ $item->id }}"
                                                            value="{{ $item->siswa->nama }}" class="form-control" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editEmail{{ $item->id }}"
                                                            class="form-label">Email</label>
                                                        <input type="email" name="email"
                                                            id="editEmail{{ $item->id }}" value="{{ $item->email }}"
                                                            class="form-control" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editPassword{{ $item->id }}"
                                                            class="form-label">Password</label>
                                                        <input type="password" name="password"
                                                            id="editPassword{{ $item->id }}" class="form-control">
                                                        <small>Biarkan kosong jika tidak ingin mengganti password</small>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editJurusan{{ $item->id }}"
                                                            class="form-label">Jurusan</label>
                                                        <select name="jurusan_id" id="editJurusan{{ $item->id }}"
                                                            class="form-select" required>
                                                            <option value="">Pilih Jurusan</option>
                                                            @foreach ($jurusan as $j)
                                                                <option value="{{ $j->id }}"
                                                                    {{ $item->siswa->jurusan_id == $j->id ? 'selected' : '' }}>
                                                                    {{ $j->nama_jurusan }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editKelas{{ $item->id }}"
                                                            class="form-label">Kelas</label>
                                                        <select name="kelas_id" id="editKelas{{ $item->id }}"
                                                            class="form-select" required>
                                                            <option value="">Pilih Kelas</option>
                                                            @foreach ($kelas as $k)
                                                                <option value="{{ $k->id }}"
                                                                    {{ $item->siswa->kelas_id == $k->id ? 'selected' : '' }}>
                                                                    {{ $k->nama_kelas }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                                    <button class="btn btn-dark" type="button"
                                                        data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Modal Hapus Siswa -->
                                <div class="modal fade" id="modalHapusSiswa{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalHapusSiswaLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form method="POST" action="{{ route('siswa.destroy', $item->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Hapus Siswa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin ingin menghapus Siswa ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-danger" type="submit">Hapus</button>
                                                    <button class="btn btn-dark" type="button"
                                                        data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Siswa -->
    <div class="modal fade" id="modalTambahSiswa" tabindex="-1" aria-labelledby="modalTambahSiswaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="jurusan_id" class="form-label">Jurusan</label>
                            <select name="jurusan_id" id="jurusan_id" class="form-select" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach ($jurusan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-select" required>
                                <option value="">Pilih Kelas</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-dark" type="button" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#jurusan_id').on('change', function() {
            var jurusanId = $(this).val();

            $('#kelas_id').html('<option value="">Memuat...</option>');

            if (jurusanId) {
                $.get('/kelas-by-jurusan/' + jurusanId, function(data) {
                    var options = '<option value="">Pilih Kelas</option>';
                    data.forEach(function(item) {
                        options += `<option value="${item.id}">${item.nama_kelas}</option>`;
                    });
                    $('#kelas_id').html(options);
                });
            } else {
                $('#kelas_id').html('<option value="">Pilih Kelas</option>');
            }
        });
    </script>
@endpush
```
