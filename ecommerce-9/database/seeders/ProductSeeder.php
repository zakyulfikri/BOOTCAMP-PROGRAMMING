<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\Products;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->delete();
        DB::table('product_categories')->delete();

        $categories = [
            ['name' => 'Elektronik', 'slug' => 'elektronik'],
            ['name' => 'Fashion', 'slug' => 'fashion'],
            ['name' => 'Olahraga', 'slug' => 'olahraga'],
            ['name' => 'Rumah Tangga', 'slug' => 'rumah-tangga'],
            ['name' => 'Kecantikan', 'slug' => 'kecantikan'],
        ];

        $now = now();
        foreach ($categories as &$category) {
            $category['created_at'] = $now;
            $category['updated_at'] = $now;
        }

        ProductCategory::insert($categories);

        $categoryMap = ProductCategory::query()
            ->whereIn('slug', array_column($categories, 'slug'))
            ->pluck('id', 'slug')
            ->toArray();

        $products = [
            'elektronik' => [
                ['name' => 'Smartphone X', 'slug' => 'smartphone-x', 'description' => 'Smartphone dengan layar AMOLED dan baterai tahan lama.', 'image' => 'images/smartphone-x.jpg', 'stock' => 25, 'price' => 2999000],
                ['name' => 'Laptop Nova 14', 'slug' => 'laptop-nova-14', 'description' => 'Laptop ringan untuk kerja harian dan multitasking.', 'image' => 'images/laptop-nova-14.jpg', 'stock' => 10, 'price' => 7999000],
                ['name' => 'Tablet Air Pro', 'slug' => 'tablet-air-pro', 'description' => 'Tablet produktivitas dengan performa cepat.', 'image' => 'images/tablet-air-pro.jpg', 'stock' => 18, 'price' => 4599000],
                ['name' => 'Earbuds Pro Lite', 'slug' => 'earbuds-pro-lite', 'description' => 'Headset wireless dengan bass seimbang.', 'image' => 'images/earbuds-pro-lite.jpg', 'stock' => 50, 'price' => 899000],
                ['name' => 'Smartwatch Pulse', 'slug' => 'smartwatch-pulse', 'description' => 'Jam tangan pintar untuk tracking aktivitas.', 'image' => 'images/smartwatch-pulse.jpg', 'stock' => 22, 'price' => 1899000],
                ['name' => 'Charger Fast 65W', 'slug' => 'charger-fast-65w', 'description' => 'Charger cepat untuk perangkat mobile.', 'image' => 'images/charger-fast-65w.jpg', 'stock' => 60, 'price' => 349000],
                ['name' => 'Keyboard Wireless Max', 'slug' => 'keyboard-wireless-max', 'description' => 'Keyboard tanpa kabel ergonomis untuk kantor.', 'image' => 'images/keyboard-wireless-max.jpg', 'stock' => 20, 'price' => 549000],
                ['name' => 'Monitor 24 Inch', 'slug' => 'monitor-24-inch', 'description' => 'Monitor 24 inch full HD untuk kerja.', 'image' => 'images/monitor-24-inch.jpg', 'stock' => 12, 'price' => 2450000],
                ['name' => 'Printer DeskJet Mini', 'slug' => 'printer-deskjet-mini', 'description' => 'Printer compact untuk kebutuhan rumah dan office.', 'image' => 'images/printer-deskjet-mini.jpg', 'stock' => 8, 'price' => 1699000],
                ['name' => 'Speaker Mini Boom', 'slug' => 'speaker-mini-boom', 'description' => 'Speaker portabel dengan suara luas.', 'image' => 'images/speaker-mini-boom.jpg', 'stock' => 40, 'price' => 699000],
            ],
            'fashion' => [
                ['name' => 'Kaos Oversize Basic', 'slug' => 'kaos-oversize-basic', 'description' => 'Kaos lengan pendek oversize nyaman dipakai harian.', 'image' => 'images/kaos-oversize-basic.jpg', 'stock' => 30, 'price' => 149000],
                ['name' => 'Jaket Bomber Urban', 'slug' => 'jaket-bomber-urban', 'description' => 'Jaket bomber trendi untuk tampilan casual.', 'image' => 'images/jaket-bomber-urban.jpg', 'stock' => 14, 'price' => 489000],
                ['name' => 'Celana Chino Slim', 'slug' => 'celana-chino-slim', 'description' => 'Celana chino dengan potongan slim modern.', 'image' => 'images/celana-chino-slim.jpg', 'stock' => 26, 'price' => 249000],
                ['name' => 'Dress Floral Casual', 'slug' => 'dress-floral-casual', 'description' => 'Dress ringan motif floral untuk acara santai.', 'image' => 'images/dress-floral-casual.jpg', 'stock' => 12, 'price' => 329000],
                ['name' => 'Sepatu Sneaker Run', 'slug' => 'sepatu-sneaker-run', 'description' => 'Sneaker ringan untuk aktifitas harian.', 'image' => 'images/sepatu-sneaker-run.jpg', 'stock' => 35, 'price' => 559000],
                ['name' => 'Tudung Hijab Motion', 'slug' => 'tudung-hijab-motion', 'description' => 'Hijab nyaman untuk daily wear.', 'image' => 'images/tudung-hijab-motion.jpg', 'stock' => 44, 'price' => 89000],
                ['name' => 'Blazer Formal Navy', 'slug' => 'blazer-formal-navy', 'description' => 'Blazer formal dengan cutting rapi.', 'image' => 'images/blazer-formal-navy.jpg', 'stock' => 9, 'price' => 649000],
                ['name' => 'Kemeja Lengan Panjang', 'slug' => 'kemeja-lengan-panjang', 'description' => 'Kemeja lengan panjang premium untuk kerja.', 'image' => 'images/kemeja-lengan-panjang.jpg', 'stock' => 24, 'price' => 289000],
                ['name' => 'Ransel Travel Compact', 'slug' => 'ransel-travel-compact', 'description' => 'Ransel ringan untuk perjalanan sehari.', 'image' => 'images/ransel-travel-compact.jpg', 'stock' => 18, 'price' => 399000],
                ['name' => 'Sandal Sport Flex', 'slug' => 'sandal-sport-flex', 'description' => 'Sandal sporty untuk aktivitas luar ruangan.', 'image' => 'images/sandal-sport-flex.jpg', 'stock' => 28, 'price' => 199000],
            ],
            'olahraga' => [
                ['name' => 'Yoga Mat Pro', 'slug' => 'yoga-mat-pro', 'description' => 'Yoga mat anti-slip dengan bantalan tebal.', 'image' => 'images/yoga-mat-pro.jpg', 'stock' => 20, 'price' => 239000],
                ['name' => 'Dumbbell Set 10KG', 'slug' => 'dumbbell-set-10kg', 'description' => 'Set dumbbell ringan untuk latihan home gym.', 'image' => 'images/dumbbell-set-10kg.jpg', 'stock' => 15, 'price' => 499000],
                ['name' => 'Sepeda Listrik Urban', 'slug' => 'sepeda-listrik-urban', 'description' => 'Sepeda listrik untuk perjalanan harian.', 'image' => 'images/sepeda-listrik-urban.jpg', 'stock' => 5, 'price' => 6399000],
                ['name' => 'T-Shirt Sport Aero', 'slug' => 't-shirt-sport-aero', 'description' => 'T-shirt olahraga cepat kering.', 'image' => 'images/t-shirt-sport-aero.jpg', 'stock' => 28, 'price' => 119000],
                ['name' => 'Botol Minum Kinetik', 'slug' => 'botol-minum-kinetik', 'description' => 'Botol minum tahan panas dan anti bocor.', 'image' => 'images/botol-minum-kinetik.jpg', 'stock' => 33, 'price' => 99000],
                ['name' => 'Raket Badminton Power', 'slug' => 'raket-badminton-power', 'description' => 'Raket ringan cocok untuk latihan badminton.', 'image' => 'images/raket-badminton-power.jpg', 'stock' => 13, 'price' => 349000],
                ['name' => 'Tas Gym Flex', 'slug' => 'tas-gym-flex', 'description' => 'Tas gym sederhana dan nyaman.', 'image' => 'images/tas-gym-flex.jpg', 'stock' => 16, 'price' => 279000],
                ['name' => 'Jersey Futsal Team', 'slug' => 'jersey-futsal-team', 'description' => 'Jersey futsal bahan ringan dan menyerap keringat.', 'image' => 'images/jersey-futsal-team.jpg', 'stock' => 22, 'price' => 219000],
                ['name' => 'Treadmill Mini Fit', 'slug' => 'treadmill-mini-fit', 'description' => 'Alat lari mini untuk rumah.', 'image' => 'images/treadmill-mini-fit.jpg', 'stock' => 4, 'price' => 3999000],
                ['name' => 'Kacamata Olahraga X', 'slug' => 'kacamata-olahraga-x', 'description' => 'Kacamata olahraga anti silau.', 'image' => 'images/kacamata-olahraga-x.jpg', 'stock' => 30, 'price' => 195000],
            ],
            'rumah-tangga' => [
                ['name' => 'Blender Kitchen Mix', 'slug' => 'blender-kitchen-mix', 'description' => 'Blender rumah tangga multifungsi.', 'image' => 'images/blender-kitchen-mix.jpg', 'stock' => 12, 'price' => 399000],
                ['name' => 'Set Piring Ceramic', 'slug' => 'set-piring-ceramic', 'description' => 'Set piring 6 pcs untuk keluarga.', 'image' => 'images/set-piring-ceramic.jpg', 'stock' => 18, 'price' => 289000],
                ['name' => 'Kipas Angin Mini', 'slug' => 'kipas-angin-mini', 'description' => 'Kipas angin kecil portabel untuk ruangan.', 'image' => 'images/kipas-angin-mini.jpg', 'stock' => 21, 'price' => 239000],
                ['name' => 'Lampu LED Smart', 'slug' => 'lampu-led-smart', 'description' => 'Lampu LED hemat energi dengan remote.', 'image' => 'images/lampu-led-smart.jpg', 'stock' => 30, 'price' => 159000],
                ['name' => 'Kompor Gas Portable', 'slug' => 'kompor-gas-portable', 'description' => 'Kompor gas portable untuk kebutuhan praktis.', 'image' => 'images/kompor-gas-portable.jpg', 'stock' => 10, 'price' => 325000],
                ['name' => 'Rak Dapur Modul', 'slug' => 'rak-dapur-modul', 'description' => 'Rak dapur multi fungsi ruang penyimpanan.', 'image' => 'images/rak-dapur-modul.jpg', 'stock' => 11, 'price' => 540000],
                ['name' => 'Miee Toaster', 'slug' => 'mixer-toaster', 'description' => 'Toaster ringan untuk sarapan cepat.', 'image' => 'images/toaster-bread.jpg', 'stock' => 14, 'price' => 269000],
                ['name' => 'Vacuum Cleaner Mini', 'slug' => 'vacuum-cleaner-mini', 'description' => 'Pembersih rumah kecil portable.', 'image' => 'images/vacuum-cleaner-mini.jpg', 'stock' => 8, 'price' => 659000],
                ['name' => 'Set Peralatan Makan', 'slug' => 'set-peralatan-makan', 'description' => 'Peralatan makan lengkap untuk keluarga.', 'image' => 'images/set-peralatan-makan.jpg', 'stock' => 24, 'price' => 399000],
                ['name' => 'Tempat Sampah Sensor', 'slug' => 'tempat-sampah-sensor', 'description' => 'Tempat sampah otomatis sensor.', 'image' => 'images/tempat-sampah-sensor.jpg', 'stock' => 7, 'price' => 249000],
            ],
            'kecantikan' => [
                ['name' => 'Serum Bright Skin', 'slug' => 'serum-bright-skin', 'description' => 'Serum wajah untuk mencerahkan kulit.', 'image' => 'images/serum-bright-skin.jpg', 'stock' => 40, 'price' => 179000],
                ['name' => 'Lip Tint Velvet', 'slug' => 'lip-tint-velvet', 'description' => 'Lip tint tahan lama dengan warna natural.', 'image' => 'images/lip-tint-velvet.jpg', 'stock' => 34, 'price' => 95000],
                ['name' => 'Face Wash Glow', 'slug' => 'face-wash-glow', 'description' => 'Sabun wajah pembersih lembut.', 'image' => 'images/face-wash-glow.jpg', 'stock' => 50, 'price' => 79000],
                ['name' => 'Sunscreen Daily UV', 'slug' => 'sunscreen-daily-uv', 'description' => 'Sunscreen perlindungan SPF 30.', 'image' => 'images/sunscreen-daily-uv.jpg', 'stock' => 26, 'price' => 129000],
                ['name' => 'Makeup Brush Set', 'slug' => 'makeup-brush-set', 'description' => 'Set kuas makeup untuk daily routine.', 'image' => 'images/makeup-brush-set.jpg', 'stock' => 24, 'price' => 189000],
                ['name' => 'Body Lotion Soft', 'slug' => 'body-lotion-soft', 'description' => 'Lotion pelembap tubuh aroma lembut.', 'image' => 'images/body-lotion-soft.jpg', 'stock' => 39, 'price' => 110000],
                ['name' => 'Masker Sheet Hydrate', 'slug' => 'masker-sheet-hydrate', 'description' => 'Masker wajah hydrating sheet.', 'image' => 'images/masker-sheet-hydrate.jpg', 'stock' => 55, 'price' => 45000],
                ['name' => 'Perfume Bloom Mist', 'slug' => 'perfume-bloom-mist', 'description' => 'Parfum mist dengan aroma bunga lembut.', 'image' => 'images/perfume-bloom-mist.jpg', 'stock' => 16, 'price' => 269000],
                ['name' => 'Hair Serum Gloss', 'slug' => 'hair-serum-gloss', 'description' => 'Hair serum mengurangi kusut.', 'image' => 'images/hair-serum-gloss.jpg', 'stock' => 20, 'price' => 139000],
                ['name' => 'Mini Makeup Kit', 'slug' => 'mini-makeup-kit', 'description' => 'Kit makeup travel compact.', 'image' => 'images/mini-makeup-kit.jpg', 'stock' => 17, 'price' => 219000],
            ],
        ];

        $dataToInsert = [];

        foreach ($products as $slugCategory => $items) {
            $categoryId = $categoryMap[$slugCategory] ?? null;

            if ($categoryId === null) {
                continue;
            }

            foreach ($items as $item) {
                $dataToInsert[] = [
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                    'description' => $item['description'],
                    'image' => $item['image'],
                    'stock' => $item['stock'],
                    'price' => $item['price'],
                    'product_category_id' => $categoryId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        Products::insert($dataToInsert);
    }
}
