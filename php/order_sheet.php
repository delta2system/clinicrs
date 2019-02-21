<?PHP
session_start();
include("../data/connect.inc");
if(empty($_COOKIE["sIdname"])){
	echo("<script>alert('กรุณาลงชื่อเข้าใช้');window.top.window.login();</script>");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>..:OPD CARD:..</title>
	 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="autdor" content="">
	 <link href="../css/rs_style.css" rel="stylesheet">
	  <script src="../vendor/jquery/jquery.min.js"></script>
	   <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
	 <script type="text/javascript">


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
	 			 $("input[name=firstname]").val(val["firstname"]+" "+val["lastname"]);
					$("input[name=blood]").val(val["blood"]);
					return_course(val["hn"]);
					return_select_course(val["hn"])	;								
                          });
                    }
           }
    });
}

function return_course(hn){
	$.ajax({
      type: "POST",
      url: "mysql_opdcard.php",
      data: 'submit=return_course&hn='+hn,
      cache: false,
      success: function(result)
        {

					$("#show_product").html('');
                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {
                          $.each(obj, function(key, val) {
														var data = "<div style='border-bottom:1px solid #e0e0e0;padding:10px;'>";
			 											  	data = data + "<div style='padding:5px;width:70%;float:left;'>"+val["detail"]+" </div>";
			 											  	data = data + val["price"]+" ฿ <button class='btn btn-success' onclick=\"add_pr('"+val["row_id"]+"')\">>></button>";
			 											  	data = data + "</div>";

				$("#show_product").append(data);
                          });
                    }
           }
    });
}

function return_select_course(hn){
	$.ajax({
      type: "POST",
      url: "mysql_opdcard.php",
      data: 'submit=return_select_course&hn='+hn,
      cache: false,
      success: function(result)
        {

								var obj = jQuery.parseJSON(result);
								$("#product_select").html('');
                    if(obj != '')
                    {
                          $.each(obj, function(key, val) {
														
														var data = "<div style='border-bottom:1px solid #e0e0e0;padding:5px;text-align:right;'>";
			 											  	data = data + "<div style='padding:5px;width:75%;float:left;text-align:left;'>"+val["detail"]+" </div>";
																data = data + val["price"]+" ฿ <button class='btn btn-danger' onclick=\"del_pr('"+val["row_id"]+"')\">-</button>";
																data = data + "<div> ผู้ปฏิบัติงาน &nbsp;&nbsp;<select style='width:150px;' name='"+val["row_id"]+"' onchange=\"worker(this)\">"+val["officer"]+"</select></div>";
			 											  	data = data + "</div>";
																$("#product_select").append(data);
																$("select[name="+val["row_id"]+"]").val(val["worker"]);
                          });
                    }
           }
    });
}
function add_pr(rd){
	var hn = $("input[name=hn]").val();

	$.ajax({
      type: "POST",
      url: "mysql_opdcard.php",
      data: 'submit=add_course&hn='+hn+'&row_id='+rd,
      cache: false,
      success: function(result)
        {
					
						return_select_course(hn);
						return_course(hn);
           }
    });
}

function del_pr(rd){
	var hn = $("input[name=hn]").val();
	$.ajax({
      type: "POST",
      url: "mysql_opdcard.php",
      data: 'submit=del_course&hn='+hn+'&row_id='+rd,
      cache: false,
      success: function(result)
        {
						
						return_select_course(hn);
						return_course(hn);
           }
    });	
}

function worker(str){
	var na = str.name;
	var vl = str.value;
//	alert(na + vl);
$.ajax({
      type: "POST",
      url: "mysql_opdcard.php",
      data: 'submit=course_worker&row_id='+na+'&worker='+vl,
      cache: false,
      success: function(result){}
    });	
}


function print_order_sheet(){

	$.ajax({
      type: "POST",
      url: "mysql_opdcard.php",
      data: 'submit=print_course_worker&hn='+$("input[name=hn]").val(),
      cache: false,
      success: function(result){
				
				//	alert(result);
				window.location='order_sheet_print.php?no='+result;
			}
    });	
}




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

	<div id="opdcard" style="width:21cm;height:29.5cm;margin:0px auto;padding:10px 10px;background-color: #ffffff;border-radius: 5px;border:1px solid #c2c2c2;box-shadow: 5px 5px 5px rgba(0,0,0,0.1)">
		<table id="datatable" style="width:20cm;margin:0px auto;">
	<thead>
<!-- 		<td colspan="7" style="color:#626262;text-align: center;">OPD Card</td>
		<tr>
		<td style="height:80px;text-align: right;"> </td><td style="text-align: left;"></td><td></td>	-->
		<td colspan="3" style="text-align: center;"><img src="../images/logo.jpg" style="height:70px;"></td>
		<tr>
		<td style="text-align: right;" colspan="3">OPD <input type="text" name="hn" style="width:100px;border:0px solid #e0e0e0;font-weight: bold; "></td>
		<tr>
		<td style="text-align: left;" colspan="3">ชื่อ : <input type="text" name="firstname" style="width:80%;border:0px solid #e0e0e0;border-bottom: 1px solid #c0c0c0;"> กรุ๊ปเลือด : <input type="text" name="blood" style="width:40px;border:0px solid #e0e0e0;border-bottom: 1px solid #c0c0c0;"></td>
		<tr>
		<td colspan="3" style="text-align:right;"><button class="btn" onclick="print_order_sheet()">พิมพ์ใบรักษา</button></td>
		</thead>
		<tbody >
		<tr>
			<td style="width:40%;border:1px solid #e0e0e0;">

			<div id="show_product" style="width:100%;overflow: auto;">
			</div>
			</td>
			<td colspan="2" style="width:60%;border:1px solid #e0e0e0;">
			<div id="product_select" style="width:100%;overflow: auto;"></div>	



			</td>
	</tbody>
</table>

</div>

</body>
</html>
<script type="text/javascript">
	$(function() {
    
		var topOffset = 0;
		var width = window.innerWidth;
		var height = window.innerHeight;
		height = height - topOffset;
			$("#opdcard").css({"height": (height-10) + "px"});
				$("#show_product").css({"height": (height-280) + "px"});      
				$("#product_select").css({"height": (height-230) + "px"});
				//$("#officer").css({"height": (height-150) + "px"});
});
</script>
<?
if(isset($_GET["hn"])){
	echo "<script>hn_detail('".$_GET["hn"]."');</script>";
}
?>
