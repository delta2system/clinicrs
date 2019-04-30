<?
session_start();
include("../data/connect.inc");
?>
<!DOCTYPE html>
<html>
<head>
	<title>.::Print Slip::.</title>
		 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="autdor" content="">
	 <link href="../css/rs_style.css" rel="stylesheet">
	  <script src="../vendor/jquery/jquery.min.js"></script>
	   <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
	   <script type="text/javascript">
	   	function cancel_bill(){
	
		$.ajax({
    		type: "POST",
    		url: "mysql_report.php",
    		data: "submit=passadmin&pass="+$("#passadmin").val(),
    		cache: false,
    		success: function(html){
    			if(html=="true"){
    				var bi = $("#nobill").val();
    				ajax_cancel(bi);

    			}else if(html=="false"){
    				alert("รหัสผ่านไม่ถูกต้อง");
    				$('#popup_admin').hide();
    			}
    		}
    		
		});
	}
	function ajax_cancel(bi){

		$.ajax({
    		type: "POST",
    		url: "mysql_report.php",
    		data: "submit=cancel_bill&nobill="+bi,
    		cache: false,
    		success: function(html){
    			if(html=="true"){
    				window.close();
    			}else{
    				alert(html);
    			}
    		}
    		
		});

	}
	   </script>
</head>
<body >
<div style="width:60mm;margin:0px auto;">
<?
		  $sql_head = "SELECT opdcard.firstname, opdcard.lastname, opd_order.hn , opd_order.nobill_system  FROM opd_order INNER JOIN opdcard ON opd_order.hn=opdcard.hn  WHERE  opd_order.nobill = '".$_GET["nobill"]."'  limit 1 ";
  		  list($firstname,$lastname,$hn,$nobill_system) = Mysql_fetch_row(Mysql_Query($sql_head));
  		  echo mysql_error();
?>	

	<table style="width:100%;">
	<td colspan="2">
		<img src="../images/logo.jpg" style="width:58mm;">
	</td>
	<tr><td colspan="2">เลขที่บิล : <?=$nobill_system?></td>
	<tr><td colspan="2">OPD : <?=$hn?></td>
	<tr><td colspan="2" style="height:20px;border-bottom: 1px solid #c2c2c2">ชื่อลูกค้า : คุณ <?=$firstname." ".$lastname?></td>
		
	<?
	if($_GET["status"]=="4"){
	$sql="SELECT tools_product.detail, opd_order.pcs, opd_order.price, opd_order.course_id, opd_order.discount FROM opd_order INNER JOIN tools_product ON opd_order.course_id=tools_product.row_id WHERE opd_order.nobill = '".$_GET["nobill"]."' GROUP by opd_order.course_id";
	
	}else{
	$sql="SELECT product.detail, opd_order.pcs, opd_order.price, opd_order.course_id FROM opd_order INNER JOIN product ON opd_order.course_id=product.row_id WHERE opd_order.nobill = '".$_GET["nobill"]."' GROUP by opd_order.course_id";
	}
	$result = mysql_query($sql);
	$total=array();
	while ($row = mysql_fetch_array($result) ) {

		  $sql_pcs = "SELECT sum(pcs) from opd_order WHERE course_id = '".$row["course_id"]."' AND nobill = '".$_GET["nobill"]."' GROUP by course_id  ";
  		  list($pcs) = Mysql_fetch_row(Mysql_Query($sql_pcs));

		print "<tr>"
			  ."<td style='padding-top:5px;padding-bottom:5px;'>".$row["detail"]." x ".$pcs."</td>"
			  ."<td style='text-align:right;padding-right:5px;'>".number_format($pcs*$row["price"])." ฿</td>";
		array_push($total,($pcs*$row["price"]));
	}
	?>
	<tr><td colspan="2" style="border-top: 1px solid #c2c2c2"></td>
		<tr><td style="text-align: right;">รวมเงิน</td><td style="text-align: right;padding-right: 5px;border-bottom: 1px double #000000;font-weight: bold; "><?=number_format(array_sum($total))?> ฿</td></tr>
		<tr><td style="height:30px;"></td></tr>
		<tr><td colspan="2" style="height:40px;text-align: center;">.::ขอบคุณที่ใช้บริการ::.</td></tr>
		<tr><td colspan="2" style="height:50px;"></td>
			<tr><td colspan="2" style="height:50px;text-align: center;"><div style="padding:5px 20px;border:1px solid #909090;background-color: #f0f0f0;border-radius: 5px;cursor: pointer;" onclick="$('#popup_admin').show();$('#passadmin').focus();">ยกเลิก</div><input type="hidden" id="nobill" value='<?=$_GET["nobill"]?>'></td>
	</table>
</div>
</body>
</html>
<div id='popup_admin' style="display:none;position: absolute;top:0px;left:0px;width:100%;height:100%;background-color: rgba(0,0,0,0.6);">
<div style="margin:0px auto;width:250px;height:120px;border:1px solid #a0a0a0;background-color: #ffffff;border-radius: 5px;box-shadow: 5px 5px 5px rgba(0,0,0,0.4);margin-top: 20%;text-align: center;padding-top: 10px">
	กรุณาใส่รหัสผ่าน admin <input type="password" id="passadmin" style="font-size: 16px;text-align: center;padding:3px;border-radius: 3px;border:1px solid #a0a0a0;" onkeyup="if(event.which==13){cancel_bill();}">
	<div style="margin:0px auto;width:100px;margin-top:10px;padding:5px 5px;border:1px solid #909090;background-color: #f0f0f0;border-radius: 5px;cursor: pointer;" onclick="$('#popup_admin').hide();">ยกเลิกบิล</div>
</div>
</div>