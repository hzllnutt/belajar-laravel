<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kopi PPKD Jakarta Pusat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #e1c1d7;
            font-family: Arial, Helvetica, sans-serif;
        }

        .product-item {
            cursor: pointer;
        }

        .product-card {
            border: none;
            border-radius: 15px;
            transaction: 0.2s;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-4);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.10);
        }

        .product-image {
            height: 130px;
            display: flex;
            /* align-items: center; */
            justify-content: center;
        }

        .product-image img {
            object-fit: cover;
            /* width: 10%; */
        }

        .product {
            color: rgb(15, 32, 217);
            font-weight: bold;
        }

        .card-box {
            position: sticky;
            top: 20px;
        }

        .card-item {
            border-bottom: 1px solid #eee;
            padding: 12px 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            padding: 0;
            border-radius: 50%;
        }

        .total-price {
            font-size: 25px;
            font-weight: bold;
            color: #6f4e37;
        }

        .payment-btn {
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <main class="col-lg-12 p-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Point Of Sales</h3>
                    <p class="text-muted">POS - Toko Kopi PPKD Jakarta Pusat</p>
                </div>
                <button class="btn btn-dark">Empty Cart</button>
            </div>

            <div class="row g-5 mb-5">
                <div class="col-md-4">
                    <div class="card shadow p-3">
                        <div class="d-flex aligns-item-center gap-3">
                            <div>
                                <i class="bi bi-cart" style="font-size:2rem"></i>
                            </div>
                            <div>
                                <small class="text-muted">Today's Transaction</small>
                                <h4 class="mb-0 fw-bold">10</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow p-3">
                        <div class="d-flex aligns-item-center gap-3">
                            <div>
                                <i class="bi bi-cash" style="font-size:2rem"></i>
                            </div>
                            <div>
                                <small class="text-muted">Today's Sales</small>
                                <h4 class="mb-0 fw-bold">Rp 10.000.000,00</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow p-3">
                        <div class="d-flex aligns-item-center gap-3">
                            <div>
                                <i class="bi bi-bag-dash" style="font-size:2rem"></i>
                            </div>
                            <div>
                                <small class="text-muted">Product Sold</small>
                                <h4 class="mb-0 fw-bold">100</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-7">
                                    <h5 class="fw-bold">Select Product</h5>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" id="searchProduct" class="form-control"
                                        placeholder="Search Product..." onkeyup="searchProduct()">
                                </div>
                            </div>

                            <div class="mb-4">
                                <button class="btn btn-dark btn-sm me-1 category-btn"
                                    onclick="filterCategory('all', this)" data-category="all">Semua</button>
                                @foreach ($categories as $category)
                                    <button class="btn btn-outline-dark btn-sm me-1 category-btn"
                                        onclick="filterCategory('{{ $category->id }}', this)"
                                        data-category="{{ $category->id }}">{{ $category->name ?? '' }}</button>
                                @endforeach

                            </div>

                            <div class="row g-3" id="productList">
                                @foreach ($products as $product)
                                    <div class="col-md-4 col-sm-6 product-item"
                                        data-category="{{ $product->category_id }}" data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                        onclick="addToCart({{ $product->id }})">
                                        <div class="card product-card shadow h-100">
                                            <div class="product-image">
                                                <img src="{{ asset('storage/' . $product->photo) }}" alt="">
                                            </div>
                                            <div class="card-body">
                                                <span class="badge bgt-light text-dark mb-2">
                                                    {{ $product->category->name }}
                                                </span>
                                                <h6 class="fw-bold">{{ $product->name ?? '' }}</h6>
                                                <span class="price"> Rp.
                                                    {{ number_format($product->price, 0) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="card border-0 shadow card-box">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="fw-bold mb-0">
                                    <i class="bi bi-cart"></i>Cart
                                </h5>
                                <span class="badge bg-dark" id="cartCount">
                                    0
                                </span>
                            </div>
                            <div class="mb-3" id="cartItems">
                                <div class="text-center text-muted py-5">
                                    <i class="bi bi-cart4"></i>
                                    <p>Empty Cart</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Sub Total</span>
                                <strong id="subtotal">Rp. 0</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Pajak (10%)</span>
                                <strong id="tax">Rp. 0</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold">Total</span>
                                <span class="total-price" id="total">Rp. 0</span>
                            </div>
                            <button id="btnOpenPaymentModal" onclick="openModalPayment()"
                                class="btn btn-success w-100 py-3">Payment</button>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="paymentMethod" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="paymentMethodLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="paymentMethodLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                    <div class="mb-3">
                        <label for="" class="form-label fw-semibold">Customer Name</label>
                        <input type="text" id="customer_name" class="form-control">
                    </div>
                    <h5 class="mb-3 fw-bold">Pilih Metode Pembayaran</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="" class="w-100 cursor-pointer">
                                <input type="radio" name="payment_method" value="cash"
                                    class="d-none payment-option" checked>
                                <div class="card p-3 shadow-sm border payment-card text-center h-100">
                                    <h4 class="text-success fw-bold">
                                        <i class="bi bi-cash-stack"></i>Cash
                                    </h4>
                                    <p class="text-muted small">Bayar langsung di kasir secara tunai.</p>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="w-100 cursor-pointer">
                                <input type="radio" name="payment_method" value="midtrans"
                                    class="d-none payment-option">
                                <div class="card p-3 shadow-sm border payment-card text-center h-100">
                                    <h4 class="text-success fw-bold">
                                        <i class="bi bi-qr-code-scan"></i>Midtrans
                                    </h4>
                                    <p class="text-muted small">Pembayaran Online.</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="processPayment()" class="btn btn-primary">Pay Now</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script>
        document.querySelectorAll('.payment-option').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.payment-card').forEach(card => card. classList.remove(
                    'border-success', 'border-primary', 'bg-light'
                ));
                if (this.checked){
                    const card = this.nextElementSibling;
                    card.classList.add(this.value === 'cash' ? 'border-success' : 'border-primary', 'bg-light');
                }
            });
        });
        function openModalPayment() {
            if (cart.length === 0) {
                alert('Cart is Empty')
                return;
            }
            const modal = new bootstrap.Modal(document.getElementById('paymentMethod'));
            modal.show();
        }

        function filterCategory(categoryId, button) {
            //selectorAll=array
            const products = document.querySelectorAll('.product-item');
            products.forEach(function(product) {
                const categoryName = product.dataset.category;
                // jika user click category bernama all, muncul category all
                // jika user click category snack, muncul kategory snack
                if (categoryId === 'all' || categoryName === String(categoryId)) {
                    product.style.display = "";
                } else {
                    product.style.display = 'none';
                }

            });
            //ketika user reset category
            document.querySelectorAll('.category-btn').forEach(function(btn) {
                btn.classList.remove('btn-dark', 'active');
                btn.classList.add('btn-outline-dark');
            });
            // ketika user milih category
            button.classList.remove('btn-outline-dark');
            button.classList.add('btn-dark', 'active');
        }

        let cart = [];

        function addToCart(productId) {

            const product = document.querySelector(`.product-item[data-id="${productId}"]`);
            if (!product) {
                alert('Product not found');
                return;
            }
            const productName = product.dataset.name;
            const productPrice = Number(product.dataset.price);

            const existingItem = cart.find(function(item) {
                return Number(item.id) === Number(productId);

            });
            if (existingItem) {
                existingItem.qty++;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    qty: 1,
                })
            }

            displayCart();
            console.log(cart);


        }

        function displayCart() {
            const cartItems = document.getElementById('cartItems');
            cartItems.innerHTML = "";
            if (cart.length === 0) {
                cartItems.innerHTML = `
                <div class="text-center text-muted py-5">
                    <i class="bi bi-cart4"></i>
                    <p>Empty Cart</p>
                </div>
                `;
            }

            cart.forEach(function(item) {
                cartItems.innerHTML +=
                    `<div class="cart-item">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>
                                ${item.name}
                            </strong>
                            <div class="small text-muted">Rp ${formatRupiah(item.price)}</div>
                        </div>
                        <strong>
                            Rp ${formatRupiah(item.price * item.qty)}
                        </strong>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <button onclick="decreaseItem(${item.id})"type="button"
                        class="btn btn-outline-secondary quantity-btn">
                            -
                        </button>
                        <span>${item.qty}</span>
                        <button onclick="increaseItem(${item.id})" type="button"
                        class="btn btn-outline-secondary quantity-btn">
                            +
                        </button>

                        <button type="button"
                        class="btn btn-sm btn-outline-danger ms-auto" onclick="removeItem(${item.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>`
            });
            calculateCart();
        }

        function removeItem(productId) {
            cart = cart.filter(function(item) {
                return Number(item.id) !== Number(productId);
            });

            displayCart();
        }

        function decreaseItem(productId) {
            const item = cart.find(function(item) {
                return Number(item.id) === Number(productId);

            });
            console.log(item);
            item.qty--;
            if (item.qty <= 0) {
                removeItem(productId);
                return;
            }
            displayCart();
        }

        function increaseItem(productId) {
            const item = cart.find(function(item) {
                return Number(item.id) === Number(productId);

            });
            item.qty++;

            displayCart();
        }

        function calculateCart() {
            let subtotal = 0;
            let itemCount = 0;

            cart.forEach(function(item) {
                subtotal += Number(item.price) * Number(item.qty);
                itemCount += Number(item.qty);

            });
            const tax = subtotal * 0.10;
            const total = subtotal + tax;
            document.getElementById('subtotal').innerText = `Rp ${formatRupiah(subtotal)}`
            document.getElementById('tax').innerText = `Rp ${formatRupiah(tax)}`
            document.getElementById('total').innerText = `Rp ${formatRupiah(total)}`
            document.getElementById('cartCount').innerText = itemCount;
        }

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number)
        }

        function searchProduct() {
            const search = document.getElementById('searchProduct').value.toLowerCase().trim();
            const products = document.querySelectorAll('.product-item');

            products.forEach(function(product) {
                const productName = product.dataset.name.toLowerCase();

                // jika product name didalam table nilainya sama pada saat user input
                if (productName.includes(search)) {
                    product.style.display = "";
                } else {
                    product.style.display = "none";
                }
            });
        }
        async function processPayment() {
            if (cart.length === 0) {
                alert('Cart is Empty')
                return;
            }

            const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
            const paymentMethod = selectedPayment ? selectedPayment.value : 'cash';
            const customerName = document.getElementById('customer_name').value;

            // console.log("Metode pembayaran terpilih:", paymentMethod);
            // console.log("Nama Customer:", customerName);

            try {
                const response = await fetch("{{ route('order.store') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector(`meta[name="csrf-token"]`).getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        items: carts.map(function(item) {
                            return {
                                id: item.id,
                                qty: item.qty
                            };
                        }),
                        payment_method: paymentMethod,
                        customerName: customerName
                    })
                });
                const result = await response.json();
                cart = [];
                displayCart();
                location.reload();
            } catch (error) {
                console.log(error)
            }
        }
        displayCart();
    </script>
</body>

</html>
