@extends('layouts.admin.app')

@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">Pelanggan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Pelanggan</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Edit Pelanggan</h1>
                <p class="mb-0">Form untuk mengedit data pelanggan.</p>
            </div>
            <div>
                <a href="" class="btn btn-primary"><i class="far fa-question-circle me-1"></i> Kembali</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">

                    <form action="{{ route('pelanggan.update', $dataPelanggan->pelanggan_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <div class="col-lg-4 col-sm-6">
                                <!-- First Name -->
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First name</label>
                                    <input type="text" id="first_name" name="first_name"
                                        value="{{ $dataPelanggan->first_name }}" class="form-control" required>
                                </div>

                                <!-- Last Name -->
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last name</label>
                                    <input type="text" id="last_name" name="last_name"
                                        value="{{ $dataPelanggan->last_name }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6">
                                <!-- Birthday -->
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Birthday</label>
                                    <input type="date" id="birthday" name="birthday"
                                        value="{{ $dataPelanggan->birthday }}" class="form-control">
                                </div>

                                <!-- Gender -->
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select id="gender" name="gender" class="form-select">
                                        <option value="">-- Pilih --</option>
                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>
                                            Male</option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>
                                            Female</option>
                                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>
                                            Other</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-12">
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" id="email" name="email" value="{{ $dataPelanggan->email }}"
                                        class="form-control" required>
                                </div>

                                <!-- Phone -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" id="phone" name="phone" value="{{ $dataPelanggan->phone }}"
                                        class="form-control">
                                </div>

                                <!-- Buttons -->
                                <div class="">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('pelanggan.index') }}"
                                        class="btn btn-outline-secondary ms-2">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div class="col-12 mb-4">

            {{-- Card Upload File  --}}
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Upload File</strong>
                </div>
                <div class="card-body">

                    <form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="ref_table" value="pelanggan">
                        <input type="hidden" name="ref_id" value="{{ $dataPelanggan->pelanggan_id }}">



                        <label>File Pendukung:</label>
                        <input type="file" name="filename[]" multiple class="form-control">

                        <button type="submit" class="btn btn-primary mt-3">Upload</button>
                    </form>
                </div>
            </div>


            {{-- Card List File Pendukung --}}
            <div class="card">
                <div class="card-header">
                    <strong>Daftar File Pendukung</strong>
                </div>

                <div class="card-body">
                    @if ($pelangganFiles->count() == 0)
                        <p class="text-muted">Belum ada file yang diupload.</p>
                    @else
                        <ul class="list-group">
                            @forelse ($pelangganFiles as $file)
                                <li>
                                    @php
                                        $extension = strtolower(pathinfo($file->filename, PATHINFO_EXTENSION));
                                    @endphp

                                    {{-- Tampilkan thumbnail jika gambar --}}
                                    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                        <img src="{{ asset('uploads/' . $file->filename) }}" width="50"
                                            alt="{{ $file->filename }}">
                                    @endif

                                    {{ $file->filename }}

                                    {{-- Tombol hapus --}}
                                    <form action="{{ route('uploads.destroy', $file->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </li>
                            @empty
                                <li>Belum ada file.</li>
                            @endforelse
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
