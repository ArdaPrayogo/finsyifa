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
        <h1 class="h2">Daftar Jenis Tagihan</h1>
        <a href="daftar_tagihan/create" class="btn btn-outline-primary">Tambah Jenis Tagihan</a>
    </div>

    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tagihan</th>
                <th>Nominal Default</th>
                <th>Bulanan?</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($billTypes as $i => $type)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $type->name }}</td>
                    <td>
                        @if ($type->default_amount)
                            Rp {{ number_format($type->default_amount, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $type->is_monthly ? 'bg-success' : 'bg-secondary' }}">
                            {{ $type->is_monthly ? 'Ya' : 'Tidak' }}
                        </span>
                    </td>
                    <td>
                        <a href="/daftar_tagihan/{{ $type->id }}" class="btn btn-sm btn-primary">Detail</a>
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
