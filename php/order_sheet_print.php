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

        @media print {
    .page_breck {page-break-after: always;}
     pre, blockquote {page-break-inside: avoid;}
}

	</style>
</head>
<body onload="window.print()">
<?
    $strSQL = "SELECT opdcard.hn,opdcard.firstname,opdcard.lastname,opdcard.blood FROM opd_order INNER JOIN opdcard ON opd_order.hn=opdcard.hn WHERE opd_order. no_ordersheet = '".$_GET["no"]."'";
    list($hn,$firstname,$lastname,$blood) = Mysql_fetch_row(Mysql_Query($strSQL));    
    
    function user_name($str){
        $strSQL = "SELECT fullname FROM account_login  WHERE row_id = '".$str."'";
        list($fullname) = Mysql_fetch_row(Mysql_Query($strSQL));       
        return $fullname;
    }


    $sql = "SELECT product.detail,opd_order.worker,opd_order.course_id from opd_order inner join product on opd_order.course_id=product.row_id where opd_order.no_ordersheet = '".$_GET["no"]."'";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result) ) {
 ?>
	
		<table style="width:20cm;margin:0px auto;" class="page_breck">
	<thead>
		<td colspan="3" style="text-align: center;"><img src="../images/logo.jpg" style="height:70px;"></td>
		<tr>
        <td colspan="3" style="text-align: center;">ใบรับการรักษา</td>
		<tr>
		<td style="text-align: left;">เลขที่ : <?=$_GET["no"]?></td><td style="text-align: left;"></td>
		<td style="text-align: right;width:300px;" colspan="2">OPD <input type="text" name="hn" style="width:80px;border:0px solid #e0e0e0;font-weight: bold; " value="<?=$hn?>"></td>
		<tr>
		<td style="text-align: left;" colspan="3">ชื่อ : <input type="text" name="firstname" style="width:80%;border:0px solid #e0e0e0;border-bottom: 1px solid #c0c0c0;" value="<?="คุณ ".$firstname." ".$lastname?>"> กรุ๊ปเลือด : <input type="text" name="blood" style="width:40px;border:0px solid #e0e0e0;border-bottom: 1px solid #c0c0c0;" value="<?=$blood?>"></td>
		</thead>
		<tbody >
        <?

        print "<tr><td>คอร์ส : $row[detail] </td><td>ผู้ปฏิบัติงาน : ".user_name($row[worker])."</td>";
        print "<tr><td colspan='2' style='padding-left:15px;'>";

        $sqls = "SELECT tools_product.detail,tools_product.unit,product_tools.pcs from product_tools inner join tools_product on product_tools.id_tools=tools_product.row_id where product_tools.id = '".$row["course_id"]."'";
        $results = mysql_query($sqls)or die(mysql_error());
        while ($data = mysql_fetch_array($results) ) {
        print "<div style='width:100%;border-bottom:1px solid #e2e2e2;float:left;'>".
              "<div style='width:200px;padding:5px;float:left;'>• $data[detail]</div>".
              "<div style='width:200px;padding:5px;float:left;'>$data[pcs] $data[unit]</div></div>";
        }   
        print "</td>";
        print "<tbody><tfoot>";
        print "<tr><td colspan='2' style='height:200px;' >ผู้ปฏิบัติงาน.................................................................<br>".
              "<div style='margin-left:100px;margin-top:30px;'>วันที่.........../................./...................</div></td>";
      
        ?>
	</tfoot>
</table>
    <?}
    ?>


</body>
</html>
<script type="text/javascript">
// 	$(function() {
    
// 		var topOffset = 0;
// 		var width = window.innerWidth;
// 		var height = window.innerHeight;
// 		height = height - topOffset;
// 			$("#opdcard").css({"height": height + "px"});
// 				$("#show_product").css({"height": (height-150) + "px"});      
// 				$("#product_select").css({"height": (height-150) + "px"});
// 				$("#officer").css({"height": (height-150) + "px"});
// });
</script>
