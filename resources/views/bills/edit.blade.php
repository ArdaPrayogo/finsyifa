@extends('layouts.main')

@section('container')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Tagihan Siswa</h2>
    </div>

    <form action="/tagihan/{{ $bill->id }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama Siswa (tidak bisa diubah) --}}
        <div class="mb-3">
            <label for="student_id" class="form-label">Nama Siswa</label>
            <input type="text" class="form-control" value="{{ $bill->student->name }} ({{ $bill->student->class }})"
                disabled>
            <input type="hidden" name="student_id" value="{{ $bill->student_id }}">
        </div>


        <div class="mb-3">
            <label for="bill_type_id" class="form-label">Jenis Tagihan</label>
            <select name="bill_type_id" id="bill_type_id" class="form-select @error('bill_type_id') is-invalid @enderror"
                required>
                <option disabled selected>-- Pilih Jenis --</option>
                @foreach ($billTypes as $type)
                    <option value="{{ $type->id }}"
                        {{ old('bill_type_id', $bill->bill_type_id) == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
            @error('bill_type_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Jumlah Tagihan</label>
            <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror"
                value="{{ old('amount', $bill->amount) }}" required>
            @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Jatuh Tempo</label>
            <input type="date" name="due_date" id="due_date"
                class="form-control @error('due_date') is-invalid @enderror"
                value="{{ old('due_date', \Carbon\Carbon::parse($bill->due_date)->format('Y-m-d')) }}" required>

        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status Pembayaran</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="unpaid" {{ old('status', $bill->status) == 'unpaid' ? 'selected' : '' }}>Belum Lunas
                </option>
                <option value="partial" {{ old('status', $bill->status) == 'partial' ? 'selected' : '' }}>Sebagian</option>
                <option value="paid" {{ old('status', $bill->status) == 'paid' ? 'selected' : '' }}>Lunas</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-dark">Perbarui Tagihan</button>
        <a href="/tagihan" class="btn btn-secondary">Batal</a>
    </form>
@endsection
