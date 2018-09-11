<?php

//$a = "abc";
//$a = 'abc';
//
//$a = <<<JOINTHEDARKSIDE
//        BLA BLA BLA
//JOINTHEDARKSIDE;
//        
//echo $a
        
require_once './tcpdf_6_2_12/tcpdf/tcpdf.php';
require './db.php';

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('DAVID BERNADI');
$pdf->SetTitle('PROJECT PWEB');
$pdf->SetSubject('CREATE PDF');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

//AMBIL DATA ---------------------------------------------------------
$periode = $_POST['periode'];
$namamatkul = $_POST['matkul'];
$kp = $_POST['kelas'];
$sql1 = "select kode_mk from matakuliah where nama='". $namamatkul . "'";
$result = mysqli_query($link, $sql1);
$row = mysqli_fetch_array($result);
$kodemk = $row['kode_mk'];

//hitung kapasitas kelas dan cari kode kelas
$sql2 = "select * from kelas where kode_mk='" . $kodemk ."' and nama_kelas='" . $kp . "'";
$result = mysqli_query($link, $sql2);
$row = mysqli_fetch_array($result);

$kodekelas = $row['kode_kelas'];
$kapasitas = $row['kapasitas'];
if (empty($kodekelas)) {
            header("Location: proses.php?act=gaksesuai");
            
        }
//itung jumlah yang ada di dalam kelas
$sql3 = "select count(kode_kelas) from mahasiswa_kelas WHERE kode_kelas=" . $kodekelas;
$result = mysqli_query($link, $sql3);
$row = mysqli_fetch_array($result);
$isikelas = $row[0];

// set font
$pdf->SetFont('helvetica', '', 20);

// add a page
$pdf->AddPage();

$pdf->Write(0, 'DAFTAR ISI KELAS', '', 0, 'C', 1, 0, false, false, 0);
$Tanggal = date("d-m-Y");
// set font
$pdf->SetFont('helvetica', '', 12);
$pdf->Text(10, 50, 'Mata Kuliah : ' . $namamatkul);
$pdf->Text(10, 55, 'Kode : ' . $kodemk);
$pdf->Text(10, 60, 'Kelas : ' . $kp);
$pdf->Text(10, 65, 'Kapasitas : ' . $isikelas . '/' . $kapasitas);
$pdf->Text(140, 50, 'Periode : ' . $periode);
$pdf->Text(140, 55, 'Tanggal Cetak : ' . $Tanggal);
//table
$pdf->SetFont('helvetica', '', 11);
$html = <<<HAHAHA
        <br/><br/><br/><br/><br/><br/>
        <table border="1" style="text-align:center;">
            <tr>
                <th>NO</th>
                <th>NRP</th>
                <th>NAMA MAHASISWA</th>
            </tr>
HAHAHA;


$sql = "SELECT mahkel.nrp,m.nama FROM mahasiswa_kelas mahkel inner join mahasiswa m "
        . "on mahkel.nrp=m.nrp where mahkel.kode_kelas=" . $kodekelas;
$result = mysqli_query($link, $sql);
$no = 1;
while($row=  mysqli_fetch_array($result)) {
    $html = $html . "<tr>";
    $html = $html . "<td>" . $no . "</td>";
    $html = $html . "<td>" . $row['nrp'] . "</td>";
    $html = $html . "<td>" . $row['nama'] . "</td>";
    $html = $html . "</tr>";
    $no += 1;
}
$html=$html."</table>";
$pdf->writeHTML($html);



$pdf->Output("transkrip kelas.pdf");
?>