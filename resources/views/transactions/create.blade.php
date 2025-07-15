@extends('layouts.main')

@section('container')
    <h2 class="mb-3">Tambah Transaksi</h2>

    <form id="transaksi-form" action="/transaksi" method="POST">
        @csrf

        {{-- Siswa --}}
        <div class="mb-3">
            <label for="student_id" class="form-label">Siswa</label>
            <select id="student-select" name="student_id" class="form-select" required>
                <option value="" disabled selected>-- Pilih Siswa --</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->class }})</option>
                @endforeach
            </select>
        </div>

        {{-- Tagihan --}}
        <div class="mb-3">
            <label for="bill_id" class="form-label">Tagihan</label>
            <select id="bill-select" name="bill_id" class="form-select" required disabled>
                <option value="">-- Pilih Tagihan --</option>
            </select>
        </div>

        {{-- Info Sisa Tagihan --}}
        <div id="remaining-info" class="mb-3 text-muted" style="display: none;">
            <strong>Sisa pembayaran:</strong> <span id="remaining-amount"></span>
        </div>

        {{-- Jumlah Bayar --}}
        <div class="mb-3">
            <label for="amount_paid" class="form-label">Jumlah</label>
            <input type="number" id="amount-paid" name="amount_paid" class="form-control" required>
        </div>

        {{-- Tanggal Pembayaran --}}
        <div class="mb-3">
            <label for="payment_date" class="form-label">Tanggal Pembayaran</label>
            <input type="date" name="payment_date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
        </div>

        {{-- Catatan --}}
        <div class="mb-3">
            <label for="note" class="form-label">Catatan</label>
            <textarea name="note" class="form-control"></textarea>
        </div>

        {{-- Tanda Tangan --}}
        <div class="mb-3">
            <label class="form-label">Tanda Tangan Bendahara</label><br>
            <canvas id="signature-pad" width="400" height="200" style="border:1px solid #ccc;"></canvas>
            <br>
            <button type="button" id="clear" class="btn btn-warning mt-2">Hapus</button>
            <button type="button" id="save-signature" class="btn btn-primary mt-2">Simpan Tanda Tangan</button>
            <input type="hidden" name="signature" id="signature">
        </div>

        {{-- Tombol Submit --}}
        <div class="mt-4">
            <button id="submit-button" class="btn btn-dark" type="submit" disabled>Simpan Transaksi</button>
            <a href="/transaksi" class="btn btn-secondary">Kembali</a>
        </div>
    </form>

    {{-- Signature Pad --}}
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas);
        const clearBtn = document.getElementById('clear');
        const saveBtn = document.getElementById('save-signature');
        const submitBtn = document.getElementById('submit-button');
        const inputSignature = document.getElementById('signature');

        clearBtn.addEventListener('click', () => {
            signaturePad.clear();
            inputSignature.value = "";
            submitBtn.disabled = true;
        });

        saveBtn.addEventListener('click', () => {
            if (!signaturePad.isEmpty()) {
                const dataURL = signaturePad.toDataURL();
                inputSignature.value = dataURL;
                submitBtn.disabled = false;
                alert("Tanda tangan berhasil disimpan. Sekarang kamu bisa menyimpan transaksi.");
            } else {
                alert("Silakan isi tanda tangan terlebih dahulu.");
            }
        });
    </script>

    {{-- Load Tagihan Berdasarkan Siswa --}}
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
                amountPaidInput.max = remaining;
            } else {
                document.getElementById('remaining-info').style.display = 'none';
                amountPaidInput.removeAttribute('max');
            }
        });

        document.getElementById('transaksi-form').addEventListener('submit', function(e) {
            const signature = inputSignature.value;
            if (!signature) {
                e.preventDefault();
                alert("Silakan simpan tanda tangan terlebih dahulu.");
            }
        });
    </script>
@endsection
