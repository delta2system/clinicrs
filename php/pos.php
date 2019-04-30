<?PHP
session_start();
include("../data/connect.inc");
if(empty($_COOKIE["sIdname"])&&empty($_SESSION["sIdname"])){
	echo("<script>alert('กรุณาลงชื่อเข้าใช้');window.top.window.login();</script>");
}

$sql="DELETE FROM product_real WHERE status = '4'";
mysql_query($sql);

// if(empty($_GET["hn"])){

//   $sql = "SELECT no,year from runno WHERE row_id = '1'";
//   list($no,$year) = Mysql_fetch_row(Mysql_Query($sql));

//   if($year!=(date("Y")+43)){
//   	$year=date("Y")+43;
//   	$no = "1";
//   }
//   	$no++;
//  	$sql_update = "UPDATE runno SET no='$no',year='$year' WHERE row_id='1' ";
// 	$result_update= mysql_query($sql_update) or die(mysql_error());	
// 	$hn=$year.str_pad($no,2,'0',STR_PAD_LEFT);

// }else{
// 	$hn=$_GET["hn"];
// }


?>
<!DOCTYPE html>
<html>
<head>
	<title>..:POS:..</title>
	 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="autdor" content="">
	 <link href="../css/rs_style.css" rel="stylesheet">
	  <script src="../vendor/jquery/jquery.min.js"></script>
	   <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
	 <script type="text/javascript">
function addCommas(nStr)
      {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
      }

    function hn_detail(hn){
    
    $.ajax({
      type: "POST",
      url: "mysql_opdcard.php",
      data: 'submit=return_hn&hn='+hn,
      cache: false,
      success: function(result)
        {
                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {
                          $.each(obj, function(key, val) {

	 			 $("input[name=hn]").val(hn);
	 			// $("input[name=sale]").val(val["sale"]);
	 			 $("input[name=firstname]").val(val["firstname"]+" "+val["lastname"]);
	 			// $("input[name=lastname]").val(val["lastname"]);
	 			// $("input[name=idcard]").val(val["idcard"]);
	 			// $("input[name=nickname]").val(val["nickname"]);
	 			// $("input[name=birthday]").val(val["birthday"]);
	 			// $("input[name=height_opd]").val(val["height_opd"]);
	 			// $("input[name=weight_opd]").val(val["weight_opd"]);
	 			// $("select[name=sex]").val(val["sex"]);
	 			 $("input[name=blood]").val(val["blood"]);
	 			// $("input[name=phone]").val(val["phone"]);
	 			// $("input[name=email]").val(val["email"]);
	 			// $("input[name=allergic]").val(val["allergic"]);
	 			// $("input[name=disease]").val(val["disease"]);
	 			// $("input[name=img_profile]").val('');
	 			// $("input[name=row_id]").val(val["row_id"]);

                          });
                    }
           }
    });
}

function add_pr(id){
	var data = "&hn="+$("input[name=hn]").val();
	    data = data + "&id="+id;

    $.ajax({
      type: "POST",
      url: "mysql_pos.php",
      data: 'submit=add_product'+data,
      cache: false,
      success: function(result)
        {
		return_real();
           }
    });


}

function del_pr(id){

	var data = "&hn="+$("input[name=hn]").val();
	    data = data + "&row_id="+id;
     // alert(data);
    $.ajax({
      type: "POST",
      url: "mysql_pos.php",
      data: 'submit=del_product'+data,
      cache: false,
      success: function(result)
        {
  			return_real();
           }
    });


}

function return_real(){

    $.ajax({
      type: "POST",
      url: "mysql_pos.php",
      data: 'submit=return_product',
      cache: false,
      success: function(result)
        {
                
        		// $("#product_select").html('');
        		$("#product_total").html('');
                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {
                    var total=0;
                    $.each(obj, function(key, val) {
             var data = "<div style='border-bottom:1px solid #e0e0e0;padding:10px;text-align:right;'>";
			 	data = data + "<div style='padding:5px;width:60%;float:left;text-align:left;'>"+val["detail"]+"</div>";
			 	data = data + "&nbsp;"+val["pcs"]+"&nbsp;"+val["unit"]+" x <input type='text' value='"+val["price"]+"' style='width:60px;font-size:16px;' onkeyup=\"ch_price('"+val["row_id"]+"',this.value)\">&nbsp;&nbsp;&nbsp;";
			 	data = data + "<button class='btn btn-danger' onclick=\"del_pr('"+val["row_id"]+"')\">-</button>";
			 	data = data + "</div>";
                $("#product_total").append(data);
                var tx = parseFloat(val["total"]);   if ( isNaN(tx)){tx = 0;}
                 total = total+tx;
                });

                    var dis = parseFloat($("#discount").val());   if ( isNaN(dis)){dis = 0;}
                     total=(total-dis).toFixed(2);
                     $("#total_cash").html(addCommas(total)+" ฿");
                     $("#total_org").val(total);                    

                    }else{
                     $("#total_cash").html("0.00฿");
                     $("#total_org").val("0");  
                    }
           }
    });

}

function ch_price(rd,val){
  //alert(rd);
  //update_price_real
    $.ajax({
      type: "POST",
      url: "mysql_pos.php",
      data: 'submit=update_price_real&row_id='+rd+'&price='+val,
      cache: false,
      success: function(result){ update_price();}
    });
}

function update_price(){
      $.ajax({
      type: "POST",
      url: "mysql_pos.php",
      data: 'submit=return_update_price',
      cache: false,
      success: function(result)
        {
         var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {
                    var total=0;
                    $.each(obj, function(key, val) {
                var tx = parseFloat(val["total"]);   if ( isNaN(tx)){tx = 0;}
                 total = total+tx;
                });
                    var dis = parseFloat($("#discount").val());   if ( isNaN(dis)){dis = 0;}
                     total=(total-dis).toFixed(2);
                     $("#total_cash").html(addCommas(total)+" ฿");
                     $("#total_org").val(total);                    

                    }
           }
    });
}

function course(vl){


   $.ajax({
      type: "POST",
      url: "mysql_tools.php",
      data: 'submit=search_product&search='+vl,
      cache: false,
      success: function(result)
        {
        	
        		$("#show_product").html('');

                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {
                    $.each(obj, function(key, val) {

             var data = "<div style='border-bottom:1px solid #e0e0e0;padding:10px;text-align:right;'>";
			 	data = data + "<div style='padding:5px;width:150px;overflow:hidden;float:left;text-align:left;'>"+val["detail"]+"</div>";
			 	data = data + val["price"]+" ฿ <button class='btn btn-success' onclick=\"add_pr('"+val["row_id"]+"')\">+</button>";
			 	data = data + "</div>";

				$("#show_product").append(data);
                                });
                    }
           }
    });
}

function discount(vl){
    var vx = parseFloat(vl);   if ( isNaN(vx)){vx = 0;}
    var org = parseFloat($("#total_org").val()); if ( isNaN(org)){org = 0;}
    //var dis = parseFloat($("#discount").val());   if ( isNaN(dis)){dis = 0;}
                    var total=(org-vx).toFixed(2);
                     $("#total_cash").html(addCommas(total)+" ฿");
   
}

 function save_course(){

    var data = "&hn="+$("input[name=hn]").val();
        data = data + "&dateday="+$("input[name=dateday]").val();
        data = data + "&discount="+$("#discount").val();
        data = data + "&officer="+$("#officer").val();

    $.ajax({
      type: "POST",
      url: "mysql_pos.php",
      data: 'submit=save_pos'+data,
      cache: false,
      success: function(result)
        {
              //return_real();
  
  			window.location='print_slip_pos.php?nobill='+result;
        }
    });


 }



	$(function() {
    
        var topOffset = 0;
        var width = window.innerWidth;
        var height = window.innerHeight;
        height = height - topOffset;
        	$("#opdcard").css({"height": height + "px"});
            $("#show_product").css({"height": (height-150) + "px"});      
            $("#product_total").css({"height": (height-150) + "px"});
});

	 </script>
	<style type="text/css">
		input[type=text],input[type=date],select{
			border-radius:5px;
			border:1px solid #b2b2b2;
			padding:5px 5px;
			width:90%;
			font-size: 16px;
		}

		td{
			height:40px;
		}
		table{
			border-collapse: collapse;
		}



	</style>
</head>
<body>

	<div id="opdcard" style="margin:0px auto;padding:10px 10px;background-color: #ffffff;border-radius: 5px;border:1px solid #c2c2c2;box-shadow: 5px 5px 5px rgba(0,0,0,0.1);overflow: auto;">
		<fieldset style="width: 20cm;margin:0px auto;height:160px;">
			<legend style="text-align: center;background-color:#66a3ff;color:#ffffff;border-top-left-radius: 10px;border-top-right-radius: 10px; ">.::POS::..</legend>
			<table style="width:100%;">
            <td>วันที่ <input type="text" name="dateday" style="width:100px;border:1px solid #e0e0e0;" value="<?=date("d/m/").(date("Y")+543)?>">
               พนักงานขาย <select id="officer" style="width:180px;background-color:#ffe6ff;border-color:#ff66ff;">
                <?
                $stroff="SELECT * FROM account_login WHERE status = 'Y' ";
                $result=mysql_query($stroff);
                while($of = mysql_fetch_array($result)){
                  if($_SESSION["sIdname"]==$of[user]){
                    $sel = "selected";
                  }else{
                    $sel = '';
                  }
                  echo "<option $sel value='$of[user]'>$of[fullname]</option>";
                }
                ?>
              </select>

            </td>
            <td><div style="position:absolute;background-color:#000000;color:#00ff00;font-size: 35px;text-align: right;padding:5px;font-weight: bold;width:250px;height:70px;margin-left:-250px;margin-top:-20px;vertical-align: middle;" id="total_cash">0.00 ฿</div><input type='hidden' id='total_org'></td>
            <tr>
				<td style="text-align: left;" colspan="3">OPD <input type="text" name="hn" style="width:100px;border:1px solid #e0e0e0;font-weight: bold; " onkeyup="if(event.which==13){ hn_detail(this.value)}"> &nbsp; ชื่อ : <input type="text" name="firstname" style="width:250px;border:0px solid #e0e0e0;border-bottom: 1px solid #c0c0c0;" placeholder="ลูกค้าเงินสด"> </td>
		<tr>
		</table>
		</fieldset>

		<table style="width:20cm;margin:0px auto;">
	<thead>
<!-- 		<td colspan="7" style="color:#626262;text-align: center;">OPD Card</td>
		<tr>
		<td style="height:80px;text-align: right;"> </td><td style="text-align: left;"></td><td></td>	-->
	
			<td>				
			<input type="text" name="search" id="search" class="form-control" placeholder="Search"  onkeyup="course(this.value)">
		</td>
		<td></td>
		<td style="text-align: right;">ส่วนลด <input type="text" id="discount" style="width:100px;text-align:right;" onkeyup="discount(this.value)"> <button class="btn btn-success" onclick="save_course()">บันทึก</button></td>
		<tr>
			<td style="width:35%;border:1px solid #e0e0e0;">

			<div id="show_product" style="width:100%;overflow: auto;">
			</div>
			</td>
			<td colspan="2" style="width:65%;border:1px solid #e0e0e0;">
			<div id="product_total" style="width:100%;overflow: auto;"></div>	
			</td>
	<!-- 	
		<td  style="text-align: right;">กรุ๊ปเลือด : </td><td><select name="blood" style="width:50px;"><option>O</option><option>A</option><option>B</option><option>AB</option><option>ABO</option></select></td><tr>
		
		<td style="text-align: right;">โรคประจำตัว : </td><td style="text-align: left;" ><input type="text" name="disease"></td>
		</td><td style="text-align: right;">ประวัติแพ้ยา : </td><td style="text-align: left;" colspan='4'><input type="text" name="allergic" style="width:100%;"></td>
			
		<tr>
		<td colspan="7" style="height: 15px;"><hr></td>
		<tr>
			<td><button class="btn btn-primary" onclick="doctor_order()">ออกใบรักษา</button></td>
			<td colspan="3" style="height: 15px;text-align: center;">
				
				<input type="hidden" name="row_id">
				<input type="hidden" name="img_profile" id="img_profile" value="">
				<button class="btn btn-success" onclick="save_opd()">บันทึก</button>
				</td>
				<td></td> -->
	</tbody>
</table>

</div>

</body>
</html>
<script type="text/javascript">

</script>
<?

	echo "<script>course('');</script>";

?>
