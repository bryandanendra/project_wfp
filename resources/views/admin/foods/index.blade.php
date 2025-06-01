@extends('layouts.admin')

@section('title', 'Daftar Menu Makanan')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Daftar Menu Makanan</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ route('admin.foods.create') }}" class="btn btn-primary btn-sm mb-0">
                                <i class="fas fa-plus me-2"></i>Tambah Makanan
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-3">
                        <table class="table align-items-center mb-0" id="foods-table">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Menu</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($foods as $food)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                @if($food->image)
                                                    <img src="{{ asset('storage/' . $food->image) }}" class="avatar avatar-sm me-3" alt="{{ $food->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                                @else
                                                    <div class="avatar avatar-sm me-3 bg-gradient-primary" style="width: 40px; height: 40px; border-radius: 8px;">
                                                        <i class="fas fa-utensils text-white"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $food->name }}</h6>
                                                <p class="text-xs text-muted mb-0">{{ \Illuminate\Support\Str::limit($food->description, 50) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $food->category->name }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">Rp {{ number_format($food->price, 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        @if($food->is_active)
                                            <span class="badge badge-sm bg-gradient-success">Aktif</span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.foods.show', $food->id) }}" class="btn btn-link text-info text-gradient px-3 mb-0">
                                                <i class="fas fa-eye me-2"></i>Detail
                                            </a>
                                            <a href="{{ route('admin.foods.edit', $food->id) }}" class="btn btn-link text-primary text-gradient px-3 mb-0">
                                                <i class="fas fa-edit me-2"></i>Edit
                                            </a>
                                            <form action="{{ route('admin.foods.destroy', $food->id) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger text-gradient px-3 mb-0">
                                                    <i class="fas fa-trash me-2"></i>Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#foods-table').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari makanan...",
            }
        });
        
        // Delete confirmation
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Makanan yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush 