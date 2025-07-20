@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">Ringkasan Hasil Penilaian</h4>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="datatable">
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th>Nama</th>
                            <th>Jumlah Siswa</th>
                            <th>Rata-rata Skor</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grouped as $item)
                            <tr>
                                <td>{{ $item->nama_periode }}</td>
                                <td>{{ $item->nama_target }}</td>
                                <td>{{ $item->jumlah_siswa }}</td>
                                <td>{{ number_format($item->rata_rata, 2) }}</td>
                                <td>
                                    <form action="{{ route('hasil-penilaian.detail', $item->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="nama_target" value="{{ $item->nama_target }}">
                                        <input type="hidden" name="nama_periode" value="{{ $item->nama_periode }}">
                                        <button type="submit" class="btn btn-sm btn-primary">Detail</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
