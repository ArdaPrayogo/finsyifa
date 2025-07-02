@extends('layouts.main')

@section('container')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Detail Tagihan</h2>
</div>

<div class="card mb-4">
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Nama Siswa</th>
                <td>{{ $bill->student->name }} ({{ $bill->student->class }})</td>
            </tr>
            <tr>
                <th>Jenis Tagihan</th>
                <td>{{ $bill->billType->name }}</td>
            </tr>
            <tr>
                <th>Jumlah</th>
                <td>Rp {{ number_format($bill->amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Jatuh Tempo</th>
                <td>{{ \Carbon\Carbon::parse($bill->due_date)->translatedFormat('d F Y') }}</td>
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
        </table>

        <a href="/tagihan" class="btn btn-secondary">Kembali</a>
        <a href="/tagihan/{{ $bill->id }}/edit" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection