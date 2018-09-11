<?php

 session_start();
    if(isset($_SESSION['login'])){
         
            require './db.php';
            $sql2 = "Select * from periode where status=1";
            $result = mysqli_query($link, $sql2);
            $row = mysqli_fetch_array($result);
            $periode = $row['nama'];
            if (empty($periode)) {
                header("Location: adminhome.php");
                $_SESSION['TIDAKAKTIF'] = true;
            }
           
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
            .periode{
                margin-left: 230px;
                margin-top: -78px;
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
                width: 80px;
                height: 35px;
            }
            .isi table{
                margin-left: 18%;
                color: black;
                font-size: 18px;
                text-align: center;
            }
        </style>
    </head>
    <body background="img/background_admin.jpg" style="opacity: 0.9">
        <div class="top">
            <h3>Master Kelas</h3>
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
                <a href="masterlaporan.php"><button class="button">Master Laporan</button></a>
            </div>
        </div>
        <div class="isi">
            <h4>Tambah Kelas</h4>
           
            <?php
            require './db.php';
            if (isset($_GET['edit'])) {
                $a = $_GET['edit'];
                $sql = "Select * from kelas where kode_kelas='" . $a . "'";
                $result = mysqli_query($link, $sql);
                $row = mysqli_fetch_array($result);
                $kodekelas = $row['kode_kelas'];
                $kodemk = $row['kode_mk'];
                $kodeperiode = $row['kode_periode'];
                $namakelas = $row['nama_kelas'];
                $kapasitas = $row['kapasitas'];
                $sql1 = "Select * from matakuliah where kode_mk='" . $kodemk . "'";
                $result = mysqli_query($link, $sql1);
                $row = mysqli_fetch_array($result);
                $matkul = $row['nama'];
                $sql2 = "Select * from periode where kode_periode='" . $kodeperiode . "'";
                $result = mysqli_query($link, $sql2);
                $row = mysqli_fetch_array($result);
                $periodeedit = $row['nama'];
            }
            ?>
            <form action="proses.php?act=tambahkelas" method="POST">
                <p>Nama Kelas:</p>
                <input type="text" name="namakelas" placeholder="Nama Kelas" required maxlength="8" <?php
                if (isset($_GET['edit'])) {
                    echo "value='" . $namakelas . "'";
                }
                ?> />
                <input type ="hidden" name="periode" value="<?php
                if (isset($_GET['edit'])) {
                    echo $periodeedit;
                } else
                    echo $periode;
                ?>"/>
                <div class='periode'>
                    <p>Periode:</p>
                    <input type="text" name="periode" value="<?php
                    if (isset($_GET['edit'])) {
                        echo $periodeedit;
                    } else
                        echo $periode;
                    ?>" disabled/>
                </div>
                <p>Mata kuliah:</p>
                <select name="matkul" style="width: 405px;" >
                    <?php
                    require './db.php';
                    $sql = "Select * from matakuliah";
                    $result = mysqli_query($link, $sql);
                    $status;
                    while ($row = mysqli_fetch_object($result)) {

                        echo "<option>" . $row->nama;
                    }
                    if (isset($_GET['edit'])) {
                        echo "<option selected>" . $matkul;
                    }
                    ?>
                </select><br/>
                <p>Kapasitas Kelas:</p>
                <input type="number" name="kapasitas" placeholder="-" style="width: 50px;" <?php
                if (isset($_GET['edit'])) {
                    echo "value='" . $kapasitas . "'";
                }
                ?>/><br/><br/>

                <button type="submit" value="Simpan" name="simpan">Simpan</button><br/>
                <input type="hidden" name="kodekelas" value="<?php echo $kodekelas ?>"/><br/>
                <input type="hidden" name="kode" value="<?php
                if (isset($_GET['edit'])) {
                    echo "edit";
                } else
                    echo "in";
                ?>"/>
            </form>
            <table border="1" style="width: 60%">
                <tr>
                    <th>Nama Kelas</th>
                    <th>Mata Kuliah</th>
                    <th>Periode</th>
                    <th>Kapasitas</th>
                    <th>Edit | Hapus</th>
                </tr> 
                <?php
                require './db.php';
                $sql = "SELECT k.kode_kelas,k.nama_kelas,mk.nama,p.nama,k.kapasitas,k.hapuskah FROM kelas k inner join matakuliah mk
            		 on k.kode_mk=mk.kode_mk inner join periode p
            		 on k.kode_periode=p.kode_periode where k.hapuskah = 0";


                $result = mysqli_query($link, $sql);


                while ($row = mysqli_fetch_array($result)) {

                    echo "<tr style='text-align:center'>";
                    echo "<td>" . $row[1] . "</td>";
                    echo "<td>" . $row[2] . "</td>";

                    echo "<td>" . $row[3] . "</td>";
                    echo "<td>" . $row[4] . "</td>";
                    echo "<td>";
                    echo "<a href='masterkelas.php?edit=" . $row[0] . "'>Edit</a>";
                    echo " | ";
                    echo "<a href='proses.php?i=" . $row[0] . "&act=hapuskelas'>Hapus</a>";
                    echo "</td>";
                    echo "</tr>";
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
        }
        if (isset($_SESSION['EDIT'])) {
            echo "<script type='text/javascript'>alert('EDIT BERHASIL')</script>";
            unset($_SESSION['EDIT']);
        }
        if (isset($_SESSION['HAPUS'])) {
            echo "<script type='text/javascript'>alert('DATA TERHAPUS')</script>";
            unset($_SESSION['HAPUS']);
        }
        ?>

    </body>
</html>
