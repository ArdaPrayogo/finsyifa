@extends('layouts.main')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Welcome back</h1>
    </div>
    @php
        $students = [
            ['name' => 'Ahmad Fauzan', 'class' => 'A1'],
            ['name' => 'Siti Nurhaliza', 'class' => 'B2'],
            ['name' => 'Dewi Lestari', 'class' => 'A2'],
            ['name' => 'Rizky Ramadhan', 'class' => 'B1'],
            ['name' => 'Putri Ayu', 'class' => 'A1'],
        ];
    @endphp

    <table id="myTable" class="table table-bordered table-striped">
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
                    <td>{{ $student['name'] }}</td>
                    <td>{{ $student['class'] }}</td>
                    <td><a href="#" class="btn btn-primary btn-sm">Detail</a></td>
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
