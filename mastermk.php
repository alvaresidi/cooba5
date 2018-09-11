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
                padding-bottom: 30%;
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
                margin-top: -36%;
                margin-left: 35%;
                color: black;
                font-size: 14px;
                text-align: center;
            }
        </style>
    </head>
    <body background="img/background_admin.jpg" style="opacity: 0.9">
        <div class="top">
            <h3>Master Mata Kuliah</h3>
            <div class="top-left">
                <a href="adminhome.php"><img src="img/LogoUbaya.png" alt="Logo"/></a>
            </div>
            <div class="top-right">
                <a href="proses.php?act=logout"><button type="button" name="btnExit"><strong>Log Out</strong></button></a>
            </div>
            <div class="menu">
                <a href="adminhome.php"><button class="button">Home</button></a>
                <a href="masterperiode.php"><button class="button">Master Periode</button></a>
                <a href="mastermhs.php"><button class="button">Master Mahasiswa</button></a>
                <a href="masterkelas.php"><button class="button">Master Kelas</button></a>
                <a href="masterlaporan.php"><button class="button">Master Laporan</button></a>
            </div>
        </div>
        <div class="isi">
            <h4>Tambah Mata Kuliah</h4>
            <?php
            require './db.php';
            if (isset($_GET['edit'])) {
                $a = $_GET['edit'];
                $sql = "Select * from matakuliah where kode_mk='" . $a . "'";
                $result = mysqli_query($link, $sql);
                $row = mysqli_fetch_array($result);
                $nama = $row['nama'];
                $kodemk = $row['kode_mk'];
                $sks = $row['jumlah_sks'];
                $des = $row['deskripsi'];
            }
            ?>
            <form action="proses.php?act=tambahmk" method="POST">
                <p>Kode Mata Kuliah:</p>  
                <input type="text" name="kodeMk" placeholder="Kode Mata Kuliah" maxlength="8"<?php
                if (isset($_GET['edit'])) {
                    echo "value='" . $kodemk . "' disabled";
                } else
                    echo " required"
                    ?>/>
                <p>Nama Mata Kuliah:</p>  
                <input type="text" name="namaMk" placeholder="Nama Mata Kuliah" required  <?php
                if (isset($_GET['edit'])) {
                    echo "value='" . $nama . "'";
                }
                ?>/>
                <p>Deskripsi:</p>
                <textarea rows="4" cols="50" name="deskripsi" placeholder="Detail Mata Kuliah" style="max-width: 400px; max-height: 150px;"><?php
                    if (isset($_GET['edit'])) {
                        echo $des;
                    }
                    ?>
                </textarea>
                <p>Jumlah SKS:</p>  
                <input type="number" name="jsks" placeholder="Jumlah SKS" required <?php
                if (isset($_GET['edit'])) {
                    echo "value='" . $sks . "'";
                }
                ?>/><br/><br/>
                <button type="submit" value="Simpan" name="simpan">Simpan</button><br/>
                <input type="hidden" name="kodemkedit" value="<?php echo $kodemk; ?>"><br/>
                <input type="hidden" name="kode" value="<?php
                if (isset($_GET['edit'])) {
                    echo "edit";
                } else
                    echo "in";
                ?>"/>
            </form>
            <table border="1" style="width: 60%">
                <tr>
                    <th>Kode Mata Kuliah</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Jumlah SKS</th>
                    <th>Edit | Hapus</th>
                </tr> 
                <?php
                require './db.php';
                $sql = "Select * from matakuliah where hapuskah = false";
                $result = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_object($result)) {
                    echo "<tr>";
                    echo "<td>" . $row->kode_mk . "</td> ";
                    echo "<td>" . $row->nama . "</td> ";
                    echo "<td>" . $row->jumlah_sks . "</td> ";
                    echo "<td>";
                    echo "<a href='mastermk.php?edit=" . $row->kode_mk . "'>Edit</a>";
                    echo " | ";
                    echo "<a href='proses.php?i=" . $row->kode_mk . "&act=hapusmk'>Hapus</a>";
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
