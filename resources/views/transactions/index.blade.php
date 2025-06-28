@extends('layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Daftar Transaksi Pembayaran</h1>
    </div>

    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Jenis Tagihan</th>
                <th>Jumlah Dibayar</th>
                <th>Tanggal Pembayaran</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $i => $trx)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $trx->student->name }}</td>
                    <td>{{ $trx->bill->billType->name }}</td>
                    <td>Rp {{ number_format($trx->amount_paid, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->payment_date)->translatedFormat('d F Y') }}</td>
                    <td>{{ $trx->note ?? '-' }}</td>
                    <td>
                        <a href="/" class="btn btn-sm btn-primary">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data tersedia",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                }
            });
        });
    </script>
@endsection
