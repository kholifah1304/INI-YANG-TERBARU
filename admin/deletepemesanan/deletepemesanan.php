<?php
// Simulasi data (bisa diganti dari database)
$data = [
    ['id' => 1, 'nama' => 'Ayu', 'tgl' => '30', 'total' => '164900', 'pembayaran' => 'BRI', 'pengiriman' => 'J&T Ekspress', 'alamat' => 'kamal'],
    ['id' => 2, 'nama' => 'Arum Rahmadhani', 'tgl' => '45', 'total' => '299800', 'pembayaran' => 'DANA', 'pengiriman' => 'Antaraja', 'alamat' => 'Graha Candi'],
    ['id' => 3, 'nama' => 'Arum Rahmadhani', 'tgl' => '43', 'total' => '1224300', 'pembayaran' => 'BNI', 'pengiriman' => 'JNE Express', 'alamat' => 'Graha Candi'],
    ['id' => 4, 'nama' => 'Adinda', 'tgl' => '21', 'total' => '644600', 'pembayaran' => 'BRI', 'pengiriman' => 'J&T Ekspress', 'alamat' => 'Lamongan'],
];

// Simulasi penghapusan (tidak permanen, hanya tampilannya saja)
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $data = array_filter($data, function ($item) use ($delete_id) {
        return $item['id'] != $delete_id;
    });
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #fff8f1;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        thead tr {
            background-color: #fcefe2;
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #fff4ea;
        }

        .delete-btn {
            background-color: #8c5b3e;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 4px;
        }

        .delete-btn:hover {
            background-color: #6d4631;
        }

        .back-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #8c5b3e;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .popup {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: #8c5b3e;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .popup-content button {
            margin: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        #confirmDelete {
            background: #fdf2e9;
            color: #000;
        }

        .popup-content button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<h2>Data Pemesanan</h2>

<!-- Popup Konfirmasi -->
<div id="popup" class="popup">
    <div class="popup-content">
        <p>Apakah Anda yakin ingin menghapus pesanan ini?</p>
        <button id="confirmDelete">Oke</button>
        <button onclick="closePopup()">Cancel</button>
    </div>
</div>

<!-- Tabel Pemesanan -->
<table>
    <thead>
        <tr>
            <th>Id Pembayaran</th>
            <th>Nama Pembeli</th>
            <th>Tgl Pembayaran</th>
            <th>Total Harga</th>
            <th>Metode Pembayaran</th>
            <th>Metode Pengiriman</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['tgl'] ?></td>
            <td><?= $row['total'] ?></td>
            <td><?= $row['pembayaran'] ?></td>
            <td><?= $row['pengiriman'] ?></td>
            <td><?= $row['alamat'] ?></td>
            <td>
                <button class="delete-btn" onclick="showPopup(<?= $row['id'] ?>)">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<button class="back-btn" onclick="history.back()">Back</button>

<script>
    let deleteId = null;

    function showPopup(id) {
        deleteId = id;
        document.getElementById('popup').style.display = 'flex';
    }

    function closePopup() {
        document.getElementById('popup').style.display = 'none';
        deleteId = null;
    }

    document.getElementById('confirmDelete').addEventListener('click', function () {
        if (deleteId !== null) {
            window.location.href = '?delete_id=' + deleteId;
        }
    });
</script>

</body>
</html>
