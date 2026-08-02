<?php
require_once 'koneksi.php';

$message = '';
$message_type = '';

// 1. DELETE PRODUK
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        header("Location: admin.php?msg=deleted");
        exit;
    } catch (PDOException $e) {
        $message = "Gagal menghapus produk: " . $e->getMessage();
        $message_type = "danger";
    }
}

// 2. CREATE & UPDATE PRODUK
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id          = isset($_POST['id']) && $_POST['id'] !== '' ? (int)$_POST['id'] : null;
    $name        = trim($_POST['name']);
    $category    = trim($_POST['category']);
    $price       = (float)$_POST['price'];
    $stock       = (int)$_POST['stock'];
    $image       = trim($_POST['image']);
    $description = trim($_POST['description']);

    if (empty($name) || empty($category) || $price < 0 || $stock < 0) {
        $message = "Harap isi semua kolom wajib dengan benar!";
        $message_type = "warning";
    } else {
        try {
            if ($id) {
                $sql = "UPDATE products SET name = :name, category = :category, price = :price, stock = :stock, image = :image, description = :description WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':name' => $name, ':category' => $category, ':price' => $price,
                    ':stock' => $stock, ':image' => $image, ':description' => $description, ':id' => $id
                ]);
                header("Location: admin.php?msg=updated");
                exit;
            } else {
                $sql = "INSERT INTO products (name, category, price, stock, image, description) VALUES (:name, :category, :price, :stock, :image, :description)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':name' => $name, ':category' => $category, ':price' => $price,
                    ':stock' => $stock, ':image' => $image, ':description' => $description
                ]);
                header("Location: admin.php?msg=created");
                exit;
            }
        } catch (PDOException $e) {
            $message = "Terjadi kesalahan database: " . $e->getMessage();
            $message_type = "danger";
        }
    }
}

if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'created') { $message = "Produk berhasil ditambahkan!"; $message_type = "success"; }
    elseif ($_GET['msg'] === 'updated') { $message = "Data produk berhasil diperbarui!"; $message_type = "info"; }
    elseif ($_GET['msg'] === 'deleted') { $message = "Produk berhasil dihapus!"; $message_type = "success"; }
}

// Fetch Produk
$stmtProducts = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmtProducts->fetchAll();

// Fetch Pesanan/Orders
$stmtOrders = $pdo->query("SELECT * FROM orders ORDER BY id DESC");
$orders = $stmtOrders->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin Z Shop</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold text-primary" href="admin.php">
                <i class="fa-solid fa-user-gear me-2 fs-3"></i>
                <span>Panel Admin Z Shop</span>
            </a>
            <div class="ms-auto">
                <a href="index.php" class="btn btn-outline-primary rounded-pill px-3" target="_blank">
                    <i class="fa-solid fa-store me-1"></i> Lihat Toko
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <?php if (!empty($message)) : ?>
            <div class="alert alert-<?= $message_type; ?> alert-dismissible fade show rounded-3" role="alert">
                <?= htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Nav Tabs Admin -->
        <ul class="nav nav-pills mb-4" id="adminTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active rounded-pill px-4" id="products-tab" data-bs-toggle="tab" data-bs-target="#products-pane" type="button"><i class="fa-solid fa-box me-2"></i>Kelola Produk</button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders-pane" type="button"><i class="fa-solid fa-receipt me-2"></i>Riwayat Pesanan (<?= count($orders); ?>)</button>
            </li>
        </ul>

        <div class="tab-content" id="adminTabContent">
            <!-- TAB PRODUK -->
            <div class="tab-pane fade show active" id="products-pane">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0">Daftar Inventaris Produk</h4>
                    <button class="btn btn-primary rounded-pill px-4" onclick="openAddModal()"><i class="fa-solid fa-plus me-1"></i> Tambah Produk</button>
                </div>

                <div class="card overflow-hidden border-0 shadow-sm rounded-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">#ID</th>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $row) : ?>
                                    <tr>
                                        <td class="ps-3 fw-bold text-muted">#<?= $row['id']; ?></td>
                                        <td><img src="<?= htmlspecialchars($row['image'] ?? ''); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;" onerror="this.src='https://via.placeholder.com/50'"></td>
                                        <td><div class="fw-bold"><?= htmlspecialchars($row['name']); ?></div></td>
                                        <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($row['category']); ?></span></td>
                                        <td class="fw-bold text-primary">Rp <?= number_format($row['price'], 0, ',', '.'); ?></td>
                                        <td><span class="badge <?= $row['stock'] > 5 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'; ?>"><?= $row['stock']; ?> unit</span></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1" onclick='openEditModal(<?= json_encode($row); ?>)'><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                            <a href="admin.php?action=delete&id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Hapus produk ini?')"><i class="fa-solid fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB PESANAN / ORDERS -->
            <div class="tab-pane fade" id="orders-pane">
                <h4 class="fw-bold mb-3">Riwayat Transaksi Masuk</h4>
                <div class="card overflow-hidden border-0 shadow-sm rounded-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">#ID</th>
                                    <th>Pemesan</th>
                                    <th>Metode</th>
                                    <th>Alamat Pengiriman</th>
                                    <th>Rincian Barang</th>
                                    <th>Total Tagihan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($orders) > 0) : ?>
                                    <?php foreach ($orders as $ord) : ?>
                                        <tr>
                                            <td class="ps-3 fw-bold">#<?= $ord['id']; ?></td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($ord['buyer_name']); ?></div>
                                                <small class="text-muted d-block"><?= htmlspecialchars($ord['buyer_email']); ?></small>
                                                <small class="text-muted"><?= htmlspecialchars($ord['buyer_phone']); ?></small>
                                            </td>
                                            <td><span class="badge bg-primary-subtle text-primary"><?= htmlspecialchars($ord['payment_method']); ?></span></td>
                                            <td><small><?= htmlspecialchars($ord['buyer_address']); ?></small></td>
                                            <td>
                                                <?php 
                                                    $items = json_decode($ord['items_json'], true);
                                                    if ($items) {
                                                        foreach ($items as $it) {
                                                            echo "<small class='d-block'>• " . htmlspecialchars($it['product_name']) . " (" . $it['quantity'] . "x)</small>";
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td class="fw-bold text-primary">Rp <?= number_format($ord['total_price'], 0, ',', '.'); ?></td>
                                            <td><small class="text-muted"><?= $ord['created_at']; ?></small></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada transaksi masuk.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form (Create & Edit) -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form method="POST" action="admin.php">
                    <div class="modal-header border-0 bg-light">
                        <h5 class="modal-title fw-bold" id="modalTitle">Tambah Produk Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="id" id="prod_id">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Nama Produk *</label>
                                <input type="text" name="name" id="prod_name" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Kategori *</label>
                                <select name="category" id="prod_category" class="form-select" required>
                                    <option value="Elektronik">Elektronik</option>
                                    <option value="Fashion">Fashion</option>
                                    <option value="Rumah Tangga">Rumah Tangga</option>
                                    <option value="Olahraga">Olahraga</option>
                                    <option value="Kecantikan">Kecantikan & Kesehatan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Harga (Rp) *</label>
                                <input type="number" step="0.01" name="price" id="prod_price" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jumlah Stok *</label>
                                <input type="number" name="stock" id="prod_stock" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">URL Gambar Produk</label>
                                <input type="url" name="image" id="prod_image" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Deskripsi Produk</label>
                                <textarea name="description" id="prod_description" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const productModal = new bootstrap.Modal(document.getElementById('productModal'));

        function openAddModal() {
            document.getElementById('modalTitle').innerText = 'Tambah Produk Baru';
            document.getElementById('prod_id').value = '';
            document.getElementById('prod_name').value = '';
            document.getElementById('prod_category').value = 'Elektronik';
            document.getElementById('prod_price').value = '';
            document.getElementById('prod_stock').value = '';
            document.getElementById('prod_image').value = '';
            document.getElementById('prod_description').value = '';
            productModal.show();
        }

        function openEditModal(product) {
            document.getElementById('modalTitle').innerText = 'Edit Produk #' + product.id;
            document.getElementById('prod_id').value = product.id;
            document.getElementById('prod_name').value = product.name;
            document.getElementById('prod_category').value = product.category;
            document.getElementById('prod_price').value = product.price;
            document.getElementById('prod_stock').value = product.stock;
            document.getElementById('prod_image').value = product.image || '';
            document.getElementById('prod_description').value = product.description || '';
            productModal.show();
        }
    </script>
</body>
</html>