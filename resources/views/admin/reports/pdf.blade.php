<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Perpustakaan</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { margin: 0; }
        .header p { margin: 5px 0; color: #555; }
        .content-table { border-collapse: collapse; margin: 25px 0; font-size: 0.9em; min-width: 100%; }
        .content-table thead tr { background-color: #009879; color: #ffffff; text-align: left; }
        .content-table th, .content-table td { padding: 12px 15px; }
        .content-table tbody tr { border-bottom: 1px solid #dddddd; }
        .content-table tbody tr:nth-of-type(even) { background-color: #f3f3f3; }
        .content-table tbody tr:last-of-type { border-bottom: 2px solid #009879; }
        .section-title { font-size: 1.2em; margin-top: 30px; margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Statistik Perpustakaan</h1>
        <p>Digenerate pada: {{ $generationDate }}</p>
    </div>

    <div class="section-title">Buku Terpopuler</div>
    <table class="content-table">
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Total Dipinjam</th>
            </tr>
        </thead>
        <tbody>
            @forelse($popularBooks as $index => $book)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->borrowings_count }} kali</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Anggota Paling Aktif</div>
     <table class="content-table">
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama Anggota</th>
                <th>Email</th>
                <th>Total Pinjaman</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activeMembers as $index => $member)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->email }}</td>
                <td>{{ $member->borrowings_count }} kali</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>