@extends('layouts.dashboard')

@section('content')
    <style>
        .custom-radio input[type="radio"] {
            width: 24px;
            height: 24px;
            cursor: pointer;
            vertical-align: middle;
        }

        .custom-radio input[type="radio"]:checked {
            background-color: #007bff;
            border-color: #007bff;
        }

        .custom-radio input[type="radio"]:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }

        .custom-radio label {
            margin-left: 8px;
            font-size: 16px;
            vertical-align: middle;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-12">
            <h3 class="fw-bold text-center">
                Penilaian Guru dan Karyawan
            </h3>
            <div class="card mt-3">
                <div class="card-header">
                    <table style="border: none; width: 100%;">
                        <tr>
                            <td style="padding: 0; width: 30%;" class="fw-bold">Periode Aktif</td>
                            <td style="padding: 0;">: {{ $periode_aktif->nama_periode ?? 'Tidak ada periode aktif' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0;" class="fw-bold">Siswa</td>
                            <td style="padding: 0;">: {{ $siswa->nama }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0;" class="fw-bold">Kelas</td>
                            <td style="padding: 0;">: {{ $siswa->kelas->nama_kelas }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0;" class="fw-bold">Jurusan</td>
                            <td style="padding: 0;">: {{ $siswa->jurusan->nama_jurusan }}</td>
                        </tr>
                    </table>
                </div>

                <div class="card-body">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs" id="penilaianTabs" role="tablist">
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
                    <div class="tab-content" id="penilaianTabsContent">
                        <!-- Tab Guru -->
                        <div class="tab-pane fade show active" id="guru" role="tabpanel" aria-labelledby="guru-tab">
                            @if ($periode_aktif)
                                <form method="POST" action="{{ route('penilaian.store') }}">
                                    @csrf
                                    <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                                    <input type="hidden" name="periode_id" value="{{ $periode_aktif->id }}">

                                    @php
                                        $semuaInstrumenGuruSudahDinilai = true;
                                    @endphp
                                    @foreach ($guru as $g)
                                        <h5 class="mt-3">{{ $g->nama }}</h5>
                                        <input type="hidden" name="target_ids[guru][]" value="{{ $g->id }}">
                                        <table class="table table-striped" id="datatable-guru-{{ $g->id }}">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Pertanyaan</th>
                                                    <th>Sangat Baik (4)</th>
                                                    <th>Baik (3)</th>
                                                    <th>Tidak Baik (2)</th>
                                                    <th>Sangat Tidak Baik (1)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($instrumen_guru as $instrumen)
                                                    @php
                                                        $penilaian = $penilaian_data
                                                            ->where('target_id', $g->id)
                                                            ->where('instrumen_id', $instrumen->id)
                                                            ->first();

                                                        if (!$penilaian) {
                                                            $semuaInstrumenGuruSudahDinilai = false;
                                                        }

                                                        $isDisabled = $penilaian ? 'disabled' : '';
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $instrumen->pertanyaan }}</td>
                                                        <td class="custom-radio">
                                                            <input type="radio"
                                                                name="skor[guru][{{ $g->id }}][{{ $instrumen->id }}]"
                                                                value="4"
                                                                {{ $penilaian && $penilaian->skor == 4 ? 'checked' : '' }}
                                                                {{ $isDisabled }} required>
                                                        </td>
                                                        <td class="custom-radio">
                                                            <input type="radio"
                                                                name="skor[guru][{{ $g->id }}][{{ $instrumen->id }}]"
                                                                value="3"
                                                                {{ $penilaian && $penilaian->skor == 3 ? 'checked' : '' }}
                                                                {{ $isDisabled }}>
                                                        </td>
                                                        <td class="custom-radio">
                                                            <input type="radio"
                                                                name="skor[guru][{{ $g->id }}][{{ $instrumen->id }}]"
                                                                value="2"
                                                                {{ $penilaian && $penilaian->skor == 2 ? 'checked' : '' }}
                                                                {{ $isDisabled }}>
                                                        </td>
                                                        <td class="custom-radio">
                                                            <input type="radio"
                                                                name="skor[guru][{{ $g->id }}][{{ $instrumen->id }}]"
                                                                value="1"
                                                                {{ $penilaian && $penilaian->skor == 1 ? 'checked' : '' }}
                                                                {{ $isDisabled }}>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" class="btn btn-primary"
                                            {{ $semuaInstrumenGuruSudahDinilai ? 'disabled' : '' }}>
                                            {{ $semuaInstrumenGuruSudahDinilai ? 'Sudah Dinilai' : 'Simpan Semua Penilaian Guru' }}
                                        </button>
                                    </div>
                                </form>
                            @else
                                <p>Tidak ada periode aktif untuk penilaian.</p>
                            @endif
                        </div>

                        <!-- Tab Karyawan -->
                        <div class="tab-pane fade" id="karyawan" role="tabpanel" aria-labelledby="karyawan-tab">
                            @if ($periode_aktif)
                                <form method="POST" action="{{ route('penilaian.store') }}">
                                    @csrf
                                    <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                                    <input type="hidden" name="periode_id" value="{{ $periode_aktif->id }}">

                                    @foreach ($karyawan as $k)
                                        <h5 class="mt-3">{{ $k->nama }} ({{ $k->jurusan->nama_jurusan ?? '-' }})
                                        </h5>
                                        <input type="hidden" name="target_ids[karyawan][]" value="{{ $k->id }}">
                                        <table class="table table-striped" id="datatable-karyawan-{{ $k->id }}">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Pertanyaan</th>
                                                    <th>Sangat Baik (4)</th>
                                                    <th>Baik (3)</th>
                                                    <th>Tidak Baik (2)</th>
                                                    <th>Sangat Tidak Baik (1)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $semuaInstrumenKaryawanSudahDinilai = true;
                                                @endphp
                                                @foreach ($instrumen_karyawan as $instrumen)
                                                    @php
                                                        $penilaian = $penilaian_data
                                                            ->where('target_id', $k->id)
                                                            ->where('instrumen_id', $instrumen->id)
                                                            ->first();
                                                        if (!$penilaian) {
                                                            $semuaInstrumenKaryawanSudahDinilai = false;
                                                        }
                                                        $isDisabled = $penilaian ? 'disabled' : '';
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $instrumen->pertanyaan }}</td>
                                                        <td class="custom-radio">
                                                            <input type="radio"
                                                                name="skor[karyawan][{{ $k->id }}][{{ $instrumen->id }}]"
                                                                value="4"
                                                                {{ $penilaian && $penilaian->skor == 4 ? 'checked' : '' }}
                                                                {{ $isDisabled }} required>
                                                        </td>
                                                        <td class="custom-radio">
                                                            <input type="radio"
                                                                name="skor[karyawan][{{ $k->id }}][{{ $instrumen->id }}]"
                                                                value="3"
                                                                {{ $penilaian && $penilaian->skor == 3 ? 'checked' : '' }}
                                                                {{ $isDisabled }}>
                                                        </td>
                                                        <td class="custom-radio">
                                                            <input type="radio"
                                                                name="skor[karyawan][{{ $k->id }}][{{ $instrumen->id }}]"
                                                                value="2"
                                                                {{ $penilaian && $penilaian->skor == 2 ? 'checked' : '' }}
                                                                {{ $isDisabled }}>
                                                        </td>
                                                        <td class="custom-radio">
                                                            <input type="radio"
                                                                name="skor[karyawan][{{ $k->id }}][{{ $instrumen->id }}]"
                                                                value="1"
                                                                {{ $penilaian && $penilaian->skor == 1 ? 'checked' : '' }}
                                                                {{ $isDisabled }}>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" class="btn btn-primary"
                                            {{ $semuaInstrumenKaryawanSudahDinilai ? 'disabled' : '' }}>
                                            {{ $semuaInstrumenKaryawanSudahDinilai ? 'Sudah Dinilai' : 'Simpan Semua Penilaian Karyawan' }}
                                        </button>
                                    </div>
                                </form>
                            @else
                                <p>Tidak ada periode aktif untuk penilaian.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('[id^=datatable-guru-]').each(function() {
                $(this).DataTable({
                    responsive: true,
                });
            });
            $('[id^=datatable-karyawan-]').each(function() {
                $(this).DataTable({
                    responsive: true,
                });
            });

            $('.custom-radio input[type="radio"]').on('change', function() {
                $(this).closest('tr').find('input[type="radio"]').removeClass('checked-radio');
                $(this).addClass('checked-radio');
            });
        });
    </script>
@endpush
