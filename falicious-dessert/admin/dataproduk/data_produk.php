<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Data Produk</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <h1>Data Produk</h1>
    <div class="top-bar">
      <input type="text" placeholder="Cari Data..." class="search-input" />
      <button class="input-btn">Input Produk</button>
    </div>
    <table>
      <thead>
        <tr>
          <th>Id Produk</th>
          <th>Nama</th>
          <th>Stok</th>
          <th>Harga</th>
          <th>Kategori</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $produk = [
          ["Chocolate Lava Crunch", 30, "Rp 65.000,00", "Brownies Cake"],
          ["Red Velvet Cream Cheese Brownies", 45, "Rp 65.000,00", "Brownies Cake"],
          ["Honey Date Brownies", 43, "Rp 65.000,00", "Brownies Cake"],
          ["Matcha Chocolate Brownies", 21, "Rp 65.000,00", "Brownies Cake"],
          ["Salted Caramel Brownies", 55, "Rp 65.000,00", "Brownies Cake"],
          ["Oreo Cream Brownies", 56, "Rp 65.000,00", "Fruit Dessert Box"],
          ["Salted Caramel Brownies", 55, "Rp 65.000,00", "Fruit Dessert Box"],
          ["Oreo Cream Brownies", 56, "Rp 65.000,00", "Fruit Dessert Box"],
          ["Salted Caramel Brownies", 55, "Rp 65.000,00", "Fruit Dessert Box"],
          ["Oreo Cream Brownies", 56, "Rp 65.000,00", "Fruit Dessert Box"],
          ["Salted Caramel Brownies", 55, "Rp 65.000,00", "Classic Dessert Box"],
          ["Oreo Cream Brownies", 56, "Rp 65.000,00", "Classic Dessert Box"],
          ["Salted Caramel Brownies", 55, "Rp 65.000,00", "Classic Dessert Box"],
          ["Oreo Cream Brownies", 56, "Rp 65.000,00", "Classic Dessert Box"],
          ["Salted Caramel Brownies", 55, "Rp 65.000,00", "Classic Dessert Box"],
        ];

        foreach ($produk as $id => $item) {
          echo "<tr>
                  <td>{$id}</td>
                  <td>{$item[0]}</td>
                  <td>{$item[1]}</td>
                  <td>{$item[2]}</td>
                  <td>{$item[3]}</td>
                  <td>
                    <button class='edit'>Edit</button>
                    <button class='delete'>Delete</button>
                  </td>
                </tr>";
        }
        ?>
      </tbody>
    </table>
    <button class="back-btn">Back</button>
  </div>
</body>
</html>