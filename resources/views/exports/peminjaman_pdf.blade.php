<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Peralatan</title>
    <style>
        body { font-family: 'Arial', sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #b6252a; color: white; }
        .header { text-align: center; margin-bottom: 20px; }
        .date { text-align: right; font-size: 12px; margin-bottom: 10px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="background: #b6252a; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
            🖨️ Print / Save as PDF
        </button>
    </div>

    <div class="header">
        <h2 style="color: #b6252a;">Laporan Peminjaman Peralatan</h2>
        <h3>Lab TEFA PPLG</h3>
    </div>
    <div class="date">
        Tanggal: {{ date('d/m/Y H:i:s') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pengguna</th>
                <th>Kelas</th>
                <th>Peralatan</th>
                <th>Jumlah</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->pengguna->nama }}</td>
                <td>{{ $item->pengguna->kelas }}</td>
                <td>{{ $item->peralatan->nama_peralatan }}</td>
                <td>{{ $item->jumlah_pinjam }}</td>
                <td>{{ $item->tanggal_pinjam }}</td>
                <td>{{ $item->tanggal_kembali ?? '-' }}</td>
                <td>{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>