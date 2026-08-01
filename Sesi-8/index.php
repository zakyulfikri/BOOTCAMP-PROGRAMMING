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

// 2. Petakan masing-masing placeholder ke nilainya
$params = [
    ':search1'   => "%$search%",
    ':search2'   => "%$search%",
    ':min_price' => $min_price,
    ':max_price' => $max_price
];

// Filter Kategori
if ($category !== 'all') {
    $sql .= " AND category = :category";
    $params[':category'] = $category;
}

// Order By / Sorting
if ($sort === 'price-asc') {
    $sql .= " ORDER BY price ASC";
} elseif ($sort === 'price-desc') {
    $sql .= " ORDER BY price DESC";
} elseif ($sort === 'name-asc') {
    $sql .= " ORDER BY name ASC";
} else {
    $sql .= " ORDER BY id DESC";
}

// Eksekusi Menggunakan PDO Prepared Statement
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Helper Class Badge Kategori
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
    <title>Z Shop - E-Commerce Praktis (PDO Version)</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
   l<!-- Custom CSS -->
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
                <button class="btn btn-outline-primary position-relative touch-target rounded-pill me-2 px-3" data-bs-toggle="modal" data-bs-target="#cartModal">
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

        <!-- Main Workspace -->
        <div class="row g-4">
            <!-- Sidebar Filter -->
            <div class="col-lg-3">
                <form method="GET" action="index.php" class="filter-card">
                    <h5 class="fw-bold mb-3 d-flex align-items-center">
                        <i class="fa-solid fa-sliders text-primary me-2"></i> Filter Produk
                    </h5>
                    
                    <!-- Search Input -->
                    <div class="mb-4">
                        <label for="search-input" class="form-label fw-semibold text-muted small uppercase">Cari Produk</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                            <input type="text" name="search" id="search-input" class="form-control bg-light border-start-0" placeholder="Ketik nama produk..." value="<?= htmlspecialchars($search); ?>">
                        </div>
                    </div>

                    <!-- Category Filter -->
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

                    <!-- Price Filter -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted small uppercase mb-2">Rentang Harga</label>
                        <div class="mb-2">
                            <label for="min-price" class="small text-muted">Harga Minimum (Rp)</label>
                            <input type="number" name="min_price" id="min-price" class="form-control bg-light" placeholder="0" value="<?= $min_price > 0 ? $min_price : ''; ?>">
                        </div>
                        <div>
                            <label for="max-price" class="small text-muted">Harga Maksimum (Rp)</label>
                            <input type="number" name="max_price" id="max-price" class="form-control bg-light" placeholder="99000000" value="<?= $max_price < 999999999 ? $max_price : ''; ?>">
                        </div>
                    </div>

                    <!-- Sort -->
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
                        <i class="fa-solid fa-arrow-rotate-left me-1"></i> Atur Ulang Filter
                    </a>
                </form>
            </div>

            <!-- Product Grid Area -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="text-muted mb-0"><span class="fw-bold text-dark"><?= count($products); ?></span> produk ditemukan</p>
                </div>

                <!-- Grid Product Cards -->
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
                                                        onclick='addToCart(<?= json_encode($item); ?>)'>
                                                    <i class="fa-solid fa-cart-plus"></i>
                                                    <span class="d-none d-sm-inline">Beli</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-12 text-center py-5">
                            <img src="https://placehold.co/150x150/faf6f6/94a3b8?text=Empty" alt="Tidak Ditemukan" class="img-fluid rounded-circle mb-3" style="width: 120px;">
                            <h5 class="fw-bold">Produk Tidak Ditemukan</h5>
                            <p class="text-muted">Cobalah mengubah kata kunci pencarian atau pengaturan filter Anda.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold" id="detailModalLabel">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="detail-image" src="" alt="" class="img-fluid rounded-3 mb-3 w-100" style="object-fit: cover; max-height: 300px;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span id="detail-category" class="badge bg-primary"></span>
                        <span id="detail-stock" class="badge bg-secondary"></span>
                    </div>
                    <h4 id="detail-name" class="fw-bold text-dark mb-1"></h4>
                    <p id="detail-price" class="fs-5 fw-bold text-primary mb-3"></p>
                    <p id="detail-description" class="text-muted"></p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                    <button id="detail-add-to-cart-btn" type="button" class="btn btn-primary rounded-pill px-4"><i class="fa-solid fa-cart-plus me-1"></i> Tambah ke Keranjang</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold" id="cartModalLabel"><i class="fa-solid fa-cart-shopping text-primary me-2"></i>Keranjang Belanja Anda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="cart-items-wrapper"></div>
                    <div id="cart-empty-message" class="text-center py-4 d-none">
                        <i class="fa-solid fa-basket-shopping text-muted fs-1 mb-2"></i>
                        <p class="text-muted mb-0">Keranjang belanja Anda masih kosong.</p>
                    </div>
                    <hr class="my-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Total Tagihan:</h5>
                        <h4 class="fw-bold text-primary mb-0" id="cart-total-price">Rp 0</h4>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Lanjut Belanja</button>
                    <button id="checkout-btn" type="button" class="btn btn-primary rounded-pill px-4" disabled>Selesaikan Pembelian</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkout Success Modal -->
    <div class="modal fade" id="checkoutSuccessModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow text-center p-4">
                <div class="modal-body">
                    <i class="fa-solid fa-circle-check text-success display-2 mb-3"></i>
                    <h3 class="fw-bold">Pembayaran Berhasil!</h3>
                    <p class="text-muted">Terima kasih telah berbelanja di Z Shop. Pesanan Anda akan segera kami proses dan kirimkan.</p>
                    <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">Selesai</button>
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
        const checkoutBtn = document.getElementById("checkout-btn");
        const cartToast = new bootstrap.Toast(document.getElementById("cartToast"));

        const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
        const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
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
                cart[index].quantity += amount;
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

            cartItemsWrapper.innerHTML = "";
            let totalBill = 0;

            if (cart.length === 0) {
                cartEmptyMessage.classList.remove("d-none");
                checkoutBtn.disabled = true;
            } else {
                cartEmptyMessage.classList.add("d-none");
                checkoutBtn.disabled = false;

                cart.forEach(item => {
                    const itemSubtotal = item.product.price * item.quantity;
                    totalBill += itemSubtotal;

                    const itemRow = document.createElement("div");
                    itemRow.className = "d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom";
                    itemRow.innerHTML = `
                        <div class="d-flex align-items-center me-3" style="flex: 1;">
                            <img src="${item.product.image || 'https://via.placeholder.com/100'}" alt="${item.product.name}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;" onerror="this.onerror=null;this.src='https://via.placeholder.com/100'">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.9rem;">${item.product.name}</h6>
                                <span class="small text-muted">${formatRupiah(item.product.price)}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="input-group input-group-sm me-3" style="width: 100px;">
                                <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(${item.product.id}, -1)">-</button>
                                <span class="form-control text-center bg-light border-secondary-subtle" style="font-weight: 500;">${item.quantity}</span>
                                <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(${item.product.id}, 1)">+</button>
                            </div>
                            <div class="text-end me-3" style="min-width: 100px;">
                                <span class="fw-bold text-dark small">${formatRupiah(itemSubtotal)}</span>
                            </div>
                            <button class="btn btn-link text-danger p-0 border-0" onclick="removeFromCart(${item.product.id})" style="width: 24px; height: 24px;">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    `;
                    cartItemsWrapper.appendChild(itemRow);
                });
            }

            cartTotalPrice.innerText = formatRupiah(totalBill);
        }

        checkoutBtn.addEventListener("click", () => {
            cartModal.hide();
            cart = [];
            updateCartUI();
            
            setTimeout(() => {
                checkoutSuccessModal.show();
            }, 300);
        });
    </script>
</body>
</html>