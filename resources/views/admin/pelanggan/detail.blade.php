@extends('layouts.admin.app')
@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('pelanggan.index') }}">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">Pelanggan</a></li>
            </ol>
        </nav>

        {{-- Judul Halaman --}}
        <h3 class="mb-4">Detail Pelanggan</h3>

        {{-- Card Informasi Umum --}}
        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi Pelanggan</strong>
            </div>
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-md-4"><strong>Nama Depan</strong></div>
                    <div class="col-md-8">: {{ $pelanggan->first_name }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4"><strong>Nama Belakang</strong></div>
                    <div class="col-md-8">: {{ $pelanggan->last_name }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4"><strong>Tanggal Lahir</strong></div>
                    <div class="col-md-8">: {{ $pelanggan->birthday }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4"><strong>Jenis Kelamin</strong></div>
                    <div class="col-md-8">: {{ ucfirst($pelanggan->gender) }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4"><strong>Email</strong></div>
                    <div class="col-md-8">: {{ $pelanggan->email }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4"><strong>Telepon</strong></div>
                    <div class="col-md-8">: {{ $pelanggan->phone }}</div>
                </div>

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
                            </li>
                        @empty
                            <li>Belum ada file.</li>
                        @endforelse
                    </ul>
                @endif
            </div>
        </div>

    </div>
@endsection
