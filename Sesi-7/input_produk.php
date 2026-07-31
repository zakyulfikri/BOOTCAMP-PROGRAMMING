<?php
session_start();

// Ambil data pesan dan error dari Session
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
$success_msg = $_SESSION['success_msg'] ?? "";

// Hapus Session setelah diambil agar tidak tampil lagi saat page di-refresh
unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['success_msg']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Produk</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="card-title mb-0">Tambah Produk Baru</h4>
                </div>
                <div class="card-body p-4">

                    <!-- Pesan Sukses -->
                    <?php if (!empty($success_msg)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $success_msg ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Pesan Error Global -->
                    <?php if (isset($errors['global'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $errors['global'] ?>
                        </div>
                    <?php endif; ?>

                    <form action="process.php" method="POST" enctype="multipart/form-data" novalidate>
                        
                        <!-- Nama Produk -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                                   id="name" 
                                   name="name" 
                                   value="<?= htmlspecialchars($old['name'] ?? '') ?>" 
                                   placeholder="Contoh: Laptop Gaming Pro">
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback"><?= $errors['name'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Kategori & Harga -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select <?= isset($errors['category']) ? 'is-invalid' : '' ?>" id="category" name="category">
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    <?php 
                                    $categories = ['elektronik' => 'Elektronik', 'pakaian' => 'Pakaian', 'makanan' => 'Makanan', 'aksesoris' => 'Aksesoris'];
                                    foreach ($categories as $key => $label): 
                                        $selected = ($old['category'] ?? '') === $key ? 'selected' : '';
                                    ?>
                                        <option value="<?= $key ?>" <?= $selected ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errors['category'])): ?>
                                    <div class="invalid-feedback"><?= $errors['category'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-bold">Harga (IDR) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           step="0.01" 
                                           class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>" 
                                           id="price" 
                                           name="price" 
                                           value="<?= htmlspecialchars($old['price'] ?? '') ?>" 
                                           placeholder="100000">
                                    <?php if (isset($errors['price'])): ?>
                                        <div class="invalid-feedback"><?= $errors['price'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Stok & Gambar -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="stock" class="form-label fw-bold">Jumlah Stok <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control <?= isset($errors['stock']) ? 'is-invalid' : '' ?>" 
                                       id="stock" 
                                       name="stock" 
                                       value="<?= htmlspecialchars($old['stock'] ?? '') ?>" 
                                       placeholder="10">
                                <?php if (isset($errors['stock'])): ?>
                                    <div class="invalid-feedback"><?= $errors['stock'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-8 mb-3">
                                <label for="image" class="form-label fw-bold">Gambar Produk (Maks 2MB) <span class="text-danger">*</span></label>
                                <input type="file" 
                                       class="form-control <?= isset($errors['image']) ? 'is-invalid' : '' ?>" 
                                       id="image" 
                                       name="image" 
                                       accept="image/*">
                                <?php if (isset($errors['image'])): ?>
                                    <div class="invalid-feedback"><?= $errors['image'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Deskripsi Produk <span class="text-danger">*</span></label>
                            <textarea class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Tuliskan deskripsi lengkap produk..."><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
                            <?php if (isset($errors['description'])): ?>
                                <div class="invalid-feedback"><?= $errors['description'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <button type="submit" class="btn btn-primary px-4">Simpan Produk</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>