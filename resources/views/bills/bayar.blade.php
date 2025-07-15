@extends('layouts.main')

@section('container')
    <h2>Pembayaran Tagihan</h2>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Siswa:</strong> {{ $bill->student->name }} ({{ $bill->student->class }})</p>
            <p><strong>Tagihan:</strong> {{ $bill->billType->name }}</p>
            <p><strong>Total Tagihan:</strong> Rp {{ number_format($bill->amount, 0, ',', '.') }}</p>
            <p><strong>Sisa Pembayaran:</strong> Rp {{ number_format($sisa, 0, ',', '.') }}</p>

            <form id="payment-form" action="{{ route('tagihan.bayar.proses', $bill->id) }}" method="POST">
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

                {{-- Tanda Tangan --}}
                <div class="mb-3">
                    <label class="form-label">Tanda Tangan</label><br>
                    <canvas id="signature-pad" width="400" height="200" style="border:1px solid #ccc;"></canvas>
                    <br>
                    <button type="button" id="clear" class="btn btn-warning mt-2">Hapus TTD</button>
                    <button type="button" id="save-signature" class="btn btn-primary mt-2">Simpan TTD</button>
                    <input type="hidden" name="signature" id="signature">
                    <p id="signature-status" class="text-success mt-2" style="display: none;">✅ Tanda tangan disimpan!</p>
                </div>

                <button type="submit" class="btn btn-success" id="submit-btn" disabled>Bayar</button>
                <a href="/tagihan/{{ $bill->id }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

    {{-- Signature Pad Script --}}
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas);
        const clearBtn = document.getElementById('clear');
        const saveBtn = document.getElementById('save-signature');
        const inputSignature = document.getElementById('signature');
        const submitBtn = document.getElementById('submit-btn');
        const signatureStatus = document.getElementById('signature-status');

        // Hapus TTD
        clearBtn.addEventListener('click', () => {
            signaturePad.clear();
            inputSignature.value = '';
            submitBtn.disabled = true;
            signatureStatus.style.display = 'none';
        });

        // Simpan TTD
        saveBtn.addEventListener('click', () => {
            if (!signaturePad.isEmpty()) {
                const dataURL = signaturePad.toDataURL();
                inputSignature.value = dataURL;
                submitBtn.disabled = false;
                signatureStatus.style.display = 'block';
            } else {
                alert('Silakan isi tanda tangan terlebih dahulu.');
            }
        });

        // Validasi saat submit
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            if (inputSignature.value === '') {
                e.preventDefault();
                alert('Silakan simpan tanda tangan terlebih dahulu.');
            }
        });
    </script>
@endsection
