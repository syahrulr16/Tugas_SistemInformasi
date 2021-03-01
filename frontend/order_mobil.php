<?php
//koneksi database
  $server = "localhost";
  $user = "root";
  $pass = "";
  $database = "rental_mobil";

  $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

  //tombol simpan
  if(isset($_POST['bsimpan']))
  {

    //edit or new
    if($_GET['hal'] == "edit")
    {
      //edit
      $edit = mysqli_query($koneksi, "UPDATE sewa set
                        Id_Sewa = '$_POST[Id_Sewa]',
                        Id_Cst = '$_POST[Id_Cst]',
                        Id_Mobil = '$_POST[Id_Mobil]',
                        Tgl_Transaksi = '$_POST[Tgl_Transaksi]',
                        Pembayaran = '$_POST[Pembayaran]',
                        Nominal = '$_POST[Nominal]'
                        WHERE Id_Sewa = '$_GET[Id_Sewa]'
                       ");
      if($edit) //finish edit
      {
        echo "<script>
            alert('Edit data suksess!');
            document.location='order_mobil.php';
          </script>";
      }
      else
      {
        echo "<script>
            alert('Edit data GAGAL!!');
            document.location='order_mobil.php';
          </script>";
      }
    }else
    {
      //new
      $simpan = mysqli_query($koneksi, "INSERT INTO sewa (Id_Sewa, Id_Cst, Id_Mobil, Tgl_Transaksi, Pembayaran, Nominal)
                      VALUES
                        ('$_POST[Id_Sewa]',
                          '$_POST[Id_Cst]',
                          '$_POST[Id_Mobil]',
                          '$_POST[Tgl_Transaksi]',
                          '$_POST[Pembayaran]',
                          '$_POST[Nominal]')
                    ");
      if($simpan)
      {
        echo "<script>
            alert('Order Mobil Sukses, Terimakasih Sudah Rental Mobil Disini!');
            document.location='order_mobil.php';
          </script>";
      }
      else
      {
        echo "<script>
            alert('Order Mobil GAGAL! Periksa Kembali Data Anda!');
            document.location='order_mobil.php';
          </script>";
      }
    }

  }

  //Hapus
  if(isset($_GET['hal']))
  {
    //hapus data
    if ($_GET['hal'] == "hapus")
     {
      //hapus
      $hapus = mysqli_query($koneksi, "DELETE  FROM sewa WHERE Id_Sewa = '$_GET[Id_Sewa]' ");
      if($hapus) 
      {
        echo "<script>
        alert ('Hapus data Suksess!!!!');
        </script>";  
      }
    }
    
  }

  //edit
  if(isset ($_GET['hal']))
  {
      //tampilan data yang diedit
    if ($_GET['hal'] == "edit")
    {
        $tampil = mysqli_query($koneksi, "SELECT * FROM sewa WHERE Id_Sewa = '$_GET[Id_Sewa]' ");
        $data = mysqli_fetch_array($tampil);
        if($data)
        {
            $vId_Sewa = $data['Id_Sewa'];
            $vId_Cst = $data['Id_Cst'];
            $vId_Mobil = $data['Id_Mobil'];
            $vTgl_transaksi = $data['Tgl_Transaksi'];
            $vPembayaran = $data['Pembayaran'];
            $vNominal = $data['Nominal'];
        }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">

    <title>Detail Mobil</title>
</head>
<body>
    <!-- Jumbotron -->
        <div class="jumbotron jumbotron-fluid text-center">
            <div class="container">
            <h1 class="display-4"><span class="font-weight-bold">RENTAL MOBIL SYAHRUL</span></h1>
            <hr>
            <p class="lead font-weight-bold">Silahkan Sewa Mobil Sesuai Keinginan Anda <br> 
            Selamat Berlibur jangan lupa jaga Keselamatan</p>
            </div>
        </div>
    <!-- Akhir Jumbotron -->
    <!-- Navbar -->
        <nav class="navbar navbar-expand-lg  bg-dark">
            <div class="container">
            <a class="navbar-brand text-white" href="index.html"><img src="images/logo.png" width="500" height="50" class="" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav text-bold">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                <a class="nav-link mr-4" href="home.php">HOME</a>
                </li>
                <li class="nav-item">
                <a class="nav-link mr-4" href="daftar_mobil.php">DAFTAR MOBIL</a>
                </li>
                <li class="nav-item">
                <a class="nav-link mr-4" href="tentang_kami.php">TENTANG KAMI</a>
                </li>
            </ul>
            </div>
        </div> 
        </nav>
    <!-- Akhir Navbar -->
    <!-- Awal Data Order-->  
    <div class="container mt-5">
      <div class="card">
          <div class="card-header text-center text-white bg-dark">
              <h4><b>DATA ORDER TRANSAKSI</b></h4>
          </div>
          <div class="card-body">
              <form method="post" action="">
                  <div class="form-group">
                      <label>Id Sewa</label>
                      <input type="text" name="Id_Sewa" value="<?=@$vId_Sewa?>" class="form-control" placeholder="Inputkan Id Sewa Anda" required>
                      <label>Id Customer</label>
                      <input type="text" name="Id_Cst" value="<?=@$vId_Cst?>" class="form-control" placeholder="Inputkan Id Customer Anda" required>
                      <label>Id Mobil</label>
                      <input type="text" name="Id_Mobil" value="<?=@$vId_Mobil?>" class="form-control" placeholder="Inputkan Id Mobil Anda" required>
                      <label>Tanggal Transaksi</label>
                      <input type="text" name="Tgl_Transaksi" value="<?=@$vTgl_Transaksi?>" class="form-control" placeholder="Inputkan Tanggal Transaksi" required>
                      <label>Pembayaran</label>
                      <input type="text" name="Pembayaran" value="<?=@$vPembayaran?>" class="form-control" placeholder="Inputkan Pembayaran" required>
                      <label>Nominal</label>
                      <input type="text" name="Nominal" value="<?=@$vNominal?>" class="form-control" placeholder="Inputkan Nominal" required>
                    </div>
                    <button type="submit" class="btn btn-warning text-white" name="bsimpan">Order</button>
			  		<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
              </form>
          </div>
      </div>
    <!-- Akhir Data Order-->
    <!-- Awal Footer -->
    <hr class="footer">
    <div class="container">
        <div class="row footer-body">
        <div class="col-md-6">
        <div class="copyright">
            <strong>Terimakasih Sudah Berkunjung dan Menikmati</strong> <br>Semoga Suka dan Menjadi tempat makan Favorit dan<br> Jangan Lupa Mampir lagi Oke!</p>
        </div>
        </div>

        <div class="col-md-6 d-flex justify-content-end">
        <div class="icon-contact">
        <label class="font-weight-bold">Follow Us </label>
        <a href="#"><img src="images/social2.png" width="60" height="60" class="mr-3 ml-4" data-toggle="tooltip" title="Facebook"></a>
        <a href="#"><img src="images/social1.png" width="50" height="50" class="mr-3" data-toggle="tooltip" title="Instagram"></a>
        <a href="#"><img src="images/social3.png" width="50" height="50" class="" data-toggle="tooltip" title="WhatsApp"></a>
        </div>
        </div>
        </div>
    </div>
    <!-- Akhir Footer -->

</body>
</html>