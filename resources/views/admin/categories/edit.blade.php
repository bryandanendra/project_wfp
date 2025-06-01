@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Edit Kategori</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm mb-0">Kembali</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Nama Kategori <span class="text-danger">*</span></label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required>
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
                                    
                                    @if($category->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-thumbnail" id="current-image" style="max-height: 150px; max-width: 100%; object-fit: contain;">
                                            <p class="small text-muted mt-1">Gambar saat ini</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="form-control-label">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary mb-0">Update Kategori</button>
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
            
            // Sembunyikan gambar saat ini
            const currentImage = document.getElementById('current-image');
            if (currentImage) {
                currentImage.style.display = 'none';
                currentImage.nextElementSibling.style.display = 'none';
            }
            
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