<?php 
session_start();

if ( !isset($_SESSION["login"])){
    header("Location: login.php");
}

require 'functions.php';

$id_barang= $_GET['id_barang'];

if (hapus($id_barang) > 0){
    echo "
    <script>
    alert('data berhasil dihapus');
    document.location.href = 'index.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('data gagal dihapus');
    document.location.href = 'index.php';
    </script>
    ";
}
?>