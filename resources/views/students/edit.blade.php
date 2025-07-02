@extends('layouts.main')

@section('container')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1><i class="bi bi-pencil-square"></i> Edit Data Siswa</h1>
        </div>
        <hr>

        <form method="POST" action="/siswa/{{ $student->id }}">
            @csrf
            @method('PUT')
            <div class="col-md-6 col-lg-8">
                <div class="card shadow rounded-2">
                    <div class="card-body p-4">

                        <div class="mb-4">
                            <label for="name" class="form-label"><strong>Nama Siswa</strong></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $student->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="class" class="form-label"><strong>Kelas</strong></label>
                            <select class="form-select @error('class') is-invalid @enderror" name="class" id="class">
                                <option disabled>-- Pilih Kelas --</option>
                                @foreach (['A1', 'A2', 'B1', 'B2'] as $kelas)
                                    <option value="{{ $kelas }}"
                                        {{ old('class', $student->class) == $kelas ? 'selected' : '' }}>{{ $kelas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="parent_name" class="form-label"><strong>Nama Orang Tua</strong></label>
                            <input type="text" class="form-control @error('parent_name') is-invalid @enderror"
                                id="parent_name" name="parent_name" value="{{ old('parent_name', $student->parent_name) }}">
                            @error('parent_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label"><strong>Alamat</strong></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address', $student->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="form-label"><strong>Nomor Telepon</strong></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" value="{{ old('phone', $student->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="my-3">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ url('/siswa') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
