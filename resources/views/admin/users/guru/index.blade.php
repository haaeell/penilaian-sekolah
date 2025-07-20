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
                                <th>Nama</th>
                                <th> Email </th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->guru->nama ?? '-' }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        @if ($item->guru && $item->guru->kelas->isNotEmpty())
                                            {{ $item->guru->kelas->pluck('nama_kelas')->implode(', ') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-warning"
                                                data-bs-target="#modalEditGuru{{ $item->id }}" data-bs-toggle="modal">
                                                <i class="ti ti-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalHapusGuru{{ $item->id }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit Guru -->
                                <div class="modal fade" id="modalEditGuru{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalEditGuru{{ $item->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('guru.update', $item->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Guru</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="editNama{{ $item->id }}"
                                                            class="form-label">Nama</label>
                                                        <input type="text" name="name"
                                                            id="editNama{{ $item->id }}"
                                                            value="{{ $item->guru->nama ?? '' }}" class="form-control"
                                                            required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editEmail{{ $item->id }}"
                                                            class="form-label">Email</label>
                                                        <input type="email" name="email"
                                                            id="editEmail{{ $item->id }}" value="{{ $item->email }}"
                                                            class="form-control" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editKelas{{ $item->id }}" class="form-label">Kelas
                                                            yang Diajar</label>
                                                        <select name="kelas_id[]" id="editKelas{{ $item->id }}"
                                                            class="form-select select2" multiple>
                                                            @foreach ($kelas as $k)
                                                                <option value="{{ $k->id }}"
                                                                    {{ $item->guru && $item->guru->kelas->contains('id', $k->id) ? 'selected' : '' }}>
                                                                    {{ $k->nama_kelas }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="editPassword{{ $item->id }}"
                                                            class="form-label">Password</label>
                                                        <input type="password" name="password"
                                                            id="editPassword{{ $item->id }}" class="form-control">
                                                        <small>Biarkan kosong jika tidak ingin mengganti password</small>
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

                                <!-- Modal Hapus Guru -->
                                <div class="modal fade" id="modalHapusGuru{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalHapusGuruLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form method="POST" action="{{ route('guru.destroy', $item->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Hapus Guru</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin ingin menghapus Guru ini?</p>
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
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas yang Diajar</label>
                            <select name="kelas_id[]" id="kelas_id" class="form-select select2" multiple>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
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
        $(document).ready(function() {
            $('#kelas_id').select2({
                placeholder: "Pilih kelas",
                allowClear: true,
                dropdownParent: $('#modalTambahGuru')
            });

            @foreach ($users as $item)
                $('#editKelas{{ $item->id }}').select2({
                    placeholder: "Pilih kelas",
                    allowClear: true,
                    dropdownParent: $('#modalEditGuru{{ $item->id }}')
                });
            @endforeach

            $('.modal').on('hidden.bs.modal', function() {
                $(this).find('.select2').each(function() {
                    $(this).select2('destroy');
                });
            });

            $('.modal').on('shown.bs.modal', function() {
                $(this).find('.select2').each(function() {
                    $(this).select2({
                        placeholder: "Pilih kelas",
                        allowClear: true,
                        dropdownParent: $(this).closest('.modal')
                    });
                });
            });
        });
    </script>
@endpush
