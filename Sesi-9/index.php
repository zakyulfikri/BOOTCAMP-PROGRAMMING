<?php
require_once 'koneksi.php';

// Parameter Filter & Pencarian
$search    = isset($_GET['search']) ? trim($_GET['search']) : '';
$category  = isset($_GET['category']) ? $_GET['category'] : 'all';
$min_price = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? (float)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? (float)$_GET['max_price'] : 999999999;
$sort      = isset($_GET['sort']) ? $_GET['sort'] : 'default';

// Konstruksi Kueri SQL Dinamis
$sql = "SELECT * FROM products WHERE (name LIKE :search1 OR description LIKE :search2) AND price >= :min_price AND price <= :max_price";

$params = [
    ':search1'   => "%$search%",
    ':search2'   => "%$search%",
    ':min_price' => $min_price,
    ':max_price' => $max_price
];

if ($category !== 'all') {
    $sql .= " AND category = :category";
    $params[':category'] = $category;
}

if ($sort === 'price-asc') {
    $sql .= " ORDER BY price ASC";
} elseif ($sort === 'price-desc') {
    $sql .= " ORDER BY price DESC";
} elseif ($sort === 'name-asc') {
    $sql .= " ORDER BY name ASC";
} else {
    $sql .= " ORDER BY id DESC";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

function getCategoryBadgeClass($cat) {
    switch($cat) {
        case 'Elektronik': return 'badge-elektronik';
        case 'Fashion': return 'badge-fashion';
        case 'Rumah Tangga': return 'badge-rumahtangga';
        case 'Olahraga': return 'badge-olahraga';
        case 'Kecantikan': return 'badge-kecantikan';
        default: return 'bg-secondary';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z Shop - E-Commerce Praktis</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold text-primary" href="index.php">
                <i class="fa-solid fa-bag-shopping me-2 fs-3"></i>
                <span>Z Shop</span>
            </a>
            <div class="d-flex align-items-center ms-auto">
                <a href="admin.php" class="btn btn-outline-secondary rounded-pill me-2 px-3 small">
                    <i class="fa-solid fa-user-gear me-1"></i> Admin
                </a>
                <button class="btn btn-outline-primary position-relative touch-target rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#cartModal">
                    <i class="fa-solid fa-cart-shopping me-1"></i>
                    <span class="d-none d-sm-inline">Keranjang</span>
                    <span id="cart-count-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                </button>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <!-- Hero Banner -->
        <div class="hero-banner text-center">
            <div class="row justify-content-center px-4">
                <div class="col-lg-8">
                    <h1 class="fw-bold mb-2">Belanja Puas, Kualitas Berkelas!</h1>
                    <p class="lead mb-3 opacity-90">Dapatkan promo menarik, diskon mingguan, dan pengiriman kilat ke seluruh Indonesia.</p>
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold shadow-sm">
                        <i class="fa-solid fa-bolt me-1"></i> Promo Terbatas Minggu Ini
                    </span>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Sidebar Filter -->
            <div class="col-lg-3">
                <form method="GET" action="index.php" class="filter-card">
                    <h5 class="fw-bold mb-3 d-flex align-items-center">
                        <i class="fa-solid fa-sliders text-primary me-2"></i> Filter Produk
                    </h5>
                    
                    <div class="mb-4">
                        <label for="search-input" class="form-label fw-semibold text-muted small uppercase">Cari Produk</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                            <input type="text" name="search" id="search-input" class="form-control bg-light border-start-0" placeholder="Ketik nama produk..." value="<?= htmlspecialchars($search); ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted small uppercase mb-2">Kategori</label>
                        <select name="category" class="form-select bg-light">
                            <option value="all" <?= $category === 'all' ? 'selected' : ''; ?>>Semua Kategori</option>
                            <option value="Elektronik" <?= $category === 'Elektronik' ? 'selected' : ''; ?>>Elektronik</option>
                            <option value="Fashion" <?= $category === 'Fashion' ? 'selected' : ''; ?>>Fashion</option>
                            <option value="Rumah Tangga" <?= $category === 'Rumah Tangga' ? 'selected' : ''; ?>>Rumah Tangga</option>
                            <option value="Olahraga" <?= $category === 'Olahraga' ? 'selected' : ''; ?>>Olahraga</option>
                            <option value="Kecantikan" <?= $category === 'Kecantikan' ? 'selected' : ''; ?>>Kecantikan & Kesehatan</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted small uppercase mb-2">Rentang Harga</label>
                        <div class="mb-2">
                            <input type="number" name="min_price" class="form-control bg-light" placeholder="Harga Minimum (Rp)" value="<?= $min_price > 0 ? $min_price : ''; ?>">
                        </div>
                        <div>
                            <input type="number" name="max_price" class="form-control bg-light" placeholder="Harga Maksimum (Rp)" value="<?= $max_price < 999999999 ? $max_price : ''; ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted small uppercase mb-2">Urutkan</label>
                        <select name="sort" class="form-select bg-light">
                            <option value="default" <?= $sort === 'default' ? 'selected' : ''; ?>>Relevansi / Terbaru</option>
                            <option value="price-asc" <?= $sort === 'price-asc' ? 'selected' : ''; ?>>Harga: Rendah ke Tinggi</option>
                            <option value="price-desc" <?= $sort === 'price-desc' ? 'selected' : ''; ?>>Harga: Tinggi ke Rendah</option>
                            <option value="name-asc" <?= $sort === 'name-asc' ? 'selected' : ''; ?>>Nama: A ke Z</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill mb-2">
                        <i class="fa-solid fa-filter me-1"></i> Terapkan Filter
                    </button>
                    <a href="index.php" class="btn btn-outline-danger w-100 rounded-pill">
                        <i class="fa-solid fa-arrow-rotate-left me-1"></i> Atur Ulang
                    </a>
                </form>
            </div>

            <!-- Product Grid Area -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="text-muted mb-0"><span class="fw-bold text-dark"><?= count($products); ?></span> produk ditemukan</p>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    <?php if (count($products) > 0) : ?>
                        <?php foreach ($products as $item) : ?>
                            <div class="col">
                                <div class="product-card">
                                    <div class="product-image-wrapper">
                                        <span class="category-badge <?= getCategoryBadgeClass($item['category']); ?>"><?= htmlspecialchars($item['category']); ?></span>
                                        <img src="<?= htmlspecialchars($item['image'] ?? 'https://via.placeholder.com/500x375?text=No+Image'); ?>" alt="<?= htmlspecialchars($item['name']); ?>" class="product-image" onerror="this.onerror=null;this.src='https://via.placeholder.com/500x375?text=No+Image'">
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title text-dark"><?= htmlspecialchars($item['name']); ?></h5>
                                        <p class="product-desc"><?= htmlspecialchars($item['description'] ?? ''); ?></p>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="product-price mb-0">Rp <?= number_format($item['price'], 0, ',', '.'); ?></span>
                                            <span class="badge bg-light text-muted border">Stok: <?= $item['stock']; ?></span>
                                        </div>
                                        <div class="row g-2 mt-auto pt-2">
                                            <div class="col-6">
                                                <button class="btn btn-outline-primary w-100 touch-target rounded-pill d-flex align-items-center justify-content-center gap-1 px-2" 
                                                        onclick='openDetail(<?= json_encode($item); ?>)'>
                                                    <i class="fa-solid fa-eye"></i>
                                                    <span class="d-none d-sm-inline">Detail</span>
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn btn-primary w-100 touch-target rounded-pill d-flex align-items-center justify-content-center gap-1 px-2" 
                                                        onclick='addToCart(<?= json_encode($item); ?>)' <?= $item['stock'] <= 0 ? 'disabled' : ''; ?>>
                                                    <i class="fa-solid fa-cart-plus"></i>
                                                    <span class="d-none d-sm-inline"><?= $item['stock'] <= 0 ? 'Habis' : 'Beli'; ?></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-12 text-center py-5">
                            <h5 class="fw-bold">Produk Tidak Ditemukan</h5>
                            <p class="text-muted">Cobalah mengubah kata kunci pencarian atau pengaturan filter Anda.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <img id="detail-image" src="" alt="" class="img-fluid rounded-3 mb-3 w-100" style="object-fit: cover; max-height: 300px;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span id="detail-category" class="badge bg-primary"></span>
                        <span id="detail-stock" class="badge bg-secondary"></span>
                    </div>
                    <h4 id="detail-name" class="fw-bold text-dark mb-1"></h4>
                    <p id="detail-price" class="fs-5 fw-bold text-primary mb-3"></p>
                    <p id="detail-description" class="text-muted"></p>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                    <button id="detail-add-to-cart-btn" type="button" class="btn btn-primary rounded-pill px-4"><i class="fa-solid fa-cart-plus me-1"></i> Tambah ke Keranjang</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-primary text-white py-3">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center">
                        <i class="fa-solid fa-cart-shopping me-2"></i> Keranjang Belanja
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="cart-items-wrapper"></div>
                    <div id="cart-empty-message" class="text-center py-5 d-none">
                        <i class="fa-solid fa-basket-shopping text-muted display-4 mb-3 d-block"></i>
                        <h6 class="fw-bold text-dark">Keranjang Belanja Anda Kosong</h6>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light flex-column align-items-stretch p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                        <div>
                            <span class="text-muted small d-block">Total Pembayaran:</span>
                            <h4 class="fw-bold text-primary mb-0" id="cart-total-price">Rp 0</h4>
                        </div>
                        <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 rounded-pill" id="cart-items-count">0 Items</span>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary rounded-pill w-50" data-bs-dismiss="modal">Lanjut Belanja</button>
                        <button id="proceed-checkout-btn" type="button" class="btn btn-primary rounded-pill w-50" disabled>
                            <i class="fa-solid fa-arrow-right me-1"></i> Lanjut Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkout Form Modal -->
    <div class="modal fade" id="checkoutFormModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 bg-light py-3">
                    <h5 class="modal-title fw-bold">
                        <i class="fa-solid fa-credit-card text-primary me-2"></i> Formulir Pembayaran & Pengiriman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="checkoutForm">
                    <div class="modal-body p-4">
                        <div class="bg-light p-3 rounded-3 mb-4 border">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold text-muted">Total Tagihan Pesanan:</span>
                                <span class="fw-bold fs-5 text-primary" id="checkout-summary-total">Rp 0</span>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2">Data Pemesan</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" id="buyer-name" class="form-control" placeholder="Contoh: Muhammad Zaky" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                                <input type="email" id="buyer-email" class="form-control" placeholder="nama@email.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                                <input type="tel" id="buyer-phone" class="form-control" placeholder="081234567890" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Metode Pembayaran <span class="text-danger">*</span></label>
                                <select id="payment-method" class="form-select" required>
                                    <option value="">-- Pilih Metode Pembayaran --</option>
                                    <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                                    <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                                    <option value="QRIS / GoPay / OVO">QRIS / GoPay / OVO</option>
                                    <option value="COD (Bayar di Tempat)">COD (Bayar di Tempat)</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Alamat Pengiriman <span class="text-danger">*</span></label>
                                <textarea id="buyer-address" class="form-control" rows="2" placeholder="Jl. Ringroad Utara, Sleman, Yogyakarta..." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#cartModal">Kembali ke Keranjang</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fa-solid fa-lock me-1"></i> Konfirmasi & Bayar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Checkout Success Modal -->
    <div class="modal fade" id="checkoutSuccessModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg text-center p-4 rounded-4">
                <div class="modal-body">
                    <i class="fa-solid fa-circle-check text-success display-1 mb-3"></i>
                    <h3 class="fw-bold text-dark">Pembayaran Berhasil!</h3>
                    <p class="text-muted small mb-4">Terima kasih telah berbelanja di Z Shop.</p>
                    
                    <div class="text-start bg-light p-3 rounded-3 mb-4 border small">
                        <div class="mb-1"><strong>Nama Pemesan:</strong> <span id="success-name">-</span></div>
                        <div class="mb-1"><strong>Email:</strong> <span id="success-email">-</span></div>
                        <div class="mb-1"><strong>No. HP:</strong> <span id="success-phone">-</span></div>
                        <div class="mb-1"><strong>Metode Pembayaran:</strong> <span id="success-method" class="badge bg-primary">-</span></div>
                        <div><strong>Total Tagihan:</strong> <span id="success-total" class="fw-bold text-primary">-</span></div>
                    </div>

                    <button type="button" class="btn btn-primary rounded-pill px-5" data-bs-dismiss="modal">Selesai</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-container">
        <div id="cartToast" class="toast align-items-center text-bg-success border-0 shadow-sm" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fa-solid fa-circle-check me-2"></i> Produk berhasil ditambahkan ke keranjang!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let cart = [];

        const cartCountBadge = document.getElementById("cart-count-badge");
        const cartItemsWrapper = document.getElementById("cart-items-wrapper");
        const cartEmptyMessage = document.getElementById("cart-empty-message");
        const cartTotalPrice = document.getElementById("cart-total-price");
        const cartItemsCount = document.getElementById("cart-items-count");
        const proceedCheckoutBtn = document.getElementById("proceed-checkout-btn");
        const cartToast = new bootstrap.Toast(document.getElementById("cartToast"));

        const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
        const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
        const checkoutFormModal = new bootstrap.Modal(document.getElementById('checkoutFormModal'));
        const checkoutSuccessModal = new bootstrap.Modal(document.getElementById('checkoutSuccessModal'));

        let selectedProductForDetail = null;

        function formatRupiah(value) {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0
            }).format(value);
        }

        function getCategoryClass(cat) {
            switch(cat) {
                case "Elektronik": return "badge-elektronik";
                case "Fashion": return "badge-fashion";
                case "Rumah Tangga": return "badge-rumahtangga";
                case "Olahraga": return "badge-olahraga";
                case "Kecantikan": return "badge-kecantikan";
                default: return "bg-secondary";
            }
        }

        function openDetail(product) {
            selectedProductForDetail = product;

            document.getElementById("detail-image").src = product.image || 'https://via.placeholder.com/500x375?text=No+Image';
            const catBadge = document.getElementById("detail-category");
            catBadge.innerText = product.category;
            catBadge.className = `badge ${getCategoryClass(product.category)}`;
            
            document.getElementById("detail-stock").innerText = `Stok: ${product.stock}`;
            document.getElementById("detail-name").innerText = product.name;
            document.getElementById("detail-price").innerText = formatRupiah(product.price);
            document.getElementById("detail-description").innerText = product.description || '-';

            detailModal.show();
        }

        document.getElementById("detail-add-to-cart-btn").addEventListener("click", () => {
            if (selectedProductForDetail) {
                addToCart(selectedProductForDetail);
                detailModal.hide();
            }
        });

        function addToCart(product) {
            const existingIndex = cart.findIndex(item => item.product.id === product.id);
            const currentQtyInCart = existingIndex > -1 ? cart[existingIndex].quantity : 0;

            if (currentQtyInCart + 1 > product.stock) {
                alert(`Stok produk "${product.name}" hanya tersisa ${product.stock} unit.`);
                return;
            }

            if (existingIndex > -1) {
                cart[existingIndex].quantity += 1;
            } else {
                cart.push({ product, quantity: 1 });
            }

            updateCartUI();
            cartToast.show();
        }

        function removeFromCart(id) {
            cart = cart.filter(item => item.product.id !== id);
            updateCartUI();
        }

        function changeQuantity(id, amount) {
            const index = cart.findIndex(item => item.product.id === id);
            if (index > -1) {
                const newQty = cart[index].quantity + amount;

                if (newQty > cart[index].product.stock) {
                    alert(`Stok produk terbatas (${cart[index].product.stock} unit).`);
                    return;
                }

                cart[index].quantity = newQty;
                if (cart[index].quantity <= 0) {
                    removeFromCart(id);
                } else {
                    updateCartUI();
                }
            }
        }

        function updateCartUI() {
            const totalQty = cart.reduce((acc, curr) => acc + curr.quantity, 0);
            cartCountBadge.innerText = totalQty;
            cartItemsCount.innerText = `${totalQty} Items`;

            cartItemsWrapper.innerHTML = "";
            let totalBill = 0;

            if (cart.length === 0) {
                cartEmptyMessage.classList.remove("d-none");
                proceedCheckoutBtn.disabled = true;
            } else {
                cartEmptyMessage.classList.add("d-none");
                proceedCheckoutBtn.disabled = false;

                cart.forEach(item => {
                    const itemSubtotal = item.product.price * item.quantity;
                    totalBill += itemSubtotal;

                    const itemCard = document.createElement("div");
                    itemCard.className = "card border-0 shadow-sm mb-3 bg-light rounded-3 overflow-hidden";
                    itemCard.innerHTML = `
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center me-3" style="flex: 1;">
                                <img src="${item.product.image || 'https://via.placeholder.com/100'}" alt="${item.product.name}" class="rounded-3 me-3" style="width: 65px; height: 65px; object-fit: cover;" onerror="this.onerror=null;this.src='https://via.placeholder.com/100'">
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.95rem;">${item.product.name}</h6>
                                    <span class="small text-muted d-block mb-1">${formatRupiah(item.product.price)}</span>
                                    <span class="fw-bold text-primary small">Subtotal: ${formatRupiah(itemSubtotal)}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="input-group input-group-sm rounded-pill border bg-white overflow-hidden" style="width: 100px;">
                                    <button class="btn btn-link text-dark text-decoration-none px-2" type="button" onclick="changeQuantity(${item.product.id}, -1)">-</button>
                                    <span class="form-control text-center bg-white border-0 px-0 fw-semibold">${item.quantity}</span>
                                    <button class="btn btn-link text-dark text-decoration-none px-2" type="button" onclick="changeQuantity(${item.product.id}, 1)">+</button>
                                </div>
                                <button class="btn btn-outline-danger btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center" onclick="removeFromCart(${item.product.id})" style="width: 32px; height: 32px;">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    cartItemsWrapper.appendChild(itemCard);
                });
            }

            cartTotalPrice.innerText = formatRupiah(totalBill);
            document.getElementById("checkout-summary-total").innerText = formatRupiah(totalBill);
        }

        proceedCheckoutBtn.addEventListener("click", () => {
            cartModal.hide();
            setTimeout(() => {
                checkoutFormModal.show();
            }, 300);
        });

        // Submit Form Checkout (Proses Pembayaran & Pengurangan Stok)
        document.getElementById("checkoutForm").addEventListener("submit", async (e) => {
            e.preventDefault();

            const submitBtn = e.target.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin me-1"></i> Memproses...`;

            const buyerData = {
                name: document.getElementById("buyer-name").value,
                email: document.getElementById("buyer-email").value,
                phone: document.getElementById("buyer-phone").value,
                method: document.getElementById("payment-method").value,
                address: document.getElementById("buyer-address").value
            };

            try {
                const response = await fetch('checkout.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ cart: cart, buyer: buyerData })
                });

                const result = await response.json();

                if (result.success) {
                    document.getElementById("success-name").innerText = buyerData.name;
                    document.getElementById("success-email").innerText = buyerData.email;
                    document.getElementById("success-phone").innerText = buyerData.phone;
                    document.getElementById("success-method").innerText = buyerData.method;
                    document.getElementById("success-total").innerText = cartTotalPrice.innerText;

                    cart = [];
                    updateCartUI();
                    document.getElementById("checkoutForm").reset();

                    checkoutFormModal.hide();
                    setTimeout(() => {
                        checkoutSuccessModal.show();
                    }, 300);
                } else {
                    alert("Transaksi Gagal: " + result.message);
                }
            } catch (error) {
                alert("Terjadi kesalahan jaringan atau server.");
                console.error(error);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `<i class="fa-solid fa-lock me-1"></i> Konfirmasi & Bayar`;
            }
        });

        // Reload halaman saat modal sukses ditutup untuk memperbarui angka stok katalog
        document.getElementById('checkoutSuccessModal').addEventListener('hidden.bs.modal', () => {
            window.location.reload();
        });
    </script>
</body>
</html>