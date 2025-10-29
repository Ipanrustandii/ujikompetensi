<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../../theme.css" />
    <title>Daftar Menu</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            padding: 32px;
        }

        h1,
        h2 {
            color: #333;
            margin-bottom: 24px;
        }

        .table-produk {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .table-produk th,
        .table-produk td {
            border: 1px solid #e2e2e2;
            padding: 12px 16px;
            text-align: left;
        }

        .table-produk th {
            background: #e9ecef;
            color: #222;
        }

        .table-produk tr:nth-child(even) {
            background: #f4f6f8;
        }

        .btn {
            background: #2dce89;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            transition: background 0.2s;
        }

        .btn:hover {
            background: #218c5b;
        }
        /* qty control styles */
        .qty-controls .btn { padding: 4px 10px; }
        .qty-display { min-width:56px; font-weight:600; display:flex; align-items:center; justify-content:center; }
    </style>
</head>

<body>
    <?php
    include '../../backend/querySql/readProduk.php';
    ?>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary"><i class="bi bi-box-seam"></i> Daftar Menu</h2>
          
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-sm rounded">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Gambar</th>
                        <th scope="col" colspan="2" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    while ($data = mysqli_fetch_assoc($tampil)) {
                        $no++;
                    ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td class="fw-semibold text-dark"><?= htmlspecialchars($data['nama_produk']) ?></td>
                            <td>Rp <?= number_format($data['harga'], 0, ',', '.') ?></td>
                            <td><?= $data['stok'] ?></td>
                            <td><img src="../../image/<?= $data['file_gambar'] ?>"alt="GAMBAR TIDAK DITEMUKAN"  width="100" ></td>
                            <td class="text-center align-middle">
                                <div class="qty-controls d-inline-flex" data-id="<?= $data['id_produk'] ?>" data-stok="<?= $data['stok'] ?>" data-nama="<?= htmlspecialchars($data['nama_produk'], ENT_QUOTES) ?>" data-harga="<?= $data['harga'] ?>">
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-decr" title="Kurangi">-</button>
                                    <div class="qty-display px-3 py-1 mx-1" style="min-width:48px;text-align:center;border:1px solid #dee2e6;border-radius:6px;background:#fff">0</div>
                                    <button type="button" class="btn btn-sm btn-outline-success btn-incr" title="Tambah">+</button>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <!-- per-row add removed; use Add All button below -->
                                &nbsp;
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3 text-end">
            <button id="btn-add-all" class="btn btn-lg btn-primary">Tambah</button>
        </div>
        <!-- Order summary -->
        <div id="order-summary" class="mt-4">
            <h4>Ringkasan Pesanan</h4>
            <div id="order-content">
                <p class="text-muted">Belum ada item yang dipilih.</p>
            </div>
        </div>
    </div>
    <script>
        // Use event delegation and read/write the DOM value directly so clicks always work
        (function(){
            function getWrapper(el){ return el.closest('.qty-controls'); }

            document.addEventListener('click', function(e){
                var inc = e.target.closest('.btn-incr');
                var dec = e.target.closest('.btn-decr');
                var add = e.target.closest('.btn-add');

                if (inc) {
                    var wrapper = getWrapper(inc);
                    if (!wrapper) return;
                    var display = wrapper.querySelector('.qty-display');
                    var max = parseInt(wrapper.getAttribute('data-stok')) || 0;
                    var cur = parseInt(display.textContent) || 0;
                    var next = Math.min(max, cur + 1);
                    display.textContent = next;
                    console.log('increment', wrapper.getAttribute('data-id'), next);
                    return;
                }

                if (dec) {
                    var wrapper = getWrapper(dec);
                    if (!wrapper) return;
                    var display = wrapper.querySelector('.qty-display');
                    var cur = parseInt(display.textContent) || 0;
                    var next = Math.max(0, cur - 1);
                    display.textContent = next;
                    console.log('decrement', wrapper.getAttribute('data-id'), next);
                    return;
                }

                // no per-row add handlers; handled by global button
            });

            // Global add-all button: gather all non-zero quantities
            var btnAddAll = document.getElementById('btn-add-all');
            if (btnAddAll) {
                btnAddAll.addEventListener('click', function(){
                    var rows = document.querySelectorAll('.qty-controls');
                    var items = [];
                    rows.forEach(function(w){
                        var id = w.getAttribute('data-id');
                        var qty = parseInt(w.querySelector('.qty-display').textContent) || 0;
                        if (qty > 0) items.push({id: id, qty: qty});
                    });
                    if (items.length === 0) return alert('Pilih setidaknya 1 produk dengan jumlah > 0.');
                    // Add items to client-side cart and render summary
                    items.forEach(function(it){
                        var wrapper = document.querySelector('.qty-controls[data-id="'+it.id+'"]');
                        var nama = wrapper ? wrapper.getAttribute('data-nama') : it.id;
                        var harga = wrapper ? parseFloat(wrapper.getAttribute('data-harga')) : 0;
                        addToCart(it.id, nama, harga, it.qty);
                    });
                    // reset displays
                    rows.forEach(function(w){ w.querySelector('.qty-display').textContent = '0'; });
                    renderCart();
                    console.log('addAll', items, cart);
                });
            }
        })();
        // ----- Cart logic -----
        var cart = {}; // key: id, value: {id,nama,harga,qty}

        function addToCart(id, nama, harga, qty){
            qty = parseInt(qty) || 0;
            if (qty <= 0) return;
            if (cart[id]) cart[id].qty += qty; else cart[id] = {id:id, nama:nama, harga:harga, qty:qty};
        }

        function removeFromCart(id){ delete cart[id]; renderCart(); }

        function changeQty(id, newQty){
            newQty = parseInt(newQty) || 0;
            if (newQty <= 0) { removeFromCart(id); return; }
            if (cart[id]) { cart[id].qty = newQty; renderCart(); }
        }

        function renderCart(){
            var container = document.getElementById('order-content');
            if (!container) return;
            var keys = Object.keys(cart);
            if (keys.length === 0) { container.innerHTML = '<p class="text-muted">Belum ada item yang dipilih.</p>'; return; }
            var rows = keys.map(function(k){
                var it = cart[k];
                var subtotal = (it.harga * it.qty) || 0;
                return '<tr data-id="'+it.id+'">'
                    +'<td>'+escapeHtml(it.nama)+'</td>'
                    +'<td class="text-end">Rp '+numberFormat(it.harga)+'</td>'
                    +'<td class="text-center"><input type="number" class="cart-qty form-control form-control-sm" data-id="'+it.id+'" value="'+it.qty+'" style="width:80px;margin:0 auto;"></td>'
                    +'<td class="text-end">Rp '+numberFormat(subtotal)+'</td>'
                    +'<td class="text-center"><button class="btn btn-sm btn-outline-danger btn-remove" data-id="'+it.id+'">Hapus</button></td>'
                    +'</tr>';
            }).join('');
            var total = keys.reduce(function(acc,k){ var it=cart[k]; return acc + (it.harga*it.qty); },0);
            container.innerHTML = '<div class="table-responsive"><table class="table table-sm"><thead><tr><th>Produk</th><th class="text-end">Harga</th><th class="text-center">Qty</th><th class="text-end">Subtotal</th><th></th></tr></thead><tbody>'+rows+'</tbody><tfoot><tr><th colspan="3" class="text-end">Total</th><th class="text-end">Rp '+numberFormat(total)+'</th><th></th></tr></tfoot></table></div>';
            // wire qty inputs and remove buttons
            document.querySelectorAll('.cart-qty').forEach(function(inp){ inp.addEventListener('change', function(){ changeQty(this.getAttribute('data-id'), this.value); }); });
            document.querySelectorAll('.btn-remove').forEach(function(b){ b.addEventListener('click', function(){ removeFromCart(this.getAttribute('data-id')); }); });
        }

        function numberFormat(n){ return (parseFloat(n)||0).toLocaleString('id-ID'); }
        function escapeHtml(s){ return (s+'').replace(/[&<>"']/g, function(c){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;"}[c]; }); }
    </script>
</body>

</html>