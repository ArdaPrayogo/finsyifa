@extends('layouts.main')

@section('container')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Jenis Tagihan</h2>
    </div>

    <form action="/daftar_tagihan/{{ $billType->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Jenis Tagihan</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $billType->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="default_amount" class="form-label">Jumlah Default</label>
            <input type="number" name="default_amount" id="default_amount"
                class="form-control @error('default_amount') is-invalid @enderror"
                value="{{ old('default_amount', $billType->default_amount) }}">
            @error('default_amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="is_monthly" class="form-label">Apakah Tagihan Bulanan?</label>
            <select name="is_monthly" id="is_monthly" class="form-select @error('is_monthly') is-invalid @enderror">
                <option value="1" {{ old('is_monthly', $billType->is_monthly) == 1 ? 'selected' : '' }}>Ya</option>
                <option value="0" {{ old('is_monthly', $billType->is_monthly) == 0 ? 'selected' : '' }}>Tidak</option>
            </select>
            @error('is_monthly')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-dark">Simpan Perubahan</button>
        <a href="/jenis-tagihan" class="btn btn-secondary">Batal</a>
    </form>
@endsection
