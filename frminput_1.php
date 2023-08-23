<?php
  include("../../configuration.php");
  include("../../connection.php");

  if(isset($_POST['innomp'])){
    $innomp = strtoupper(htmlspecialchars($_POST['innomp']));
  }

  $sql = "select *, 
          (select nama from kmcustomer where cust = dt1.cust) as customer, 
          (select nmassort from clsizeassort where kdassort = dt2.rassort) as assortment 
          from
           (
          select a.cust, a.mpno, a.article, a.noso, a.colour, DATE_FORMAT(a.dd,'%d/%m/%Y') AS dd, a.tot, a.ket
          from clmphead a
          where a.mpno = '".$innomp."'
          )dt1
          left join
           (
          select b.rnomp,b.rassort, b.rkdbrgjd, DATE_FORMAT(b.rtglmp,'%d/%m/%Y') AS rtglmp
          from clemcmp b
          where b.rnomp = '".$innomp."'
          )dt2 on dt1.mpno = dt2.rnomp
          join (
          select *
          from clmpdet3 c
          where c.mpno = '".$innomp."'
          )dt3 on dt1.mpno = dt3.mpno and dt2.rkdbrgjd = dt3.kdbrg";
  $result = mysql_query($sql,$conn);
  $data = mysql_fetch_array($result);

  $artprod = trim($data["article"]);
  $artcust = trim($data["ket"]);
  $tglmp = trim($data["rtglmp"]);
  $tglkrm = trim($data["dd"]);
  $kdcust = trim($data["cust"]);
  $cust = trim($data["customer"]);
  $so = trim($data["noso"]);
  $warna = trim($data["colour"]);
  $assort = trim($data["assortment"]);
  $tot = floor(trim($data["tot"]));

  $d33 = $data["d33"];
  $d34 = $data["d34"];
  $d35 = $data["d35"];
  $d36 = $data["d36"];
  $d37 = $data["d37"];
  $d38 = $data["d38"];
  $d39 = $data["d39"];
  $d40 = $data["d40"];
  $d41 = $data["d41"];
  $d42 = $data["d42"];
  $d43 = $data["d43"];
  $d44 = $data["d44"];

  $d33s = $data["d33s"];
  $d34s = $data["d34s"];
  $d35s = $data["d35s"];
  $d36s = $data["d36s"];
  $d37s = $data["d37s"];
  $d38s = $data["d38s"];
  $d39s = $data["d39s"];
  $d40s = $data["d40s"];
  $d41s = $data["d41s"];
  $d42s = $data["d42s"];
  $d43s = $data["d43s"];
  $d44s = $data["d44s"];

  $url = "gambar/".$kdcust."-".$artprod.".jpg";

  $sql_1 = "select * from clkompmp where pcnomp = '".$innomp."'";
  $result_1  = mysql_query($sql_1,$conn);
  $count_1 = mysql_num_rows($result_1);
  $no_1 = 1;

  if ($count_1 > 0){
    $tambah = $count_1;
  }
  else{
    $tambah = 0;
  }
?>

<table>
  <tr>
    <td width="50%">
      <fieldset class="info_fieldset" style="" ><legend>View Detail MP</legend>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="width: 70%;" valign="top">
              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                   <td>
                      <label>Artikel Produksi</label>
                      <INPUT id="inartprod" class="textbox" type="text" name="intype" value="<?=$artprod?>" style="width: 200px" disabled><br />
                   </td>
                   <td>&nbsp;</td>
                </tr>
                <tr>
                   <td>
                      <label>Artikel Customer</label>
                      <INPUT id="inartcust" class="textbox" type="text" name="intype" value="<?=$artcust?>" style="width: 200px" disabled><br />
                   </td>
                   <td>&nbsp;</td>
                </tr>
                <tr>
                   <td>
                      <label>Tanggal Keluar MP</label>
                      <INPUT id="intglmp" class="textbox" type="text" name="intype" value="<?=$tglmp?>" style="width: 200px" disabled><br />
                   </td>
                   <td>&nbsp;</td>
                </tr>
                <tr>
                   <td>
                      <label>Tanggal Kirim</label>
                      <INPUT id="intglkrm" class="textbox" type="text" name="intype" value="<?=$tglkrm?>" style="width: 200px" disabled><br />
                   </td>
                   <td>&nbsp;</td>
                </tr>
                <tr>
                   <td>
                      <label>Customer</label>
                      <INPUT id="inkdcust" class="textbox" type="hidden" name="intype" value="<?=$kdcust?>" style="width: 200px" disabled>
                      <INPUT id="incust" class="textbox" type="text" name="intype" value="<?=$cust?>" style="width: 200px" disabled><br />
                   </td>
                   <td>&nbsp;</td>
                </tr>
                <tr>
                   <td>
                      <label>Sales Order</label>
                      <INPUT id="inso" class="textbox" type="text" name="intype" value="<?=$so?>" style="width: 200px" disabled>
                   </td>
                   <td>&nbsp;</td>
                </tr>
                <tr>
                   <td>
                      <label>Warna</label>
                      <INPUT id="incolour" class="textbox" type="text" name="intype" value="<?=$warna?>" style="width: 200px" disabled><br />
                   </td>
                   <td>&nbsp;</td>
                </tr>
                <tr>
                   <td>
                      <label>Assortment</label>
                      <INPUT id="inassort" class="textbox" type="text" name="intype" value="<?=$assort?>" style="width: 200px" disabled><br />
                   </td>
                   <td>&nbsp;</td>
                </tr>
                <tr>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                </tr>
              </table>
            </td>
            <td style="width: 30%;" valign="top">
              <div id="uploaded-picture_1" style="border:4px black inset;width: 120px; height: 120px;">
                <img src="../frm_pembuatan_mp/<?=$url?>" style="width: 120px; height: 120px;">
                <!-- <img src="../../../factory/frm/frmTiket/<?=$hgambar?>" style="width: 120px; height: 120px;"> -->
              </div>
            </td>
          </tr>
        </table>
        <table border="0" align="center" style="margin: 5px">
          <tr>
            <td align="center"><span id="33">S.33</span></td>
            <td align="center"><span id="34">S.34</span></td>
            <td align="center"><span id="35">S.35</span></td>
            <td align="center"><span id="36">S.36</span></td>
            <td align="center"><span id="37">S.37</span></td>
            <td align="center"><span id="38">S.38</span></td>
            <td align="center"><span id="39">S.39</span></td>
            <td align="center"><span id="40">S.40</span></td>
            <td align="center"><span id="41">S.41</span></td>
            <td align="center"><span id="42">S.42</span></td>
            <td align="center"><span id="43">S.43</span></td>
            <td align="center"><span id="44">S.44</span></td>
            <td align="center" rowspan="2"><span id="">Total Order</span></td>
          </tr>
          <tr>
            <td>
              <input id="indord33" class="textbox" type="text" name="intype_1" value="<?=$d33?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord34" class="textbox" type="text" name="intype_1" value="<?=$d34?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord35" class="textbox" type="text" name="intype_1" value="<?=$d35?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord36" class="textbox" type="text" name="intype_1" value="<?=$d36?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord37" class="textbox" type="text" name="intype_1" value="<?=$d37?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord38" class="textbox" type="text" name="intype_1" value="<?=$d38?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord39" class="textbox" type="text" name="intype_1" value="<?=$d39?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord40" class="textbox" type="text" name="intype_1" value="<?=$d40?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord41" class="textbox" type="text" name="intype_1" value="<?=$d41?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord42" class="textbox" type="text" name="intype_1" value="<?=$d42?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord43" class="textbox" type="text" name="intype_1" value="<?=$d43?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord44" class="textbox" type="text" name="intype_1" value="<?=$d44?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
          </tr>
          <tr>
            <td align="center"><span id="33s">S.33s</span></td>
            <td align="center"><span id="34s">S.34s</span></td>
            <td align="center"><span id="35s">S.35s</span></td>
            <td align="center"><span id="36s">S.36s</span></td>
            <td align="center"><span id="37s">S.37s</span></td>
            <td align="center"><span id="38s">S.38s</span></td>
            <td align="center"><span id="39s">S.39s</span></td>
            <td align="center"><span id="40s">S.40s</span></td>
            <td align="center"><span id="41s">S.41s</span></td>
            <td align="center"><span id="42s">S.42s</span></td>
            <td align="center"><span id="43s">S.43s</span></td>
            <td align="center"><span id="44s">S.44s</span></td>
          </tr>
          <tr>
            <td>
              <input id="indord33s" class="textbox" type="text" name="intype_1" value="<?=$d33s?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord34s" class="textbox" type="text" name="intype_1" value="<?=$d34s?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord35s" class="textbox" type="text" name="intype_1" value="<?=$d35s?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord36s" class="textbox" type="text" name="intype_1" value="<?=$d36s?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord37s" class="textbox" type="text" name="intype_1" value="<?=$d37s?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord38s" class="textbox" type="text" name="intype_1" value="<?=$d38s?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord39s" class="textbox" type="text" name="intype_1" value="<?=$d39s?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord40s" class="textbox" type="text" name="intype_1" value="<?=$d40s?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord41s" class="textbox" type="text" name="intype_1" value="<?=$d41s?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord42s" class="textbox" type="text" name="intype_1" value="<?=$d42s?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord43s" class="textbox" type="text" name="intype_1" value="<?=$d43s?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="indord44s" class="textbox" type="text" name="intype_1" value="<?=$d44s?>" maxlength="7" style="width: 40px; text-align:center;"  align="center" onkeydown="" onkeyup="" Placeholder="0" disabled>
            </td>
            <td>
              <input id="intot" class="textbox" type="text" name="intype" value="<?=$tot?>" maxlength="10" style="width: 70px; text-align:center;"  align="center" onkeyup="" Placeholder="0" disabled>
            </td>
          </tr>
        </table>
      </fieldset>
    </td>
    <td width="50%" valign="top">
      <fieldset class="info_fieldset" style="" id = "komposisi"><legend>Form Komposisi Packing <img id="addRow" src="img/plus.png" onclick="addRow('komposisi')" class="addRow" style="cursor: pointer; vertical-align: center;" title="Add Row" ></legend>
          <input type="hidden" id="row_komposisi" value="<?=0+($tambah)?>" size="3">
          <input type="hidden" id="row_id_komposisi" value="<?=$count_1?>" size="3">
          <table id="tabel_komposisi" class="tablesorter">
            <thead>
              <tr>
                <th align="center" style="width: 50%;">Kode</th>
                <th align="center" style="width: 15%;">J. Karton</th>
                <th align="center" style="width: 15%;">Cancel</th>
                <th align="center" style="width: 15%;">Output</th>
                <th align="center" style="width: 5%;">...</th>
              </tr>
            </thead>
            <tbody id="body_komposisi">
              <?php
                if ($count_1 > 0) {
                  while ($data_1 = mysql_fetch_array($result_1)) {
                    $kode = $data_1["pckdkomp"];
                    $karton = $data_1["pcqtykarton"];
                    $cancel = $data_1["pcqtycancel"];
                    $output = $data_1["pcqtyoutput"];

                    echo "<tr>";
                      echo "<td style=\"text-align: center;\">";
                        echo "<INPUT id=\"kode".$no_1."\" class=\"kode\" type='text' name='' onkeyup=\"\" onkeypress=\"getAutocomplete(this.id)\" style=\"width: 200px\" value=\"".$kode."\">";
                      echo "</td>";
                      echo "<td style=\"text-align: center;\">";
                        echo "<INPUT id=\"karton".$no_1."\" class=\"karton\" onkeyup=\"\" onkeydown=\"number(event)\" type='text' name='' placeholder=\"0\" style=\"width: 50px; text-align: center;\" value=\"".$karton."\">";
                      echo "</td>";
                      echo "<td style=\"text-align: center;\">";
                        echo "<INPUT id=\"cancel".$no_1."\" class=\"cancel\" onkeyup=\"\" onkeydown=\"number(event)\" type='text' name='' placeholder=\"0\" style=\"width: 50px; text-align: center;\" value=\"".$cancel."\">";
                      echo "</td>";
                      echo "<td style=\"text-align: center;\">";
                        echo "<INPUT id=\"output".$no_1."\" class=\"output\" onkeyup=\"\" onkeydown=\"number(event)\" type='text' name='' placeholder=\"0\" style=\"width: 50px; text-align: center;\" value=\"".$output."\" readonly>";
                      echo "</td>";
                      echo "<td style=\"text-align: center;\">";
                        echo "<img id=\"remove".$no_1."\" class=\"remove\" src=\"img/delete.png\" onclick=\"removeRow(this,'komposisi')\" style=\"cursor: pointer; vertical-align: center;\" title=\"Delete Row\" >";
                      echo "</td>";
                    echo "</tr>";
                    $no_1++;
                  }
                }
              ?>
            </tbody>
          </table>
      </fieldset>
    </td>
  </tr>
</table>