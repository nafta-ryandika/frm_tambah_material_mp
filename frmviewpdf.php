<?php

include("../../configuration.php");
include("../../connection.php");
include("../../endec.php");

//Class For Pdf
//require('mysql_report.php');
require('mc_table_list.php');

if(isset($_POST['nmField'])){
  $nmField = strtoupper($_POST['nmField']);
}
if(isset($_POST['nmParameter'])){
  $nmParameter = $_POST['nmParameter'];
}
if(isset($_POST['nmData'])){
  $nmData = strtoupper($_POST['nmData']);
}

//Cek Get Data
if(isset($_POST['nmSQL'])){
  $txtSQL = $_POST['nmSQL'];
}else{
  $txtSQL = "";
}

$nmField = explode("|", $nmField);
$nmParameter = explode("|", $nmParameter);
$nmData = explode("|", $nmData);
$count = count($nmField);



$image1 = "img/logokmbs.jpg";


$xname = $_SESSION[$domainApp."_myname"];
$xgroup = $_SESSION[$domainApp."_mygroup"];

class PDF extends PDF_MC_Table
 {
   //Fungsi Untuk Membuat Header
 function Header()
 {
  global $image1,$xname,$xgroup,$brandApp,$nmData,$nmField,$nmParameter,$count;
  $this->SetLeftMargin(10);
// $image1 = "logokmbs.jpg";

  $this->SetFont("arial","B",7);
  $this->Cell(10.25, 7.5, $this->Image($image1, $this->GetX(), $this->GetY(), 10.25,7.5), 0, 0, 'L', false );
  $this->Cell(0,7.5,"PT KARYAMITRA BUDISENTOSA",'',0,'L');
  $this->ln(10);
  $this->SetFont("arial","B",7);
  $this->Cell(0,5,"Laporan Master Jenis Kulit",'',0,'L');
  $this->ln();

  if ($count == 1) {
  	 $parameter = $nmParameter[0];
    if ($parameter == 'equal') {
      $parameter = '=';
    }

    if ($parameter == 'notequal') {
      $parameter = '<>';
    }

    if ($parameter == 'less') {
      $parameter = '<';
    }

    if ($parameter == 'lessorequal') {
      $parameter = '<=';
    }

    if ($parameter == 'greater') {
      $parameter = '>';
    }

    if ($parameter == 'greaterorequal') {
      $parameter = '>=';
    }    

    $field = $nmField[0];
    if ($field == 'KDJENIS') {
      $field = 'Kode Jenis';
    }

    if ($field == 'NMJENIS') {
      $field = 'Nama Jenis';
    }

    $data = $nmData[0];

    if ($field != '' && $parameter != '' && $data != '') {
  	 $this->Cell(0,5,$field.' '.$parameter.' '.$data,'',0,'L');
     $this->ln();
    } else{
      $this->ln();
    }
  }
  else{
    for ($i=0; $i < $count-1 ; $i++) {
      $parameter = $nmParameter[$i];
      if ($parameter == 'equal') {
        $parameter = '=';
      }

      if ($parameter == 'notequal') {
        $parameter = '<>';
      }

      if ($parameter == 'less') {
        $parameter = '<';
      }

      if ($parameter == 'lessorequal') {
        $parameter = '<=';
      }

      if ($parameter == 'greater') {
        $parameter = '>';
      }

      if ($parameter == 'greaterorequal') {
        $parameter = '>=';
      }    

      $field = $nmField[$i];
      if ($field == 'KDJENIS') {
        $field = 'Kode Kulit';
      }

      if ($field == 'NMJENIS') {
        $field = 'Nama Kulit';
      }

      $data = $nmData[$i];

      if ($field != '' && $parameter != '' && $data != '') {
        $this->Cell(0,5,$field .' '.$parameter.' '.$data,'',0,'L');
        $this->ln();
      } else{
        $this->ln();
      }
  	}
  }

  $this->SetFont("arial","B",5);
  $this->Cell(10,4,"NO",'RLBT',0,'C');
  $this->Cell(30,4,"Kode Kulit",'RLBT',0,'C');
  $this->Cell(50,4,"Nama Kulit",'RLBT',0,'C');
  $this->ln();

 }

  function Footer()
 {
  global $xname,$xgroup,$brandApp;
 //Position at "n" cm from bottom
 $this->SetY(-20);
 //Arial italic 8
 $this->SetFont('Arial','',6);
 //Page number
// $this->Cell(0,10,'FM-MCH-008 - 4 Januari 13-01','',0,'L');
 $today = date("d/m/Y H:i:s");
 $this->Cell(0,10,'Tgl Cetak : '.$today .' by '.$xname.' # '.$xgroup,0,0,'L');
 $this->Cell(0,10,'Halaman ke : '.$this->PageNo().'/{nb}',0,0,'R');
 }

 }

 $pdf=new PDF('P','mm','A4');
 $pdf->AliasNbPages();
 $pdf->Open();
 $pdf->AddPage();
//left body margin
 $pdf->SetLeftMargin(10);

  $pdf->SetWidths(array(10,30,50));
  srand(microtime()*1000000);

  // $batas = 15;
  $row = 1;
  $result = mysql_query($txtSQL);
  while($data = mysql_fetch_array($result)){

    $pdf->SetFont('arial','',6);

    $column = 2;
    
    $pdf->Row(array($row,$data['kdjenis'],
                        $data['nmjenis']
                        ),
                array('C','C','C'),
                $column
                );

    $row++;
  }


$pdf->Output("laporanMasterJenisKulit.pdf",'I');
?>