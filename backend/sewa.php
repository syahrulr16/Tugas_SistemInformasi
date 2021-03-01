<?php include "config.php"?>

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
            document.location='sewa.php';
          </script>";
      }
      else
      {
        echo "<script>
            alert('Edit data GAGAL!!');
            document.location='sewa.php';
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
            alert('Simpan data suksess!');
            document.location='sewa.php';
          </script>";
      }
      else
      {
        echo "<script>
            alert('Simpan data GAGAl!!');
            document.location='sewa.php';
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

<!doctype html><html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top">
    <a class="navbar-brand text-white" href="#">SELAMAT DATANG <b>ADMIN RENTAL MOBIL (SYAHRUL  ROMADHONI)</b></a>
      <form class="form-inline my-2 my-lg-0 ml-auto">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Search</button>
      </form>
  </nav>

  <div class="row no-gutters mt-5">

    <div class="col-md-2 bg-warning mt-2 pr-3">
      <ul class="nav flex-column ml-3 mb-5">
        <li class="nav-item">
          <a class="nav-link active text-dark text-bold" href="dashboard.php"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a><hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="customer.php"><i class="fas fa-users mr-2"></i>Customer</a><hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link active text-dark" href="karyawan.php"><i class="fas fa-user mr-2"></i>Karyawan</a><hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link active text-dark" href="mobil.php"><i class="fas fa-car mr-2"></i>Mobil</a><hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="sewa.php"><i class="fas fa-paper-plane mr-2"></i>Sewa</a><hr class="bg-secondary">
        </li>
      </ul>
    </div>

    <div class="col-md-10 p-5 pt-2">
       <h3><i class="fas fa-paper-plane mr-2"></i>PENYEWAAN</h3><hr>
       <table class="table table-striped table-bordered text-center">
          <thead class="bg-dark text-white">
            <tr>
              <th scope="col">No</th>
              <th scope="col">Id Sewa</th>
              <th scope="col">Id Customer</th>
              <th scope="col">Id Mobil</th>
              <th scope="col">Tanggal Transaksi</th>
              <th scope="col">Pembayaran</th>
              <th scope="col">Harga</th>
              <th colspan="6" scope="col">Aksi</th>
            </tr>
          </thead>
          <?php
            $no =1;
            $tampil = mysqli_query($koneksi, "SELECT * from sewa order by Id_Sewa desc");
            while($data = mysqli_fetch_array($tampil)) :
          ?>
          <tbody>
            <tr>
              <td><?=$no++;?></td>
              <td><?=$data['Id_Sewa'];?></td>
              <td><?=$data['Id_Cst'];?></td>
              <td><?=$data['Id_Mobil'];?></td>
              <td><?=$data['Tgl_Transaksi'];?></td>
              <td><?=$data['Pembayaran'];?></td>
              <td><?=$data['Nominal'];?></td>
              <td><a href="sewa.php?hal=edit&Id_Sewa=<?=$data['Id_Sewa']?>" class = "bg-warning p-2 text-white rounded" data-toggle="tooltip" title="edit">Edit</a></td>
              <td><a href="sewa.php?hal=hapus&Id_Sewa=<?=$data['Id_Sewa']?>" class = "bg-danger p-2 text-white rounded" data-toggle="tooltip" title="hapus">Hapus</a></td>
            </tr>
          </tbody>
          <?php endwhile; ?>
      </table>
      
      <div class="container">
      <div class="card">
          <div class="card-header text-center text-white bg-dark">
              TAMBAH DATA SEWA
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
                    <button type="submit" class="btn btn-warning text-white" name="bsimpan">Simpan</button>
			  		        <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
              </form>
          </div>
      </div>

    </div>

  </div>

  <!-- Optional JavaScript; choose one of the two! -->
  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="admin.js"></script>
</body>
</html>