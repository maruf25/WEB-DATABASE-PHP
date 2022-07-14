<?php 

session_start();

if ( !isset($_SESSION["login"])){
    header("Location: login.php");
}

// Koneksi database
require 'functions.php';

// pagination


// konfigurasi
$jumlahDataPerHalaman = 25;
$jumlahData = count(query("SELECT * FROM barang"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

$halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;

$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$barang = query("SELECT * FROM barang LIMIT $awalData,$jumlahDataPerHalaman");

// tombol cari diklik
if (isset($_POST["cari"])) {
    $barang = cari($_POST["search"]);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Halaman Admin</title>
</head>

<body>
    <a href="logout.php">Logout</a>


    <h1>Daftar Toko</h1>
    <a href="tambah.php">Tambah Data</a>
    <br><br>

    <form action="" method="post">
        <input type="text" name="search" size="50" 
        autofocus placeholder="Masukkan keyword pencarian" 
        autocomplete="off" id="keyword">
        <button type="submit" name="cari" id="tombol-cari">Search</button>
    </form>
    <br><br>

    <!-- Navigasi Halaman -->
        <!-- <?php if($halamanAktif > 1): ?>
            <a href="?halaman=<?php echo $halamanAktif - 1 ?>">&laquo;</a>
        <?php endif; ?>

        <?php for($i=1;$i <= $jumlahHalaman; $i++) : ?>
            <?php if($i == $halamanAktif): ?>
                <a href="?halaman= <?php echo $i ?> " style="color:red;"><?php echo $i ?></a>
            <?php else : ?>
                <a href="?halaman= <?php echo $i ?> "><?php echo $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if($halamanAktif < $jumlahHalaman): ?>
            <a href="?halaman=<?php echo $halamanAktif + 1 ?>">&raquo;</a>
        <?php endif; ?> -->

    <br><br>
    <div id="container">
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No Urut</th>
            <th>Gambar</th>
            <th>Nama Barang</th>
            <th>Supllier</th>
            <th>Aksi</th>
        </tr>
        <?php $i=1; ?>
        <?php foreach($barang as $row) : ?>
        <tr>
            <td><?php echo $i?></td>
            <td> <img src="img/<?php echo$row["gambar"] ?>"alt="" width="60"></td>
            <td><?php echo $row["nama_barang"]?></td>
            <td><?php echo $row["supplier"] ?></td>
            <td>
                <a href="ubah.php?id_barang=<?php echo$row['id_barang'] ?>">Ubah</a> |
                <a href="hapus.php?id_barang=<?php echo $row['id_barang']?>" 
                onclick="return confirm('yakin menghapus ?');">Hapus</a>
            </td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>
    </div>
    <script src="js/script.js"></script>

</body>

</html>