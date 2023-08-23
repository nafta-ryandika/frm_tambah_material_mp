<?php
  include("../../configuration.php");
  include("../../connection.php");
?>

<fieldset class="info_fieldset"><legend>Form Input</legend>
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        <label>No. Bukti</label>
        <INPUT id="innobukti" class="textbox" type="text" name="intype" value="" onkeypress="" onkeydown="" style="width: 250px;" disabled><br/>
      </td>
    </tr>
    <tr>
      <td>
        <label>Pekerjaan</label>
        <select class='txtfield' name="intype" id="inpkj" onkeypress="enterInput(event,this.id)" style="margin-bottom: 5px;">
          <option value=''>-</option>
          <?php
          $sql = "SELECT pkj, ket FROM kmmstpkj ORDER BY pkj";
          $result = mysql_query($sql,$conn);
          while ($data = mysql_fetch_array($result)) {
          ?>
              <option value="<?php echo $data["pkj"]?>"><?php echo $data["ket"]?></option>;
          <?php
          }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        <label>Sub Pekerjaan</label>
        <INPUT id="insubpkjx" class="textbox" type="hidden" name="intype" value="" >
        <INPUT id="insubpkj" class="textbox" type="text" name="intype" value="" onkeypress="getAutocomplete(this.id)" onkeydown="enterInput(event,this.id)" style="width: 300px;"><br/>
      </td>
    </tr>
    <tr>
      <td>
        <label>Nama Barang</label>
        <INPUT id="innmbrgx" class="textbox" type="hidden" name="intype" value="" >
        <INPUT id="innmbrg" class="textbox" type="text" name="intype" value="" onkeypress="getAutocomplete(this.id)" onkeydown="enterInput(event,this.id)" style="width: 500px;"><br/>
      </td>
    </tr>
    <tr>
      <td>
        <label>Satuan</label>
        <select class='txtfield' name="intype" id="insatuan" onkeypress="enterInput(event,this.id)" style="margin-bottom: 5px;">
          <option value=''>-</option>
          <?php
          $sql = "SELECT satuan, nmsatuan FROM kmsatuan ORDER BY satuan";
          $result = mysql_query($sql,$conn);
          while ($data = mysql_fetch_array($result)) {
          ?>
              <option value="<?php echo $data["satuan"]?>"><?php echo $data["satuan"]?></option>;
          <?php
          }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        <label>Nama Supplier</label>
        <INPUT id="innmsuppx" class="textbox" type="hidden" name="intype" value="" >
        <INPUT id="innmsupp" class="textbox" type="text" name="intype" value="" onkeypress="getAutocomplete(this.id)" onkeydown="enterInput(event,this.id)" style="width: 300px;"><br/>
      </td>
    </tr>
    <tr>
      <td>
        <label>Kalkulasi</label>
        <INPUT id="inkalkulasi" class="textbox" type="text" name="intype" value="" style="text-align: right;" onkeydown="number(event); enterInput(event, this.id)" >
      </td>
    </tr>
    <tr>
      <td>
        <label>No. MP</label>
        <INPUT id="innomp" class="textbox" type="text" name="intype" value="" onkeydown="enterInput(event,this.id)" style="">
      </td>
    </tr>
    <tr>
      <td>
        <label>Qty. Order</label>
        <INPUT id="inqtyorder" class="textbox" type="text" name="intype" value="" style="text-align: right;" onkeydown="number(event)" disabled>
      </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <div align="center" style="margin: 10px;">
          <INPUT id="cmdadd" class="buttonadd" type="button" name="nmcmdadd" value="Add" onclick="checkmp()">
        </div>
      </td>
    </tr>
  </table>
  <fieldset class="info_fieldset" style="margin-right: 10px; padding: 10px;"><legend>Data MP</legend>
      <input type="hidden" id="row_content" value="<?=0+($tambah)?>" size="3">
      <input type="hidden" id="row_id_content" value="<?=$count_1+1?>" size="3">
      <table id="table_content" class="table">
        <thead>
          <tr>
            <th align="center" style="width: ;">No. MP</th>
            <th align="center" style="width: ;">Pekerjaan</th>
            <th align="center" style="width: ;">Sub-Pekerjaan</th>
            <th align="center" style="width: ;">Nama Barang</th>
            <th align="center" style="width: ;">Supplier</th>
            <th align="center" style="width: ;">Satuan</th>
            <th align="center" style="width: ;">Kalkulasi</th>
            <th align="center" style="width: ;">Qty Order</th>
            <th align="center" style="width: ;">...</th>
          </tr>
        </thead>
        <tbody id="body_komposisi">
          
        </tbody>
      </table>
  </fieldset>
  <div align="center" style="margin: 10px;">
    <INPUT id="cmdsave" class="buttonadd" type="button" name="nmcmdsave" value="Save" onclick="saveclick()">
    <INPUT id="cmdcancel" class="buttondelete" type="button" name="nmcmdcancel" value="Cancel" onclick="cancelclick()">
  </div>
</fieldset>


<script type="text/javascript">
  $("input[name=intype]").bind("keydown", function(event) {
    if (event.which === 13) {
      event.stopPropagation();
      event.preventDefault();
      $(':input:eq(' + ($(':input').index(this) + 1) +')').focus();
    }
  });
</script>