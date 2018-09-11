
<html>

    <?php
    session_start();
    if (isset($_SESSION['loginsiswa'])) {
        $nrp = $_SESSION['nrp'];
        require './db.php';
        $sql2 = "Select * from periode where status=1";
        $result = mysqli_query($link, $sql2);
        $row = mysqli_fetch_array($result);
        $periode = $row['nama'];
        if (empty($periode)) {
            header("Location: index.php");
            $_SESSION['periode'] = true;
        }

        $sql = "Select * from mahasiswa where nrp=" . $nrp;
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        $nama = $row['nama'];

        $pass = $row['password'];
        $jatah = $row['jatah_sks'];
        $foto = $row['foto_profil'];
        ?>

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
                    padding-top: 4%;
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
                    text-align: center;
                }
                .isi pre{
                    margin-left: 120px;
                    margin-top: -250px; 
                }
                .tambahMK button{
                    font-size: 14px;
                    font-weight: bold;
                    font-family: tahoma,serif;
                    width: 150px;
                    height: 35px;
                }
                .tambahMK{
                    margin-left: 4%;
                    background-color: gray;
                    padding-left: 3%;
                    border: 1px solid transparent;
                    border-radius: 10px;
                    margin-right: 4%;
                    padding-bottom: 2%;
                    color: black;
                    font-size: 18px;
                    font-weight: 500;
                    font-family: Gadugi,Arial,Tahoma,Serif;
                    text-align: center;
                }
            </style>

            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
            <script>
                function tampilkanpeta() {
                    var infoWindow;

                    if (document.getElementById('map-canvas')) {
                        // Coordinates to center the map
                        var myLatlng = new google.maps.LatLng(-7.3207374, 112.7674089);
                        var mapOptions = {
                            zoom: 14,
                            center: myLatlng,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
    <?php
    $koneksi = new mysqli("localhost", "root", "", "test");
    $sql = "SELECT * FROM mahasiswa";
    $result = $koneksi->query($sql);
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $i++;
        ?>
                            var marker<?php echo $i; ?> = new google.maps.Marker({
                                position: new google.maps.LatLng(<?php echo $row['lokasi']; ?>),
                                map: map,
                                title: '<?php echo $row['nama']; ?>'
                            });

                            google.maps.event.addListener(marker<?php echo $i; ?>, 'click', function () {
                                // Check to see if an InfoWindow already exists
                                if (!infoWindow) {
                                    infoWindow = new google.maps.InfoWindow();
                                }
                                // Creating the content
                                var content = '<div id="info">' +
                                        '<h2 style="color:black;"><?php echo $row['nama']; ?></h2>' +
                                        '<p style="color:black;">Alamat: <?php echo $row['alamat']; ?></p>' +
                                        '<p style="color:black;">No HP: <?php echo $row['telepon']; ?> </p>' +
                                        '</div>';
                                // Setting the content of the InfoWindow
                                infoWindow.setContent(content);
                                // Opening the InfoWindow
                                infoWindow.open(map, marker<?php echo $i; ?>);
                            });
    <?php } ?>

                    }
                }


            </script>
        </head>
        <body background="img/background_student.jpg" style="opacity: 0.9">
            <div class="top">
                <h3>Welcome, <?php echo $nama; ?></h3>
                <div class="top-left">
                    <a href="#"><img src="img/LogoUbaya.png" alt="Logo"/></a>
                </div>
                <div class="top-right">
                    <a href="proses.php?act=logout"><button type="button" name="btnExit"><strong>Log Out</strong></button></a>
                </div>
                <div class="menu">
                    <a href="matakuliah.php"><button class="button">Mata Kuliah</button></a>
                </div>
            </div>
            <div class="isi">
                <h4>Periode <?php echo $periode; ?></h4>
                <?php
                echo "<img src='propic/" . $foto . "' width='200px' height='250px'/>";
                ?>
                <PRE><br>
                    <?php
                    require './db.php';
                    $sql2 = "SELECT mahkel.kode_kelas,k.kode_mk,mk.nama,k.nama_kelas,mk.jumlah_sks from"
                            . " mahasiswa_kelas mahkel inner join "
                            . "kelas k on mahkel.kode_kelas= k.kode_kelas inner join matakuliah mk on "
                            . "k.kode_mk=mk.kode_mk where mahkel.nrp='" . $nrp . "'";

                    $sksterpakai = 0;
                    $result = mysqli_query($link, $sql2);
                    while ($row = mysqli_fetch_array($result)) {

                        echo "<input type='hidden' value='" . $row[4] . "' />";
                        $skster = $row[4];
                        $sksterpakai += $skster;
                    }

                    $skssisa = $jatah - $sksterpakai;
                    ?>
        <strong>NRP:</strong> <?php echo $nrp; ?> <br/>
                            <strong>Nama:</strong> <?php echo $nama; ?><br/>
                            <strong>SKS maks:</strong> <?php echo $jatah; ?><br/>
                            <strong>Sisa SKS:</strong> <?php echo $skssisa; ?><br/>
                        </div>
                    <form action="proses.php?act=perwaliant" method="POST">
                        <div class="tambahMK">
                        <h3>Tambah Mata Kuliah</h3>
                        Kode Mata Kuliah: <input type="text" name="kodemk" placeholder="Kode Mata Kuliah" required /><br>
                        KP: <input type="text" size="2" name="kp" placeholder="-" required/><br><br>
                        <input type="hidden" name="nrp" value="<?php echo $nrp; ?>"/>
                        <input type="hidden" name="sks" value="<?php echo $jatah; ?>"/>
                        <input type="hidden" name="nrp" value="<?php echo $nrp; ?>"/>
                        
                        <input type="hidden" name="sks" value="<?php echo $skssisa; ?>"/>
                        <button type="Submit" value="Submit" name="submit">Submit</button><br><br>
                    </form>
                    <table align="center" border="1" width="60%">
                        <caption>Daftar Mata Kuliah yang diambil</caption>
                        <tr>
                        <th>KODE MK</th>
                        <th>NAMA MATA KULIAH</th>
                        <th>KELAS</th>
                        <th>SKS</th>
                        <th>KETERANGAN</th>
                        </tr>
                        <?php
                        require './db.php';
                        $sql = "SELECT mahkel.kode_kelas,k.kode_mk,mk.nama,k.nama_kelas,mk.jumlah_sks from"
                                . " mahasiswa_kelas mahkel inner join "
                                . "kelas k on mahkel.kode_kelas= k.kode_kelas inner join matakuliah mk on "
                                . "k.kode_mk=mk.kode_mk where mahkel.nrp='" . $nrp . "'";


                        $result = mysqli_query($link, $sql);


                        while ($row = mysqli_fetch_array($result)) {

                            echo "<tr style='text-align:center'>";
                            echo "<td>" . $row[1] . "</td>";
                            echo "<td>" . $row[2] . "</td>";

                            echo "<td>" . $row[3] . "</td>";
                            echo "<td>" . $row[4] . "</td>";
                            echo "<td>";
                            echo "<a href='proses.php?i=" . $row[0] . "&act=hapusinput&a=" . $row[4] . "'>Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                        </div>
                		<div id="map-canvas" style="width: 100%; height: 100%;"></div>
                <?php
            } else {
                header("Location: index.php");
            }

            if (isset($_SESSION['salahinput'])) {
                echo "<script type='text/javascript'>alert('MAAF KODE MK DENGAN KP TIDAK SESUAI')</script>";
                unset($_SESSION['salahinput']);
                unset($_SESSION['kelaspenuh']);
            }
            if (isset($_SESSION['INSERT'])) {
                echo "<script type='text/javascript'>alert('DATA BERHASIL DI INPUT')</script>";
                unset($_SESSION['INSERT']);
            }
            if (isset($_SESSION['skslebih'])) {
                echo "<script type='text/javascript'>alert('JATAH SKS TIDAK MENCUKUPI')</script>";
                unset($_SESSION['skslebih']);
            }

            if (isset($_SESSION['mksama'])) {
                echo "<script type='text/javascript'>alert('MAAF mk sama tidak boleh 2kali')</script>";
                unset($_SESSION['mksama']);
            }

            if (isset($_SESSION['kelaspenuh'])) {
                echo "<script type='text/javascript'>alert('Maaf ya,Kelas sudah Penuh')</script>";
                unset($_SESSION['kelaspenuh']);
            }
            if (isset($_SESSION['HAPUS'])) {
                echo "<script type='text/javascript'>alert('DATA TERHAPUS')</script>";
                unset($_SESSION['HAPUS']);
            }
            ?>
    
		<Script>
                tampilkanpeta();
</Script>
    </body>    
    
 
</html>