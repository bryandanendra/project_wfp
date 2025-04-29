@extends('layouts.app')

@section('title', 'Menu Makanan Sehat')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-center">Menu Makanan Sehat</h2>
            <p class="text-center text-muted">
                {{ $orderType == 'dinein' ? 'Makan di Tempat' : 'Bawa Pulang' }}
            </p>
        </div>
    </div>

    <!-- Category Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-center flex-wrap">
                <button class="btn btn-outline-primary m-1 category-filter active" data-category="all">Semua</button>
                @foreach($categories as $category)
                    <button class="btn btn-outline-primary m-1 category-filter" data-category="{{ $category->id }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Food Items -->
    <div class="row">
        @if($foods->count() > 0)
            @foreach($foods as $food)
                <div class="col-md-4 mb-4 food-item" data-category="{{ $food->category_id }}">
                    <div class="card food-card shadow-sm">
                        @if($food->image)
                            <img src="{{ asset('storage/' . $food->image) }}" class="card-img-top" alt="{{ $food->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light text-center py-5">
                                <i class="fas fa-utensils fa-4x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $food->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($food->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold">Rp {{ number_format($food->price, 0, ',', '.') }}</span>
                                <button class="btn btn-sm btn-primary add-to-cart" 
                                        data-id="{{ $food->id }}"
                                        data-name="{{ $food->name }}"
                                        data-price="{{ $food->price }}">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </div>
                            <div class="mt-2">
                                <button class="btn btn-sm btn-outline-secondary btn-block view-details" 
                                        data-id="{{ $food->id }}"
                                        data-name="{{ $food->name }}"
                                        data-description="{{ $food->description }}"
                                        data-nutrition="{{ $food->nutrition_facts }}"
                                        data-price="{{ $food->price }}"
                                        data-image="{{ $food->image ? asset('storage/' . $food->image) : '' }}">
                                    <i class="fas fa-info-circle"></i> Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center py-5">
                <p class="text-muted">Tidak ada menu yang tersedia saat ini.</p>
            </div>
        @endif
    </div>

    <!-- Order Summary Float Button -->
    <div class="position-fixed bottom-0 end-0 mb-4 me-4">
        <button id="viewCart" class="btn btn-primary rounded-circle p-3 shadow" style="width: 60px; height: 60px;">
            <i class="fas fa-shopping-cart"></i>
            <span id="cartCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                0
            </span>
        </button>
    </div>

    <!-- Food Detail Modal -->
    <div class="modal fade" id="foodDetailModal" tabindex="-1" aria-labelledby="foodDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="foodDetailModalLabel">Detail Makanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3" id="modalImage">
                        <!-- Food image will be placed here -->
                    </div>
                    <h4 id="modalFoodName" class="mb-3"><!-- Food name --></h4>
                    <p id="modalDescription"><!-- Description --></p>
                    <div class="mb-3">
                        <h5>Informasi Nutrisi:</h5>
                        <p id="modalNutrition" class="small"><!-- Nutrition facts --></p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-primary" id="modalPrice"><!-- Price --></h5>
                        <button class="btn btn-primary btn-sm add-to-cart-modal"
                                data-id=""
                                data-name=""
                                data-price="">
                            <i class="fas fa-plus"></i> Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Keranjang Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <label for="orderNotes" class="form-label">Catatan Pesanan:</label>
                                <textarea id="orderNotes" class="form-control" rows="2" placeholder="Masukkan catatan untuk pesanan ini (opsional)"></textarea>
                            </div>
                            @if($orderType == 'dinein')
                            <div class="form-group mb-3">
                                <label for="tableNumber" class="form-label">Nomor Meja:</label>
                                <input type="number" id="tableNumber" class="form-control" required min="1" placeholder="Masukkan nomor meja">
                            </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Ringkasan</h5>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Total Item:</span>
                                        <span id="totalItems">0</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Total Harga:</span>
                                        <span id="totalPrice" class="fw-bold">Rp 0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="button" class="btn btn-success" id="checkoutBtn" disabled>Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cart functionality
        let cart = [];
        updateCartDisplay();

        // Category filtering
        const categoryButtons = document.querySelectorAll('.category-filter');
        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                
                // Update active button
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter food items
                const foodItems = document.querySelectorAll('.food-item');
                foodItems.forEach(item => {
                    if (category === 'all' || item.getAttribute('data-category') === category) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Add to cart from menu
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const price = parseFloat(this.getAttribute('data-price'));
                
                addToCart(id, name, price);
            });
        });

        // View food details
        document.querySelectorAll('.view-details').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const description = this.getAttribute('data-description');
                const nutrition = this.getAttribute('data-nutrition');
                const price = parseFloat(this.getAttribute('data-price'));
                const image = this.getAttribute('data-image');
                
                document.getElementById('modalFoodName').textContent = name;
                document.getElementById('modalDescription').textContent = description;
                document.getElementById('modalNutrition').textContent = nutrition;
                document.getElementById('modalPrice').textContent = `Rp ${formatNumber(price)}`;
                
                const modalImage = document.getElementById('modalImage');
                if (image) {
                    modalImage.innerHTML = `<img src="${image}" class="img-fluid rounded" style="max-height: 200px;">`;
                } else {
                    modalImage.innerHTML = `<div class="bg-light text-center py-5 rounded">
                                            <i class="fas fa-utensils fa-4x text-muted"></i>
                                        </div>`;
                }
                
                // Set data for add to cart button in modal
                const addToCartBtn = document.querySelector('.add-to-cart-modal');
                addToCartBtn.setAttribute('data-id', id);
                addToCartBtn.setAttribute('data-name', name);
                addToCartBtn.setAttribute('data-price', price);
                
                const modal = new bootstrap.Modal(document.getElementById('foodDetailModal'));
                modal.show();
            });
        });
        
        // Add to cart from modal
        document.querySelector('.add-to-cart-modal').addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const price = parseFloat(this.getAttribute('data-price'));
            
            addToCart(id, name, price);
            bootstrap.Modal.getInstance(document.getElementById('foodDetailModal')).hide();
        });
        
        // View cart
        document.getElementById('viewCart').addEventListener('click', function() {
            updateCartDisplay();
            const modal = new bootstrap.Modal(document.getElementById('cartModal'));
            modal.show();
        });
        
        // Checkout button
        document.getElementById('checkoutBtn').addEventListener('click', function() {
            if (cart.length === 0) return;
            
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
                items: cart.map(item => ({
                    food_id: item.id,
                    quantity: item.quantity,
                    special_instructions: item.specialInstructions || ''
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
                    specialInstructions: ''
                });
            }
            
            updateCartDisplay();
            
            // Show notification
            const toastContainer = document.createElement('div');
            toastContainer.className = 'position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '9999';
            
            toastContainer.innerHTML = `
                <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-check-circle me-2"></i> ${name} ditambahkan ke keranjang
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(toastContainer);
            const toastEl = toastContainer.querySelector('.toast');
            const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
            toast.show();
            
            toastEl.addEventListener('hidden.bs.toast', function () {
                toastContainer.remove();
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
            
            // Update cart count badge
            cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0);
            
            if (cart.length === 0) {
                emptyCartMessage.style.display = 'block';
                cartSummary.style.display = 'none';
                checkoutBtn.disabled = true;
                cartItemsContainer.innerHTML = `
                    <div class="text-center py-5 empty-cart-message">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <p>Keranjang belanja kosong</p>
                    </div>`;
                return;
            }
            
            emptyCartMessage.style.display = 'none';
            cartSummary.style.display = 'flex';
            checkoutBtn.disabled = false;
            
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
                        </div>
                    </div>
                `;
            });
            
            cartItemsContainer.innerHTML = cartItemsHTML;
            
            // Update total items and price
            totalItems.textContent = cart.reduce((total, item) => total + item.quantity, 0);
            totalPrice.textContent = `Rp ${formatNumber(cart.reduce((total, item) => total + item.subtotal, 0))}`;
            
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
        }
        
        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    });
</script>
@endpush 