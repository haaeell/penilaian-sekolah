@extends('layouts.dashboard')

@section('content')
    <div class="card py-4">
        <div class="card-body">
            <h4 class="mb-3">Detail Rata-rata Penilaian untuk <strong>{{ $nama_target }}</strong> ({{ $nama_periode }})
            </h4>

            <a href="{{ url('/admin/hasil-penilaian') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pertanyaan (Instrumen)</th>
                            <th>Jumlah Penilai</th>
                            <th>Rata-rata Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grouped as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->nama_instrumen }}</td>
                                <td>{{ $item->jumlah_penilai }}</td>
                                <td>{{ number_format($item->rata_rata, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
