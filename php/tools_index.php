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
    var data = "&detail="+$("#detail").val();
        data = data + "&row_id="+$("#row_id").val();
        data = data + "&pcs="+$("#pcs").val();
        data = data + "&unit="+$("#unit").val();
        data = data + "&price="+$("#price").val();
    $.ajax({
      type: "POST",
      url: "mysql_tools.php",
      data: 'submit=new_product'+data,
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
      url: "mysql_tools.php",
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

function edit_p(rd,de,pc,un,pr){

	$("#detail").val(de);
    $("#row_id").val(rd);
    $("#pcs").val(pc);
    $("#unit").val(un);
    $("#price").val(pr);
    
	$("#edit_botton").show();
	$("#new_botton").hide();
	$("#new_product").show();

}

function new_pupup(){
	$("#detail").val('');
    $("#row_id").val('');
    $("#pcs").val('');
    $("#unit").val('');
    $("#price").val('');
	$("#edit_botton").hide();
	$("#new_botton").show();
	$("#new_product").show();

}

function return_product(vl){
	$("#new_product").hide();
    $.ajax({
      type: "POST",
      url: "mysql_tools.php",
      data: 'submit=search_product&search='+vl,
      cache: false,
      success: function(result)
        {
         var obj = jQuery.parseJSON(result);
         $("#tabledata tbody tr").remove();
                    if(obj != '')
                    {
                         
                          $.each(obj, function(key, val) {                           
                            var tr = "<tr>";
                                tr = tr + "<td style='border-bottom: 1px solid #e0e0e0;padding-left: 10px;'>"+val["detail"]+"</td>";
                                tr = tr + "<td style='border-bottom: 1px solid #e0e0e0;padding-right: 10px;text-align:right;width:100px;'>"+val["pcs"]+"</td>";
                                tr = tr + "<td style='border-bottom: 1px solid #e0e0e0;text-align:left;'> "+val["unit"]+"</td>";
                                tr = tr + "<td style='border-bottom: 1px solid #e0e0e0;padding-left: 10px;text-align:right;'>"+val["price"]+"</td>";
			 					tr = tr + "<td style='text-align: center;'><button class='btn btn-warning' onclick=\"edit_p('"+val["row_id"]+"','"+val["detail"]+"','"+val["pcs"]+"','"+val["unit"]+"','"+val["price"]+"')\">&#9998;</button></td>";
                                tr = tr + "</tr>";
                            $('#tabledata > tbody:last').append(tr);
                          });

                    }
                              
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
	<div id="opdcard" style="width:850px;margin:0px auto;padding:10px 10px;background-color: #ffffff;border-radius: 5px;border:1px solid #c2c2c2;box-shadow: 5px 5px 5px rgba(0,0,0,0.1)">
		<table id="tabledata" style="width:100%;">
	<thead>
		<td colspan="5" style="color:#626262;text-align: center;font-size: 20px;">อุปกรณ์/ยา</td>
		<tr>
		<td colspan="5"><button class="btn btn-success" onclick="new_pupup()" style="float: left;">เพิ่ม</button>
			<input type="text" name="search" class="form-control" style="width:200px;margin-left:600px;" onkeyup="return_product(this.value)"></td>
		<tr>
		<td style="border:1px solid #e0e0e0;background-color: #f0f0f0;padding-left: 10px;width:500px;">สินค้า</td>
        <td colspan="2" style="border:1px solid #e0e0e0;background-color: #f0f0f0;text-align:center;padding-right: 10px;width:100px;">จำนวน</td>
		<td style="border:1px solid #e0e0e0;background-color: #f0f0f0;width:100px;text-align:right;">ราคา</td>
		<td style="border:1px solid #e0e0e0;background-color: #f0f0f0;text-align: right;width:70px;"></td>
		</thead>
		<tbody >

	</tbody>

</table>

</div>
<div id="new_product" style="display:none;position:fixed;width:300px;height:300px;background-color: #ffffff;border:1px solid #e0e0e0;box-shadow: 5px 5px 5px rgba(0,0,0,0.3);left:50%;top:50%;margin-left: -150px;margin-top: -100px;text-align: center;border-radius: 10px;">
	<center>
	<table style="width: 90%;">
		<tr><td colspan="2" style="text-align: center;font-weight:bold;">เพิ่มอุปกรณ์</td>
		<tr><td style="text-align:right;">สินค้า :</td><td><input type="text" id="detail"></td>
        <tr><td style="text-align:right;">จำนวน :</td><td><input type="text" id="pcs"></td>
        <tr><td style="text-align:right;">หน่วย :</td><td><input type="text" id="unit"></td>
		<tr><td style="text-align:right;">ราคา :</td><td><input type="text" id="price"></td>
		<tr><td colspan="2" style="text-align: center;">
			<input type="hidden" id="row_id">
			<span id="edit_botton" style="display: none;">
			<button class="btn btn-success" onclick="new_product()">แก้ไข</button>
			<button class="btn btn-warning" onclick="del_p()">ลบ</button>
            <button class="btn btn-danger" onclick="$('#new_product').hide()">ปิด</button>
			</span>
			<span id="new_botton" >
			<button class="btn btn-success" onclick="new_product()">เพิ่ม</button>
            <button class="btn btn-danger" onclick="$('#new_product').hide()">ปิด</button>
			</span>
			
		</td>
	</table>
</center>
</div>
</body>
</html>
<script type="text/javascript">
	return_product('');
</script>
