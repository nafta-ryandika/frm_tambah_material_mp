<?php

include("../../configuration.php");
include("../../connection.php");
include("../../endec.php");
date_default_timezone_set("Asia/Bangkok");

// Action input php
if(isset($_POST['intxtmode'])){
  $intxtmode = $_POST['intxtmode'];
}
if(isset($_POST['innomp'])){
  $innomp = strtoupper(htmlspecialchars(trim($_POST['innomp'])));
}
if(isset($_POST['inqtyorder'])){
  $inqtyorder = strtoupper(htmlspecialchars(trim($_POST['inqtyorder'])));
}
if(isset($_POST['innobukti'])){
  $innobukti = strtoupper(htmlspecialchars(trim($_POST['innobukti'])));
}
if(isset($_POST['inpkj'])){
  $inpkj = strtoupper(htmlspecialchars(trim($_POST['inpkj'])));
}
if(isset($_POST['insubpkj'])){
  $insubpkj = strtoupper(htmlspecialchars(trim($_POST['insubpkj'])));
}
if(isset($_POST['innmbrg'])){
  $innmbrg = strtoupper(htmlspecialchars(trim($_POST['innmbrg'])));
}
if(isset($_POST['insatuan'])){
  $insatuan = strtoupper(htmlspecialchars(trim($_POST['insatuan'])));
}
if(isset($_POST['innmsupp'])){
  $innmsupp = strtoupper(htmlspecialchars(trim($_POST['innmsupp'])));
}
if(isset($_POST['inkalkulasi'])){
  $inkalkulasi = strtoupper(htmlspecialchars(trim($_POST['inkalkulasi'])));
}

if($intxtmode=='add'){
  $innomp = explode("|",rtrim($innomp,'|'));
  $inqtyorder = explode("|",rtrim($inqtyorder,'|'));

  $nopkj = "";

  if ($inpkj == "ASSEMBLY") {
    $nopkj = 1;
  }
  else if ($inpkj == "BOTTOM"){
    $nopkj = 2;
  }
  else if ($inpkj == "CUTTING L"){
    $nopkj = 3;
  }
  else if ($inpkj == "CUTTING NL"){
    $nopkj = 4;
  }
  else if ($inpkj == "STITCHING"){
    $nopkj = 5;
  }
  

  for ($i=0; $i < count($innomp); $i++) {
    // cari max nosubpkj
    $sql = "SELECT MAX(a.nosubpkj) AS maxnosubpkj FROM clmpdet2 a WHERE a.mpno = '".$innomp[$i]."' AND a.nopkj = '".$nopkj."'";
    $result = mysql_query($sql,$conn);
    $data = mysql_fetch_array($result);

    $maxnosubpkj = $data["maxnosubpkj"];

    if ($maxnosubpkj > 0) {
      $maxnosubpkj++;
    }
    else{
      $maxnosubpkj = 1;
    }

    $sql_1 = "INSERT into clmpdet2 
            (mpno,nopkj,nosubpkj,subpkj,materi,colour,sup,calc,qty,stn,nstn,ambil,backorder) 
            VALUES 
            ('".$innomp[$i]."','".$nopkj."','".$maxnosubpkj."','".$insubpkj."','".$innmbrg."','NON','".$innmsupp."','".$inkalkulasi."','".($inkalkulasi*$inqtyorder[$i])."','','".$insatuan."','','')";

    if (!mysql_query($sql_1,$conn)){
      die('Error (Insert clmpdet2) : ' . mysql_error());
    }

    $sql_2 = "INSERT INTO cltmbhmatmp 
             (mpno,nopkj,nosubpkj,subpkj,materi,colour,sup,calc,qty,stn,nstn,nobukti,tgl,access,komp,userby,qpass) 
             VALUES 
             ('".$innomp[$i]."','".$nopkj."','".$maxnosubpkj."','".$insubpkj."','".$innmbrg."', 'NON','".$innmsupp."','".$inkalkulasi."','".($inkalkulasi*$inqtyorder[$i])."','','".$insatuan."','".$innobukti."',CURDATE(),NOW(),'".$_SESSION[$domainApp."_mygroup"]." # ".$_SESSION[$domainApp."_mylevel"]."','".$_SESSION[$domainApp."_myname"]."','')";
    if (!mysql_query($sql_1,$conn)){
      die('Error (Insert cltmbhmatmp) : ' . mysql_error());
    }
  }
  // print_r($inkomposisi);
  echo(1);
}
elseif($intxtmode=='checkmp'){
  $sql = "SELECT IF(ISNULL(a.rtglpost),0,1) AS status FROM clemcmp a WHERE a.rnomp = '".$innomp."'";
  $result = mysql_query($sql,$conn);
  $data = mysql_fetch_array($result);
  $status_clemcmp = $data["status"];

  if ($status_clemcmp == 1) {
    echo("clemcmp");
  }
  else{
    $sql_1 = "SELECT a.mpno, a.tot FROM clmphead a WHERE a.mpno = '".$innomp."'";
    $result_1 = mysql_query($sql_1,$conn);
    $count_1 = mysql_num_rows($result_1);

    if ($count_1 > 0) {
      $sql_2 = "SELECT mpno FROM clmpdet2 WHERE mpno = '".$innomp."' AND materi = '".$innmbrg."' AND subpkj = '".$insubpkj."'";
      $result_2 = mysql_query($sql_2,$conn);
      $count_2 = mysql_num_rows($result_2);

      if ($count_2 > 0) {
        echo("clmpdet2");
      }
      else{
        $data_1 = mysql_fetch_array($result_1);
        $tot = $data_1["tot"];
        echo($tot);
      }
    }
    else{
      echo("clmphead");
    }
  }
  mysql_free_result($result);
}
elseif($intxtmode=='getnobukti'){
  $month = date("m");
  $year = date("Y");
  // get counter number
  $sql_4 = "SELECT ccounter FROM rlcounter WHERE ckode = 'TMMP' AND cbultah = '".$month.$year."'";
  $result_4 = mysql_query($sql_4,$conn);
  $row_4 = mysql_num_rows($result_4);

  if ($row_4 == 0) {
    $sql_5 = "INSERT INTO rlcounter 
              (
              ckode, cnama, cbultah, ccounter, access, userby, entry, `lock`
              ) 
              VALUES 
              (
              'TMMP', 'TAMBAH MAT. DI BANYAK MP', '".$month.$year."', 0, now(), '".$_SESSION[$domainApp."_myname"]."', 
              (SELECT curtime()), NULL
              )";
    if (!mysql_query($sql_5,$conn)){
      die('Error (Insert Counter): ' . mysql_error());
    }
    $incounter = 1;
  }
  else{
    $data_4 = mysql_fetch_array($result_4);
    $incounter = ($data_4["ccounter"]) + 1;
  }

  // update counter number
  $sql_9 = "UPDATE rlcounter SET
            ccounter = '".$incounter."',
            access = now(),
            userby = '".$_SESSION[$domainApp."_myname"]."',
            entry = (SELECT curtime())
            WHERE
            ckode = 'TMMP' AND cbultah = '".$month.$year."'";
  if (!mysql_query($sql_9,$conn)){
    die('Error (Update Counter): ' . mysql_error());
  }

  //create no bukti
  $nobukti = "TMMP/".$month.$year."/".sprintf("%07s", $incounter);
  echo($nobukti);
}
// close connection !!!!
mysql_close($conn);
?>