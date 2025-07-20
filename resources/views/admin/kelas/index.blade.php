```blade
@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title fw-bold">Data Kelas</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
                        <i class="ti ti-plus"></i> Tambah
                    </button>
                </div>

                <div class="card-body">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kelas</th>
                                <th>Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelas as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_kelas }}</td>
                                    <td>{{ $item->jurusan->nama_jurusan ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-warning"
                                                data-bs-target="#modalEditKelas{{ $item->id }}" data-bs-toggle="modal">
                                                <i class="ti ti-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalHapusKelas{{ $item->id }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit Kelas -->
                                <div class="modal fade" id="modalEditKelas{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalEditKelas{{ $item->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('kelas.update', $item->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Kelas</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="editNamaKelas{{ $item->id }}"
                                                            class="form-label">Nama Kelas</label>
                                                        <input type="text" name="nama_kelas"
                                                            id="editNamaKelas{{ $item->id }}"
                                                            value="{{ $item->nama_kelas }}" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editJurusan{{ $item->id }}"
                                                            class="form-label">Jurusan</label>
                                                        <select name="jurusan_id" id="editJurusan{{ $item->id }}"
                                                            class="form-select" required>
                                                            <option value="">Pilih Jurusan</option>
                                                            @foreach ($jurusan as $j)
                                                                <option value="{{ $j->id }}"
                                                                    {{ $item->jurusan_id == $j->id ? 'selected' : '' }}>
                                                                    {{ $j->nama_jurusan }}
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

                                <!-- Modal Hapus Kelas -->
                                <div class="modal fade" id="modalHapusKelas{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalHapusKelasLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form method="POST" action="{{ route('kelas.destroy', $item->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Hapus Kelas</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin ingin menghapus Kelas ini?</p>
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

    <!-- Modal Tambah Kelas -->
    <div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-labelledby="modalTambahKelasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kelas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas</label>
                            <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" required>
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
@endpush
```
