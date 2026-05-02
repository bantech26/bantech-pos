    $(document).ready(function() {
        const memberInput   = $('#member-input');
        const barcodeInput  = $('#barcode-input');
        const tableBody     = $('#transaction-table-body');
        const inputDiscount = $('#input-discount-total');

        $(document).on('keydown', function(e) {
            // F2 untuk Fokus ke Scan Barcode
            if (e.key === "F2") {
                e.preventDefault();
                $('#barcode-input').focus();
            }
            
            // F12 untuk tombol Payment (sesuai teks di tombol Anda)
            if (e.key === "F12") {
                e.preventDefault();
                $('.btn-success.w-100').click(); 
            }
        });

        barcodeInput.focus();
        // 1. Tangkap input saat kasir tekan Enter
        barcodeInput.on('keypress', function(e) {
            if (e.which == 13) { // 13 adalah tombol Enter
                e.preventDefault();
                let code = $(this).val();
                
                if (code !== '') {
                    fetchProduct(code);
                }
            }
        });

        // 2. Fungsi Axios untuk ambil data ke Controller
        function fetchProduct(code) {
            axios.get(`/api/product/${code}`)
                .then(response => {
                    const product = response.data;
                    addToTable(product);
                    barcodeInput.val(''); // Bersihkan input setelah scan
                })
                .catch(error => {
                    console.error(error);
                    alert('Produk tidak ditemukan atau stok kosong');
                });
        }

        memberInput.on('keypress', function(e) {
            if (e.which == 13) { // 13 adalah tombol Enter
                e.preventDefault();
                let code = $(this).val();
                
                if (code !== '') {
                    fetchMember(code);
                }
                barcodeInput.focus();
            }
        });

        //Member
        function fetchMember(code){
            axios.get(`/api/member/${code}`)
            .then(response => {
                const member = response.data;
                $('#mamber-name').val(member.name);
                $('#mamber-point').val(member.point.toLocaleString('id-ID'));
                
            })
            .catch(error => {
                console.error(error);
                alert(code);
            });
        }


        $(document).on('keydown', function(e) {
            // F2 untuk Fokus ke Scan Barcode
            if (e.key === "F2") {
                e.preventDefault();
                $('#barcode-input').focus();
            }
            
            // F12 untuk tombol Payment (sesuai teks di tombol Anda)
            if (e.key === "F12") {
                e.preventDefault();
                $('.btn-success.w-100').click(); 
            }
        });

        barcodeInput.focus();
        // 1. Tangkap input saat kasir tekan Enter
        barcodeInput.on('keypress', function(e) {
            if (e.which == 13) { // 13 adalah tombol Enter
                e.preventDefault();
                let code = $(this).val();
                
                if (code !== '') {
                    fetchProduct(code);
                }
            }
        });

        // Menggunakan event delegation agar baris baru yang di-scan tetap terdeteksi
        tableBody.on('input change', '.qty-input, .uom-select, .disc-input', function() {
        const row = $(this).closest('tr');
            
            // 1. Ambil data dasar
            const price = parseFloat(row.find('.uom-select').val()) || 0;
            let qty = parseFloat(row.find('.qty-input').val()) || 0;
            
            // 2. Logika Promo Otomatis (Kelipatan)
            const threshold = parseInt(row.data('threshold')) || 0; 
            const bonusPerThreshold = parseInt(row.data('bonus')) || 0;

            const promoType = 'Active Promo : '+row.attr('data-promo-type') || 'Promo';
            
            let autoDiscount = 0;

            // Jika produk memiliki promo aktif (B2G1, B1G1, dll)
            if (threshold > 0 && bonusPerThreshold > 0) {
                const totalSet = threshold + bonusPerThreshold; // B2G1 = 3
                
                // Hitung berapa kali kelipatan promo terpenuhi
                const multiplier = Math.floor(qty / totalSet);
                
                if (multiplier > 0) {
                    // Hitung nilai diskon: (jumlah gratis) x (harga satuan)
                    autoDiscount = multiplier * bonusPerThreshold * price;
                    
                    // Isi ke input diskon secara otomatis
                    row.find('.disc-input').val(autoDiscount);
                    
                    // Tambahkan label visual agar kasir tahu ini barang promo
                    if(row.find('.promo-label').length === 0) {
                        row.find('td:eq(1)').append('<br><span class="badge bg-green-lt promo-label">'+promoType+'</span>');
                    }
                } else {
                    // Reset diskon jika qty dikurangi di bawah threshold
                    row.find('.disc-input').val(0);
                    row.find('.promo-label').remove();
                }
            }

            // 3. Ambil nilai diskon (bisa dari otomatis atau input manual kasir)
            const disc = parseFloat(row.find('.disc-input').val()) || 0;

            // 4. Hitung Total Per Baris
            const rowTotal = (price * qty) - disc;

            // 5. Update tampilan di tabel
            row.find('.price-text').text('Rp ' + price.toLocaleString('id-ID'));
            row.find('.total-text')
                .attr('data-total', rowTotal)
                .text('Rp ' + rowTotal.toLocaleString('id-ID'));

            // 6. Update Grand Total keseluruhan
            updateGrandTotal();
        });

        // Listener untuk tombol hapus baris (menggunakan event delegation)
        tableBody.on('click', '.btn-remove-row', function() {
            // Mencari elemen <tr> terdekat dari tombol yang diklik
            const row = $(this).closest('tr');
            const productName = row.find('td:nth-child(2)').text(); // Ambil nama produk untuk konfirmasi

            // Tambahkan konfirmasi sederhana agar tidak sengaja terhapus
            if (confirm(`Apakah Anda yakin ingin menghapus ${productName} dari daftar belanja?`)) {
                // Hapus baris dari DOM
                row.remove();
                
                // Sangat Penting: Hitung ulang Grand Total setelah baris dihapus
                updateGrandTotal();
                
                // Fokuskan kembali ke input barcode agar kasir bisa langsung scan barang lain
                barcodeInput.focus();
            }
        });



        let debounceTimer;

        document.getElementById('search-input-modal').addEventListener('input', function() {
            let query = this.value;

            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                if (query.length >= 3) { // Pencarian dimulai setelah 3 karakter
                    fetchProducts(query);
                }
            }, 300); // Tunggu kasir berhenti mengetik selama 300ms
        });

        function fetchProducts(query) {
            axios.get(`/api/search-products?q=${query}`)
                .then(response => {
                    let html = '';
                    response.data.forEach(product => {
                        html += `
                            <tr>
                                <td>${product.name} <br> <small class="text-muted">${product.sku}</small></td>
                                <td>${product.base_uom}</td>
                                <td>Rp ${new Intl.NumberFormat('id-ID').format(product.base_price)}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="selectToCart('${product.sku}')">Pilih</button>
                                </td>
                            </tr>`;
                    });
                    document.getElementById('result-table-body').innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        }



    });


    function selectToCart(barcode){
        $('#modal-product').modal('hide');

        // Lakukan request ke server untuk mengambil detail produk lengkap
        $.ajax({
            url: `/api/product/${barcode}`, // Sesuaikan dengan route API Anda
            method: 'GET',
            success: function(product) {
                addToTable(product);
            },
            error: function() {
                alert('Gagal mengambil data produk.');
            }
        });
    }

    // 3. Fungsi untuk render baris baru di tabel
    function addToTable(product) {
        let exists = false;

            // 1. Cek setiap baris yang sudah ada di tabel
            $('#transaction-table-body tr').each(function() {
            const row = $(this);
            // Ambil nama produk dari kolom kedua (index 1)
            const productNameInTable = row.find('td:eq(1)').text().trim();

                if (productNameInTable === product.name) {
                    // Jika nama cocok, ambil input qty dan tambah 1
                    let qtyInput = row.find('.qty-input');
                    let currentQty = parseInt(qtyInput.val()) || 0;
                    qtyInput.val(currentQty + 1);

                    // Trigger event 'input' agar total baris & grand total otomatis terhitung
                    qtyInput.trigger('input');
                    
                    exists = true;
                    return false; // Berhenti dari loop .each()
                }
            });

            // 2. Jika produk belum ada di tabel, baru tambahkan baris baru
            if (!exists) {
                let uomOptions = `<option value="${product.base_price}">${product.base_uom}</option>`;
                if (product.units) {
                    product.units.forEach(u => {
                        uomOptions += `<option value="${u.price}">${u.uom_name}</option>`;
                    });
                }

                let row = `
                    <tr class="text-center"
                        data-promo-type="${product.active_promo?.type || ''}" 
                        data-threshold="${product.active_promo?.threshold || 0}"
                        data-bonus="${product.active_promo?.bonus_qty || 0}">
                        <td>
                            <button class="btn btn-danger btn-icon btn-sm btn-remove-row" title="Hapus Item">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="4" y1="7" x2="20" y2="7"></line>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                </svg>
                            </button>
                        </td>
                        <td class="text-start">${product.name}</td>
                        <td><select class="form-select uom-select">${uomOptions}</select></td>
                        <td class="price-text" data-price="${product.base_price}">Rp ${product.base_price.toLocaleString('id-ID')}</td>
                        <td><input type="number" class="form-control qty-input mx-auto" style="width: 80px;" value="1" min="1"></td>
                        <td><input type="number" class="form-control disc-input mx-auto" style="width: 100px;" value="0" min="0"></td>
                        <td class="total-text" data-total="${product.base_price}">Rp ${product.base_price.toLocaleString('id-ID')}</td>
                    </tr>
                `;
                
                $('#transaction-table-body').append(row);
                updateGrandTotal();
            }
        }

        
        function updateGrandTotal() {
            let subTotal = 0;
            let totalDiscount = 0;

            // Jumlahkan semua nilai data-total dari setiap baris
            $('.total-text').each(function() {
                subTotal += parseFloat($(this).attr('data-total')) || 0;
            });

            // Update angka besar di dashboard (TOTAL Rp 0)
            $('#grandTotal').text('Rp ' + subTotal.toLocaleString('id-ID'));

            $('.disc-input').each(function() {
                totalDiscount += parseFloat($(this).val()) || 0;
            });

            $('#displayDiscount').text('Rp ' + totalDiscount.toLocaleString('id-ID'));
            
            // Update input di sidebar kanan
            $('input[name="example-text-input"]').each(function() {
                let label = $(this).parent().find('label').text();
                if (label === 'Sub Total' || label === 'Grand Total') {
                    $(this).val(subTotal);
                }
            });
        }