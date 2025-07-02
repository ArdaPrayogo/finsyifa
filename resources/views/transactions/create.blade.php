@extends('layouts.main')
@section('container')
    <h2 class="mb-3">Tambah Transaksi</h2>

    <form action="/transaksi" method="POST">
        @csrf

        {{-- Siswa --}}
        <div class="mb-3">
            <label for="student_id" class="form-label">Siswa</label>
            <select name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                <option value="" disabled selected>-- Pilih Siswa --</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->name }} ({{ $student->class }})
                    </option>
                @endforeach
            </select>
            @error('student_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Bill --}}
        <div class="mb-3">
            <label for="bill_id" class="form-label">Tagihan</label>
            <select name="bill_id" class="form-select @error('bill_id') is-invalid @enderror">
                <option value="" selected>-- Pilih Tagihan (opsional) --</option>
                @foreach ($bills as $bill)
                    <option value="{{ $bill->id }}" {{ old('bill_id') == $bill->id ? 'selected' : '' }}>
                        {{ $bill->student->name }} - {{ $bill->billType->name }} (Rp {{ number_format($bill->amount) }})
                    </option>
                @endforeach
            </select>
            @error('bill_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Amount --}}
        <div class="mb-3">
            <label for="amount_paid" class="form-label">Jumlah</label>
            <input type="number" name="amount_paid" class="form-control @error('amount_paid') is-invalid @enderror"
                value="{{ old('amount_paid') }}" required>
            @error('amount_paid')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Payment Date --}}
        <div class="mb-3">
            <label for="payment_date" class="form-label">Tanggal Pembayaran</label>
            <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror"
                value="{{ old('payment_date') ?? now()->format('Y-m-d') }}" required>
            @error('payment_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Note --}}
        <div class="mb-3">
            <label for="note" class="form-label">Catatan</label>
            <textarea name="note" class="form-control">{{ old('note') }}</textarea>
        </div>

        <button class="btn btn-dark" type="submit">Simpan</button>
        <a href="/transaksi" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
