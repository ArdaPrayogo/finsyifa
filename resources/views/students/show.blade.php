@extends('layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Siswa</h1>
        <a href="/siswa/{{ $student->id }}/edit" class="btn btn-outline-primary">Edit data siswa</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">{{ $student->name }}</h4>

            <table class="table table-borderless">
                <tr>
                    <td style="width: 200px"><strong>Kelas</strong></td>
                    <td>{{ $student->class }}</td>
                </tr>
                <tr>
                    <td><strong>Nama Orang Tua</strong></td>
                    <td>{{ $student->parent_name }}</td>
                </tr>
                <tr>
                    <td><strong>Alamat</strong></td>
                    <td>{{ $student->address }}</td>
                </tr>
                <tr>
                    <td><strong>No. Telepon</strong></td>
                    <td>{{ $student->phone }}</td>
                </tr>
            </table>

            <a href="/siswa" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    {{-- Tabel Daftar Tagihan --}}
    <h4 class="mb-3">Daftar Tagihan</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Tagihan</th>
                <th>Jumlah</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($student->bills as $i => $bill)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $bill->billType->name }}</td>
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
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada tagihan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="">
        <form action="/siswa/{{ $student->id }}" method="POST" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
            @csrf
            @method('DELETE')
            <button class="col-12 btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus Data Siswa</button>
        </form>
    </div>
@endsection
