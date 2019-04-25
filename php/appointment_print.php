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
			padding-top: 7px;
			padding-bottom: 5px;
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
function room_work($str){
  $sql = "SELECT title from room_work WHERE id='$str'  ";
  list($title) = Mysql_fetch_row(Mysql_Query($sql));
    return $title;
}



    $strSQL = "SELECT opdcard.hn,opdcard.firstname,opdcard.lastname,opdcard.blood,notify.start,notify.course_id,notify.officer,notify.other FROM notify INNER JOIN opdcard ON notify.opd=opdcard.hn WHERE notify.row_id = '".$_GET["no"]."'";
    list($hn,$firstname,$lastname,$blood,$start,$course_id,$officer,$other) = Mysql_fetch_row(Mysql_Query($strSQL));    
    echo mysql_error();
    
    function user_name($str){
        $strSQL = "SELECT fullname FROM account_login  WHERE user = '".$str."'";
        list($fullname) = Mysql_fetch_row(Mysql_Query($strSQL));       
        return $fullname;
    }




    // $sql = "SELECT product.detail,product.time_do,opd_order.worker,opd_order.course_id,opd_order.timedo,opd_order.datedo,opd_order.room from opd_order inner join product on opd_order.course_id=product.row_id where opd_order.no_ordersheet = '".$_GET["no"]."'";
    // $result = mysql_query($sql);
    // while ($row = mysql_fetch_array($result) ) {

    	$datedo=explode("-",substr($start,0,10));
    	$datedx=$datedo[2]."/".$datedo[1]."/".($datedo[0]+543);

 ?>
	
		<table style="width:57mm;margin:0px auto;" class="page_breck">
	<thead>
		<td colspan="3" style="text-align: center;"><img src="../images/logo.jpg" style="height:70px;"></td>
		<tr>
        <td colspan="3" style="text-align: center;">ใบนัด</td>
		<tr>
<!-- 		<td style="text-align: left;">เลขที่ : <?=$_GET["no"]?></td> -->
		<tr><td style="text-align: left;width:300px;" colspan="2">OPD <?=$hn?></td>
		<tr>
		<td style="text-align: left;border-bottom:1px solid #a2a2a2 ;" colspan="3">ชื่อ : คุณ <?=$firstname." ".$lastname?></td>
		</thead>
		<tbody >
        <?

       // print "<tr><td>คอร์ส : $row[detail] </td><td>$row[time_do] นาที</td>";
        print "<tr><td >วันที่ ".$datedx." </td><td>เวลา ".substr($start,11,5)." น.</td>";
        print "<tr><td colspan='3' style='border-top:1px solid #a2a2a2;padding-left:15px;'>";
        echo "มีนัดทำคอร์ส";
        // $sqls = "SELECT tools_product.detail,tools_product.unit,product_tools.pcs from product_tools inner join tools_product on product_tools.id_tools=tools_product.row_id where product_tools.id = '".$row["course_id"]."'";
        // $results = mysql_query($sqls)or die(mysql_error());
        // while ($data = mysql_fetch_array($results) ) {
        // print "<div style='width:100%;border-bottom:1px solid #e2e2e2;float:left;'>".
        //       "<div style='width:100px;padding:5px;float:left;'>• $data[detail]</div>".
        //       "<div style='width:100px;padding:5px;float:left;'>$data[pcs] $data[unit]</div></div>";
        // }  

        $sql = "SELECT * from product where row_id IN (".substr($course_id,1).")";
        $result = mysql_query($sql)or die(mysql_error());
        while ($row = mysql_fetch_array($result) ) {
        print "<div style='width:100%;border-bottom:1px solid #e2e2e2;float:left;'>".
              "<div style='width:100px;padding:5px;float:left;'>• $row[detail]</div>".
              "</div>";
        }

        print "</td>";
        print "<tr><td colspan='3' style='padding-left:5px;'>หมายเหตุ : $other</td>";
        print "<tbody><tfoot>";
        print "<tr><td colspan='2' style='height:50px;'>ผู้นัด : ".user_name($officer)."</td>";
        
      //  print "<tr><td colspan='2' style='height:50px;text-align:center;'>กรณีหากลูกค้าต้องการเลื่อนนัดหรือยกเลิก<br> กรุณาโทรแจ้งทางร้านก่อน 1-2 วันค่ะ</td>";
        print "<tr><td colspan='2' style='height:30px;border-top:1px solid #e0e0e0;text-align:center;font-size:18px;' >ขอบคุณที่ใช้บริการ</td>";

 
      
        ?>
	</tfoot>
</table>
    <?
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
