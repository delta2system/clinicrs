<?PHP
session_start();
include("../data/connect.inc");

function addcomma($str){
	if($str!=""){
		return number_format($str,2);
	}else{
		return "";
	}
}

function mount($str){
switch($str)
{
case "01": $str = "ม.ค."; break;
case "02": $str = "ก.พ."; break;
case "03": $str = "มี.ค."; break;
case "04": $str = "เม.ย."; break;
case "05": $str = "พ.ค."; break;
case "06": $str = "มิ.ย."; break;
case "07": $str = "ก.ค."; break;
case "08": $str = "ส.ค."; break;
case "09": $str = "ก.ย."; break;
case "10": $str = "ต.ค."; break;
case "11": $str = "พ.ย."; break;
case "12": $str = "ธ.ค."; break;
}
return $str;
}
if($_POST["submit"]=="detailbill"){

function return_hn($str){
  $sql = "SELECT firstname,lastname from opdcard WHERE hn = '$str' limit 1  ";
  list($firstname,$lastname) = Mysql_fetch_row(Mysql_Query($sql));
  return $str.":".$firstname." ".$lastname;
}


echo "<table style='margin:0px auto;width:600px;'>";
echo "<thead>"
	 ."<td colspan='3' style='text-align:center;padding:15px;font-weight:bold;font-size:21px;color:#1a75ff;'>รายงานการขาย ประจำวัน ".substr($_POST["dateday"],6,2)." ".mount(substr($_POST["dateday"],4,2))." ".substr($_POST["dateday"],0,4)."</td>"
	 ."<tr>"
	 ."<td style='text-align:center;background-color:#ffd11a;'> เลขที่บิล</td>"
	 ."<td style='text-align:center;background-color:#ffd11a;'> ลูกค้า</td>"
	 ."<td style='text-align:center;background-color:#ffd11a;'> จำนวนเงิน</td>"
	 ."</thead><tbody>";
$sql = "SELECT * from opd_order where nobill_system like '".$_POST["dateday"]."%' GROUP by nobill_system";
$result = mysql_query($sql);
$total_array=array();
while ($row = mysql_fetch_array($result) ) {
$total=0;

$sqls = "SELECT * from opd_order where nobill_system = '".$row[nobill_system]."'";
$results = mysql_query($sqls);
while ($data = mysql_fetch_array($results) ) {
$total=$total+($data["pcs"]*$data["price"]);
}


echo "<tr class='body_cursor' onclick=\"show_bill('$row[nobill_system]','$row[status]')\">".
	 "<td style='text-align:center;'>$row[nobill_system]</td>".
	 "<td style='text-align:left;'>HN ".return_hn($row[hn])."</td>".
 	 "<td style='text-align:right;padding-right:8px;'>".addcomma($total)."</td>";
 	 array_push($total_array, $total);

}
echo "<tr><td colspan='2' style='text-align:right;padding:7px 7px;background-color:#c0c0c0;'>รวมจำนวนเงิน</td>".
	 "<td style='text-align:right;padding:7px 7px;color:red;font-weight:bold;''>".addcomma(array_sum($total_array))."</td>";
echo "</tbody></table>";
}else if($_POST["submit"]=="return_bill_month"){

    $resultArray = array();


	 for($d=1;$d<=31;$d++){
	 $total=0;
	 $date=$_POST["year"].str_pad($_POST["month"],2,"0",STR_PAD_LEFT).str_pad($d,2,"0",STR_PAD_LEFT);
  	 $strSQL = "SELECT * FROM opd_order WHERE nobill_system like '".$date."%' ";
  	 $objQuery = mysql_query($strSQL) or die (mysql_error());
  	 $intnum = mysql_num_rows($objQuery);
  	 //$intNumField = mysql_num_fields($objQuery);
  	 if($intnum){
  	 $arrCol = array();
  	 while($obResult = mysql_fetch_array($objQuery))
    {
    
	$total=$total+($obResult[pcs]*$obResult[price]);

	}
     $arrCol["dateday"] = substr($date,6,2)."/".substr($date,4,2)."/".substr($date,0,4);
     $arrCol["total"] = addcomma($total);
     $arrCol["datereturn"] = $date;
     $arrCol["total_fi"] = $total;
     array_push($resultArray,$arrCol);
   	}
	}
  
  echo json_encode($resultArray);

}else if($_POST["submit"]=="return_morrisjs"){


 $resultArray = array();


	 for($m=1;$m<=12;$m++){
	 $total=0;
	 $date=$_POST["year"].str_pad($m,2,"0",STR_PAD_LEFT);
  	 $strSQL = "SELECT * FROM opd_order WHERE nobill_system like '".$date."%' ";
  	 $objQuery = mysql_query($strSQL) or die (mysql_error());
  	 $arrCol = array();
  	 while($obResult = mysql_fetch_array($objQuery))
    {
    
	$total=$total+($obResult[pcs]*$obResult[price]);

	}
     $arrCol["y"] = mount($m)." ".$_POST["year"];
     $arrCol["a"] = $total;
     array_push($resultArray,$arrCol);
   	}
	
  
  echo json_encode($resultArray);





}else if($_POST["submit"]=="return_totalyear"){

  	 $strSQL = "SELECT * FROM opd_order WHERE nobill_system like '".$_POST["year"]."%' ";
  	 $objQuery = mysql_query($strSQL) or die (mysql_error());
  	 $total=0;
  	 while($obResult = mysql_fetch_array($objQuery))
    {    
	$total=$total+($obResult[pcs]*$obResult[price]);
	}
   	

   	echo $total;
}else if($_POST["submit"]=="return_morrisemp"){

 	$resultArray = array();


	// for($m=1;$m<=12;$m++){
	 
	 $date=$_POST["year"]."-".str_pad($_POST["month"],2,"0",STR_PAD_LEFT);

	$sqls = "SELECT * from account_login where user != 'admin' AND status = 'Y'";
	$results = mysql_query($sqls);
	while ($data = mysql_fetch_array($results) ) {
	 $total=0;

  	$strSQL = "SELECT * FROM opd_order WHERE worker='".$data[row_id]."' AND datedo like '".$date."%' ";
  	 $objQuery = mysql_query($strSQL) or die (mysql_error());
  	 $arrCol = array();
  	 while($obResult = mysql_fetch_array($objQuery))
    {
    
	$total=$total+($obResult[pcs]*$obResult[price]);

	}


     $arrCol["y"] = $data[fullname];
     $arrCol["a"] = $total;
     array_push($resultArray,$arrCol);
   	//}
	
  }
  echo json_encode($resultArray);


}else if($_POST["submit"]=="passadmin"){


     $strSQL = "SELECT * FROM account_login WHERE user = 'admin' AND passwd ='".$_POST['pass']."' ";
     $objQuery = mysql_query($strSQL) or die (mysql_error());
     $intnum = mysql_num_rows($objQuery);
     if($intnum){
      echo "true";
     }else{
      echo "false";
     }


}else if($_POST["submit"]=="cancel_bill"){

   $sql_del = "DELETE FROM opd_order WHERE nobill_system = '".$_POST["nobill"]."'"; 
  $query = mysql_query($sql_del); 
  echo "true";
}else if($_POST["submit"]=="cancel_billorder"){

$strSQL = "UPDATE opd_order SET ";
$strSQL .="no_ordersheet = '' ";
$strSQL .=",worker = '' ";
$strSQL .=",room = '' ";
$strSQL .=",officerdo = '' ";
$strSQL .=",discount = '' ";
$strSQL .=",datedo = '0000-00-00' ";
$strSQL .=",timedo = '00:00:00' ";
$strSQL .=",status = '1' ";
$strSQL .="WHERE row_id = '".$_POST["row_id"]."' ";
$objQuery = mysql_query($strSQL);    

  $sql_del = "DELETE FROM  calendar WHERE id = '".$_POST["row_id"]."'"; 
  $query = mysql_query($sql_del); 


  echo "true";

}

?>