@extends('layouts.main')

@section('container')
    <h2 class="mb-4">Tambah Tagihan Bulanan Massal</h2>

    <form action="/tagihan-bulanan/store" method="POST">
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

        {{-- PILIH JENIS TAGIHAN BULANAN --}}
        <div class="mb-3">
            <label class="form-label"><strong>Pilih Jenis Tagihan Bulanan</strong></label>
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

        {{-- TANGGAL JATUH TEMPO --}}
        <div class="mb-3">
            <label class="form-label"><strong>Tanggal Jatuh Tempo (1 - 31)</strong></label>
            <input type="number" name="tanggal_jatuh_tempo" class="form-control" min="1" max="31"
                value="10" required>
        </div>


        {{-- BULAN MULAI --}}
        <div class="mb-3">
            <label class="form-label"><strong>Mulai Bulan</strong></label>
            <select name="start_month" class="form-select" required>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ now()->month == $i ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>


        {{-- TAHUN --}}
        <div class="mb-3">
            <label class="form-label"><strong>Tahun</strong></label>
            <input type="number" name="start_year" class="form-control" value="{{ now()->year }}" required>
        </div>

        {{-- JUMLAH BULAN --}}
        <div class="mb-3">
            <label class="form-label"><strong>Jumlah Bulan</strong></label>
            <select name="jumlah_bulan" class="form-select" required>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ $i }} Bulan</option>
                @endfor
            </select>
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
