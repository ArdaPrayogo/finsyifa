<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Bulanan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background-color: #eee;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h3 class="text-center">Laporan Keuangan Bulanan</h3>
    <p><strong>Periode:</strong> {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</p>
    <p><strong>Total Pemasukan:</strong> Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Tagihan</th>
                <th>Jumlah Dibayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $trx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($trx->payment_date)->format('d/m/Y') }}</td>
                    <td>{{ $trx->student->name }}</td>
                    <td>{{ $trx->student->class }}</td>
                    <td>{{ $trx->bill->billType->name }}</td>
                    <td class="text-right">Rp {{ number_format($trx->amount_paid, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
