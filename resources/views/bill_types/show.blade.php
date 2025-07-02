@extends('layouts.main')

@section('container')
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <h2>Detail Jenis Tagihan</h2>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th>Nama Jenis Tagihan</th>
                    <td>{{ $billType->name }}</td>
                </tr>
                <tr>
                    <th>Jumlah Default</th>
                    <td>Rp {{ number_format($billType->default_amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Tagihan Bulanan</th>
                    <td>{{ $billType->is_monthly ? 'Ya' : 'Tidak' }}</td>
                </tr>
            </table>

            <a href="/daftar_tagihan" class="btn btn-secondary">Kembali</a>
            <a href="/daftar_tagihan/{{ $billType->id }}/edit" class="btn btn-warning">Edit</a>
        </div>
    </div>

    @if ($bills->count())
        <h5 class="mb-3">Siswa yang Memiliki Tagihan Ini</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Jumlah</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bills as $i => $bill)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $bill->student->name }}</td>
                        <td>{{ $bill->student->class }}</td>
                        <td>Rp {{ number_format($bill->amount, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($bill->due_date)->translatedFormat('d F Y') }}</td>
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
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">Belum ada siswa yang memiliki tagihan ini.</p>
    @endif
@endsection
