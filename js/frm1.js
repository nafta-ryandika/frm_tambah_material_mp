$(document).ready(function(){
    $("#frmloading").hide();
    $("#tabelinput").hide();
    // findclick();
  }
);

function enterfind(event){
  if(event.keyCode==13){
    findclick();
  }else{
    return ;
  }
};

function findclick(){
  var n = $(".txtfield").length;
  var txtfield = '';
  var txtparameter = '';
  var txtdata = '';
  var data = '';
  
  if(n > 1){
    $(".txtfield").each(function () {
      txtfield += $(this).val()+"|";
    });
    
    $(".txtparameter").each(function () {
      txtparameter += $(this).val()+"|";
    });
        
    $(".txtdata").each(function () {
      txtdata += $(this).val()+"|";
    });
            
    data = "txtpage="+$("#txtpage").val()+
         "&txtperpage="+$("#txtperpage").val()+
         "&txtfield="+txtfield+
         "&txtparameter="+txtparameter+
         "&txtdata="+txtdata+
         "";   
  }
  else{
    data = "txtpage="+$("#txtpage").val()+
         "&txtperpage="+$("#txtperpage").val()+
         "&txtfield="+$(".txtfield").val()+
         "&txtparameter="+$(".txtparameter").val()+
         "&txtdata="+$(".txtdata").val()+
         "";
  }
               
  $("#frmbody").slideUp('slow',function(){
    $("#frmloading").slideDown('slow',function(){
    	$.ajax({
    		url: "frmview.php",
    		type: "POST",
    		data: data,
    		cache: false,
    		success: function (html) {
          			$("#frmcontent").html(html);
                $("#frmbody").slideDown('slow',function(){
                $("#frmloading").slideUp('slow');
          });
          }
    	});
    });
  });
};

function findclick_1(){
  var data = "innomp="+$("#innomp").val()+"";
               
  $("#frmbody_1").slideUp('slow',function(){
    $("#frmloading_1").slideDown('slow',function(){
      $.ajax({
        url: "frminput_1.php",
        type: "POST",
        data: data,
        cache: false,
        success: function (html) {
                $("#frmcontent_1").fadeIn("slow");
                $("#frmcontent_1").html(html);
                $("#frmbody_1").slideDown('slow',function(){
                $("#frmloading_1").slideUp('slow');
                $("#komposisi").show();
                $("#cmdaddrow").show();
          });
          }
      });
    });
  });
}

function addnewclick(){
  showinput();
  clearinput();
  $("#intxtmode").val('add');
  $("#mode").text('Add New');
  $("#tabelview").fadeOut("slow",function(){
    $("#tabelinput").fadeIn("slow");
    $("#inpkj").focus();
  });
};
    
function showinput(){
  $.ajax({
    url: "frminput.php",
    cache: false,
    success: function(html) {
            $("#areainput").html(html);
    }
  });
}

function deleteclick(){
  var n = $("input:checked").length;
  if(n==0){
    alert('Pilih data untuk menghapus');
  }
  else if (confirm("Hapus Data ?")){
    var check = $("#chk:checked").length;
    $("input:checked").each(function () {
      $("#intxtmode").val('delete');
      var data = "intxtmode=delete&innomp="+$(this).val()+"";
      $.ajax({
      	url: "actfrm.php",
      	type: "POST",
      	data: data,
      	cache: false,
      	success: function(data) {
                // alert(data);
        }
      });
    });
    alert(check+" data berhasil dihapus");
    findclick();
  }
};

function editclick(){
  var n = $("input:checked").length;
  if (n>1){
    alert('Maksimal pilih 1 data');
  }
  else if(n==0){
    alert('Pilih data untuk mengubah');
  }
  else{
    showinput();
    clearinput();
    $("#intxtmode").val('edit');
    $("#mode").text('Edit');
    var data = "intxtmode=getedit&innomp="+$("input:checked").val()+"";
    $.ajax({
    	url: "actfrm.php",
    	type: "POST",
    	data: data,
    	cache: false,
    	success: function(data) {
              // alert(data);
              $("#areaedit").html(data);
              $("#frmloading_1").hide();
              setinput();
              $("#tabelview").fadeOut("slow",function(){
              $("#tabelinput").fadeIn("slow");
              $("#innomp").attr('disabled',true);
              findclick_1();
        });
        }
    });
  };
};

function exportclick(){
  if ($("#txtSQL").val() == "") {
    alert("Search Data Terlebih Dahulu !");
  }
  else {
    var randomnumber=Math.floor(Math.random()*11)
    var exptype = $("#exporttype").val();
    switch (exptype)
    {
    case 'grd':
      $("#formexport").attr('action', 'frmviewgrid.php');
      $("#formexport").submit();
      break;
    case 'pdf':
      $("#formexport").attr('action', 'frmviewpdf.php');
      $("#formexport").submit();
      break;
    case 'xls':
      $("#formexport").attr('action', 'frmviewxls.php');
      $("#formexport").submit();
      break;
    case 'csv':
      $("#formexport").attr('action', 'frmviewcsv.php');
      $("#formexport").submit();
      break;
    case 'txt':
      $("#formexport").attr('action', 'frmviewtxt.php');
      $("#formexport").submit();
      break;
    default:
      alert('Unidentyfication Type');
    }
  }
};

function setinput(){
  $("#innomp").val($("#getnomp").text());
  $("#inseasonx").val($("#getseasonx").text());
  $("#inseason").val($("#getseason").text());
  $("#inpic").val($("#getpic").text());
  $("#inpengiriman").val($("#getpengiriman").text());
};

function clearinput(){
  $("#areainput").html('');
};

function disabled(){
  $("#inpkj").attr('disabled',true);
  $("#insubpkj").attr('disabled',true);
  $("#innmbrg").attr('disabled',true);
  $("#innmsupp").attr('disabled',true);
  $("#insatuan").attr('disabled',true);
  $("#inkalkulasi").attr('disabled',true);
};

function enabled(){
  $("#inpkj").attr('disabled',false);
  $("#insubpkj").attr('disabled',false);
  $("#innmbrg").attr('disabled',false);
  $("#innmsupp").attr('disabled',false);
  $("#insatuan").attr('disabled',false);
  $("#inkalkulasi").attr('disabled',false);
};

function resetinput(){
  $("#innobukti").val("");
  $("#inpkj").val("");
  $("#insubpkjx").val("");
  $("#insubpkj").val("");
  $("#innmbrgx").val("");
  $("#innmbrg").val("");
  $("#insatuan").val("");
  $("#innmsuppx").val("");
  $("#innmsupp").val("");
  $("#inkalkulasi").val("");
  $("#innomp").val("");
  $("#inqtyorder").val("");
}

function saveclick(){
  $("#cmdsave").attr('disabed','disabled');

  var innomp = "";
  var inqtyorder = "";

  if($(".nomp").length > 0){
    $(".nomp").each(function(){
      innomp += $(this).text()+"|";
    })
  }

  if($(".qtyorder").length > 0){
    $(".qtyorder").each(function(){
      inqtyorder += $(this).val()+"|";
    })
  }

  var data = "intxtmode="+$("#intxtmode").val()+
             "&innomp="+encodeURIComponent(innomp)+
             "&inqtyorder="+encodeURIComponent(inqtyorder)+
             "&innobukti="+encodeURIComponent($("#innobukti").val())+
             "&inpkj="+encodeURIComponent($("#inpkj").val())+
             "&insubpkj="+encodeURIComponent($("#insubpkjx").val())+
             "&innmbrg="+encodeURIComponent($("#innmbrgx").val())+
             "&insatuan="+encodeURIComponent($("#insatuan").val())+
             "&innmsupp="+encodeURIComponent($("#innmsuppx").val())+
             "&inkalkulasi="+encodeURIComponent($("#inkalkulasi").val())+
             "";
  // console.log(data);

  $.ajax({
  	url: "actfrm.php",
  	type: "POST",
  	data: data,
  	cache: false,
  	success: function(data) {
             if (data == 1) {
                alert('Data berhasil disimpan'); 
                resetinput();
                clearRow();

                $("#row_content").val(0);
                $("#row_id_content").val(1);
             }
             else{
              alert(data);
             }
             
            $("#cmdsave").attr('disabed','');
    }
  });
};

function cancelclick(){
  clearinput();
  $("#intxtmode").val('');
  $("#mode").text('');
  $("#tabelinput").fadeOut("slow",function(){
    $("#tabelview").fadeIn("slow");
  });
  $("#frmcontent").html("");
};

function getAutocomplete(id){
  if(id == "insubpkj"){  
    var url = "get_subpkj.php";
  }
  else if(id == "innmbrg"){  
    var url = "get_nmbrg.php";
  }
  else if(id == "innmsupp"){  
    var url = "get_nmsupp.php";
  }

  $("#"+id).autocomplete({
    source: url,
    focus: function(event, ui) {
      event.preventDefault();
      $("#"+id+"x").val(ui.item.value);
      $("#"+id).val(ui.item.label);

      if (id == "innmbrg") {
        $("#insatuan").val(ui.item.satuan);
      }
    },
    select: function (event, ui) {
      event.preventDefault();
      $("#"+id+"x").val(ui.item.value);
      $("#"+id).val(ui.item.label);

      if (id == "innmbrg") {
        $("#insatuan").val((ui.item.satuan).trim());
      }
    }
  });
}

function checkmp(){
  if ($("#innomp").val() == "") {
    alert("Input No MP Kosong !");
  }
  else {
    var data = "intxtmode=checkmp&innomp="+$("#innomp").val()+
               "&insubpkj="+encodeURIComponent($("#insubpkjx").val())+
               "&innmbrg="+encodeURIComponent($("#innmbrgx").val());
    $.ajax({
      url: "actfrm.php",
      data: data,
      type: "POST",
      dataType: "html",
      success:function(data){
              if (data == "clmphead") {
                alert("Data Header No MP "+$("#innomp").val()+" Tidak Ada !");
              }
              else if (data == "clemcmp") {
                alert("No MP "+$("#innomp").val()+" Sudah di Issued !");
              }
              else if (data == "clmpdet2") {
                alert("Kode Barang dengan Sub Pekerjaan Tersebut Sudah Ada !");
              }
              else{
                $("#inqtyorder").val(data);
                if (confirm("Qty Order :"+data+ "?")) {
                  $("#cmdadd").focus();
                  add();
                }
                else{
                  $("#inqtyorder").val("");
                }
              }
      }
    });
  }
}

function getnobukti(){
  var data = "intxtmode=getnobukti";
  $.ajax({
    url: "actfrm.php",
    type: "POST",
    data: data,
    cache: false,
    success: function(data) {
             $("#innobukti").val(data);
    }
  });
}

function add(){
  if ($("#innobukti").val() == "") {
    getnobukti();
  }

  var table = document.getElementById('table_content').getElementsByTagName('tbody')[0];
  var row = table.insertRow(eval($("#row_content").val()));
  var data = $("#row_id_content").val();
  
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  var cell5 = row.insertCell(4);
  var cell6 = row.insertCell(5);
  var cell7 = row.insertCell(6);
  var cell8 = row.insertCell(7);
  var cell9 = row.insertCell(8);

  cell1.style.textAlign="center";
  cell2.style.textAlign="center";
  cell3.style.textAlign="center";
  cell4.style.textAlign="center";
  cell5.style.textAlign="center";
  cell6.style.textAlign="center";
  cell7.style.textAlign="center";
  cell8.style.textAlign="center";
  cell9.style.textAlign="center";
  
  var nomp  = $("#innomp").val();
  var pkj = $("#inpkj").val();
  var subpkjx = $("#insubpkjx").val();
  var subpkj = $("#insubpkj").val();
  var nmbrgx = $("#innmbrgx").val();
  var nmbrg = $("#innmbrg").val();
  var nmsuppx = $("#innmsuppx").val();
  var nmsupp = $("#innmsupp").val();
  var satuan = $("#insatuan").val();
  var kalkulasi = $("#inkalkulasi").val();
  var qtyorder = $("#inqtyorder").val();

  cell1.innerHTML = "<span id=\"nomp"+data+"\" class=\"nomp\">"+nomp.toUpperCase()+"</span>";
  cell2.innerHTML = "<span id=\"pkj"+data+"\" class=\"pkj\">"+pkj.toUpperCase()+"</span>";
  cell3.innerHTML = "<span id=\"subpkj"+data+"\" class=\"subpkj\">"+subpkj.toUpperCase()+"</span>\n\
                     <input id=\"subpkjx"+data+"\" class=\"subpkjx\" type='hidden' name='' value=\""+subpkjx+"\" style=\"width: 100px\">";
  cell4.innerHTML = "<span id=\"nmbrg"+data+"\" class=\"nmbrg\">"+nmbrg.toUpperCase()+"</span>\n\
                     <input id=\"nmbrgx"+data+"\" class=\"nmbrgx\" type='hidden' name='' value=\""+nmbrgx+"\" style=\"width: 100px\">";
  cell5.innerHTML = "<span id=\"nmsupp"+data+"\" class=\"nmsupp\">"+nmsupp.toUpperCase()+"</span>\n\
                     <input id=\"nmsuppx"+data+"\" class=\"nmsuppx\" type='hidden' name='' value=\""+nmsuppx+"\" style=\"width: 100px\">";
  cell6.innerHTML = "<span id=\"satuan"+data+"\" class=\"satuan\">"+satuan.toUpperCase()+"</span>";
  cell7.innerHTML = "<span id=\"kalkulasi"+data+"\" class=\"kalkulasi\">"+kalkulasi+"</span>";
  cell8.innerHTML = "<span id=\"qtyorder"+data+"\" class=\"qtyorder\">"+qtyorder.toUpperCase()+"</span>";
  cell9.innerHTML = "<img id=\"remove"+data+"\" class=\"remove\" src=\"img/delete.png\" onclick=\"removeRow(this,'content')\" style=\"cursor: pointer; vertical-align: center;\" title=\"Delete Row\" >";

  $("#row_content").val(eval($("#row_content").val())+1);
  $("#row_id_content").val(eval($("#row_id_content").val())+1);

  $("#innomp").val("");
  $("#inqtyorder").val("");
  $("#innomp").focus();
}

function removeRow(row,id){
  if (confirm("Delete Data?")){
    var row = row.parentNode.parentNode;
    row.parentNode.removeChild(row);
    $("#row_content").val(eval($("#row_content").val())-1);
  }
}

function clearRow(){
  var table = document.getElementById('table_content');
  var row = document.getElementsByTagName('tbody')[0];

    row.parentNode.removeChild(row);
}

function enterInput(event,id){
  if (event.keyCode == 13) {
    if (id == "inpkj") {
      $("#insubpkj").focus();
    } 
    else if (id == "insatuan") {
      $("#innmsupp").focus();
    } 
    else if (id == "insubpkj") {
      $("#innmbrg").focus();
    }
    else if (id == "innmbrg") {
      $("#insatuan").focus();
    }
    else if (id == "innmsupp") {
      $("#inkalkulasi").focus();
    }
    else if (id == "inkalkulasi") {
      if (confirm("Input Data sudah Benar ?")){
        disabled();
      }
    }
    else if (id == "innomp") {
      checkmp();
    }
  }
}

function number(e){
  // Allow: backspace, delete, tab, escape, enter and .
  if (
    $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
    // Allow: Ctrl/cmd+A
    (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
    // Allow: Ctrl/cmd+C
    (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
    // Allow: Ctrl/cmd+V
    (e.keyCode == 86 && (e.ctrlKey === true || e.metaKey === true)) ||
    // Allow: Ctrl/cmd+X
    (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
    // Allow: home, end, left, right
    (e.keyCode >= 35 && e.keyCode <= 39)
  ) {
    // let it happen, don't do anything
    return;
  }
  // Ensure that it is a number and stop the keypress
  if (
    (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
    (e.keyCode < 96 || e.keyCode > 105)
  ) {
    e.preventDefault();
  }
}

function searchclick(){
  if ($("#areasearch").is(":hidden")) {
    $("#areasearch").slideDown("slow");
  }
  else {
    $("#areasearch").slideUp("slow");
  }
};

// ******************************* START JS MULTISEARCH ***************************************
  var xrow = 1;

function addSearch(){
  var table = document.getElementById("tblSearch");

  // Create an empty <tr> element and add it to the 1st position of the table:
  var row = table.insertRow(xrow);

  // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  var cell5 = row.insertCell(4);
        
  //  cell2.className = 'txtmultisearch';

  // Add some text to the new cells:
  cell1.innerHTML = "Field : \n\
          <select class='txtfield'>\n\
          <option value=''>-</option>\n\
          <option value='mpno'>No. MP</option>\n\
          <option value='materi'>Kode Material</option>\n\
          <option value='userby'>User</option>\n\
          </select>";
  cell2.innerHTML = "<select class='txtparameter'>\n\
              <option value='equal'>equal</option>\n\
              <option value='notequal'>not equal</option>\n\
              <option value='less'>less</option>\n\
              <option value='lessorequal'>less or equal</option>\n\
              <option value='greater'>greater</option>\n\
              <option value='greaterorequal'>greater or equal</option>\n\
              <option value='isnull'>is null</option>\n\
              <option value='isnotnull'>is not null</option>\n\
              <option value='isnotnull'>is not null</option>\n\
              <option value='isin'>is in</option>\n\
              <option value='isnotin'>is not in</option>\n\
              <option value='like'>like</option>\n\
          </select>";
  cell3.innerHTML = "Data : <input type='text' class='txtdata' onkeydown='enterfind(event)'>";
  cell4.innerHTML = "<input type='button' value='[+]' onclick='addSearch()'>";
  cell5.innerHTML = "<input type='button' value='remove' onclick=\"deleteRow(this)\" style='cursor:pointer;'>";

  xrow++;
}

function deleteRow(btn) {
  if (btn == "rmv1") {
    $("#txtfield0").val("");
    $("#txtparameter0").val("equal");

    var data_select =
    "Data : <input type='text' class='txtdata' onkeydown='enterfind(event)'>";

    $("#filter_data0").html(data_select);
    $("#txtdata0").val("");
  } 
  else {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    xrow--;
  }
}

// ******************************* END JS MULTISEARCH ***************************************

function showpage(page){
  $("#txtpage").val(page);
  findclick();
}

function prevpage(){
  var n = eval($("#txtpage").val())-1 ;
  if (n >= 1) {
    $("#txtpage").val(n);
    findclick();
  }
}

function nextpage(){
  var n = eval($("#txtpage").val())+1 ;
  if (eval(n)<=eval($("#jumpage").val())){
    $("#txtpage").val(n);
    findclick();
  }
}

$(function() {
	$( "#tglmasuk" ).datepicker({
    dateFormat: "dd/mm/yy",
    changeMonth : true,
    changeYear  : true
  });
  $( "#tglkontrak" ).datepicker({
    dateFormat: "dd/mm/yy",
    changeMonth : true,
    changeYear  : true
  });
  $( "#intxttglmasuk" ).datepicker({
    dateFormat: "dd/mm/yy",
    changeMonth : true,
    changeYear  : true
  });
  $( "#intxttglkontrak" ).datepicker({
    dateFormat: "dd/mm/yy",
    changeMonth : true,
    changeYear  : true
  });
});


function MyValidDate(dateString){
  var validformat=/^\d{1,2}\/\d{1,2}\/\d{4}$/ //Basic check for format validity
  if (!validformat.test(dateString)){
      return ''
  }
  else{ //Detailed check for valid date ranges
    var dayfield=dateString.substring(0,2);
    var monthfield=dateString.substring(3,5);
    var yearfield=dateString.substring(6,10);
    var MyNewDate = monthfield + "/" + dayfield + "/" + yearfield;
    
    if (checkValidDate(MyNewDate)==true){
      var SQLNewDate = yearfield + "/" + monthfield + "/" + dayfield;
      return SQLNewDate;
    }
    else{
      return '';
    }
  }
}

function checkValidDate(dateStr) {
    // dateStr must be of format month day year with either slashes
    // or dashes separating the parts. Some minor changes would have
    // to be made to use day month year or another format.
    // This function returns True if the date is valid.
    var slash1 = dateStr.indexOf("/");
    if (slash1 == -1) { slash1 = dateStr.indexOf("-"); }
    // if no slashes or dashes, invalid date
    if (slash1 == -1) { return false; }
    var dateMonth = dateStr.substring(0, slash1)
    var dateMonthAndYear = dateStr.substring(slash1+1, dateStr.length);
    var slash2 = dateMonthAndYear.indexOf("/");
    if (slash2 == -1) { slash2 = dateMonthAndYear.indexOf("-"); }
    // if not a second slash or dash, invalid date
    if (slash2 == -1) { return false; }
    var dateDay = dateMonthAndYear.substring(0, slash2);
    var dateYear = dateMonthAndYear.substring(slash2+1, dateMonthAndYear.length);
    if ( (dateMonth == "") || (dateDay == "") || (dateYear == "") ) { return false; }
    // if any non-digits in the month, invalid date
    for (var x=0; x < dateMonth.length; x++) {
        var digit = dateMonth.substring(x, x+1);
        if ((digit < "0") || (digit > "9")) { return false; }
    }
    // convert the text month to a number
    var numMonth = 0;
    for (var x=0; x < dateMonth.length; x++) {
        digit = dateMonth.substring(x, x+1);
        numMonth *= 10;
        numMonth += parseInt(digit);
    }
    if ((numMonth <= 0) || (numMonth > 12)) { return false; }
    // if any non-digits in the day, invalid date
    for (var x=0; x < dateDay.length; x++) {
        digit = dateDay.substring(x, x+1);
        if ((digit < "0") || (digit > "9")) { return false; }
    }
    // convert the text day to a number
    var numDay = 0;
    for (var x=0; x < dateDay.length; x++) {
        digit = dateDay.substring(x, x+1);
        numDay *= 10;
        numDay += parseInt(digit);
    }
    if ((numDay <= 0) || (numDay > 31)) { return false; }
    // February can't be greater than 29 (leap year calculation comes later)
    if ((numMonth == 2) && (numDay > 29)) { return false; }
    // check for months with only 30 days
    if ((numMonth == 4) || (numMonth == 6) || (numMonth == 9) || (numMonth == 11)) {
        if (numDay > 30) { return false; }
    }
    // if any non-digits in the year, invalid date
    for (var x=0; x < dateYear.length; x++) {
        digit = dateYear.substring(x, x+1);
        if ((digit < "0") || (digit > "9")) { return false; }
    }
    // convert the text year to a number
    var numYear = 0;
    for (var x=0; x < dateYear.length; x++) {
        digit = dateYear.substring(x, x+1);
        numYear *= 10;
        numYear += parseInt(digit);
    }
    // Year must be a 2-digit year or a 4-digit year
    if ( (dateYear.length != 2) && (dateYear.length != 4) ) { return false; }
    // if 2-digit year, use 50 as a pivot date
    if ( (numYear < 50) && (dateYear.length == 2) ) { numYear += 2000; }
    if ( (numYear < 100) && (dateYear.length == 2) ) { numYear += 1900; }
    if ((numYear <= 0) || (numYear > 9999)) { return false; }
    // check for leap year if the month and day is Feb 29
    if ((numMonth == 2) && (numDay == 29)) {
        var div4 = numYear % 4;
        var div100 = numYear % 100;
        var div400 = numYear % 400;
        // if not divisible by 4, then not a leap year so Feb 29 is invalid
        if (div4 != 0) { return false; }
        // at this point, year is divisible by 4. So if year is divisible by
        // 100 and not 400, then it's not a leap year so Feb 29 is invalid
        if ((div100 == 0) && (div400 != 0)) { return false; }
    }
    // date is valid
    return true;
}
