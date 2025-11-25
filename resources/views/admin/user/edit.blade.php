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
                <li class="breadcrumb-item"><a href="#">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah User</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Edit Data User</h1>
                <p class="mb-0">Form untuk mengedit data User.</p>
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

                    <div class="card-body">
                        <div class="col-lg-6 col-sm-12">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Terjadi kesalahan:</strong>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <form action="{{ route('user.update', $dataUser->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-4">
                                <div class="col-lg-4 col-sm-6">

                                    {{-- Foto Profil --}}
                                    <label for="user_picture">User Picture:</label>

                                    {{-- Tampilkan foto lama jika ada --}}
                                    @if ($dataUser->user_picture)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $dataUser->user_picture) }}" alt="User Picture"
                                                style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px;">
                                        </div>
                                    @endif

                                    {{-- Simpan path lama dalam hidden input --}}
                                    <input type="hidden" name="old_user_picture" value="{{ $dataUser->user_picture }}">

                                    {{-- Input upload foto baru --}}
                                    <input type="file" name="user_picture" id="user_picture" class="form-control mt-2">

                                    <br>

                                    <!-- Nama -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">First name</label>
                                        <input type="text" id="name" name="name" value="{{ $dataUser->name }}"
                                            class="form-control" required>
                                    </div>
                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" id="email" name="email" value="{{ $dataUser->email }}"
                                            class="form-control" required>
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Ubah Password</label>
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="Masukkan password baru (opsional)">
                                    </div>


                                    {{-- Password Confirmation --}}
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            required>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endsection
