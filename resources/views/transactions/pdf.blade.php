<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Nota Transaksi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: auto;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 8px;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .mt-3 {
            margin-top: 20px;
        }

        .line {
            border-bottom: 1px dashed #999;
            margin: 20px 0;
        }

        .ttd {
            margin-top: 40px;
            text-align: center;
        }

        .ttd img {
            max-height: 100px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Nota Transaksi Pembayaran</h2>
        <div class="line"></div>
        <table>
            <tr>
                <td>Nama Siswa</td>
                <td>: {{ $transaction->student->name }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>: {{ $transaction->student->class }}</td>
            </tr>
            <tr>
                <td>Jenis Tagihan</td>
                <td>: {{ $transaction->bill->billType->name }}</td>
            </tr>
            @if ($transaction->bill->month && $transaction->bill->year)
                <tr>
                    <td>Periode</td>
                    <td>: {{ DateTime::createFromFormat('!m', $transaction->bill->month)->format('F') }}
                        {{ $transaction->bill->year }}</td>
                </tr>
            @endif
            <tr>
                <td>Jumlah Tagihan</td>
                <td>: Rp {{ number_format($transaction->bill->amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Jumlah Dibayar</td>
                <td>: Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kekurangan</td>
                <td>: Rp
                    {{ number_format(max(0, $transaction->bill->amount - $transaction->bill->transactions->sum('amount_paid')), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td>Tanggal Pembayaran</td>
                <td>: {{ \Carbon\Carbon::parse($transaction->payment_date)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Catatan</td>
                <td>: {{ $transaction->note ?? '-' }}</td>
            </tr>
        </table>

        {{-- Tanda Tangan --}}
        @if ($transaction->signature_path)
            <div class="ttd">
                <p>TTD Bendahara</p>
                <img src="{{ public_path('storage/' . $transaction->signature_path) }}" alt="Tanda Tangan"
                    style="max-height: 100px;">
            </div>
        @endif

        <div class="mt-3 text-center">
            <p>Terima kasih telah melakukan pembayaran.</p>
        </div>
    </div>
</body>

</html>
