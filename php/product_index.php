<?PHP
session_start();
include("../data/connect.inc");
if(empty($_COOKIE["sIdname"])){
	echo("<script>alert('กรุณาลงชื่อเข้าใช้');window.top.window.login();</script>");
}
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
	 

    function new_product(){
    
    $.ajax({
      type: "POST",
      url: "mysql_product.php",
      data: 'submit=new_product&detail='+$("#detail").val()+'&row_id='+$("#row_id").val()+'&time_do='+$("#time_do").val(),
      cache: false,
      success: function(result)
        {
     	//alert(result);
	 			// $("#detail").val('');
	 			// $("#price").val('');
	 			return_product('');
                              
           }
    });
}
function del_p(){
    $.ajax({
      type: "POST",
      url: "mysql_product.php",
      data: 'submit=del_product&row_id='+$("#row_id").val(),
      cache: false,
      success: function(result)
        {
     	//alert(result);
	 			// $("#detail").val('');
	 			// $("#price").val('');
	 			return_product('');
                              
           }
    });	
}

function edit_p(rd,de,tm){

	$("#detail").val(de);
	$("#time_do").val(tm);
	$("#row_id").val(rd);
	$("#edit_botton").show();
	$("#new_botton").hide();
	$("#new_product").show();

}

function new_pupup(){
	$("#detail").val('');
	$("#row_id").val('');
	$("#time_do").val('');
	$("#edit_botton").hide();
	$("#new_botton").show();
	$("#new_product").show();

}

function return_product(vl){
	$("#new_product").hide();
    $.ajax({
      type: "POST",
      url: "mysql_product.php",
      data: 'submit=search_product&search='+vl,
      cache: false,
      success: function(result)
        {
        	
 		var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {
                    	
                           $("#tabledata tbody tr").remove();
                          $.each(obj, function(key, val) {                           
                            var tr = "<tr>";
                                tr = tr + "<td style='border-bottom: 1px solid #e0e0e0;padding-left: 10px;'>"+val["detail"]+"</td>";
			 													tr = tr + "<td style='text-align: center;'><button class='btn btn-warning' onclick=\"edit_p('"+val["row_id"]+"','"+val["detail"]+"','"+val["time_do"]+"')\">&#9998;</button>";
																tr = tr + " <button class='btn btn-info' onclick=\"course_tools('"+val["detail"]+"','"+val["row_id"]+"')\">&#9881;</button>";
																 tr = tr + "</td></tr>";
                            $('#tabledata > tbody:last').append(tr);
                          });

                    }
                              
           }
    });	


}

function return_tools(vl){
	
    $.ajax({
      type: "POST",
      url: "mysql_tools.php",
      data: 'submit=search_product&search='+vl,
      cache: false,
      success: function(result)
        {
				 var obj = jQuery.parseJSON(result);

         $("#product_tools").html('');
                    if(obj != '')
                    {
                         
                          $.each(obj, function(key, val) {                           
                            var tr = "<div>";
                                tr = tr + "<div style='border-bottom: 1px solid #e0e0e0;padding: 10px 10px;float:left;width:280px;overflow:hidden;'>"+val["detail"]+"</div>";	
											 					tr = tr + "<div style='text-align: center;padding:7px 10px;'><button class='btn btn-success' onclick=\"addtools('"+val["row_id"]+"')\">>></button></div>";
                                tr = tr + "</div>";
                            $('#product_tools').append(tr);
                          });

                    }
                              
           }
    });	


}

	function addtools(rd){

		$.ajax({
      type: "POST",
      url: "mysql_tools.php",
      data: 'submit=addtools&row_id='+rd+'&row_id_tools='+$("#row_id_tools").val(),
      cache: false,
      success: function(result)
        {
	
					return_real_tools();
                              
           }
    });	

	}

function return_real_tools(){

	$.ajax({
      type: "POST",
      url: "mysql_tools.php",
      data: 'submit=return_real_tools&row_id='+$("#row_id_tools").val(),
      cache: false,
      success: function(result)
        {

				//	alert(result);
         var obj = jQuery.parseJSON(result);
         $("#tools_add").html('');
                    if(obj != '')
                    {
                         
                          $.each(obj, function(key, val) {                           
                            var tr = "<div>";
                                tr = tr + "<div style='border-bottom: 1px solid #e0e0e0;padding: 10px 10px;float:left;width:250px;'>"+val["detail"]+"</div>";
											 					tr = tr + "<div style='text-align: right;padding:7px 10px;'>&nbsp; x"+val["pcs"]+"&nbsp;&nbsp; <button class='btn btn-danger' onclick=\"deltools('"+val["row_id"]+"')\">--</button></div>";
                                tr = tr + "</div>";
                            $('#tools_add').append(tr);
                          });

                    }
                              
           }
    });	

}

function deltools(rd){
	$.ajax({
      type: "POST",
      url: "mysql_tools.php",
      data: 'submit=deltools&row_id='+rd,
      cache: false,
      success: function(result)
        {
	
					return_real_tools();
                              
           }
    });	

}

	function course_tools(dt,rd){
		$("#popup_tools").show();
		setTimeout('return_real_tools()',500);
		$("#tools_add").html('');
		$("#course_edit").html(dt);
		$("#row_id_tools").val(rd);
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
	<div id="opdcard" style="width:850px;overflow:auto;;margin:0px auto;padding:10px 10px;background-color: #ffffff;border-radius: 5px;border:1px solid #c2c2c2;box-shadow: 5px 5px 5px rgba(0,0,0,0.1)">
		<table id="tabledata" style="width:100%;">
	<thead>
		<td colspan="2" style="color:#626262;text-align: center;font-size: 20px;">สินค้า</td>
		<tr>
		<td colspan="2"><button class="btn btn-success" onclick="new_pupup()" style="float: left;">เพิ่ม</button>
			<input type="text" name="search" class="form-control" onkeyup="return_product(this.value)" style="width:200px;margin-left:600px;"></td>
		<tr>
		<td style="border:1px solid #e0e0e0;background-color: #f0f0f0;padding-left: 10px;">สินค้า</td>
		<!-- <td style="border:1px solid #e0e0e0;background-color: #f0f0f0;text-align: right;padding-right: 10px;width:100px;">ราคา</td> -->
		<td style="border:1px solid #e0e0e0;background-color: #f0f0f0;text-align: right;width:100px;"></td>
		</thead>
		<tbody >

	</tbody>

</table>

</div>
<div id="new_product" style="display:none;position:fixed;width:300px;height:200px;background-color: #ffffff;border:1px solid #e0e0e0;box-shadow: 5px 5px 5px rgba(0,0,0,0.3);left:50%;top:50%;margin-left: -150px;margin-top: -100px;text-align: center;border-radius: 10px;">
	<center>
	<table style="width: 80%;">
		<tr><td colspan="2" style="text-align: center;">เพิ่มสินค้า</td>
		<tr><td style="text-align: right;">สินค้า :</td><td><input type="text" id="detail" style="width:150px;"></td>
		<tr><td style="text-align: right;">เวลา :</td><td><input type="text" id="time_do" style="width:100px;text-align: center;"> นาที</td>
		<!-- <tr><td>ราคา</td><td><input type="text" id="price"></td> -->
		<tr><td colspan="2" style="text-align: center;">
			<input type="hidden" id="row_id">
			<span id="edit_botton" style="display: none;float: left;">
			<button class="btn btn-success" onclick="new_product()">แก้ไข</button>
			<button class="btn btn-warning" onclick="del_p()">ลบ</button>
			</span>
			<span id="new_botton" style="float: left;">
			<button class="btn btn-success" onclick="new_product()">เพิ่ม</button>
			</span>
			<button class="btn btn-danger" onclick="$('#new_product').hide()">ปิด</button>
		</td>
	</table>
</center>
</div>

<div id="popup_tools"  style="display:none;position:absolute;top:0px;width:850px;margin:0px auto;padding:10px 10px;background-color: #ffffff;border-radius: 5px;border:1px solid #c2c2c2;box-shadow: 5px 5px 5px rgba(0,0,0,0.1);left:50%;margin-left:-425px;">
<table id="tabletools" style="width:100%;">
<thead>
<td colspan="3" style="text-align:center;font-weight:bold;">อุปกรณ์ที่ใช้กับการรักษา</td>
<tr><td colspan="2" style="font-weight:bold;">&nbsp;&nbsp; คอร์สรักษา : <span id="course_edit"></span><input type="hidden" id="row_id_tools"></td>
<td style="text-align:right;"><button class="btn btn-wrong" onclick="$('#popup_tools').hide()">ปิด</button></td>
<tr><td style="width:350px;height:20px;border-bottom:1px solid #e2e2e2;background-color:#b2b2b2;">&nbsp;&nbsp;ยา/อุปกรณ์</td><td style="background-color:#b2b2b2;width:55px;height:20px;border-bottom:1px solid #e2e2e2;"></td><td style="background-color:#b2b2b2;"></td>
</thead>
<tbody></tbody>
<td valign="top"><div id="product_tools"></div></td>
<td></td><td valign="top"><div id="tools_add" style="border-left:1px solid #e2e2e2;"></div></td>
</table>
</div>

</body>
</html>
<script type="text/javascript">
	return_product('');
	return_tools('');	

</script>
<script type="text/javascript">
	$(function() {
    
		var topOffset = 0;
		var width = window.innerWidth;
		var height = window.innerHeight;
		height = height - topOffset;
		$("#opdcard").css({"height": height + "px"}); 
				$("#popup_tools").css({"height": height + "px"}); 
				     
				
			//	$("#tools_add").css({"height": (height-80) + "px"});
});
</script>
