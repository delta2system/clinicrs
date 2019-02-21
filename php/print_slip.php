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
</head>
<body onload="window.print()">
<div style="width:60mm;margin:0px auto;">
<?
		  $sql_head = "SELECT opdcard.firstname, opdcard.lastname, opd_order.hn  FROM opd_order INNER JOIN opdcard ON opd_order.hn=opdcard.hn  WHERE  opd_order.nobill = '".$_GET["nobill"]."'  limit 1 ";
  		  list($firstname,$lastname,$hn) = Mysql_fetch_row(Mysql_Query($sql_head));
  		  echo mysql_error();
?>	

	<table style="width:100%;">
	<td colspan="2">
		<img src="../images/logo.jpg" style="width:58mm;">
	</td>
	<tr><td colspan="2">OPD : <?=$hn?></td>
	<tr><td colspan="2" style="height:20px;border-bottom: 1px solid #c2c2c2">ชื่อลูกค้า : คุณ <?=$firstname." ".$lastname?></td>
		
	<?
	$sql="SELECT product.detail, opd_order.pcs, opd_order.price, opd_order.course_id FROM opd_order INNER JOIN product ON opd_order.course_id=product.row_id WHERE opd_order.nobill = '".$_GET["nobill"]."' GROUP by opd_order.course_id";
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
	</table>
</div>
</body>
</html>
<script type="text/javascript">
function next_page(){
	window.location='opd_search.php';
}
setTimeout('next_page()',3000);
</script>