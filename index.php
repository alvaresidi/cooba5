<!DOCTYPE html>
<html>
    <?php session_start(); ?>
    <head>
        <meta charset="UTF-8">
        <title>Project Web</title>
        <style>
            .background img{
                width: 101.3%;
                max-width: 110%;
                height: 100%;
                max-height: 100%;
                margin: -10px 0px -10px  -10px;
                appearance: menu;

            }
            .utama table{
                margin:-65% auto 0% auto;
                border-radius: 10px;
            }
            .utama p{
                font-size: 80px;
                font-family: serif;
            }
            .utama img{
                width: 200px;
                height: 200px;
            }

        </style>
    </head>
    <body>
        <div class="background">
            <img src="img/intro4.jpg"/>    
        </div>
        <div class="form">
            <div class="utama">
                <table>
                    <tr>
                        <th></th>
                        <th><p>Welcome</p></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th><img src="img/avatar.png"/></th>
                        <th></th>
                        <th><img src="img/woman.png"/></th>
                    </tr>
                    <tr>
                        <th><form action="proses.php?act=loginadmin" method="POST"><br><input type="text" name="uname" placeholder="Username Admin"/><br><br>
                            <input type="password" name="upass" placeholder="Password Admin"/><br><br>
                            <input type="submit" name="submit" style="width: 100px; height: 30px;"/></form></th>
                        <th></th>
                        <th><form action="proses.php?act=loginmhs" method="POST"><br><input type="text" name="nrp" placeholder="NRP"/><br><br>
                            <input type="password" name="s_pass" placeholder="Password Mahasiswa"/><br><br>
                            <input type="submit" name="submit" style="width: 100px; height: 30px;"/></form></th>
                    </tr>
                </table>
            </div>
        </div>
        <?php
        if (isset($_SESSION['salah'])) {
        echo "<script type='text/javascript'>alert('username atau password salah !')</script>";
        unset($_SESSION['salah']);
    }
    if (isset($_SESSION['salahsiswa'])) {
        echo "<script type='text/javascript'>alert('nrp atau password salah !')</script>";
        unset($_SESSION['salahsiswa']);
    }
     if (isset($_SESSION['periode'])) {
        echo "<script type='text/javascript'>alert('Maaf Perwalian Belum bisa di akses saat ini  !')</script>";
        unset($_SESSION['periode']);
    }
        ?>
    </body>
</html>
