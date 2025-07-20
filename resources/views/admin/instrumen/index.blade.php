@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title fw-bold">Data Instrumen</h4>
                </div>

                <div class="card-body">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs" id="instrumenTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="guru-tab" data-bs-toggle="tab" data-bs-target="#guru"
                                type="button" role="tab" aria-controls="guru" aria-selected="true">Guru</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="karyawan-tab" data-bs-toggle="tab" data-bs-target="#karyawan"
                                type="button" role="tab" aria-controls="karyawan"
                                aria-selected="false">Karyawan</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="instrumenTabsContent">
                        <!-- Tab Guru -->
                        <div class="tab-pane fade show active" id="guru" role="tabpanel" aria-labelledby="guru-tab">
                            <div class="d-flex justify-content-start mb-3">
                                <button class="btn btn-primary mt-3" data-bs-toggle="modal"
                                    data-bs-target="#modalTambahInstrumenGuru">
                                    <i class="ti ti-plus"></i> Tambah Instrumen Guru
                                </button>
                            </div>
                            <table class="table table-striped" id="datatable-guru">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pertanyaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($instrumen->where('target', 'guru') as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->pertanyaan }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-warning"
                                                        data-bs-target="#modalEditInstrumen{{ $item->id }}"
                                                        data-bs-toggle="modal">
                                                        <i class="ti ti-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#modalHapusInstrumen{{ $item->id }}">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit Instrumen Guru -->
                                        <div class="modal fade" id="modalEditInstrumen{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="modalEditInstrumen{{ $item->id }}Label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST" action="{{ route('instrumen.update', $item->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Instrumen Guru</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="target" value="guru">
                                                            <div class="mb-3">
                                                                <label for="editPertanyaan{{ $item->id }}"
                                                                    class="form-label">Pertanyaan</label>
                                                                <input type="text" name="pertanyaan"
                                                                    id="editPertanyaan{{ $item->id }}"
                                                                    value="{{ $item->pertanyaan }}" class="form-control"
                                                                    required>
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

                                        <!-- Modal Hapus Instrumen -->
                                        <div class="modal fade" id="modalHapusInstrumen{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="modalHapusInstrumenLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <form method="POST" action="{{ route('instrumen.destroy', $item->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Hapus Instrumen</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Yakin ingin menghapus Instrumen ini?</p>
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

                        <!-- Tab Karyawan -->
                        <div class="tab-pane fade" id="karyawan" role="tabpanel" aria-labelledby="karyawan-tab">
                            <div class="d-flex justify-content-start mb-3">
                                <button class="btn btn-primary mt-3" data-bs-toggle="modal"
                                    data-bs-target="#modalTambahInstrumenKaryawan">
                                    <i class="ti ti-plus"></i> Tambah Instrumen Karyawan
                                </button>
                            </div>
                            <table class="table table-striped" id="datatable-karyawan">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pertanyaan</th>
                                        <th>Jurusan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($instrumen->where('target', 'karyawan') as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->pertanyaan }}</td>
                                            <td>{{ $item->jurusan->nama_jurusan ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-warning"
                                                        data-bs-target="#modalEditInstrumen{{ $item->id }}"
                                                        data-bs-toggle="modal">
                                                        <i class="ti ti-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#modalHapusInstrumen{{ $item->id }}">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit Instrumen Karyawan -->
                                        <div class="modal fade" id="modalEditInstrumen{{ $item->id }}"
                                            tabindex="-1" aria-labelledby="modalEditInstrumen{{ $item->id }}Label"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST" action="{{ route('instrumen.update', $item->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Instrumen Karyawan</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="target" value="karyawan">
                                                            <div class="mb-3">
                                                                <label for="editPertanyaan{{ $item->id }}"
                                                                    class="form-label">Pertanyaan</label>
                                                                <input type="text" name="pertanyaan"
                                                                    id="editPertanyaan{{ $item->id }}"
                                                                    value="{{ $item->pertanyaan }}" class="form-control"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editJurusan{{ $item->id }}"
                                                                    class="form-label">Jurusan</label>
                                                                <select name="jurusan_id"
                                                                    id="editJurusan{{ $item->id }}"
                                                                    class="form-select">
                                                                    <option value="">Tidak Ada Jurusan</option>
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

                                        <!-- Modal Hapus Instrumen -->
                                        <div class="modal fade" id="modalHapusInstrumen{{ $item->id }}"
                                            tabindex="-1" aria-labelledby="modalHapusInstrumenLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <form method="POST"
                                                    action="{{ route('instrumen.destroy', $item->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Hapus Instrumen</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Yakin ingin menghapus Instrumen ini?</p>
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
        </div>
    </div>

    <!-- Modal Tambah Instrumen Guru -->
    <div class="modal fade" id="modalTambahInstrumenGuru" tabindex="-1" aria-labelledby="modalTambahInstrumenGuruLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('instrumen.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Instrumen Guru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="target" value="guru">
                        <div class="mb-3">
                            <label for="pertanyaan_guru" class="form-label">Pertanyaan</label>
                            <input type="text" name="pertanyaan" id="pertanyaan_guru" class="form-control" required>
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

    <!-- Modal Tambah Instrumen Karyawan -->
    <div class="modal fade" id="modalTambahInstrumenKaryawan" tabindex="-1"
        aria-labelledby="modalTambahInstrumenKaryawanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('instrumen.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Instrumen Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="target" value="karyawan">
                        <div class="mb-3">
                            <label for="pertanyaan_karyawan" class="form-label">Pertanyaan</label>
                            <input type="text" name="pertanyaan" id="pertanyaan_karyawan" class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="jurusan_id_karyawan" class="form-label">Jurusan</label>
                            <select name="jurusan_id" id="jurusan_id_karyawan" class="form-select">
                                <option value="">Tidak Ada Jurusan</option>
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
    <script>
        $(document).ready(function() {
            $('#datatable-guru').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                }
            });
            $('#datatable-karyawan').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                }
            });
        });
    </script>
@endpush
