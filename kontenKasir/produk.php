<?php
// Periksa keberadaan file koneksi database
if (!file_exists(__DIR__ . '/../backend/database.php')) {
    die('File koneksi database tidak ditemukan');
}

// Masukkan file koneksi database
require_once __DIR__ . '/../backend/database.php';

// Mulai session

// helper untuk menghasilkan src gambar atau placeholder
function product_image_src($filename, $width = 180) {
    $diskPath = __DIR__ . '/../image/' . $filename;
    if ($filename && file_exists($diskPath)) {
        return '../image/' . rawurlencode($filename);
    }
    // gunakan placeholder (bisa ganti ke path placeholder lokal jika ada)
    return "https://via.placeholder.com/{$width}?text=No+Image";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --grey-primary: #2c3338;
            --grey-secondary: #3f474e;
            --grey-light: #e9ecef;
            --grey-hover: #4a545c;
        }

        body {
            background-color: var(--grey-light);
        }

        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card-header {
            border-bottom: none;
        }

        /* Best Seller Card */
        .card-header.bg-warning {
            background-color: var(--grey-secondary) !important;
            color: white !important;
        }

        .btn-warning {
            background-color: var(--grey-primary);
            border-color: var(--grey-primary);
            color: white;
        }

        .btn-warning:hover {
            background-color: var(--grey-hover);
            border-color: var(--grey-hover);
            color: white;
        }

        /* Product List Card */
        .card-header.bg-primary {
            background-color: var(--grey-primary) !important;
        }

        .btn-success {
            background-color: var(--grey-secondary);
            border-color: var(--grey-secondary);
        }

        .btn-success:hover {
            background-color: var(--grey-hover);
            border-color: var(--grey-hover);
        }

        /* Cart Card */
        .card-header.bg-success {
            background-color: var(--grey-secondary) !important;
        }

        .btn-primary {
            background-color: var(--grey-primary);
            border-color: var(--grey-primary);
        }

        .btn-primary:hover {
            background-color: var(--grey-hover);
            border-color: var(--grey-hover);
        }

        /* Table Styling */
        .table {
            color: var(--grey-primary);
        }

        .table thead th {
            background-color: var(--grey-light);
            border-bottom: 2px solid var(--grey-secondary);
        }

        /* Form Controls */
        .form-control:focus {
            border-color: var(--grey-secondary);
            box-shadow: 0 0 0 0.2rem rgba(63, 71, 78, 0.25);
        }

        /* Remove Button in Cart */
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #bb2d3b;
            border-color: #b02a37;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Bagian Kiri - Daftar Produk -->
            <div class="col-md-8">
                <!-- Best Seller Card -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">Produk Terlaris</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            // Query untuk mengambil produk terlaris
                            $best_seller_query = "SELECT 
                                p.id_produk,
                                p.nama_produk,
                                p.harga,
                                p.stok,
                                p.file_gambar,
                                COALESCE(SUM(tp.jumlah), 0) as total_terjual
                                FROM produk p
                                LEFT JOIN transaksi_produk tp ON p.id_produk = tp.id_produk
                                WHERE p.stok > 0
                                GROUP BY p.id_produk, p.nama_produk, p.harga, p.stok, p.file_gambar
                                ORDER BY total_terjual DESC
                                LIMIT 4";
                            
                            $best_seller_result = $conn->query($best_seller_query);
                            while($product = $best_seller_result->fetch_assoc()):
                            ?>
                            <div class="col-md-3 mb-3">
                                <div class="card h-100">
                                    <img src="<?= product_image_src($product['file_gambar'], 120) ?>" 
                                         class="card-img-top"
                                         alt="<?= htmlspecialchars($product['nama_produk']) ?>"
                                         style="height:120px; object-fit:cover;">
                                    <div class="card-body text-center">
                                        <h6 class="card-title"><?= htmlspecialchars($product['nama_produk']) ?></h6>
                                        <p class="card-text text-primary fw-bold">
                                            Rp <?= number_format($product['harga'], 0, ',', '.') ?>
                                        </p>
                                        <p class="card-text small text-muted">
                                            Terjual: <?= $product['total_terjual'] ?>
                                        </p>
                                        <button class="btn btn-warning btn-sm add-item w-100" 
                                                data-id="<?= $product['id_produk'] ?>"
                                                data-nama="<?= $product['nama_produk'] ?>"
                                                data-harga="<?= $product['harga'] ?>"
                                                data-gambar="<?= htmlspecialchars($product['file_gambar']) ?>">
                                            <i class="bi bi-cart-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Daftar Produk</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            $query = "SELECT * FROM produk WHERE stok > 0";
                            $result = $conn->query($query);
                            while($row = $result->fetch_assoc()):
                            ?>
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    <img src="<?= product_image_src($row['file_gambar'], 180) ?>" 
                                         class="card-img-top"
                                         alt="<?= htmlspecialchars($row['nama_produk']) ?>"
                                         style="height: 180px; object-fit: cover;">
                                    <div class="card-body">
                                        <h6 class="card-title"><?= htmlspecialchars($row['nama_produk']) ?></h6>
                                        <p class="card-text">
                                            <span class="text-primary fw-bold">Rp <?= number_format($row['harga'], 0, ',', '.') ?></span>
                                            <br>
                                            <small class="text-muted">Stok: <?= htmlspecialchars($row['stok']) ?></small>
                                        </p>
                                        <button class="btn btn-success btn-sm w-100 add-item" 
                                                data-id="<?= $row['id_produk'] ?>"
                                                data-nama="<?= $row['nama_produk'] ?>"
                                                data-harga="<?= $row['harga'] ?>"
                                                data-gambar="<?= htmlspecialchars($row['file_gambar']) ?>">
                                            <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan - Keranjang & Pembayaran -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Keranjang</h5>
                    </div>
                    <div class="card-body">
                        <form id="transaksi-form" action="../backend/querySql/proses_transaksi.php" method="POST">
                            <div class="cart-items mb-3">
                                <!-- Item keranjang akan ditambahkan di sini via JavaScript -->
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label">Total:</label>
                                <input type="text" class="form-control" id="total" name="total" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bayar:</label>
                                <input type="number" class="form-control" id="bayar" name="bayar" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kembalian:</label>
                                <input type="text" class="form-control" id="kembalian" readonly>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Proses Pembayaran</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cart = [];
            const cartDiv = document.querySelector('.cart-items');
            const totalInput = document.getElementById('total');
            const bayarInput = document.getElementById('bayar');
            const kembalianInput = document.getElementById('kembalian');

            // Tambah item ke keranjang
            document.querySelectorAll('.add-item').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nama = this.dataset.nama;
                    const harga = parseFloat(this.dataset.harga);
                    const gambar = this.dataset.gambar || ''; // ambil nama file gambar
                                        
                    addToCart(id, nama, harga, gambar);
                    updateCartDisplay();
                });
            });

            // Hitung kembalian saat input pembayaran berubah
            bayarInput.addEventListener('input', function() {
                const total = parseFloat(totalInput.value.replace(/[^\d]/g, '')) || 0;
                const bayar = parseFloat(this.value) || 0;
                const kembalian = bayar - total;
                
                kembalianInput.value = `Rp ${kembalian.toLocaleString('id-ID')}`;
            });

            // Modify form submission
            document.getElementById('transaksi-form').addEventListener('submit', async function(e) {
                e.preventDefault();
                
                if (cart.length === 0) {
                    alert('Keranjang masih kosong!');
                    return;
                }

                const formData = new FormData(this);
                formData.append('items', JSON.stringify(cart));

                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();
                    
                    if (result.success) {
                        // Redirect ke halaman struk dengan ID transaksi
                        window.open(`Struk/struk.php?id=${result.transaction_id}`, '_blank', 'width=400,height=600');
                        
                        // Reset keranjang
                        cart = [];
                        updateCartDisplay();
                        bayarInput.value = '';
                        kembalianInput.value = '';
                    } else {
                        alert(result.message || 'Terjadi kesalahan');
                    }
                } catch (error) {
                    alert('Terjadi kesalahan sistem');
                    console.error(error);
                }
            });

            function addToCart(id, nama, harga, gambar = '') {
                const existingItem = cart.find(item => item.id === id);
                
                if (existingItem) {
                    existingItem.qty++;
                } else {
                    cart.push({ id, nama, harga, qty: 1, gambar });
                }
            }

            function updateCartDisplay() {
                cartDiv.innerHTML = '';
                let total = 0;

                cart.forEach((item, index) => {
                    const itemTotal = item.harga * item.qty;
                    total += itemTotal;

                    cartDiv.innerHTML += `
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <img src="../image/${item.gambar}" alt="${item.nama}" style="width:40px;height:40px;object-fit:cover;border-radius:4px;margin-right:8px;">
                                <div>
                                    ${item.nama} x ${item.qty}
                                    <input type="hidden" name="items[${index}][id]" value="${item.id}">
                                    <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
                                    <input type="hidden" name="items[${index}][gambar]" value="${item.gambar}">
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span>Rp ${itemTotal.toLocaleString('id-ID')}</span>
                                <button type="button" class="btn btn-danger btn-sm remove-item" 
                                        data-index="${index}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });

                totalInput.value = `Rp ${total.toLocaleString('id-ID')}`;

                // Add event listeners for remove buttons
                document.querySelectorAll('.remove-item').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        cart.splice(index, 1);
                        updateCartDisplay();
                    });
                });
            }
        });
    </script>
</body>
</html>