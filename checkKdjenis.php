<?php
  include("../../connection.php");

  $inkdjenis = strtoupper(htmlspecialchars($_POST['inkdjenis']));

  $sqlCheck = "SELECT COUNT(kdjenis) FROM kmjeniskulit WHERE kdjenis = '".$inkdjenis."'";  
  $result =  mysql_query($sqlCheck,$conn);
  $rowCount =  mysql_result($result,0);

  if($rowCount > 0) {
    echo "<span id='status-not-available' class='status-not-available'> Kode Sudah Ada !</span>";
    // echo($rowCount);
  } 
  else {
    echo "<span id='status-available' class='status-available'>Available</span>";
    // echo($rowCount);
  }
?>