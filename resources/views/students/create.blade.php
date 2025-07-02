@extends('layouts.main')

@section('container')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1><i class="bi bi-person-plus"></i> Tambah Data Siswa</h1>
        </div>
        <hr>
        <form method="POST" action="/siswa">
            @csrf
            <div class="col-md-6 col-lg-8">
                <div class="card shadow rounded-2">
                    <div class="card-body p-4">
                        {{-- Nama Siswa --}}
                        <div class="mb-4">
                            <label for="name" class="form-label"><strong>Nama Siswa</strong></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kelas --}}
                        <div class="mb-4">
                            <label for="class" class="form-label"><strong>Kelas</strong></label>
                            <select class="form-select @error('class') is-invalid @enderror" name="class" id="class"
                                required>
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                                <option value="A1" {{ old('class') == 'A1' ? 'selected' : '' }}>A1</option>
                                <option value="A2" {{ old('class') == 'A2' ? 'selected' : '' }}>A2</option>
                                <option value="B1" {{ old('class') == 'B1' ? 'selected' : '' }}>B1</option>
                                <option value="B2" {{ old('class') == 'B2' ? 'selected' : '' }}>B2</option>
                            </select>
                            @error('class')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Orang Tua --}}
                        <div class="mb-4">
                            <label for="parent_name" class="form-label"><strong>Nama Orang Tua</strong></label>
                            <input type="text" class="form-control @error('parent_name') is-invalid @enderror"
                                id="parent_name" name="parent_name" value="{{ old('parent_name') }}">
                            @error('parent_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-4">
                            <label for="address" class="form-label"><strong>Alamat</strong></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- No Telepon --}}
                        <div class="mb-4">
                            <label for="phone" class="form-label"><strong>Nomor Telepon</strong></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="my-3">
                    <button type="submit" class="btn btn-dark">Simpan Data Siswa</button>
                    <a href="{{ url()->previous() }}" class="btn btn-danger rounded-3" style="font-weight: 600">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
