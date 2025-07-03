@extends('layouts.main')
@section('container')
    <h2 class="mb-3">Tambah Transaksi</h2>

    <form action="/transaksi" method="POST">
        @csrf

        {{-- Siswa --}}
        <div class="mb-3">
            <label for="student_id" class="form-label">Siswa</label>
            <select id="student-select" name="student_id" class="form-select @error('student_id') is-invalid @enderror"
                required>
                <option value="" disabled selected>-- Pilih Siswa --</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->class }})</option>
                @endforeach
            </select>
            @error('student_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Bill --}}
        <div class="mb-3">
            <label for="bill_id" class="form-label">Tagihan</label>
            <select id="bill-select" name="bill_id" class="form-select @error('bill_id') is-invalid @enderror" required
                disabled>
                <option value="">-- Pilih Tagihan --</option>
            </select>
            @error('bill_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Info Kekurangan Pembayaran --}}
        <div id="remaining-info" class="mb-3 text-muted" style="display: none;">
            <strong>Sisa pembayaran:</strong> <span id="remaining-amount"></span>
        </div>

        {{-- Amount --}}
        <div class="mb-3">
            <label for="amount_paid" class="form-label">Jumlah</label>
            <input type="number" id="amount-paid" name="amount_paid"
                class="form-control @error('amount_paid') is-invalid @enderror" value="{{ old('amount_paid') }}" required>
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

    <script>
        let billData = [];

        document.getElementById('student-select').addEventListener('change', function() {
            const studentId = this.value;
            const billSelect = document.getElementById('bill-select');

            billSelect.innerHTML = `<option value="">Memuat tagihan...</option>`;
            billSelect.disabled = true;
            document.getElementById('remaining-info').style.display = 'none';

            fetch(`/api/get-bills-by-student/${studentId}`)
                .then(response => response.json())
                .then(data => {
                    billData = data;
                    billSelect.innerHTML = `<option value="">-- Pilih Tagihan --</option>`;
                    if (data.length > 0) {
                        data.forEach(bill => {
                            const amount = parseInt(bill.amount);
                            const paid = parseInt(bill.total_paid || 0);
                            const remaining = amount - paid;

                            const isMonthly = bill.month && bill.year;
                            const period = isMonthly ?
                                ` (${new Date(bill.year, bill.month - 1).toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })})` :
                                '';
                            const type = isMonthly ? 'Tagihan Bulanan' : 'Tagihan Satuan';

                            billSelect.innerHTML += `
                                <option value="${bill.id}">
                                    ${bill.bill_type.name}${period} - ${type} - Rp ${amount.toLocaleString('id-ID')}
                                </option>`;
                        });
                        billSelect.disabled = false;
                    } else {
                        billSelect.innerHTML = `<option value="">Tidak ada tagihan</option>`;
                    }
                });
        });

        document.getElementById('bill-select').addEventListener('change', function() {
            const selectedId = this.value;
            const selected = billData.find(b => b.id == selectedId);
            const amountPaidInput = document.getElementById('amount-paid');

            if (selected) {
                const remaining = selected.amount - (selected.total_paid || 0);
                document.getElementById('remaining-info').style.display = 'block';
                document.getElementById('remaining-amount').innerText = 'Rp ' + remaining.toLocaleString('id-ID');

                // Batasi input maksimal
                amountPaidInput.max = remaining;
            } else {
                document.getElementById('remaining-info').style.display = 'none';
                amountPaidInput.removeAttribute('max');
            }
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            const selectedId = document.getElementById('bill-select').value;
            const selected = billData.find(b => b.id == selectedId);
            const amountPaid = parseInt(document.getElementById('amount-paid').value);

            if (selected) {
                const remaining = selected.amount - (selected.total_paid || 0);
                if (amountPaid > remaining) {
                    e.preventDefault();
                    alert('Jumlah pembayaran tidak boleh melebihi sisa tagihan: Rp ' + remaining.toLocaleString(
                        'id-ID'));
                }
            }
        });
    </script>
@endsection
