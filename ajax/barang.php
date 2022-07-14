<?php 
require '../functions.php';
$keyword = $_GET['keyword'];
$barang = query("SELECT * FROM barang WHERE nama_barang LIKE '%$keyword%' OR supplier LIKE '%$keyword%'");

?>

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