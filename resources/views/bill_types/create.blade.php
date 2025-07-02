@extends('layouts.main')

@section('container')
    <h2 class="mb-4">Tambah Jenis Tagihan</h2>
    <form action="/daftar_tagihan" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Jenis</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="mb-3">
            <label for="default_amount" class="form-label">Jumlah Default</label>
            <input type="number" class="form-control" name="default_amount">
        </div>

        <div class="mb-3">
            <label for="is_monthly" class="form-label">Tagihan Bulanan?</label>
            <select name="is_monthly" class="form-select">
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-dark">Simpan</button>
        <a href="/jenis-tagihan" class="btn btn-secondary">Batal</a>
    </form>
@endsection
