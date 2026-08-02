<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || empty($input['cart']) || empty($input['buyer'])) {
    echo json_encode(['success' => false, 'message' => 'Data pesanan tidak valid!']);
    exit;
}

$cart  = $input['cart'];
$buyer = $input['buyer'];

try {
    $pdo->beginTransaction();

    // 1. Hitung Total Pembelian & Susun Array JSON
    $totalPrice = 0;
    $itemsSummary = [];

    foreach ($cart as $item) {
        $price = (float)$item['product']['price'];
        $qty   = (int)$item['quantity'];
        $subtotal = $price * $qty;
        
        $totalPrice += $subtotal;

        $itemsSummary[] = [
            'product_id'   => $item['product']['id'],
            'product_name' => $item['product']['name'],
            'price'        => $price,
            'quantity'     => $qty,
            'subtotal'     => $subtotal
        ];
    }

    // 2. Simpan Data Transaksi ke Tabel `orders`
    $orderSql = "INSERT INTO orders (buyer_name, buyer_email, buyer_phone, buyer_address, payment_method, total_price, items_json) 
                 VALUES (:name, :email, :phone, :address, :method, :total, :items)";
    
    $orderStmt = $pdo->prepare($orderSql);
    $orderStmt->execute([
        ':name'    => $buyer['name'],
        ':email'   => $buyer['email'],
        ':phone'   => $buyer['phone'],
        ':address' => $buyer['address'],
        ':method'  => $buyer['method'],
        ':total'   => $totalPrice,
        ':items'   => json_encode($itemsSummary)
    ]);

    // 3. Kurangi Stok pada Tabel `products`
    $checkStmt  = $pdo->prepare("SELECT stock, name FROM products WHERE id = :id FOR UPDATE");
    $updateStmt = $pdo->prepare("UPDATE products SET stock = stock - :qty WHERE id = :id");

    foreach ($cart as $item) {
        $productId   = (int)$item['product']['id'];
        $productName = $item['product']['name'];
        $qty         = (int)$item['quantity'];

        $checkStmt->execute([':id' => $productId]);
        $product = $checkStmt->fetch();

        if (!$product || $product['stock'] < $qty) {
            throw new Exception("Stok produk '$productName' tidak mencukupi!");
        }

        $updateStmt->execute([
            ':qty' => $qty,
            ':id'  => $productId
        ]);
    }

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Pesanan berhasil disimpan dan stok telah berkurang!'
    ]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>