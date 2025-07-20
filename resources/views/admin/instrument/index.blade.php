<!DOCTYPE html>
<html>

<head>
    <title>Manajemen Instrumen</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <h1>Manajemen Instrumen</h1>
    <form action="{{ route('admin.instrumen.store') }}" method="POST">
        @csrf
        <input type="text" name="pertanyaan" placeholder="Pertanyaan" required>
        <select name="target" required>
            <option value="guru">Guru</option>
            <option value="karyawan">Karyawan</option>
        </select>
        <select name="jurusan_id">
            <option value="">Pilih Jurusan (opsional)</option>
            @foreach ($jurusan as $j)
                <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
            @endforeach
        </select>
        <button type="submit">Simpan</button>
    </form>

    <h2>Daftar Instrumen</h2>
    <table>
        <tr>
            <th>Pertanyaan</th>
            <th>Target</th>
            <th>Jurusan</th>
        </tr>
        @foreach ($instrumen as $i)
            <tr>
                <td>{{ $i->pertanyaan }}</td>
                <td>{{ $i->target }}</td>
                <td>{{ $i->jurusan ? $i->jurusan->nama_jurusan : '-' }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
