<?php 
$conx = mysqli_connect("localhost","root","", "tokoonline");

function query($query) {
    global $conx;
    $result = mysqli_query($conx,$query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data){
    global $conx;
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $supplier = htmlspecialchars($data["supplier"]);
    // Upload gambar
    $gambar = upload();
    if (!$gambar ) {
        return false;
    }

    $query = "INSERT INTO barang VALUES
    ('','$nama_barang','$supplier','$gambar')";

    mysqli_query($conx,$query);

    return mysqli_affected_rows($conx);
}

function upload(){
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFIle = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tempName = $_FILES['gambar']['tmp_name'];

    // Cek gambar di upload
    if ($error === 4) {
        echo "<script> 
        alert('Pilih gambar terlebih dahulu');
        </script>";
        return false;
    }

    // Cek di upload gambar atau bukan
    $ekstensiGambarValid = ['jpg','jpeg','png'];
    $ekstensiGmbr = explode('.',$namaFile);
    $ekstensiGmbr = strtolower(end($ekstensiGmbr));

    if ( !in_array($ekstensiGmbr,$ekstensiGambarValid)) {
        echo "<script> 
        alert('Anda bukan mengupload gambar');
        </script>";
        return false;
    }

    // cek jika ukuran terlalu besar
    if ( $ukuranFIle > 8000000 ) {
        echo "<script> 
        alert('Ukuran terlalu besar');
        </script>";
        return false;
    }

    // Gambar di upload
    // Generate nama baru
    $namaFileBaru = uniqid();
    $namaFileBaru.= '.';
    $namaFileBaru .= $ekstensiGmbr;
    move_uploaded_file($tempName, 'img/'.$namaFileBaru);

    return $namaFileBaru;

}

function hapus($id_barang) {
    global $conx;
    mysqli_query($conx,"DELETE FROM barang WHERE id_barang = $id_barang");

    return mysqli_affected_rows($conx);
}

function ubah($data){
    global $conx;

    $id = $data["id_barang"];
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $supplier = htmlspecialchars($data["supplier"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // Cek apa user pilih gambar
    if($_FILES['gamabar']['error']===4){
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }


    $query = "UPDATE barang SET 
                nama_barang ='$nama_barang', 
                supplier = '$supplier' ,
                gambar = '$gambar'
            WHERE id_barang = $id"
            ;

    mysqli_query($conx,$query);
    
    return mysqli_affected_rows($conx);
}

function cari($search){
    global $conx;
    $query = "SELECT * FROM barang WHERE nama_barang LIKE '%$search%' OR supplier LIKE '%$search%'";

    return query($query);
}

function register($data){
    global $conx;
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conx,$data["password"]);
    $password2 = mysqli_real_escape_string($conx,$data["password2"]);

    // cek username ada apa belum
    $query = "SELECT username FROM users WHERE username='$username'";
    $result = mysqli_query($conx,$query);
    if (mysqli_fetch_assoc($result)){
        echo "<script>
        alert('username sudah ada');
        </script>";
        return false;
      }

    // cek konfirmasi password
    if ($password !== $password2){
        echo "<script>
        alert('password tidak sesuai');
        </script>";
        return false;
    } 

    // enkripsi password
    $password = password_hash($password,PASSWORD_DEFAULT);
    
    // tambah ke database
    $query = "INSERT INTO users VALUES('','$username','$password')";
    mysqli_query($conx,$query);

    return mysqli_affected_rows($conx);

}

?>