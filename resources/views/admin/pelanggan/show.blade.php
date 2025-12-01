@extends('layouts.admin.app')
@section('content')
        {{-- start main content --}}
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
                    <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Pelanggan</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">Detail Pelanggan</h1>
                    <p class="mb-0">Informasi detail dan file pendukung pelanggan.</p>
                </div>
                <div>
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-primary">
                        <i class="far fa-question-circle me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-info">
                {!! session('success') !!}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {!! session('error') !!}
            </div>
        @endif

        <div class="row">
            <!-- Informasi Pelanggan -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Pelanggan</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Nama Lengkap</th>
                                <td>{{ $dataPelanggan->first_name }} {{ $dataPelanggan->last_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $dataPelanggan->email }}</td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td>{{ $dataPelanggan->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>{{ $dataPelanggan->birthday ? \Carbon\Carbon::parse($dataPelanggan->birthday)->format('d/m/Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $dataPelanggan->gender ?? '-' }}</td>
                            </tr>
                        </table>

                        <div class="mt-3">
                            <a href="{{ route('pelanggan.edit', $dataPelanggan->pelanggan_id) }}" class="btn btn-info btn-sm">
                                Edit Data Pelanggan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload File -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Upload File Pendukung</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pelanggan.upload-files', $dataPelanggan->pelanggan_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Hidden fields untuk ref_table dan ref_id -->
                            <input type="hidden" name="ref_table" value="pelanggan">
                            <input type="hidden" name="ref_id" value="{{ $dataPelanggan->pelanggan_id }}">

                            <div class="mb-3">
                                <label for="files" class="form-label">Pilih File</label>
                                <input type="file" class="form-control" name="files[]" multiple
                                       accept=".doc,.docx,.pdf,.jpg,.jpeg,.png,.gif,.txt" required>
                                <div class="form-text">
                                    Format: DOC, DOCX, PDF, JPG, JPEG, PNG, GIF, TXT. Maksimal 2MB per file.
                                </div>
                                @error('files')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-upload me-1"></i> Upload Files
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar File -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h5 class="mb-0">File Pendukung</h5>
                    </div>
                    <div class="card-body">
                        @if($dataPelanggan->files->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="60%">Nama File</th>
                                            <th width="20%">Tipe</th>
                                            <th width="20%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataPelanggan->files as $file)
                                            <tr>
                                                <td>
                                                    @if(in_array(pathinfo($file->filename, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                        <img src="{{ $file->file_url }}" alt="Thumbnail" width="50" class="me-2 rounded">
                                                    @else
                                                        <i class="fas fa-file me-2 text-muted"></i>
                                                    @endif
                                                    {{ basename($file->filename) }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ strtoupper(pathinfo($file->filename, PATHINFO_EXTENSION)) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ $file->file_url }}" target="_blank" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ $file->file_url }}" download class="btn btn-sm btn-success">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <form action="{{ route('pelanggan.delete-file', [$dataPelanggan->pelanggan_id, $file->id]) }}"
                                                          method="POST" style="display:inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Hapus file ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada file pendukung</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- end main content --}}
@endsection
