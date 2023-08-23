<?php
include("../../connection.php");

$q = strtolower($_GET['term']);
$query = "SELECT trim(subpkj), trim(ket) FROM kmmstsubpkj WHERE trim(ket) LIKE '$q' ORDER BY subpkj, ket limit 50";
$query = mysql_query($query);
$num = mysql_num_rows($query);

if($num > 0){
  	while ($row = mysql_fetch_array($query)){
      $row_set[] = array('value' => stripslashes($row[0]),'label' => stripslashes($row[1]));
  	}
echo json_encode($row_set);
}
?>