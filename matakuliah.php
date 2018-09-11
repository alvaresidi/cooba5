<?php

session_start();
if(isset($_SESSION['loginsiswa'])){
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
                padding-left: 3%;
                padding-top: 20%;
                border: 1px solid transparent;
                border-radius: 10px;
                margin-top: -10px;
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
                text-align: center;
            }
            .isi table{
                color:black;
                margin-top: -30px;
            }
        </style>
    </head>
    <body background="img/background_student.jpg" style="opacity: 0.9">
        <div class="top">
            <h3>Mata Kuliah</h3>
            <div class="top-left">
                <a href="#"><img src="img/LogoUbaya.png" alt="Logo"/></a>
            </div>
            <div class="top-right">
                <a href="index.php"><button type="button" name="btnExit"><strong>Log Out</strong></button></a>
            </div>
            <div class="menu">
                <a href="inputperwalian.php"><button class="button">Home</button></a>
            </div>
        </div>

        <div class="isi">
            <table align="center" border="1" width="60%">
                <h4>Daftar Mata Kuliah</h4>
                <tr>
                    <th>KODE MK</th>
                    <th>NAMA MATA KULIAH</th>
                    <th>SKS</th>
                    <th style="width:100px;">DESKRIPSI</th>
                    <th style="width:50px;">KP</th>
                    <th>KAPASITAS</th>
                </tr>
                <?php
                require './db.php';
                $sql = "SELECT mk.kode_mk,mk.nama,mk.jumlah_sks,mk.deskripsi,k.nama_kelas,k.kapasitas "
                        . "FROM matakuliah mk inner join kelas k on mk.kode_mk=k.kode_mk where mk.hapuskah=0 and k.hapuskah=0";


                $result = mysqli_query($link, $sql);


                while ($row = mysqli_fetch_array($result)) {

                    echo "<tr style='text-align:center'>";
                    echo "<td>" . $row[0] . "</td>";
                    echo "<td>" . $row[1] . "</td>";

                    echo "<td>" . $row[2] . "</td>";
                    echo "<td>" . $row[3] . "</td>";
                    echo "<td>" . $row[4] . "</td>";
                    echo "<td>" . $row[5] . "</td>";
                    
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

        ?>



    </body>    


</html>