@extends('layouts.main')

@section('container')
    <div class="pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">Selamat Datang di Finsyifa</h1>
        <p class="text-muted">Sistem Administrasi Keuangan RA Syifaul Qolbi</p>
    </div>

    {{-- Navigasi Menu Utama --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <a href="/siswa" class="text-decoration-none">
                <div class="card shadow-sm text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-people-fill fs-1 text-primary mb-2"></i>
                        <h5 class="card-title">Data Siswa</h5>
                        <p class="card-text text-muted small">Kelola data siswa dan kelas.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="/tagihan" class="text-decoration-none">
                <div class="card shadow-sm text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-receipt fs-1 text-success mb-2"></i>
                        <h5 class="card-title">Tagihan</h5>
                        <p class="card-text text-muted small">Kelola tagihan bulanan dan satuan.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="/transaksi" class="text-decoration-none">
                <div class="card shadow-sm text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-wallet2 fs-1 text-warning mb-2"></i>
                        <h5 class="card-title">Transaksi</h5>
                        <p class="card-text text-muted small">Catat pembayaran dan histori transaksi.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="/laporan" class="text-decoration-none">
                <div class="card shadow-sm text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-graph-up fs-1 text-danger mb-2"></i>
                        <h5 class="card-title">Laporan</h5>
                        <p class="card-text text-muted small">Lihat laporan keuangan bulanan.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Tabel Siswa --}}
    <div class="table-responsive">
        <table id="myTable" class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $i => $student)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->class }}</td>
                        <td>
                            <a href="{{ url('/siswa/' . $student->id) }}" class="btn btn-primary btn-sm">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- DataTable --}}
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data tersedia",
                    infoFiltered: "(difilter dari _MAX_ total data)"
                }
            });
        });
    </script>
@endsection
