<?php 
session_start();

if ( !isset($_SESSION["login"])){
    header("Location: login.php");
}

require 'functions.php';

if (isset($_POST["submit"])){

  if(tambah($_POST) > 0 ) {
    echo "
    <script>
    alert('data berhasil ditambahkan');
    document.location.href = 'index.php';
    </script>
    ";
  } else {
    echo "
    <script>
    alert('data gagal ditambahkan');
    document.location.href = 'tambah.php';
    </script>
    ";
  }
}


?>
<!DOCTYPE html>
<head>
    <title>Tambah Data</title>
</head>
<body>
    <h1>Tambah Data Mahasiswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nama_barang">Nama Barang : </label>
                <input type="text" name="nama_barang" id="nama_barang" required>
            </li>
            <li>
                <label for="supplier">Supplier : </label>
                <input type="text" name="supplier" id="supplier" required>
            </li>
            <li>
                <label for="gambar">Gambar : </label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Tambah</button>
            </li>
        </ul>
    </form>
</body>
</html>