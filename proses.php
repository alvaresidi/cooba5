<?php

session_start();
require './db.php';


$act = $_GET['act'];
switch ($act) {
    case "loginadmin" :
        $a_name = $_POST["uname"];
        $apass = $_POST["upass"];
        $a_pass = md5($apass);
        $sql = "select * from admin where username ='" . $a_name . "'";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        if ($a_name == $row['username'] && $a_pass == $row['password']) {
            
            header("Location: adminhome.php");
            $_SESSION['login'] = TRUE;
        } else if ($a_name != $row['username'] || $a_pass != $row['password']) {

            header("Location: index.php");
            $_SESSION['salah'] = TRUE;
        }

        break;
    case "loginmhs" :
        $nrp = $_POST["nrp"];
        $spass = $_POST["s_pass"];
        $s_pass = md5($spass);
        $sql = "select * from mahasiswa where nrp ='" . $nrp . "'";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        if ($nrp == $row['nrp'] && $s_pass == $row['password']) {  
            $_SESSION['nrp'] = $nrp;
            header("Location: inputperwalian.php");
            $_SESSION['loginsiswa'] = TRUE;
            
        } else if ($nrp != $row['nrp'] || $s_pass != $row['password']) {

            header("Location: index.php");
            $_SESSION['salahsiswa'] = TRUE;
        }

        break;
    case "simpanmhs" :
        $nrpedit = $_POST["nrpedit"];
        $kode = $_POST["kode"];
        $a = explode(".", $_FILES['uFile']['name']);
        $text = $a[count($a) - 1];

        $name = md5($_FILES['uFile']['name'] . time());
        $namaFoto = substr($name, 0, 10) . "." . $text;

        $namaMhs = $_POST['nama'];
        $passm = $_POST['pass'];
        $password = md5($passm);
        $sks = $_POST['sks'];
        if (isset($_POST['simpan']))
            if ($_POST['pass'] != $_POST['uPass']) {
                header("Location: mastermhs.php");
            $_SESSION['passbeda'] = TRUE;
            }
            else if ($_FILES['uFile']['type'] == "image/jpeg" && $kode == "in") {
                $nrp = $_POST['nrp'];
                move_uploaded_file($_FILES['uFile']['tmp_name'], "propic/" . $namaFoto);


                $sql = "INSERT INTO mahasiswa (nrp, nama, password, jatah_sks, foto_profil)" .
                        "VALUES('" . $nrp . "','" . $namaMhs . "','" . $password .
                        "'," . $sks . ",'" . $namaFoto . "')";
                $result = mysqli_query($link, $sql);
                header("Location: mastermhs.php");
                $_SESSION['INSERT'] = true;
            } else if ($_FILES['uFile']['type'] == "image/jpeg" && $kode == "edit") {
                $sqlh = "Select * from mahasiswa where nrp=" . $nrpedit;
                $result = mysqli_query($link, $sqlh);
                $row = mysqli_fetch_array($result);
                //untuk hapus foto yang lama
                $test = $row['foto_profil'];
                $path = "./propic/" . $test;
                unlink($path);
                move_uploaded_file($_FILES['uFile']['tmp_name'], "propic/" . $namaFoto);
                $sql = "update mahasiswa set nama='" . $namaMhs . "',password='" . $password . "',foto_profil='" . $namaFoto .
                        "',jatah_sks=" . $sks . " where nrp=" . $nrpedit;
                $result = mysqli_query($link, $sql);
                header("Location: mastermhs.php");
                $_SESSION['EDIT'] = true;
            } else if(empty($_FILES['uFile']['name'])){
                $sql = "update mahasiswa set nama='" . $namaMhs . "',password='" . $password . "',jatah_sks=" . $sks . " where nrp=" . $nrpedit;
                $result = mysqli_query($link, $sql);
                header("Location: mastermhs.php");
                $_SESSION['EDIT'] = true;
            }
        break;
    case "hapusmhs" :
        $i = $_GET['i'];
        $sql = "Update mahasiswa set hapuskah=1 where nrp='" . $i . "'";
        $result = mysqli_query($link, $sql);
        header("Location: mastermhs.php");
        $_SESSION['HAPUS'] = true;
        break;

    case "tambahmk" :
        $kodeedit = $_POST['kodemkedit'];

        $nama = $_POST['namaMk'];
        $deskripsi = $_POST['deskripsi'];
        $jumlahsks = $_POST['jsks'];
        $tanda = $_POST['kode'];
        if (empty($_POST['kodeMk']) && $tanda == "in")
            echo "kode mk tidak boleh kosong" . "<br/>";
        if (empty($_POST['namaMk']))
            echo "nama mk tidak boleh kosong" . "<br/>";
        if (empty($_POST['jsks']))
            echo "jumlah_sks tidak boleh kosong" . "<br/>";
        else if ($tanda == "in") {
            $kode = $_POST['kodeMk'];


            $sql = "insert into matakuliah (kode_mk, nama, jumlah_sks, deskripsi)" .
                    "values ('" . $kode . "','" . $nama . "'," . $jumlahsks . ",'" . $deskripsi . "')";
            $result = mysqli_query($link, $sql);
            header("Location: mastermk.php");
            $_SESSION['INSERT'] = true;
        } ELSE if ($tanda == "edit") {

            $sql = "update matakuliah set nama='" . $nama . "',jumlah_sks=" . $jumlahsks . ",deskripsi='" . $deskripsi . "' where kode_mk='" . $kodeedit . "'";
            $result = mysqli_query($link, $sql);
            header("Location: mastermk.php");
            $_SESSION['EDIT'] = true;
        }

        break;
    case "hapusmk" :
        $i = $_GET['i'];
        $sql = "Update matakuliah set hapuskah=1 where kode_mk='" . $i . "'";
        $result = mysqli_query($link, $sql);
        header("Location: mastermk.php");
        $_SESSION['HAPUS'] = true;
        break;


    case "tambahperiode" :

        $a = $_POST['tglmulai'];
        $b = $_POST['tglakhir'];
        $date = explode('-', $a);
        $date2 = explode('-', $b);
        $tglmulai = "$date[0]-$date[1]-$date[2]";
        $tglakhir = "$date2[0]-$date2[1]-$date2[2]";
        $kodep = $_POST['kode'];


        if (empty($_POST['nama'])) {
            echo"nama harus di isi" . "<br/>";
        }
        if (empty($_POST['tglmulai'])) {
            echo"tanggal awal harus di isi" . "<br/>";
        }
        if (empty($_POST['tglakhir'])) {
            echo"tanggal akhir harus diisi" . "<br/>";
        } else {
            $nama = $_POST['nama'];
            $status;
            if ($_POST['status'] === 'AKTIF') {
                $status = 1;
            } else if ($_POST['status'] === 'NON AKTIF') {
                $status = 0;
            }
            if ($status == 1) {
                $sql = "update periode set status=0";
                $result = mysqli_query($link, $sql);
            }
            if ($kodep == "in") {
                $sql1 = "insert into periode (nama, status, tanggal_buka, tanggal_akhir)" .
                        "values('" . $nama . "'," . $status . ",'" . $tglmulai . "','" .
                        $tglakhir . "')";
                $result = mysqli_query($link, $sql1);
                header("Location: masterperiode.php");
                $_SESSION['INSERT'] = true;
            } else {
                $sql1 = "update periode set nama='" . $nama . "',status=" . $status . ",tanggal_buka='" .
                        $tglmulai . "',tanggal_akhir='" . $tglakhir . "' where kode_periode=" . $kodep;
                $result = mysqli_query($link, $sql1);
                header("Location: masterperiode.php");
                $_SESSION['EDIT'] = true;
            }
        }
    case "hapusper":
        $i = $_GET['i'];
        $sql = "Update periode set hapuskah=1 where kode_periode=" . $i;
        $result = mysqli_query($link, $sql);

        header("Location: masterperiode.php");
        $_SESSION['HAPUS'] = true;

        break;

    case "tambahkelas":

        $kapasitas = $_POST["kapasitas"];
        $tanda = $_POST["kode"];
        $periode = $_POST["periode"];
        $sql1 = "select * from periode where nama='" . $periode . "'";
        $result = mysqli_query($link, $sql1);
        $row = mysqli_fetch_array($result);
        $kodeperiode = $row['kode_periode'];
        $mata = $_POST["matkul"];
        $sql2 = "select * from matakuliah where nama='" . $mata . "'";
        $result = mysqli_query($link, $sql2);
        $row = mysqli_fetch_array($result);
        $kode_mk = $row['kode_mk'];
        $namakelas = $_POST["namakelas"];
        $kodekelas = $_POST['kodekelas'];
        if (empty($_POST['namakelas']))
            echo "Nama kelas harus diisi ! <br/>";
        if (empty($_POST['kapasitas']))
            echo "Kapasitas kelas harus diisi ! <br/>";
        else if ($tanda == "in") {

            $sql3 = "insert into kelas (kode_mk,kode_periode,nama_kelas,kapasitas) values('" .
                    $kode_mk . "'," . $kodeperiode . ",'" . $namakelas . "'," . $kapasitas . ")";
            $result = mysqli_query($link, $sql3);
            header("Location: masterkelas.php");
            $_SESSION['INSERT'] = true;
        } else if ($tanda == "edit") {
            $sql3 = "update kelas set kode_mk='" . $kode_mk . "',kode_periode=" . $kodeperiode .
                    ",nama_kelas='" . $namakelas . "',kapasitas=" . $kapasitas . " where kode_kelas=" . $kodekelas;
            $result = mysqli_query($link, $sql3);
            header("Location: masterkelas.php");
            $_SESSION['EDIT'] = true;
        }

        break;
    case "hapuskelas" :
        $i = $_GET['i'];
        $sql = "Update kelas set hapuskah=1 where kode_kelas=" . $i;
        $result = mysqli_query($link, $sql);

        header("Location: masterkelas.php");
        $_SESSION['HAPUS'] = true;

        break;
    case "perwaliant":
        $nrp = $_POST['nrp'];
        $kodemk = $_POST['kodemk'];
        $kp = $_POST['kp'];
        $sql = "select * from kelas where kode_mk='" . $kodemk ."' and nama_kelas='KP " . $kp . "'";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        $kodekelas = $row['kode_kelas'];
        $kapasitas = $row['kapasitas'];
        
        //data untuk cek sks melebihi atau tidak
        $skssisa = $_POST['sks'];
        $sql1 = "select * from matakuliah where kode_mk='" . $kodemk ."'";
        $result = mysqli_query($link, $sql1);
        $row = mysqli_fetch_array($result);
        $sksinput = $row['jumlah_sks'];
        //data untuk cek kapasitas kelas
        $sql1 = "select count(nrp) from mahasiswa_kelas WHERE kode_kelas=" . $kodekelas;
        $result = mysqli_query($link, $sql1);
        $row = mysqli_fetch_array($result);
        $isikelas = $row[0];
        $itungkelas = $kapasitas-$isikelas;
        
//        cek input matkul yang sama
       $sql4 = "select mk.kode_kelas,k.kode_mk from mahasiswa_kelas mk inner join kelas k "
                . "on mk.kode_kelas = k.kode_kelas where nrp='" . $nrp . "'";
        $result = mysqli_query($link, $sql4);
        $sama ="";
        while ($row = mysqli_fetch_array($result)){
            $row[1];
            if($kodemk=="$row[1]"){
                $sama="yah";    
                break;
            }
        }
        if (empty($kodekelas)) {
            header("Location: inputperwalian.php");
            $_SESSION['salahinput'] = true;
        }
        else if($skssisa<=$sksinput){
            header("Location: inputperwalian.php"); 
        $_SESSION['skslebih']=true;
        }
        else if($sama=="yah"){
            header("Location: inputperwalian.php");
            $_SESSION['mksama']=true;
        }
        else if($itungkelas<=$isikelas){
           header("Location: inputperwalian.php"); 
        $_SESSION['kelaspenuh']=true; 
        }
        else{
        $sql2 = "insert into mahasiswa_kelas values('" . $nrp . "'," . $kodekelas .")";
        $result = mysqli_query($link, $sql2);
        header("Location: inputperwalian.php"); 
        $_SESSION['INSERT']=true;
        }
        break;
    case "hapusinput" :
        $i = $_GET['i'];


        $sql = "delete from mahasiswa_kelas where kode_kelas=" . $i;
        $result = mysqli_query($link, $sql);
        $sql1 = "select * from kelas where kode_kelas=" . $i;
        $result = mysqli_query($link, $sql1);
        $row = mysqli_fetch_array($result);
        $kodemk = $row['kode_mk'];
        $sql2 = "select * from matakuliah where kode_mk='" . $kodemk . "'";
        $result = mysqli_query($link, $sql2);
        $row = mysqli_fetch_array($result);
        $skssisa = $_SESSION['sisasks'];
        $skshapus = $row['jumlah_sks'];
        $sksupdate = $skssisa + $skshapus;
        $_SESSION['sisasks'] = $sksupdate;
        header("Location: inputperwalian.php");
        $_SESSION['HAPUS'] = true;
        break;
    case "logout":
        unset($_SESSION['login']);
        unset($_SESSION['loginsiswa']);
        header("Location: index.php");
        break;
    case "gaksesuai":
        header("Location: masterlaporan.php");
        $_SESSION['kelastidakada']=TRUE;
        break;
}
?>
