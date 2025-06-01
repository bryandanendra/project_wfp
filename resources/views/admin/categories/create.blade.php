@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Tambah Kategori</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm mb-0">Kembali</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Nama Kategori <span class="text-danger">*</span></label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image" class="form-control-label">Gambar</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image">
                                    <small class="text-muted">Format: JPG, PNG, JPEG, GIF. Maks: 5MB</small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="form-control-label">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary mb-0">Simpan Kategori</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview gambar yang dipilih
    document.getElementById('image').addEventListener('change', function() {
        const preview = document.createElement('img');
        preview.id = 'image-preview';
        preview.className = 'img-thumbnail mt-2';
        preview.style.maxHeight = '150px';
        preview.style.maxWidth = '100%';
        preview.style.objectFit = 'contain';
        
        const file = this.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        
        if (file) {
            reader.readAsDataURL(file);
            
            // Hapus preview lama jika ada
            const oldPreview = document.getElementById('image-preview');
            if (oldPreview) {
                oldPreview.remove();
            }
            
            // Tambahkan preview baru
            this.parentNode.appendChild(preview);
        }
    });
</script>
@endpush 