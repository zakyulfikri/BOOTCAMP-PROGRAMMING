<?php
session_start();

// Inisialisasi variabel
$errors = [];
$old_data = [];
$name = '';
$description = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Simpan data inputan sementara agar bisa dipanggil kembali jika validasi gagal
    $old_data = [
        'name'        => $_POST['name'] ?? '',
        'category'    => $_POST['category'] ?? '',
        'price'       => $_POST['price'] ?? '',
        'stock'       => $_POST['stock'] ?? '',
        'description' => $_POST['description'] ?? ''
    ];

    // 1. Validasi Nama Produk
    if (empty($_POST["name"])) {
        $errors['name'] = "Nama produk wajib diisi.";
    } else {
        $name = htmlspecialchars(trim($_POST["name"]));
        if (strlen($name) < 3) {
            $errors['name'] = "Nama produk minimal 3 karakter.";
        }
    }

    // 2. Validasi Kategori
    $valid_categories = ['elektronik', 'pakaian', 'makanan', 'aksesoris'];
    if (empty($_POST["category"])) {
        $errors['category'] = "Pilih salah satu kategori.";
    } else {
        $category = $_POST["category"];
        if (!in_array($category, $valid_categories)) {
            $errors['category'] = "Kategori yang dipilih tidak valid.";
        }
    }

    // 3. Validasi Harga
    if (empty($_POST["price"])) {
        $errors['price'] = "Harga produk wajib diisi.";
    } else {
        $price = filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        if (!is_numeric($price) || $price <= 0) {
            $errors['price'] = "Harga harus berupa angka positif yang valid.";
        }
    }

    // 4. Validasi Stok
    if ($_POST["stock"] === "" || !isset($_POST["stock"])) {
        $errors['stock'] = "Stok produk wajib diisi.";
    } else {
        $stock = filter_var($_POST["stock"], FILTER_VALIDATE_INT);
        if ($stock === false || $stock < 0) {
            $errors['stock'] = "Stok harus berupa angka bulat non-negatif.";
        }
    }

    // 5. Validasi Gambar Produk
    if (!isset($_FILES["image"]) || $_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE) {
        $errors['image'] = "Gambar produk wajib diunggah.";
    } else {
        $file = $_FILES["image"];
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        $max_size = 2 * 1024 * 1024; // 2MB

        if ($file["error"] !== UPLOAD_ERR_OK) {
            $errors['image'] = "Terjadi kesalahan saat mengunggah gambar.";
        } elseif (!in_array($file["type"], $allowed_types)) {
            $errors['image'] = "Format file harus berupa JPG, JPEG, PNG, atau WEBP.";
        } elseif ($file["size"] > $max_size) {
            $errors['image'] = "Ukuran gambar maksimal 2 MB.";
        }
    }

    // 6. Validasi Deskripsi
    if (empty($_POST["description"])) {
        $errors['description'] = "Deskripsi produk wajib diisi.";
    } else {
        $description = htmlspecialchars(trim($_POST["description"]));
    }

    // JIKA ADA ERROR VALIDASI
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old_data;
        header("Location: input_produk.php");
        exit();
    }

    // JIKA VALIDASI SUKSES
    $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
    $new_filename = time() . '_' . uniqid() . '.' . $ext;
    $upload_dir = 'uploads/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (move_uploaded_file($file["tmp_name"], $upload_dir . $new_filename)) {
        // [TEMPAT QUERY DATABASE SIMPAN PRODUK]

        $_SESSION['success_msg'] = "Produk <strong>" . htmlspecialchars($name) . "</strong> berhasil ditambahkan!";
    } else {
        $_SESSION['errors'] = ['global' => "Gagal mengunggah file ke server."];
        $_SESSION['old'] = $old_data;
    }

    header("Location: input_produk.php");
    exit();
}