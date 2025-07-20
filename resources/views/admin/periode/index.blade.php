```blade
@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title fw-bold">Data Periode</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPeriode">
                        <i class="ti ti-plus"></i> Tambah
                    </button>
                </div>

                <div class="card-body">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Periode</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($periode as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_periode }}</td>
                                    <td>{{ $item->waktu_mulai ? \Carbon\Carbon::parse($item->waktu_mulai)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td>{{ $item->waktu_selesai ? \Carbon\Carbon::parse($item->waktu_selesai)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-warning"
                                                data-bs-target="#modalEditPeriode{{ $item->id }}"
                                                data-bs-toggle="modal">
                                                <i class="ti ti-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalHapusPeriode{{ $item->id }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit Periode -->
                                <div class="modal fade" id="modalEditPeriode{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalEditPeriode{{ $item->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('periode.update', $item->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Periode</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="editNamaPeriode{{ $item->id }}"
                                                            class="form-label">Nama Periode</label>
                                                        <input type="text" name="nama_periode"
                                                            id="editNamaPeriode{{ $item->id }}"
                                                            value="{{ $item->nama_periode }}" class="form-control"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editWaktuMulai{{ $item->id }}"
                                                            class="form-label">Waktu Mulai</label>
                                                        <input type="date" name="waktu_mulai"
                                                            id="editWaktuMulai{{ $item->id }}"
                                                            value="{{ $item->waktu_mulai ? \Carbon\Carbon::parse($item->waktu_mulai)->format('Y-m-d') : '' }}"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editWaktuSelesai{{ $item->id }}"
                                                            class="form-label">Waktu Selesai</label>
                                                        <input type="date" name="waktu_selesai"
                                                            id="editWaktuSelesai{{ $item->id }}"
                                                            value="{{ $item->waktu_selesai ? \Carbon\Carbon::parse($item->waktu_selesai)->format('Y-m-d') : '' }}"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editIsActive{{ $item->id }}"
                                                            class="form-label">Status</label>
                                                        <select name="is_active" id="editIsActive{{ $item->id }}"
                                                            class="form-select" required>
                                                            <option value="1"
                                                                {{ $item->is_active ? 'selected' : '' }}>Aktif</option>
                                                            <option value="0"
                                                                {{ !$item->is_active ? 'selected' : '' }}>Nonaktif</option>
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

                                <!-- Modal Hapus Periode -->
                                <div class="modal fade" id="modalHapusPeriode{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalHapusPeriodeLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form method="POST" action="{{ route('periode.destroy', $item->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Hapus Periode</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin ingin menghapus Periode ini?</p>
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

    <!-- Modal Tambah Periode -->
    <div class="modal fade" id="modalTambahPeriode" tabindex="-1" aria-labelledby="modalTambahPeriodeLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('periode.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Periode</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_periode" class="form-label">Nama Periode</label>
                            <input type="text" name="nama_periode" id="nama_periode" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                            <input type="date" name="waktu_mulai" id="waktu_mulai" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                            <input type="date" name="waktu_selesai" id="waktu_selesai" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select name="is_active" id="is_active" class="form-select" required>
                                <option value="1">Aktif</option>
                                <option value="0" selected>Nonaktif</option>
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
