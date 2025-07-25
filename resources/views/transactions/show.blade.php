@extends('layouts.main')
@section('container')
    <div class="d-flex justify-content-between">

        <h2 class="mb-3">Detail Transaksi</h2>
        <div>
            <a href="{{ route('transaksi.nota', $transaction->id) }}" class="btn btn-outline-secondary" target="_blank">Lihat
                Nota</a>
            <a href="{{ route('transaksi.nota.pdf', $transaction->id) }}" class="btn btn-outline-primary"
                target="_blank">Download
                PDF</a>
        </div>

    </div>

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
                    <td>Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Total Tagihan</th>
                    <td>Rp {{ number_format($transaction->bill->amount_paid, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Total Telah Dibayar</th>
                    <td>
                        Rp
                        {{ number_format($transaction->bill->transactions->sum('amount_paid'), 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <th>Kekurangan</th>
                    <td>
                        @php
                            $kekurangan =
                                $transaction->bill->amount - $transaction->bill->transactions->sum('amount_paid');
                        @endphp
                        Rp {{ number_format(max($kekurangan, 0), 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Pembayaran</th>
                    <td>{{ \Carbon\Carbon::parse($transaction->payment_date)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Catatan</th>
                    <td>{{ $transaction->note ?? '-' }}</td>
                </tr>
                @if ($transaction->signature_path)
                    <tr>
                        <th>Tanda Tangan Bendahara</th>
                        <td>
                            <img src="{{ asset('storage/' . $transaction->signature_path) }}" alt="Tanda Tangan"
                                style="border:1px solid #ccc; max-width:400px;">
                        </td>
                    </tr>
                @endif
            </table>
            <a href="/transaksi" class="btn btn-secondary">Kembali</a>
            <a href="/transaksi/{{ $transaction->id }}/edit" class="btn btn-secondary">Edit</a>
        </div>
    </div>
@endsection
