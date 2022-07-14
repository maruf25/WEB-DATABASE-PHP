<?php 
require 'functions.php';
session_start();

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])){
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasar id
    $result = mysqli_query($conx, "SELECT username FROM users WHERE id = $id");
    $row = mysqli_fetch_row($result);
    
    // cek cookie dan username
    if ($key === hash('sha256',$row['username'])) {
        $_SESSION['login'] = true;
    }

}

if (isset($_SESSION['login'])){
    header("Location: index.php");
}

if (isset($_POST["login"])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conx,"SELECT * FROM users WHERE username='$username'");
    // cek username
    if (mysqli_num_rows($result) === 1){

        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password,$row["password"])) {
            // set session
            $_SESSION["login"] = true;

            // cek remember me
            if (isset($_POST["remember"])){
                setcookie('id',$row['id'],time()+60);
                setcookie('key',hash('sha256',$row['username']),time()+60);
            }
            header("Location: index.php");
            exit;
        }
    }

    $error = true;
} 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    label {
        display: block;
        padding: 5px;
    }

    .remember {
        display: inline;
        width: 20px;
    }

    body {
        background-color: orange;
    }

    li {
        list-style-type: none;
    }

    .typing {
        border: 2px solid white;
        border-radius: 4px;
        width: 200px;
    }

    .login {
        position: absolute;
        top: 25%;
        left: 25%;
        width: 500px;
        height: 280px;
        border: 2px solid black;
        border-radius: 40px;
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="login">
        <h1>Halaman Login</h1>
        <?php if(isset($error)) : ?>
        <p style="color:red">Username / Password salah</p>
        <?php endif; ?>
        <form action="" method="post">
            <ul>
                <li>
                    <label for="username">username : </label>
                    <input type="text" name="username" id="username" class="typing">
                </li>
                <li>
                    <label for="password">password : </label>
                    <input type="password" name="password" id="password" class="typing">
                </li>
                <li>
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" class="remember"> Remember me </label>
                </li>
                <li>
                    <button type="submit" name="login">Login</button>
                </li>
                <li>
                    <a href="registrasi.php">buat akun</a>
                </li>
            </ul>
        </form>
    </div>
</body>
</html>