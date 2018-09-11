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
                margin-top: -30px;
                margin-right: 4%;
                padding-bottom: 2%;
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
                width: 150px;
                height: 35px;
            }
        </style>
    </head>
    <body background="img/background_admin.jpg" style="opacity: 0.9">
        <div class="top">
            <h3>Master Laporan</h3>
            <div class="top-left">
                <a href="adminhome.php"><img src="img/LogoUbaya.png" alt="Logo"/></a>
            </div>
            <div class="top-right">
                <a href="proses.php?act=logout"><button type="button" name="btnExit"><strong>Log Out</strong></button></a>
            </div>
            <div class="menu">
                <a href="adminhome.php"><button class="button">Home</button></a>
                <a href="masterperiode.php"><button class="button">Master Periode</button></a>
                <a href="mastermk.php"><button class="button">Master Mata Kuliah</button></a>
                <a href="mastermhs.php"><button class="button">Master Mahasiswa</button></a>
                <a href="masterkelas.php"><button class="button">Master Kelas</button></a>
            </div>
        </div>
        <div class="isi">
            <h4>Filter Laporan</h4><br/>
            <form action="pdf.php" method="POST">
                <p>Pilih Periode:</p>
                <select name="periode" style="width: 405px;" required >
                    <?php
                    require './db.php';
                    $sql = "Select nama from periode where hapuskah=0";
                    $result = mysqli_query($link, $sql);
                    $status;
                    while ($row = mysqli_fetch_object($result)) {

                        echo "<option>" . $row->nama;
                    }
                    if (isset($_GET['edit'])) {
                        echo "<option selected>" . $matkul;
                    }
                    ?>
                </select>

                <p>Pilih Mata kuliah:</p>
                <select name="matkul" style="width: 405px;" >
                    <?php
                    require './db.php';
                    $sql = "Select * from matakuliah where hapuskah=0";
                    $result = mysqli_query($link, $sql);
                    $status;
                    while ($row = mysqli_fetch_object($result)) {
                       echo "<option>" . $row->nama;
                    }                 
                    ?>
                </select>

                <p>Pilih Kelas:</p>
                <select name="kelas" style="width: 405px;" >
                    <?php
                    require './db.php';
                    $sql = "Select distinct nama_kelas from kelas order by nama_kelas asc";
                    $result = mysqli_query($link, $sql);
                    $status;
                    while ($row = mysqli_fetch_object($result)) {

                        echo "<option>" . $row->nama_kelas;
                    }
                    ?>
                </select><br><br>
                <button type="submit" value="Cetak" name="cetaklaporan">Cetak Laporan</button><br/>
            </form>
        </div>
          <?php
         }
            else { header("Location: index.php");  }
            if(isset($_SESSION['kelastidakada'])){
                echo "<script type='text/javascript'>alert('maaf salah Kelas tidak ada')</script>";
             unset($_SESSION['kelastidakada']);}
            
        ?>
    </body>
</html>
