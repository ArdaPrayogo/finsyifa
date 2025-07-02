@extends('layouts.main')
@section('container')
    <h2 class="mb-3">Detail Transaksi</h2>

    <div class="card">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th>Nama Siswa</th>
                    <td>{{ $transaction->student->name }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ $transaction->student->class }}</td>
                </tr>
                <tr>
                    <th>Jumlah Pembayaran</th>
                    <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pembayaran</th>
                    <td>{{ \Carbon\Carbon::parse($transaction->payment_date)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Catatan</th>
                    <td>{{ $transaction->note ?? '-' }}</td>
                </tr>
            </table>
            <a href="/transaksi" class="btn btn-secondary">Kembali</a>
            <a href="/transaksi/{{ $transaction->id }}/edit" class="btn btn-secondary">edit</a>
        </div>
    </div>
@endsection
