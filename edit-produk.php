<?php
    session_start();
    include 'db.php';
    if($_SESSION['status_login'] != true){
        echo '<script>window.location="login.php"</script>';
    }

    $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '".$_GET['id']."' ");
    $p = mysqli_fetch_object($produk);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="ut-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vapekuyy</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
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
            <h3>Edit Produk</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select class="input-control" name="kategori" required>
                        <option value="">Pilih Produk</option>
                        <?php
                            $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
                            while($r = mysqli_fetch_array($kategori)){
                        ?>
                        <option value="<?php echo $r['category_id'] ?>" <?php echo ($r['category_id'] == $p->category_id)? 'selected':''; ?>><?php echo $r['category_name'] ?></option>
                        <?php } ?>
                    </select>

                    <input type="text" name="nama" class="input-control" placeholder="Nama Produk" value="<?php echo $p->product_name ?>" required>
                    <input type="text" name="harga" class="input-control" placeholder="Harga" value="<?php echo $p->product_price ?>" required>
                    
                    <img src="produk/<?php echo $p->product_image ?>" width="100px">
                    <input type="hidden" name="foto" value="<?php echo $p->product_image ?>">
                    <input type="file" name="gambar" class="input-control">
                    <textarea class="input-control" name="deskripsi" placeholder="Deskripsi"><?php echo $p->product_description ?></textarea><br>
                    <select class="input-control" name="status">
                        <option value="">--Pilih--</option>
                        <option value="1" <?php echo ($p->product_status == 1)? 'selected':''; ?>>Aktif</option>
                        <option value="0" <?php echo ($p->product_status == 0)? 'selected':''; ?>>Tidak Aktif</option>
                    </select>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php
                    if(isset($_POST['submit'])){                        

                        // data inputan dari form
                        $kategori   = $_POST['kategori'];
                        $nama       = $_POST['nama'];
                        $harga      = $_POST['harga'];
                        $deskripsi  = $_POST['deskripsi'];
                        $status     = $_POST['status'];
                        $foto       = $_POST['foto'];

                        // data gambar yang baru
                        $filename = $_FILES['gambar']['name'];
                        $tmp_name = $_FILES['gambar']['tmp_name'];

                        $type1 = explode('.', $filename);
                        $type2 = $type1[1];

                        $newname = 'produk'.time().'.'.$type2;

                        // menampung data format file yang diizinkan
                        $tipe_diizinkan = array('jpg', 'png', 'jpeg', 'gif');

                        // jika admin ganti gambar
                        if($filename != ''){

                            // validasi format file
                            if(!in_array($type2, $tipe_diizinkan)){
                                //jika format file tidak ada dalam tipe diizinkan
                                echo'<script>alert=("Format File Tidak di Izinkan")</script>';

                            }else{
                                unlink('./produk/'.$foto);
                                move_uploaded_file($tmp_name, './produk/'.$newname);
                                $namagambar = $newname;
                            }

                        }else{
                            // jika admin tidak ganti gambar
                            $namagambar = $foto;

                        }

                        // query update data produk
                        $update = mysqli_query($conn, "UPDATE tb_product SET 
                                                category_id         = '".$kategori."',
                                                product_name        = '".$nama."',    
                                                product_price       = '".$harga."',
                                                product_description = '".$deskripsi."',
                                                product_image       = '".$namagambar."', 
                                                product_status      = '".$status."'
                                                WHERE product_id = '".$p->product_id."' ");
                        if($update){
                            echo '<script>alert("Ubah Data Berhasil")</script>';
                            echo '<script>window.location="data-produk.php"</script>';
                        }else{
                            echo 'Gagal'.mysqli_error($conn);
                        }

                    }
                ?>
            </div>
        </div>
    </div>

    <!--FOOTER-->
    <footer>
        <div class="container">
            <small>Copyraight &copy; 2023 - Vapekuyy.</small>
        </div>
    </footer>
    <script>
        CKEDITOR.replace( 'deskripsi' );
    </script>
</body>
</html>