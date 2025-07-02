@extends('layouts.main')
@section('container')
    <h2 class="mb-4">Tambah Tagihan</h2>
    <form action="/tagihan" method="POST">
        @csrf
        <div class="mb-3">
            <label for="student_id" class="form-label">Siswa</label>
            <select name="student_id" class="form-select">
                @foreach ($students as $s)
                    <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->class }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="bill_type_id" class="form-label">Jenis Tagihan</label>
            <select name="bill_type_id" class="form-select">
                @foreach ($billTypes as $bt)
                    <option value="{{ $bt->id }}">{{ $bt->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Jumlah</label>
            <input type="number" class="form-control" name="amount">
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Jatuh Tempo</label>
            <input type="date" class="form-control" name="due_date">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="unpaid">Belum Lunas</option>
                <option value="partial">Sebagian</option>
                <option value="paid">Lunas</option>
            </select>
        </div>

        <button class="btn btn-dark" type="submit">Simpan</button>
        <a href="/tagihan" class="btn btn-secondary">Batal</a>
    </form>
@endsection
