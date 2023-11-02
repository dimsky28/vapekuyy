<?php
    session_start();
    if($_SESSION['status_login'] != true){
        echo '<script>window.location="login.php"</script>';
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ut-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Vapekuyy</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">
            <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
        </head>
<body>
    <!--HEADER-->
    <header>
        <div class="container">
            <h1><a href="dashboard.php">Vapekuyy</a></h1>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="data-kategori.php">Data Kategori</a></li>
                <li><a href="data-produk.php">Data Produk</a></li>
                <li><a href="keluar.php">Keluar</a></li>
            </ul>
        </div>
    </header>

    <!--CONTENT-->
    <div class="section">
        <div class="container">
            <h3>Dashboard</h3>
            <div class="box">
                <h4>Selamat Datang <?php echo $_SESSION['a_global']->admin_name ?> di Vapekuyy</h4>
            </div>
        </div>
    </div>

    <!--FOOTER-->
    <footer>
        <div class="container">
            <small>Copyraight &copy; 2023 - Vapekuyy.</small>
        </div>
    </footer>
</body>
</html>