<?php 

session_start();
if(isset($_SESSION['login'])){
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Project Web</title>
        <style>
            body{
                color:white;
            }
            .top{
                background-color: #5f5f5f;
                margin: -20px -20px 50px -20px;
                padding-top: 1px;
                padding-bottom: 1px;
            }
            .top h3{
                text-align: center;
                font-family: calibri,tahoma,arial,serif; 
                font-size: 30px;
                color: white;
            }
            .top-left img{
                width: 200px;
                height: 60px;
                float:left;
                margin-top: -5.5%;
                margin-left: 3%;
            }
            .top-left img:hover{
                opacity: 0.9;
            }
            .top-right button{
                position: relative;
                margin-left: 92%;
                margin-top: -6.1%;
                width: 100px;
                height: 75px;
                font-size: 15px;
                border-top: 0;
                border-right: 0;
                border-bottom: 0;
                border-color: blue;
                background-color: transparent;
            }
            .top-right button:hover{
                opacity: 0.8;
                color: white;
            }
            .menu{
                background-color: #7c7b7b;
                margin-top: -10px;
            }
            .menu a{
                text-decoration: none;
            }
            .menu button{
                height: 30px;
                margin-left: 3%;
                font-size: 15px;
                font-weight: bold;
                background-color: transparent;
                border: 0;
            }
            .menu button:hover{
                color:white;
                border:1px dotted white;
            }
            .isi{
                margin-left: 4%;
                background-color: silver;
                padding-left: 1%;
                padding-top: 2%;
                border: 1px solid transparent;
                border-radius: 10px;
                margin-top: -20px;
                margin-right: 4%;
                padding-bottom:  25%;
                color: black;
                font-size: 18px;
                font-weight: 500;
            }
            .isi h4{
                font-size: 25px;
                margin-top: -25px;
                font-family: Gadugi,Arial,Tahoma,Serif;
            }
            .isi button{
                font-size: 14px;
                font-weight: bold;
                font-family: tahoma,serif;
                width: 80px;
                height: 35px;
            }
            .isi table{
                margin-top: -31%;
                margin-left: 30%;
                color: black;
                font-size: 14px;
                text-align: center;
            }
            .kat1{
                margin-top: -50px;

            }

        </style>
    </head>
    <body background="img/background_admin.jpg" style="opacity: 0.9">
        <div class="top">
            <h3>Master Periode</h3>
            <div class="top-left">
                <a href="adminhome.php"><img src="img/LogoUbaya.png" alt="Logo"/></a>
            </div>
            <div class="top-right">
                <a href="proses.php?act=logout"><button type="button" name="btnExit"><strong>Log Out</strong></button></a>
            </div>
            <div class="menu">
                <a href="adminhome.php"><button class="button">Home</button></a>
                <a href="mastermk.php"><button class="button">Master Mata Kuliah</button></a>
                <a href="mastermhs.php"><button class="button">Master Mahasiswa</button></a>
                <a href="masterkelas.php"><button class="button">Master Kelas</button></a>
                <a href="masterlaporan.php"><button class="button">Master Laporan</button></a>
            </div>
        </div>
        <?php
        require './db.php';
        if (isset($_GET['edit'])) {
            $a = $_GET['edit'];
            $sql = "Select * from periode where kode_periode=" . $a;
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_array($result);
            $nama = $row['nama'];
            $status = $row['status'];
            $a;
            if ($status == 1) {
                $a = "AKTIF";
            } else {
                $a = "NON AKTIF";
            }
            $t1 = $row['tanggal_buka'];
            $t2 = $row['tanggal_akhir'];
            $kode = $row['kode_periode'];
        }
        ?>
        <div class="isi">
            <form action="proses.php?act=tambahperiode" method="POST">
                <h4>Tambah Periode</h4>
                <input type="hidden" name="kode" value="<?php
                if (isset($_GET['edit'])) {
                    echo $kode;
                } else
                    echo "in";
                ?>"/><br>
                <div class="kat1">
                    <p>Nama Periode:</p>
                    <input type="text" name="nama" placeholder="Nama Periode" required
                           value="<?php
                           if (isset($_GET['edit'])) {
                               echo $nama;
                           } else
                               echo "";
                           ?>"/><br>
                </div>
                <p>Status Periode:</p>
                <select name="status">
                    <option>AKTIF</option>
                    <option>NON AKTIF</option>
                    <?php
                    if (isset($_GET['edit'])) {
                        echo "<option selected>" . $a;
                    }
                    ?>
                </select><br/>
                <p>Tanggal Mulai:</p>
                <input type="date" name="tglmulai" required value="<?php
                if (isset($_GET['edit'])) {  echo $t1;    }  ?>"/><br>
                <p>Tanggal Akhir:</p>
                <input type="date" name="tglakhir" required value="<?php
                if (isset($_GET['edit'])) {  echo $t2;  } else echo "";
                ?>"/><br><br>
                <button type="submit" value="simpan" name="simpan">Simpan</button>
            </form> 
            <table border="1" style="width: 60%">
                <tr>
                    <th>ID</th>
                    <th>Periode</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Akhir</th>
                    <th>Status</th>
                    <th>Edit | Hapus</th>
                </tr>
                <?php
                require './db.php';
                $sql = "Select * from periode where hapuskah = false";
                $result = mysqli_query($link, $sql);
                $status;
                while ($row = mysqli_fetch_object($result)) {
                    echo "<tr>";
                    echo "<td>" . $row->kode_periode . "</td> ";
                    echo "<td>" . $row->nama . "</td> ";
                    echo "<td>" . $row->tanggal_buka . "</td> ";
                    echo "<td>" . $row->tanggal_akhir . "</td> ";
                    if ($row->status == 1) {
                        $status = "AKTIF";
                    } else if ($row->status == 0) {
                        $status = "NON AKTIF";
                    }
                    echo "<td>" . $status . "</td> ";
                    echo "<td>";
                    echo "<a href='masterperiode.php?edit=" . $row->kode_periode . "'>Edit</a>";
                    echo " | ";
                    echo "<a href='proses.php?i=" . $row->kode_periode . "&act=hapusper'>Hapus</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>

            </table>
        </div>
        <?php
                 }
 else {
      header("Location: index.php");  
}
        if (isset($_SESSION['INSERT'])) {
            echo "<script type='text/javascript'>alert('DATA BERHASIL DI INPUT')</script>";
            unset($_SESSION['INSERT']);
            unset($_SESSION['HAPUS']);
        }
        if (isset($_SESSION['EDIT'])) {
            echo "<script type='text/javascript'>alert('EDIT BERHASIL')</script>";
            unset($_SESSION['EDIT']);
            unset($_SESSION['HAPUS']);
        }
        if (isset($_SESSION['HAPUS'])) {
            echo "<script type='text/javascript'>alert('DATA TERHAPUS')</script>";
            unset($_SESSION['HAPUS']);
        }
   
        ?>
    </body>
</html>