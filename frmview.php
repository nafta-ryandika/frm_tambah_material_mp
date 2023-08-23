<?php
include("../../configuration.php");
include("../../connection.php");
include("actsearch.php");

    // Get Variabel

    //Cek Get Data
if(isset($_POST['txtpage'])){
  $txtpage = $_POST['txtpage'];
  $showPage = $txtpage;
  $noPage = $txtpage;
}else{
  $txtpage = 1;
  $showPage = $txtpage;
  $noPage = $txtpage;
}
if(isset($_POST['txtperpage'])){
  $txtperpage=$_POST['txtperpage'];
}else{
  $txtperpage=10;
}

$offset = ($txtpage - 1) * $txtperpage;
$sqlLIMIT = " LIMIT $offset, $txtperpage";
$sqlWHERE = " ";

if(isset($_POST['txtfield'])){
  if($_POST['txtfield']!=''){
    $txtfield = $_POST['txtfield'];

    if(isset($_POST['txtparameter'])){
      if ($_POST['txtparameter']!=''){
        $txtparameter = $_POST['txtparameter'];
      }
    }

    if(isset($_POST['txtdata'])){
      if ($_POST['txtdata']!=''){
        $txtdata = $_POST['txtdata'];
      }
    }

    $txtfieldx = explode("|",rtrim($txtfield,'|'));
    $txtparameterx = explode("|",rtrim($txtparameter,'|'));
    $txtdatax = explode("|",rtrim($txtdata,'|'));

    for($a=0;$a<count($txtfieldx);$a++){
      $sqlWHERE .= multisearch('cltmbhmatmp',$txtfieldx[$a],$txtparameterx[$a],$txtdatax[$a]);
    }
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Form View</title>
</head>

<!--<link rel="stylesheet" href="css/style.css" type="text/css" />-->
<!--<link rel="stylesheet" type="text/css" href="css/frmstyle.css" />-->
<?php
$xrdm = date("YmdHis");
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css?verion=$xrdm\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/frmstyle.css?version=$xrdm\" />";
?>
<!--<script type="text/javascript" src="js/jquery-latest.js"></script>
  <script type="text/javascript" src="js/jquery.tablesorter.js"></script>-->

  <script type="text/javascript">

  </script>


  <body>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
         <div id="frmisi">
          <table id="myTable" class="table">
            <thead>
              <tr>
               <th align="center">No</th>
               <!-- <th align="center"><INPUT type="checkbox" onchange="checkAll(this)" name="chk[]" /></th> -->
               <th align="center">No. MP</th>
               <th align="center">Subpkj</th>
               <th align="center">Materi</th>
               <th align="center">Colour</th>
               <th align="center">Supplier</th>
               <th align="center">Calc.</th>
               <th align="center">Qty</th>
               <th align="center">Satuan</th>
               <th align="center">Tgl</th>
               <th align="center">User</th>
             </tr>
           </thead>
           <tbody>
            <?php
            $sqlORDERBY="order by a.tgl desc";
            $sql =  "select a.mpno,(select ket from kmmstsubpkj where subpkj =  a.subpkj) as subpkj, a.materi, 
                    (select nmbrg from kmmstbhnbaku where kdbrg = a.materi) as nmbrg, a.colour,
                    (select nmsupp from kmmstsupp where kdsupp =  a.sup) as sup, a.calc, a.qty, a.nstn, a.tgl, a.userby 
                    from cltmbhmatmp a where 1";
                    
            $sqlCOUNT = "select count(a.mpno) as jumlah from cltmbhmatmp a where 1 ".$sqlWHERE."".$sqlORDERBY."";
 
            $result_1=mysql_query($sqlCOUNT,$conn);
            $data_1 = mysql_fetch_array($result_1);
            $count = $data_1["jumlah"];

            $sql=$sql.$sqlWHERE.$sqlORDERBY.$sqlLIMIT;
          // echo $sql."<br/>";
          // echo $sqlCOUNT."<br/>";
            $result=mysql_query($sql,$conn);

          // menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
            $jumPage = ceil($count/$txtperpage);

          //echo $count;
            if($count>0){
          // Register $myusername, $mypassword and redirect to file "login_success.php"
          //  $row = mysql_fetch_row($result);
              $row = $offset;
              while ($data = mysql_fetch_array($result, MYSQL_BOTH)){
                $row += 1;
                ?>
                <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                  <td align="center" nowrap><?php echo $row; ?></td>
                  <!-- <td align="center" nowrap><?php echo "<input id='chk'".$data['mpno']." type='checkbox' name='chk'".$data['mpno']." value='".$data["mpno"]."' >"; ?></td> -->
                  <td align="center" nowrap><?php echo $data["mpno"]; ?></td>
                  <td align="left" nowrap><?php echo $data["subpkj"]; ?></td>
                  <td align="left" nowrap><span style="color: green;"><?=$data["materi"]?></span><br/><?php echo $data["nmbrg"]; ?></td>
                  <td align="left" nowrap><?php echo $data["colour"]; ?></td>
                  <td align="left" nowrap><?php echo $data["sup"]; ?></td>
                  <td align="right" nowrap><?php echo $data["calc"]; ?></td>
                  <td align="right" nowrap><?php echo $data["qty"]; ?></td>
                  <td align="center" nowrap><?php echo $data["nstn"]; ?></td>
                  <td align="center" nowrap><?php echo $data["tgl"]; ?></td>
                  <td align="center" nowrap><?php echo $data["userby"]; ?></td>
                </tr>
                </tr>
                <?php
              }
              mysql_free_result($result);
            }
            ?>
          </tbody>
        </table>
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0" class="info_fieldset">
        <tr>
          <td><div align="left"><input id="jumpage" name="nmjmlrow" type="hidden" value="<?php echo $jumPage; ?>">Records: <?php echo ($offset + 1); ?> / <?php echo $row; ?> of <?php echo $count; ?> </div></td>
          <td>
            <div align="right">
              <?php

              echo "Page [ ";

// menampilkan link previous

              if ($txtpage > 1) {$prevpage = $txtpage - 1; echo  "<a href='#' onClick='showpage(".$prevpage.")'>&lt;&lt; Prev</a>";}

// memunculkan nomor halaman dan linknya

              for($page = 1; $page <= $jumPage; $page++)
              {
               if ((($page >= $noPage - 10) && ($page <= $noPage + 10)) || ($page == 1) || ($page == $jumPage))
               {
                if (($showPage == 1) && ($page != 2))  echo "...";
                if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "...";
                if ($page == $noPage) echo " <b>".$page."</b> ";
                else echo " <a href='#' onClick='showpage(".$page.")'>".$page."</a> ";
                $showPage = $page;
              }

//    echo " <a href='#' onClick='showpage(".$page.")'>".$page."</a> ";

            }

// menampilkan link next

            if ($txtpage < $jumPage) {$nextpage = $txtpage + 1; echo "<a href='#' onClick='showpage(".$nextpage.")'>Next &gt;&gt;</a>";}

            echo " ] ";

            ?>
          </div>
        </td>
      </tr>
    </table>
  </td>
</tr>
</table>
<FORM id="formexport" name="nmformexport" action="export.php" method="post" onsubmit="window.open ('', 'NewFormInfo', 'scrollbars,width=730,height=500')" target="NewFormInfo">
  <input id="txtSQL" name="nmSQL" type="hidden" value="<?php echo $sql; ?>">
  <input id="txtData" name="nmData" type="hidden" value="<?php echo $txtdata; ?>"/>
  <input id="txtField" name="nmField" type="hidden" value="<?php echo $txtfield; ?>"/>
  <input id="txtParameter" name="nmParameter" type="hidden" value="<?php echo $txtparameter; ?>"/>
</FORM>
</body>

</html>
<?php
mysql_close($conn);
?>
