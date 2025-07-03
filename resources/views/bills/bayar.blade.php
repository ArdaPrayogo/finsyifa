@extends('layouts.main')
@section('container')
    <h2>Pembayaran Tagihan</h2>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Siswa:</strong> {{ $bill->student->name }} ({{ $bill->student->class }})</p>
            <p><strong>Tagihan:</strong> {{ $bill->billType->name }}</p>
            <p><strong>Total Tagihan:</strong> Rp {{ number_format($bill->amount, 0, ',', '.') }}</p>
            <p><strong>Sisa Pembayaran:</strong> Rp {{ number_format($sisa, 0, ',', '.') }}</p>

            <form action="{{ route('tagihan.bayar.proses', $bill->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="amount_paid" class="form-label">Jumlah Dibayar</label>
                    <input type="number" name="amount_paid" max="{{ $sisa }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="payment_date" class="form-label">Tanggal Pembayaran</label>
                    <input type="date" name="payment_date" class="form-control" value="{{ now()->format('Y-m-d') }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Catatan</label>
                    <textarea name="note" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Bayar</button>
                <a href="/tagihan/{{ $bill->id }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
