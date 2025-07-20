<!DOCTYPE html>
<html>

<head>
    <title>Form Penilaian</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <h1>Penilaian</h1>
    @if ($periode)
        <form action="{{ route('siswa.penilaian.submit') }}" method="POST">
            @csrf
            <h2>Penilaian Guru</h2>
            @foreach ($guru as $g)
                <h3>{{ $g->nama }}</h3>
                <input type="hidden" name="target_id" value="{{ $g->user_id }}">
                @foreach ($instrumenGuru as $i)
                    <p>{{ $i->pertanyaan }}</p>
                    <input type="number" name="skor[{{ $i->id }}]" min="1" max="5" required>
                @endforeach
            @endforeach

            <h2>Penilaian Karyawan</h2>
            @foreach ($karyawan as $k)
                <h3>{{ $k->nama }}</h3>
                <input type="hidden" name="target_id" value="{{ $k->user_id }}">
                @foreach ($instrumenKaryawan as $i)
                    <p>{{ $i->pertanyaan }}</p>
                    <input type="number" name="skor[{{ $i->id }}]" min="1" max="5" required>
                @endforeach
            @endforeach
            <button type="submit">Submit</button>
        </form>
    @else
        <p>Tidak ada periode penilaian aktif.</p>
    @endif
</body>

</html>
