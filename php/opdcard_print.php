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
               
	 			$("#img_preview").attr("src","../images/img_opd/"+val["img_profile"]+"");
	 			          	
	 			$("input[name=hn]").val(hn);
	 			$("input[name=sale]").val(val["sale"]);
	 			$("input[name=firstname]").val(val["firstname"]);
	 			$("input[name=lastname]").val(val["lastname"]);
	 			$("input[name=idcard]").val(val["idcard"]);
	 			$("input[name=nickname]").val(val["nickname"]);
	 			$("input[name=birthday]").val(val["birthday"]);
	 			$("input[name=height_opd]").val(val["height_opd"]);
	 			$("input[name=weight_opd]").val(val["weight_opd"]);
	 			$("#sex").html(val["sex"]);
	 			$("#blood").html(val["blood"]);
	 			$("input[name=phone]").val(val["phone"]);
	 			$("input[name=email]").val(val["email"]);
	 			$("input[name=allergic]").val(val["allergic"]);
	 			$("input[name=disease]").val(val["disease"]);
	 			$("input[name=img_profile]").val('');
	 			$("input[name=row_id]").val(val["row_id"]);
	 			$("#canvas").hide();
	 			$("#video").hide();
	 			//$("#canvas").html("<img src='../images/img_opd/"+val["img_profile"]+"'>");

	 			window.print();
	 			CloseWindowsInTime(3);
                          });
                    }
           }
    });
}

function CloseWindowsInTime(t){
	t = t*1000;
	setTimeout('change_page()',t);
}

function change_page(){
	window.location="opdcard.php";
}

	 </script>
	<style type="text/css">
		input[type=text],select,input[type=date],span{
			
			border:0px solid #b2b2b2;
			border-bottom: 1px solid #b2b2b2;
			padding:5px 5px;
			width:90%;
			font-size: 16px;
		}

		td{
			/*border:1px solid #e0e0e0;*/
			height:40px;
		}
		table{
			border-collapse: collapse;
		}



	</style>
</head>
<body>
	<div id="opdcard" style="width:1000px;margin:0px auto;padding:10px 10px;background-color: #ffffff;">
		<table style="width:100%;">
	<tdead>
		<td colspan="7" style="color:#ffffff;text-align: center;font-size: 30px;background-color:#80bfff; ">OPD Card</td>
		<tr>
		<td></td><td style="height:70px;text-align: right;font-weight: bold;font-size: 20px;">OPD </td><td style="text-align: left;"> <input type="text" name="hn" style="width:120px;text-align: center; "></td><td></td>
		<td  style="text-align: right;" colspan="3">ชื่อเซลล์ <input type="text" name="sale" style="width:150px;text-align: center;"></td>
		</tdead>
		<tbody >
		<tr>
		<td style="height: 15px;" colspan="6"></td>
		<tr>
			<td rowspan="5" style="text-align: center;">
<div style="padding:15px;border:1px solid #b2b2b2">
<img id="img_preview" src="" >
</div>

			</td>
			<tr>
		<td style="text-align: right;">ชื่อ :</td><td style="text-align: left;"><input type="text" name="firstname"></td>
		<td style="text-align: right;">สกุล :</td><td style="text-align: left;"><input type="text" name="lastname"></td>
		<td style="text-align: right;">ชื่อเล่น :</td><td style="text-align: left;"><input type="text" name="nickname" style="width:80px;"></td>
		<tr>
		<td style="text-align: right;" >วันเกิด :</td><td  colspan="5" style="text-align: left;"><input type="date" name="birthday" style="width:160px;">
			&nbsp;&nbsp;&nbsp;&nbsp;บัตรประชาชน : <input type="text" name="idcard"  style="width:160px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;โทร : <input type="text" name="phone"  style="width:150px;"></td>
			<tr><td  style="text-align: right;">ส่วนสูง :</td><td colspan="5"> <input type="text" name="height_opd"  style="width:100px;"> Cm.
			&nbsp;&nbsp;&nbsp;&nbsp;น้ำหนัก : <input type="text" name="weight_opd"  style="width:80px;text-align: center;">Kg.
		
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; เพศ : <span id="sex"  style="width:150px;"></span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; กรุ๊ปเลือด : <span id="blood" style="width:150px;"></span>
			</td><tr>
			<td style="text-align: right;">อีเมล์ :</td><td colspan="2"> <input type="text" name="email" >
		</td>
		<tr>
			<td style="text-align: right;" colspan="2">ประวัติแพ้ยา : </td><td style="text-align: left;" colspan='2'><input type="text" name="allergic"></td>
			<td style="text-align: left;" colspan="3">โรคประจำตัว : <input type="text" name="disease" style="width:70%;"></td>
		<tr>

	</tbody>
</table>

</div>

</body>
</html>
<?
if(isset($_GET["hn"])){
	echo "<script>hn_detail('".$_GET["hn"]."');</script>";
}
?>
    <!-- jQuery -->
   

