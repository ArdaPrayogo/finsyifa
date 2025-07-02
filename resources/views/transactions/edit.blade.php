@extends('layouts.main')
@section('container')
    <h2 class="mb-3">Edit Transaksi</h2>

    <form action="/transaksi/{{ $transaction->id }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama Siswa (disabled + hidden) --}}
        <div class="mb-3">
            <label class="form-label">Siswa</label>
            <input type="text" class="form-control"
                value="{{ $transaction->student->name }} ({{ $transaction->student->class }})" disabled>
            <input type="hidden" name="student_id" value="{{ $transaction->student_id }}">
        </div>

        {{-- Tagihan (disabled + hidden) --}}
        <div class="mb-3">
            <label class="form-label">Tagihan</label>
            <input type="text" class="form-control"
                value="{{ $transaction->bill->billType->name }} - Rp {{ number_format($transaction->bill->amount, 0, ',', '.') }}"
                disabled>
            <input type="hidden" name="bill_id" value="{{ $transaction->bill_id }}">
        </div>

        {{-- Jumlah Bayar --}}
        <div class="mb-3">
            <label for="amount_paid" class="form-label">Jumlah</label>
            <input type="number" name="amount_paid" class="form-control @error('amount_paid') is-invalid @enderror"
                value="{{ old('amount_paid', $transaction->amount_paid) }}" required>
            @error('amount_paid')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal Pembayaran --}}
        <div class="mb-3">
            <label for="payment_date" class="form-label">Tanggal Pembayaran</label>
            <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror"
                value="{{ old('payment_date', \Carbon\Carbon::parse($transaction->payment_date)->format('Y-m-d')) }}"
                required>
            @error('payment_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Catatan --}}
        <div class="mb-3">
            <label for="note" class="form-label">Catatan</label>
            <textarea name="note" class="form-control">{{ old('note', $transaction->note) }}</textarea>
        </div>

        <button class="btn btn-dark" type="submit">Perbarui</button>
        <a href="/transaksi" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
