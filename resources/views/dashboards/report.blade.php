@extends('layouts.main')

@section('container')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>Laporan Keuangan Bulanan</h2>
        <form action="/laporan" method="GET" class="d-flex">
            <select name="bulan" class="form-select me-2">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>
            <select name="tahun" class="form-select me-2">
                @for ($y = now()->year; $y >= 2022; $y--)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}
                    </option>
                @endfor
            </select>
            <button class="btn btn-primary" type="submit">Tampilkan</button>
        </form>
        <a href="{{ route('laporan.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-outline-secondary mb-3"
            target="_blank">
            Download PDF
        </a>

    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Periode:</strong> {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</p>
            <p><strong>Total Pemasukan:</strong> Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        </div>
    </div>

    <h5>Rincian Transaksi Pembayaran</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Tagihan</th>
                <th>Jumlah Dibayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksi as $trx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($trx->payment_date)->format('d/m/Y') }}</td>
                    <td>{{ $trx->student->name }}</td>
                    <td>{{ $trx->student->class }}</td>
                    <td>{{ $trx->bill->billType->name }}</td>
                    <td>Rp {{ number_format($trx->amount_paid, 0, ',', '.') }}</td>
                    <td>
                        <a href="/transaksi/{{ $trx->id }}" class="btn btn-sm btn-primary">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data transaksi bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
