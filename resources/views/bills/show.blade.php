@extends('layouts.main')

@section('container')
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <h2>Detail Tagihan</h2>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th>Nama Siswa</th>
                    <td>{{ $bill->student->name }} ({{ $bill->student->class }})</td>
                </tr>
                <tr>
                    <th>Jenis Tagihan</th>
                    <td>{{ $bill->billType->name }}</td>
                </tr>
                <tr>
                    <th>Jumlah Tagihan</th>
                    <td>Rp {{ number_format($bill->amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Jumlah Dibayar</th>
                    <td>
                        Rp {{ number_format($bill->transactions->sum('amount_paid'), 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <th>Kekurangan</th>
                    @php
                        $sisa = $bill->amount - $bill->transactions->sum('amount_paid');
                    @endphp
                    <td>
                        Rp {{ number_format(max($sisa, 0), 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <th>Jatuh Tempo</th>
                    <td>
                        {{ $bill->due_date ? \Carbon\Carbon::parse($bill->due_date)->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if ($bill->status == 'paid')
                            <span class="badge bg-success">Lunas</span>
                        @elseif ($bill->status == 'partial')
                            <span class="badge bg-warning text-dark">Sebagian</span>
                        @else
                            <span class="badge bg-danger">Belum Lunas</span>
                        @endif
                    </td>
                </tr>
                @if ($bill->month && $bill->year)
                    <tr>
                        <th>Periode</th>
                        <td>{{ DateTime::createFromFormat('!m', $bill->month)->format('F') }} {{ $bill->year }}</td>
                    </tr>
                @endif

                @php
                    $latestTransaction = $bill->transactions->sortByDesc('payment_date')->first();
                @endphp

                @if ($latestTransaction && $latestTransaction->signature_path)
                    <tr>
                        <th>Tanda Tangan Bendahara</th>
                        <td>
                            <img src="{{ asset('storage/' . $latestTransaction->signature_path) }}" alt="Tanda Tangan"
                                style="border:1px solid #ccc; max-width:400px;">
                        </td>
                    </tr>
                @endif
            </table>


            <a href="/tagihan" class="btn btn-secondary">Kembali</a>
            <a href="/tagihan/{{ $bill->id }}/edit" class="btn btn-warning">Edit</a>
            @php
                $totalPaid = $bill->transactions->sum('amount_paid');
                $sisa = $bill->amount - $totalPaid;
            @endphp

            @if ($sisa > 0)
                <a href="/tagihan/{{ $bill->id }}/bayar" class="btn btn-primary">Bayar Tagihan</a>
            @else
                @php
                    $latestTransaction = $bill->transactions->sortByDesc('payment_date')->first();
                @endphp
                @if ($latestTransaction)
                    <a href="{{ route('transaksi.nota', $latestTransaction->id) }}" class="btn btn-outline-secondary"
                        target="_blank">Lihat
                        Nota</a>
                    <a href="{{ route('transaksi.nota.pdf', $latestTransaction->id) }}" class="btn btn-outline-primary"
                        target="_blank">Download PDF</a>
                @endif
            @endif

        </div>
    </div>
@endsection
