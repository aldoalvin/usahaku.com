<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Santoso Jaya Teknik</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Navbar */
        .navbar {
            background: #333;
            color: #fff;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .navbar h1 {
            font-size: 1.5em;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            padding: 0;
            margin: 0;
        }

        .navbar ul li {
            margin-left: 20px;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .navbar ul li a:hover {
            color: #f0a500;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 5px 0px #888;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5%;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #999;
        }

        .grand-total {
            margin-top: 20px;
            text-align: right;
            font-size: 1.2em;
            font-weight: bold;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .cards {
                flex-direction: row;
                justify-content: center;
            }
            .card {
                width: 45%;
            }
        }

        @media (max-width: 768px) {
            .cards {
                flex-direction: column;
                align-items: center;
            }
            .card {
                width: 80%;
                margin: 10px auto;
            }
        }

        @media (max-width: 480px) {
            .card {
                width: 90%; /* Lebih lebar agar tidak terlalu ke kanan */
                margin: 10px auto; /* Tengah dengan margin auto */
            }
            .navbar h1 {
                font-size: 1.1em;
            }
            .navbar ul {
                flex-direction: row;
                width: 100%;
                text-align: center;
            }
            .navbar ul li {
                margin: 5px 10;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>Depot Ko Bagio</h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="produk.php">Produk</a></li>
            <li><a href="transaksi.php">Transaksi</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Laporan Penjualan</h2>
        <label for="jenisLaporan">Pilih Jenis Laporan:</label>
        <select id="jenisLaporan" onchange="ambilLaporan()">
            <option value="harian">Harian</option>
            <option value="mingguan">Mingguan</option>
            <option value="bulanan">Bulanan</option>
            <option value="tahunan">Tahunan</option>
        </select>

        <table id="laporanTable">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Produk</th>
                    <th>QTY</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data laporan akan dimuat di sini -->
            </tbody>
        </table>
        <div class="grand-total">
            <strong>Grand Total: </strong><span id="grandTotal">Rp 0.000</span>
        </div>
    </div>

    <script>
        function ambilLaporan() {
            const jenis = document.getElementById("jenisLaporan").value;

            // AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open("GET", `get_laporan.php?jenis=${jenis}`, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    const data = JSON.parse(this.responseText);

                    let output = '';
                    let grandTotal = 0;

                    data.forEach(item => {
                        output += `
                            <tr>
                                <td>${item.tanggal}</td>
                                <td>${item.nama_produk}</td>
                                <td>Rp ${parseFloat(item.total).toLocaleString('id-ID')}</td>
                            </tr>
                        `;
                        grandTotal += parseFloat(item.total);
                    });

                    document.querySelector("#laporanTable tbody").innerHTML = output;
                    document.getElementById("grandTotal").textContent = `Rp ${grandTotal.toLocaleString('id-ID')}`;
                }
            }
            xhr.send();
        }

        // Muat laporan harian saat pertama kali dibuka
        window.onload = function() {
            ambilLaporan();
        }
    </script>
</body>
</html>
