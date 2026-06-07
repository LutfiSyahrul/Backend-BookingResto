<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu; // Pastikan Model Menu sudah dibuat ya bos

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Masukkan array $jamboelMenus yang tadi di sini
        $jamboelMenus = [
        // ================= PAKET AYAM & KAKAP =================
        ['kategori' => 'Paket Ayam', 'nama_menu' => 'Kremes/Goreng (Nasi+Teh/Es+Sambal Lalapan)', 'harga' => 18000, 'gambar_url' => '/menu/paket-ayam-kremes.jpg'],
        ['kategori' => 'Paket Ayam', 'nama_menu' => 'Geprek (Nasi+Teh/Es+Lalapan)', 'harga' => 19000, 'gambar_url' => '/menu/paket-ayam-geprek.jpg'],
        ['kategori' => 'Paket Kakap', 'nama_menu' => 'Bakar/Goreng (Nasi+Teh/Es+Sambal Lalapan)', 'harga' => 20000, 'gambar_url' => '/menu/paket-kakap-bakar.jpg'],
        ['kategori' => 'Paket Kakap Masak', 'nama_menu' => 'Asam Manis/Mentega/Lada Hitam', 'harga' => 22000, 'gambar_url' => '/menu/paket-kakap-masak.jpg'],
        ['kategori' => 'Paket Rombongan', 'nama_menu' => 'Paket Ber 4 (Nasi 1 Bakul, Kakap Asam Manis, Ca Kangkung, Kepala/Ati Goreng, Teh)', 'harga' => 100000, 'gambar_url' => '/menu/paket-ber-4.jpg'],

        // ================= GURAME, CUMI & UDANG =================
        ['kategori' => 'Gurame', 'nama_menu' => 'Gurame Goreng', 'harga' => 28000, 'gambar_url' => '/menu/gurame-goreng.jpg'],
        ['kategori' => 'Gurame', 'nama_menu' => 'Gurame Bakar', 'harga' => 32000, 'gambar_url' => '/menu/gurame-bakar.jpg'],
        ['kategori' => 'Gurame', 'nama_menu' => 'Gurame Telur Asin/Asam Manis', 'harga' => 39000, 'gambar_url' => '/menu/gurame-telur-asin.jpg'],
        ['kategori' => 'Cumi / Udang', 'nama_menu' => 'Goreng Tepung', 'harga' => 20000, 'gambar_url' => '/menu/cumi-udang-tepung.jpg'],
        ['kategori' => 'Cumi / Udang', 'nama_menu' => 'Masak (Asam Manis/Mentega/Lada Hitam)', 'harga' => 23000, 'gambar_url' => '/menu/cumi-udang-masak.jpg'],

        // ================= AYAM KAMPUNG & BEBEK =================
        ['kategori' => 'Ayam Kampung', 'nama_menu' => 'Goreng', 'harga' => 19000, 'gambar_url' => '/menu/ayam-kampung-goreng.jpg'],
        ['kategori' => 'Ayam Kampung', 'nama_menu' => 'Bakar', 'harga' => 20000, 'gambar_url' => '/menu/ayam-kampung-bakar.jpg'],
        ['kategori' => 'Ayam Kampung', 'nama_menu' => 'Utuh Goreng', 'harga' => 70000, 'gambar_url' => '/menu/ayam-kampung-utuh-goreng.jpg'],
        ['kategori' => 'Ayam Kampung', 'nama_menu' => 'Utuh Bakar', 'harga' => 75000, 'gambar_url' => '/menu/ayam-kampung-utuh-bakar.jpg'],
        ['kategori' => 'Bebek Utuh', 'nama_menu' => 'Goreng', 'harga' => 90000, 'gambar_url' => '/menu/bebek-utuh-goreng.jpg'],
        ['kategori' => 'Bebek Utuh', 'nama_menu' => 'Bakar', 'harga' => 90000, 'gambar_url' => '/menu/bebek-utuh-bakar.jpg'],

        // ================= STEAK, SUP & IGA =================
        ['kategori' => 'Steak', 'nama_menu' => 'Steak Ayam', 'harga' => 17000, 'gambar_url' => '/menu/steak-ayam.jpg'],
        ['kategori' => 'Steak', 'nama_menu' => 'Steak Sapi', 'harga' => 20000, 'gambar_url' => '/menu/steak-sapi.jpg'],
        ['kategori' => 'Steak', 'nama_menu' => 'Steak Sapi Lada Hitam/Bistik', 'harga' => 24000, 'gambar_url' => '/menu/steak-sapi-lada-hitam.jpg'],
        ['kategori' => 'Sup', 'nama_menu' => 'Sup Ikan', 'harga' => 17000, 'gambar_url' => '/menu/sup-ikan.jpg'],
        ['kategori' => 'Sup', 'nama_menu' => 'Sup Ayam', 'harga' => 12000, 'gambar_url' => '/menu/sup-ayam.jpg'],
        ['kategori' => 'Iga', 'nama_menu' => 'Iga + Nasi', 'harga' => 35000, 'gambar_url' => '/menu/iga-nasi.jpg'],

        // ================= SAYUR & LAIN-LAIN =================
        ['kategori' => 'Lain-Lain', 'nama_menu' => 'Jamur Crispy', 'harga' => 8000, 'gambar_url' => '/menu/jamur-crispy.jpg'],
        ['kategori' => 'Lain-Lain', 'nama_menu' => 'Tahu Tempe', 'harga' => 3000, 'gambar_url' => '/menu/tahu-tempe.jpg'],
        ['kategori' => 'Lain-Lain', 'nama_menu' => 'French Fries', 'harga' => 10000, 'gambar_url' => '/menu/french-fries.jpg'],
        ['kategori' => 'Lain-Lain', 'nama_menu' => 'Sosis Goreng', 'harga' => 11000, 'gambar_url' => '/menu/sosis-goreng.jpg'],
        ['kategori' => 'Sayur', 'nama_menu' => 'Ca Kangkung', 'harga' => 11000, 'gambar_url' => '/menu/ca-kangkung.jpg'],
        ['kategori' => 'Sayur', 'nama_menu' => 'Capcay Kuah/Goreng', 'harga' => 14000, 'gambar_url' => '/menu/capcay.jpg'],
        ['kategori' => 'Sayur', 'nama_menu' => 'Brokoli', 'harga' => 12000, 'gambar_url' => '/menu/brokoli.jpg'],

        // ================= MINUMAN =================
        ['kategori' => 'Minuman', 'nama_menu' => 'Teh Panas/Es', 'harga' => 3000, 'gambar_url' => '/menu/teh-es.jpg'], // Typo "Pasa" dikoreksi
        ['kategori' => 'Minuman', 'nama_menu' => 'Jeruk Panas/Es', 'harga' => 5000, 'gambar_url' => '/menu/jeruk-es.jpg'],
        ['kategori' => 'Minuman', 'nama_menu' => 'Es Teller', 'harga' => 13000, 'gambar_url' => '/menu/es-teller.jpg'],
        ['kategori' => 'Minuman', 'nama_menu' => 'Jus Alpukat', 'harga' => 10000, 'gambar_url' => '/menu/jus-alpukat.jpg'],
        ['kategori' => 'Minuman', 'nama_menu' => 'Jus Melon', 'harga' => 7000, 'gambar_url' => '/menu/jus-melon.jpg'],
        ['kategori' => 'Minuman', 'nama_menu' => 'Jus Jambu', 'harga' => 7000, 'gambar_url' => '/menu/jus-jambu.jpg'],
        ['kategori' => 'Minuman', 'nama_menu' => 'Jus Tomat', 'harga' => 7000, 'gambar_url' => '/menu/jus-tomat.jpg'],
        ['kategori' => 'Minuman', 'nama_menu' => 'Jus Wortel', 'harga' => 7000, 'gambar_url' => '/menu/jus-wortel.jpg'],
        ['kategori' => 'Minuman', 'nama_menu' => 'Milo', 'harga' => 8000, 'gambar_url' => '/menu/milo.jpg'],
    ];

        foreach ($jamboelMenus as $item) {
            Menu::create([
                'restaurant_id' => 1, // Sesuaikan dengan ID Waroeng JamboeL di tabel restaurants
                'kategori'      => $item['kategori'],
                'nama_menu'     => $item['nama_menu'],
                'harga'         => $item['harga'],
                'gambar_url'    => $item['gambar_url'],
            ]);
        }
    }
}