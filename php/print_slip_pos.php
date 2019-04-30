<?
session_start();
include("../data/connect.inc");

function num_comma($str){
    if(empty($str)){
        return "";
    }else{
        return number_format($str);
    }
}

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
<body >
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
	
		
	<?

    if($hn){
    echo "<tr><td colspan='2'>OPD : $hn</td>"
    	 ."<tr><td colspan='2' style='height:20px;'>ชื่อลูกค้า : คุณ $firstname $lastname</td>";
    }else{
        
    }
    echo "<tr><td colspan='2' style='height:20px;border-bottom: 1px solid #c2c2c2'>เลขที่บิล ".substr($_GET["nobill"],2,10)."</td>";


	$sql="SELECT tools_product.detail, opd_order.pcs, opd_order.price, opd_order.course_id, opd_order.discount FROM opd_order INNER JOIN tools_product ON opd_order.course_id=tools_product.row_id WHERE opd_order.nobill = '".$_GET["nobill"]."' GROUP by opd_order.course_id";
	$result = mysql_query($sql);
    $total=array();
    $dis=array();
	while ($row = mysql_fetch_array($result) ) {

		  $sql_pcs = "SELECT sum(pcs),price from opd_order WHERE course_id = '".$row["course_id"]."' AND nobill = '".$_GET["nobill"]."' GROUP by course_id  ";
  		  list($pcs,$price) = Mysql_fetch_row(Mysql_Query($sql_pcs));

		print "<tr>"
              ."<td style='padding-top:5px;padding-bottom:5px;' colspan='2'>".$row["detail"]."</td>"
              ."<tr><td style='border-bottom:1px solid #a2a2a2;'>".$pcs." x ".num_comma($price)."</td>"
			  ."<td style='text-align:right;padding-right:5px; style='border-bottom:1px solid #a2a2a2;''>".num_comma($pcs*$row["price"])." ฿</td>";
        array_push($total,($pcs*$row["price"]));
        array_push($dis,$row["discount"]);
	}
	?>
	<tr><td colspan="2" style="border-top: 1px solid #c2c2c2"></td>
        <?
        $discount=array_sum($dis);
        $total_final=array_sum($total);
        if( $discount>0){
            echo "<tr><td style='text-align: right;height:30px;'>รวมเงิน</td><td style='text-align: right;padding-right: 5px;border-bottom: 1px solid #a2a2a2; '>".num_comma($total_final)." ฿</td></tr>";    
        echo "<tr><td style='text-align: right;height:30px;'>ส่วนลด</td><td style='text-align: right;padding-right: 5px;border-bottom: 1px solid #a2a2a2; '>".num_comma($discount)." ฿</td></tr>";    
        echo "<tr><td style='text-align: right;height:30px;'>ยอดเงินสุทธิ</td><td style='text-align: right;padding-right: 5px;border-bottom: 1px double #000000;font-weight: bold; '>".num_comma($total_final-$discount)." ฿</td></tr>";
        }else{
        echo "<tr><td style='text-align: right;height:30px;'>ยอดเงินสุทธิ</td><td style='text-align: right;padding-right: 5px;border-bottom: 1px double #000000;font-weight: bold; '>".num_comma($total_final)." ฿</td></tr>";    
        }
        
        ?>
	
		<tr><td style="height:30px;"></td></tr>
		<tr><td colspan="2" style="height:30px;text-align: center;">.::ขอบคุณที่ใช้บริการ::.</td></tr>
	</table>
</div>
</body>
</html>

<script type="text/javascript">
    window.print();
function next_page(){
	window.location='pos.php';
}
setTimeout('next_page()',3000);
</script>
