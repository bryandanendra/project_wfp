@extends('layouts.admin')

@section('title', 'Tambah Makanan')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Tambah Menu Makanan</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ route('admin.foods.index') }}" class="btn btn-outline-secondary btn-sm mb-0">Kembali</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.foods.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Nama Makanan <span class="text-danger">*</span></label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id" class="form-control-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price" class="form-control-label">Harga (Rp) <span class="text-danger">*</span></label>
                                    <input class="form-control @error('price') is-invalid @enderror" type="number" id="price" name="price" value="{{ old('price') }}" min="0" required>
                                    @error('price')
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
                                    <label for="description" class="form-control-label">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nutrition_facts" class="form-control-label">Informasi Nutrisi <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('nutrition_facts') is-invalid @enderror" id="nutrition_facts" name="nutrition_facts" rows="3" required>{{ old('nutrition_facts') }}</textarea>
                                    <small class="text-muted">Contoh: Kalori: 250kkal, Protein: 15g, Lemak: 10g, Karbohidrat: 30g</small>
                                    @error('nutrition_facts')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : 'checked' }}>
                                    <label class="form-check-label" for="is_active">Aktif</label>
                                    <small class="text-muted d-block">Jika dicentang, makanan akan ditampilkan di menu</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary mb-0">Simpan Makanan</button>
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