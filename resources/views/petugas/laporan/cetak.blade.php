<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan Perpustakaan</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; }
        h2 { text-align: center; margin-bottom: 10px; }
        hr { border: 2px solid black; margin-bottom: 10px; }

        .info {
            margin-bottom: 20px;
            font-size: 14px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 13px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #035B73;
            color: white;
            text-align: center;
        }

        td.center {
            text-align: center;
        }

        .btn-print {
            display: none;
        }

        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <h2>Laporan Bulanan Perpustakaan<br>Sekolah Dasar Negeri 02 Kuta</h2>
    <hr>

    <div class="info">
        <p>Nama Petugas : {{ auth()->user()->name }}</p>
        <p>Tanggal : {{ date('d') }} {{ strtolower(date('F')) }} {{ date('Y') }}</p>
        <p>Laporan Bulan : 
            @php
                $bulanArr = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                $bulanInput = request('bulan');
                $namaBulan = $bulanInput ? $bulanArr[intval($bulanInput)] : '-';
            @endphp
            {{ $namaBulan }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Buku</th>
                <th>Judul Buku</th>
                <th>NIS Pengunjung</th>
                <th>Nama Pengunjung</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Pengembalian</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $i => $item)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $item->buku->kode_buku }}</td>
                    <td>{{ $item->buku->judul }}</td>
                    <td>{{ $item->pengunjung->nis }}</td>
                    <td>{{ $item->pengunjung->nama }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->tanggal_pinjam)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->tanggal_kembali)) }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="center">Tidak ada data peminjaman untuk bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.print();
    </script>

</body>
</html>
