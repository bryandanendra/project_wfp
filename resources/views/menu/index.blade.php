@extends('layouts.app')

@section('title', 'Menu Makanan Sehat')

@section('content')
<div class="container-fluid py-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12 position-relative">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-md-center mb-4">
                <div class="back-button-container mb-3 mb-md-0">
                    <a href="{{ route('before.order') }}" class="btn btn-outline-secondary btn-back">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
                <div class="text-center px-4">
                    <h1 class="display-4 fw-bold text-primary mb-2">Menu Makanan Sehat</h1>
                    <p class="text-muted fs-5 mb-0">
                        {{ $orderType == 'dinein' ? 'Makan di Tempat' : 'Bawa Pulang' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Filter -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-center flex-wrap category-container py-2">
                <button class="btn btn-category m-1 category-filter active" data-category="all">
                    <span class="btn-text">Semua</span>
                </button>
                @foreach($categories as $category)
                    <button class="btn btn-category m-1 category-filter" data-category="{{ $category->id }}">
                        <span class="btn-text">{{ $category->name }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Food Items -->
    <div class="row food-container">
        @if($foods->count() > 0)
            @foreach($foods as $food)
                <div class="col-lg-4 col-md-6 mb-4 food-item" data-category="{{ $food->category_id }}">
                    <div class="card food-card h-100 border-0 shadow-sm hover-elevate">
                        <div class="food-image-container">
                            @if($food->image)
                                <img src="{{ asset('storage/' . $food->image) }}" class="card-img-top food-image" alt="{{ $food->name }}">
                            @else
                                <div class="bg-light text-center py-5 food-placeholder">
                                    <i class="fas fa-utensils fa-4x text-muted"></i>
                                </div>
                            @endif
                            <div class="food-category-badge">
                                <span class="badge bg-primary">{{ $food->category->name }}</span>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title food-title">{{ $food->name }}</h5>
                            <p class="card-text text-muted small food-description">{{ Str::limit($food->description, 80) }}</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-primary fw-bold fs-5">Rp {{ number_format($food->price, 0, ',', '.') }}</span>
                                    <button class="btn btn-primary btn-sm add-to-cart" 
                                            data-id="{{ $food->id }}"
                                            data-name="{{ $food->name }}"
                                            data-price="{{ $food->price }}">
                                        <i class="fas fa-plus me-1"></i> Tambah
                                    </button>
                                </div>
                                <button class="btn btn-outline-secondary btn-sm w-100 view-details" 
                                        data-id="{{ $food->id }}"
                                        data-name="{{ $food->name }}"
                                        data-description="{{ $food->description }}"
                                        data-nutrition="{{ $food->nutrition_facts }}"
                                        data-price="{{ $food->price }}"
                                        data-image="{{ $food->image ? asset('storage/' . $food->image) : '' }}">
                                    <i class="fas fa-info-circle me-1"></i> Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-utensils fa-5x text-muted mb-3"></i>
                    <h3 class="text-muted">Menu Tidak Tersedia</h3>
                    <p class="text-muted">Tidak ada menu yang tersedia saat ini.</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Order Summary Float Button -->
    <div class="position-fixed bottom-0 end-0 mb-4 me-4 cart-button-container">
        <button id="viewCart" class="btn btn-primary rounded-circle p-3 shadow-lg cart-button">
            <i class="fas fa-shopping-cart"></i>
            <span id="cartCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge">
                0
            </span>
        </button>
    </div>

    <!-- Food Detail Modal -->
    <div class="modal fade" id="foodDetailModal" tabindex="-1" aria-labelledby="foodDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="text-center mb-3" id="modalImage">
                                <!-- Food image will be placed here -->
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h3 id="modalFoodName" class="mb-3 fw-bold"><!-- Food name --></h3>
                            <p id="modalDescription" class="text-muted"><!-- Description --></p>
                            <div class="mb-3 p-3 bg-light rounded">
                                <h5 class="fw-bold mb-2"><i class="fas fa-heartbeat me-2 text-danger"></i>Informasi Nutrisi</h5>
                                <p id="modalNutrition" class="mb-0"><!-- Nutrition facts --></p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <h4 class="text-primary fw-bold" id="modalPrice"><!-- Price --></h4>
                                <button class="btn btn-primary add-to-cart-modal"
                                        data-id=""
                                        data-name=""
                                        data-price="">
                                    <i class="fas fa-cart-plus me-2"></i> Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="cartModalLabel"><i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="cartItems">
                        <!-- Cart items will be displayed here -->
                        <div class="text-center py-5 empty-cart-message">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <p>Keranjang belanja kosong</p>
                        </div>
                    </div>
                    <div class="row mt-4 cart-summary" style="display: none;">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="orderNotes" class="form-label"><i class="fas fa-clipboard me-2"></i>Catatan Pesanan:</label>
                                <textarea id="orderNotes" class="form-control" rows="2" placeholder="Masukkan catatan untuk pesanan ini (opsional)"></textarea>
                            </div>
                            @if($orderType == 'dinein')
                            <div class="form-group mb-3">
                                <label for="tableNumber" class="form-label"><i class="fas fa-table me-2"></i>Nomor Meja:</label>
                                <input type="number" id="tableNumber" class="form-control" required min="1" placeholder="Masukkan nomor meja">
                            </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">Ringkasan Pesanan</h5>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Total Item:</span>
                                        <span id="totalItems" class="fw-bold">0</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Total Harga:</span>
                                        <span id="totalPrice" class="fw-bold text-primary">Rp 0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-arrow-left me-2"></i>Kembali</button>
                    <button type="button" class="btn btn-success" id="checkoutBtn" disabled><i class="fas fa-check me-2"></i>Checkout</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Member Registration Modal -->
    <div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="memberModalLabel"><i class="fas fa-user-plus me-2"></i>Informasi Member</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-circle fa-5x text-success mb-3"></i>
                        <h4>Silakan isi data diri Anda</h4>
                        <p class="text-muted">Data ini akan disimpan untuk transaksi selanjutnya</p>
                    </div>
                    
                    <form id="memberForm">
                        <div class="form-group mb-3">
                            <label for="memberName" class="form-label"><i class="fas fa-user me-2"></i>Nama Lengkap</label>
                            <input type="text" id="memberName" name="name" class="form-control" required placeholder="Masukkan nama lengkap Anda">
                        </div>
                        <div class="form-group mb-3">
                            <label for="memberEmail" class="form-label"><i class="fas fa-envelope me-2"></i>Email (opsional)</label>
                            <input type="email" id="memberEmail" name="email" class="form-control" placeholder="Masukkan alamat email Anda">
                        </div>
                        <div class="form-group mb-3">
                            <label for="memberPhone" class="form-label"><i class="fas fa-phone me-2"></i>Nomor Telepon (opsional)</label>
                            <input type="tel" id="memberPhone" name="phone" class="form-control" placeholder="Masukkan nomor telepon Anda">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Batal</button>
                    <button type="button" class="btn btn-success" id="saveMemberBtn"><i class="fas fa-save me-2"></i>Simpan & Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Back button styling */
    .back-button-container {
        z-index: 10;
    }
    
    @media (min-width: 768px) {
        .back-button-container {
            position: absolute;
            left: 15px;
            top: 0;
        }
    }
    
    .btn-back {
        padding: 8px 16px;
        border-radius: 30px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .btn-back:hover {
        transform: translateX(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    /* Category filter styling */
    .category-container {
        overflow-x: auto;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        padding-bottom: 5px;
    }
    .category-container::-webkit-scrollbar {
        display: none;
    }
    .btn-category {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        color: #495057;
        border-radius: 20px;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }
    .btn-category:hover {
        background-color: #e9ecef;
        transform: translateY(-2px);
    }
    .btn-category.active {
        background-color: #0d6efd;
        color: white;
        box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
    }
    
    /* Food card styling */
    .food-container {
        min-height: 50vh;
        position: relative;
    }
    .food-item {
        transition: opacity 0.4s ease, transform 0.4s ease;
        position: relative;
        opacity: 1;
        height: auto;
        will-change: transform, opacity;
    }
    .food-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
    }
    .hover-elevate:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .food-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    .food-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .food-card:hover .food-image {
        transform: scale(1.05);
    }
    .food-placeholder {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .food-category-badge {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    .food-title {
        font-weight: 600;
        margin-bottom: 8px;
    }
    .food-description {
        color: #6c757d;
        margin-bottom: 15px;
        line-height: 1.5;
    }
    
    /* Cart button styling */
    .cart-button-container {
        z-index: 1040;
    }
    .cart-button {
        width: 60px;
        height: 60px;
        transition: all 0.3s ease;
    }
    .cart-button:hover {
        transform: scale(1.1);
    }
    .cart-badge {
        transition: all 0.3s ease;
    }
    
    /* Empty state styling */
    .empty-state {
        padding: 40px;
        background-color: #f8f9fa;
        border-radius: 10px;
    }
    
    /* Animation for new items */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .food-item {
        animation: fadeIn 0.5s ease-out forwards;
    }
    
    /* Fix for category filtering to prevent jump during transitions */
    .food-container {
        padding-bottom: 50px; /* Extra space to prevent page jump */
    }
</style>
@endpush

@push('scripts')
<script>
    let cart = [];
    
    document.addEventListener('DOMContentLoaded', function() {
        // Filter by category
        const categoryButtons = document.querySelectorAll('.category-filter');
        
        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-category');
                
                // Update active state
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter food items
                const foodItems = document.querySelectorAll('.food-item');
                foodItems.forEach(item => {
                    if (categoryId === 'all' || item.getAttribute('data-category') === categoryId) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // Add to cart functionality
        const addButtons = document.querySelectorAll('.add-to-cart');
        addButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = parseInt(this.getAttribute('data-id'));
                const name = this.getAttribute('data-name');
                const price = parseFloat(this.getAttribute('data-price'));
                addToCart(id, name, price);
            });
        });
        
        // View food details
        const viewButtons = document.querySelectorAll('.view-details');
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modal = document.getElementById('foodDetailModal');
                const name = this.getAttribute('data-name');
                const description = this.getAttribute('data-description');
                const nutrition = this.getAttribute('data-nutrition');
                const price = parseFloat(this.getAttribute('data-price'));
                const image = this.getAttribute('data-image');
                const id = parseInt(this.getAttribute('data-id'));
                
                document.getElementById('modalFoodName').textContent = name;
                document.getElementById('modalDescription').textContent = description;
                document.getElementById('modalNutrition').textContent = nutrition || 'Informasi nutrisi belum tersedia';
                document.getElementById('modalPrice').textContent = 'Rp ' + formatNumber(price);
                
                const imageContainer = document.getElementById('modalImage');
                if (image) {
                    imageContainer.innerHTML = `<img src="${image}" class="img-fluid rounded" alt="${name}">`;
                } else {
                    imageContainer.innerHTML = `<div class="bg-light text-center py-5" style="height: 200px;">
                        <i class="fas fa-utensils fa-4x text-muted"></i>
                    </div>`;
                }
                
                // Update add to cart button in modal
                const addToCartModalBtn = document.querySelector('.add-to-cart-modal');
                addToCartModalBtn.setAttribute('data-id', id);
                addToCartModalBtn.setAttribute('data-name', name);
                addToCartModalBtn.setAttribute('data-price', price);
                
                // Show modal
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            });
        });
        
        // Add to cart from modal
        const modalAddButton = document.querySelector('.add-to-cart-modal');
        modalAddButton.addEventListener('click', function() {
            const id = parseInt(this.getAttribute('data-id'));
            const name = this.getAttribute('data-name');
            const price = parseFloat(this.getAttribute('data-price'));
            addToCart(id, name, price);
            
            // Hide the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('foodDetailModal'));
            if (modal) {
                modal.hide();
            }
        });
        
        // View cart
        document.getElementById('viewCart').addEventListener('click', function() {
            // Make sure modal exists and is properly initialized
            const cartModalElement = document.getElementById('cartModal');
            if (!cartModalElement) {
                console.error('Cart modal element not found');
                return;
            }
            
            try {
                const modal = new bootstrap.Modal(cartModalElement);
                modal.show();
            } catch (error) {
                console.error('Error showing cart modal:', error);
            }
        });
        
        // Checkout button
        document.getElementById('checkoutBtn').addEventListener('click', function() {
            if (cart.length === 0) return;
            
            // Show member registration modal instead of direct checkout
            const memberModal = new bootstrap.Modal(document.getElementById('memberModal'));
            memberModal.show();
        });
        
        // Save member and proceed to checkout
        document.getElementById('saveMemberBtn').addEventListener('click', function() {
            const memberName = document.getElementById('memberName').value;
            const memberEmail = document.getElementById('memberEmail').value;
            const memberPhone = document.getElementById('memberPhone').value;
            
            if (!memberName) {
                alert('Silakan masukkan nama Anda.');
                return;
            }
            
            const orderType = '{{ $orderType }}';
            let tableNumber = null;
            
            if (orderType === 'dinein') {
                tableNumber = document.getElementById('tableNumber').value;
                if (!tableNumber) {
                    alert('Silakan masukkan nomor meja.');
                    return;
                }
            }
            
            const orderData = {
                order_type: orderType === 'dinein' ? 'dine_in' : 'take_away',
                table_number: tableNumber,
                notes: document.getElementById('orderNotes').value,
                member_name: memberName,
                member_email: memberEmail,
                member_phone: memberPhone,
                items: cart.map(item => ({
                    food_id: item.id,
                    quantity: item.quantity,
                    special_instructions: item.specialInstructions || '',
                    customization_ingredients: item.customizationIngredients || '',
                    customization_portion_size: item.customizationPortionSize || '',
                    customization_allergies: item.customizationAllergies || ''
                }))
            };
            
            // Create hidden form to submit order
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('orders.store') }}';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Add order data
            for (const key in orderData) {
                if (key === 'items') {
                    orderData.items.forEach((item, index) => {
                        for (const itemKey in item) {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = `items[${index}][${itemKey}]`;
                            input.value = item[itemKey];
                            form.appendChild(input);
                        }
                    });
                } else {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = orderData[key];
                    form.appendChild(input);
                }
            }
            
            document.body.appendChild(form);
            form.submit();
        });
        
        // Helper functions
        function addToCart(id, name, price) {
            const existingItem = cart.find(item => item.id === id);
            
            if (existingItem) {
                existingItem.quantity += 1;
                existingItem.subtotal = existingItem.price * existingItem.quantity;
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    quantity: 1,
                    subtotal: price,
                    specialInstructions: '',
                    customizationIngredients: '',
                    customizationPortionSize: '',
                    customizationAllergies: ''
                });
            }
            
            updateCartDisplay();
            
            // Remove any existing toast containers to prevent stacking or interference
            const existingToasts = document.querySelectorAll('.toast-container');
            existingToasts.forEach(toast => {
                if (toast && toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            });
            
            // Show notification
            const toastContainer = document.createElement('div');
            toastContainer.className = 'position-fixed top-0 end-0 p-3 toast-container';
            toastContainer.style.zIndex = '9999';
            // Make sure toast doesn't block interactions
            toastContainer.style.pointerEvents = 'none';
            
            toastContainer.innerHTML = `
                <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-check-circle me-2"></i> ${name} ditambahkan ke keranjang
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close" style="pointer-events: auto;"></button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(toastContainer);
            const toastEl = toastContainer.querySelector('.toast');
            const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
            toast.show();
            
            toastEl.addEventListener('hidden.bs.toast', function () {
                if (toastContainer && toastContainer.parentNode) {
                    toastContainer.parentNode.removeChild(toastContainer);
                }
            });
        }
        
        function updateCartDisplay() {
            const cartItemsContainer = document.getElementById('cartItems');
            const emptyCartMessage = document.querySelector('.empty-cart-message');
            const cartSummary = document.querySelector('.cart-summary');
            const checkoutBtn = document.getElementById('checkoutBtn');
            const cartCount = document.getElementById('cartCount');
            const totalItems = document.getElementById('totalItems');
            const totalPrice = document.getElementById('totalPrice');
            
            // Check if elements exist before accessing their properties
            if (!cartItemsContainer || !cartCount) {
                console.error('Critical cart elements not found in the DOM');
                return;
            }
            
            // Update cart count badge
            cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0);
            
            if (cart.length === 0) {
                // Check if element exists before accessing style
                if (emptyCartMessage) {
                    emptyCartMessage.style.display = 'block';
                }
                if (cartSummary) {
                    cartSummary.style.display = 'none';
                }
                if (checkoutBtn) {
                    checkoutBtn.disabled = true;
                }
                cartItemsContainer.innerHTML = `
                    <div class="text-center py-5 empty-cart-message">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <p>Keranjang belanja kosong</p>
                    </div>`;
                return;
            }
            
            // Check if elements exist before accessing style
            if (emptyCartMessage) {
                emptyCartMessage.style.display = 'none';
            }
            if (cartSummary) {
                cartSummary.style.display = 'flex';
            }
            if (checkoutBtn) {
                checkoutBtn.disabled = false;
            }
            
            let cartItemsHTML = '';
            cart.forEach((item, index) => {
                cartItemsHTML += `
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="card-title">${item.name}</h5>
                                    <p class="card-text text-muted">Rp ${formatNumber(item.price)}</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary decrease-quantity" data-index="${index}">-</button>
                                        <input type="number" class="form-control text-center item-quantity" value="${item.quantity}" min="1" data-index="${index}">
                                        <button class="btn btn-outline-secondary increase-quantity" data-index="${index}">+</button>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <p class="fw-bold">Rp ${formatNumber(item.subtotal)}</p>
                                </div>
                                <div class="col-md-1 text-end">
                                    <button class="btn btn-sm btn-outline-danger remove-item" data-index="${index}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <input type="text" class="form-control special-instructions" placeholder="Instruksi khusus (opsional)" value="${item.specialInstructions || ''}" data-index="${index}">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <p class="mb-2 fw-bold">Kustomisasi Pesanan:</p>
                                    <div class="mb-2">
                                        <label class="form-label">Jenis Bahan:</label>
                                        <select class="form-select customization-ingredients" data-index="${index}">
                                            <option value="" ${!item.customizationIngredients ? 'selected' : ''}>Pilih bahan</option>
                                            <option value="Organik" ${item.customizationIngredients === 'Organik' ? 'selected' : ''}>Bahan Organik</option>
                                            <option value="Lokal" ${item.customizationIngredients === 'Lokal' ? 'selected' : ''}>Bahan Lokal</option>
                                            <option value="Impor" ${item.customizationIngredients === 'Impor' ? 'selected' : ''}>Bahan Impor</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Ukuran Porsi:</label>
                                        <select class="form-select customization-portion-size" data-index="${index}">
                                            <option value="" ${!item.customizationPortionSize ? 'selected' : ''}>Ukuran standar</option>
                                            <option value="Kecil" ${item.customizationPortionSize === 'Kecil' ? 'selected' : ''}>Porsi Kecil</option>
                                            <option value="Sedang" ${item.customizationPortionSize === 'Sedang' ? 'selected' : ''}>Porsi Sedang</option>
                                            <option value="Besar" ${item.customizationPortionSize === 'Besar' ? 'selected' : ''}>Porsi Besar</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Informasi Alergi:</label>
                                        <input type="text" class="form-control customization-allergies" placeholder="Misal: kacang, seafood, dll" value="${item.customizationAllergies || ''}" data-index="${index}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            cartItemsContainer.innerHTML = cartItemsHTML;
            
            // Update total items and price if elements exist
            if (totalItems) {
                totalItems.textContent = cart.reduce((total, item) => total + item.quantity, 0);
            }
            if (totalPrice) {
                totalPrice.textContent = `Rp ${formatNumber(cart.reduce((total, item) => total + item.subtotal, 0))}`;
            }
            
            // Add event listeners for cart item controls
            document.querySelectorAll('.increase-quantity').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    cart[index].quantity++;
                    cart[index].subtotal = cart[index].price * cart[index].quantity;
                    updateCartDisplay();
                });
            });
            
            document.querySelectorAll('.decrease-quantity').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    if (cart[index].quantity > 1) {
                        cart[index].quantity--;
                        cart[index].subtotal = cart[index].price * cart[index].quantity;
                        updateCartDisplay();
                    }
                });
            });
            
            document.querySelectorAll('.item-quantity').forEach(input => {
                input.addEventListener('change', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    const quantity = parseInt(this.value);
                    if (quantity >= 1) {
                        cart[index].quantity = quantity;
                        cart[index].subtotal = cart[index].price * cart[index].quantity;
                        updateCartDisplay();
                    } else {
                        this.value = 1;
                    }
                });
            });
            
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    cart.splice(index, 1);
                    updateCartDisplay();
                });
            });
            
            document.querySelectorAll('.special-instructions').forEach(input => {
                input.addEventListener('change', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    cart[index].specialInstructions = this.value;
                });
            });
            
            // Event listeners for customization fields
            document.querySelectorAll('.customization-ingredients').forEach(select => {
                select.addEventListener('change', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    cart[index].customizationIngredients = this.value;
                });
            });
            
            document.querySelectorAll('.customization-portion-size').forEach(select => {
                select.addEventListener('change', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    cart[index].customizationPortionSize = this.value;
                });
            });
            
            document.querySelectorAll('.customization-allergies').forEach(input => {
                input.addEventListener('change', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    cart[index].customizationAllergies = this.value;
                });
            });
        }
        
        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    });
</script>
@endpush 