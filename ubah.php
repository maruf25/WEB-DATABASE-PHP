<?php 

session_start();

if ( !isset($_SESSION["login"])){
    header("Location: login.php");
}

require 'functions.php';

$id_barang=  $_GET["id_barang"];

$brng = query("SELECT * FROM barang WHERE id_barang=$id_barang")[0];

if( isset($_POST["submit"]) ) {
    if(ubah($_POST) > 0 ) {
        echo "
        <script>
        alert('data berhasil diubah');
        document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('data gagal diubah');
        document.location.href = 'ubah.php';
        </script>
        ";
    }
}

?>
<!DOCTYPE html>
<head>
    <title>Ubah Data</title>
</head>
<body>
    <h1>Ubah Data Mahasiswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_barang" value="<?php echo $brng["id_barang"] ?>">
        <input type="hidden" name="gambarLama" value="<?php echo $brng["gambar"] ?>">
        <ul>
            <li>
                <label for="nama_barang">Nama Barang : </label>
                <input type="text" name="nama_barang" id="nama_barang" required value="<?php echo$brng["nama_barang"] ?>">
            </li>
            <li>
                <label for="supplier">Supplier : </label>
                <input type="text" name="supplier" id="supplier" required value="<?php echo$brng["supplier"] ?>">
            </li>
            <li>
                <label for="gambar">Gambar : </label>
                <input type="file" name="gambar" id="gambar"> <br><br>
                <img src="img/<?php echo$brng["gambar"]?>" width="60">
            </li>
            <li>
                <button type="submit" name="submit">Ubah</button>
            </li>
        </ul>
    </form>
</body>
</html>