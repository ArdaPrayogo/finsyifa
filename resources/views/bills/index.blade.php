@extends('layouts.main')

@section('container')
    <div class="">
        {{-- Alert Berhasil Tambah/Edit --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show col-lg-12" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Alert Berhasil Hapus --}}
        @if (session()->has('deleted'))
            <div class="alert alert-danger alert-dismissible fade show col-lg-12" role="alert">
                {{ session('deleted') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tagihan</h1>
        <div class="d-flex">
            <div class="dropdown mx-3 mb-3">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Tambah Tagihan
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="/tagihan/create">Tambah tagihan satuan</a></li>
                    <li><a class="dropdown-item" href="/massal">Tambah tagihan massal</a></li>
                </ul>
            </div>
            <div>
                <a href="/bulanan" class="btn btn-outline-success">Tambah tagihan bulanan</a>
            </div>
        </div>


    </div>

    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Jenis Tagihan</th>
                <th>Jumlah</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bills as $i => $bill)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $bill->student->name }}</td>
                    <td>{{ $bill->billType->name }}</td>
                    <td>Rp {{ number_format($bill->amount, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($bill->due_date)->translatedFormat('d F Y') }}</td>
                    <td>
                        @if ($bill->status === 'paid')
                            <span class="badge bg-success">Lunas</span>
                        @elseif ($bill->status === 'partial')
                            <span class="badge bg-warning text-dark">Sebagian</span>
                        @else
                            <span class="badge bg-danger">Belum Lunas</span>
                        @endif
                    </td>
                    <td>
                        <a href="/tagihan/{{ $bill->id }}" class="btn btn-primary btn-sm">Detail</a>
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
