@extends('layouts.main')

@section('container')
    <h2 class="mb-4">Tambah Tagihan Massal</h2>

    <form action="/massal" method="POST">
        @csrf

        {{-- PENCARIAN SISWA --}}
        <div class="mb-3">
            <label class="form-label"><strong>Cari Siswa</strong></label>
            <input type="text" id="search-student" class="form-control mb-2" placeholder="Ketik nama siswa...">
            <div class="form-control" style="height: 200px; overflow-y: auto;" id="student-list">
                @foreach ($students as $s)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="student_ids[]" value="{{ $s->id }}"
                            id="student{{ $s->id }}">
                        <label class="form-check-label" for="student{{ $s->id }}">
                            {{ $s->name }} ({{ $s->class }})
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- PENCARIAN JENIS TAGIHAN --}}
        <div class="mb-3">
            <label class="form-label"><strong>Cari Jenis Tagihan</strong></label>
            <input type="text" id="search-bill" class="form-control mb-2" placeholder="Ketik nama tagihan...">
            <div class="form-control" style="height: 150px; overflow-y: auto;" id="bill-list">
                @foreach ($billTypes as $bt)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="bill_type_ids[]" value="{{ $bt->id }}"
                            id="billType{{ $bt->id }}">
                        <label class="form-check-label" for="billType{{ $bt->id }}">
                            {{ $bt->name }} - Rp {{ number_format($bt->default_amount, 0, ',', '.') }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- JATUH TEMPO --}}
        <div class="mb-3">
            <label for="due_date" class="form-label"><strong>Jatuh Tempo</strong></label>
            <input type="date" class="form-control @error('due_date') is-invalid @enderror" name="due_date" required>
            @error('due_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- STATUS DEFAULT --}}
        <input type="hidden" name="status" value="unpaid">

        {{-- TOMBOL --}}
        <button class="btn btn-dark" type="submit">Simpan</button>
        <a href="/tagihan" class="btn btn-secondary">Batal</a>
    </form>

    {{-- SCRIPT PENCARIAN --}}
    <script>
        document.getElementById('search-student').addEventListener('keyup', function() {
            let keyword = this.value.toLowerCase();
            document.querySelectorAll('#student-list .form-check').forEach(function(item) {
                const label = item.innerText.toLowerCase();
                item.style.display = label.includes(keyword) ? '' : 'none';
            });
        });

        document.getElementById('search-bill').addEventListener('keyup', function() {
            let keyword = this.value.toLowerCase();
            document.querySelectorAll('#bill-list .form-check').forEach(function(item) {
                const label = item.innerText.toLowerCase();
                item.style.display = label.includes(keyword) ? '' : 'none';
            });
        });
    </script>
@endsection
