<html>
    <head><?php 
    session_start();
    if(isset($_SESSION['login'])){
        
    ?>
        <meta charset="UTF-8">
        <title>Project Web</title>
        <style>
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
                height: 87px;
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
            .isi a{
                margin: auto 50px auto 25px;
            }
            .isi img{
                width: 350px;
                height: 200px;
            }
            .isi2 button{
                width: 350px;
                height: 200px;
                font-size: 26px;
            }
            .isi2 button:hover{
                opacity: 0;
            }
        </style>
    </head>
    <body background="img/background_admin.jpg" style="opacity: 0.9">
        <div class="top">
            <h3>Welcome, Admin!</h3>
            <div class="top-left">
                <a href="#"><img src="img/LogoUbaya.png" alt="Logo"/></a>
            </div>
            <div class="top-right">
                <a href="proses.php?act=logout"><button type="button" name="btnExit"><strong>Log Out</strong></button></a>
            </div>
        </div>
        <div class="isi">
            <img src="img/adminperiode.jpg" style="margin-left:75px;"><br><br>
            <img src="img/adminmatakuliah.jpg" style="margin-top:-218px; margin-left: 485px;"><br><br>
            <img src="img/adminmahasiswa.jpg" style="margin-top:-235px; margin-left: 895px;"><br><br>
            <img src="img/adminkelas.jpg" style="margin-left: 280px;"><br><br>
            <img src="img/adminlaporan.jpg" style="margin-top:-218px; margin-left: 695px;"><br><br>
        </div>
        <div class="isi2">
            <a href="masterPeriode.php"><button class="button" name="btnPeriode" style="margin-left:75px;margin-top: -490px; position: fixed;">Master Periode</button></a>
            <a href="mastermk.php"><button class="button" name="btnPeriode" style="margin-left:485px;margin-top: -490px; position: fixed;">Master Mata Kuliah</button></a>
            <a href="mastermhs.php"><button class="button" name="btnPeriode" style="margin-left:895px;margin-top: -490px; position: fixed;">Master Mahasiswa</button></a>
            <a href="masterKelas.php"><button class="button" name="btnPeriode" style="margin-left:280px;margin-top: -236px; position: fixed;">Master Kelas</button></a>
            <a href="masterLaporan.php"><button class="button" name="btnPeriode" style="margin-left:695px; margin-top: -236px; position: fixed;">Master Laporan</button></a>
        </div>
    </body>    

    <?PHP
    }
 else {
      header("Location: index.php");  
}
    if (isset($_SESSION['TIDAKAKTIF'])) {
        echo "<script type='text/javascript'>alert('ANDA TIDAK BISA MENGAKSES MASTER KELAS SAAT INI')</script>";
        unset($_SESSION['TIDAKAKTIF']);
    }
    ?>

</html>

