<?
session_start();
include("../data/connect.inc");

if($_POST["submit"]=="new_product"){

if(empty($_POST["row_id"])){

$strSQL = "INSERT INTO product SET "; 
$strSQL .="detail = '".$_POST["detail"]."' ";
$strSQL .=",price = '".$_POST["price"]."' ";
$objQuery = mysql_query($strSQL);
}else{
	$sql_update = "UPDATE product SET detail='".$_POST["detail"]."' WHERE row_id = '".$_POST["row_id"]."'";
	$result_update= mysql_query($sql_update) or die(mysql_error());	
}


}else if($_POST["submit"]=="del_product"){

  $sql_del = "DELETE FROM product WHERE row_id = '".$_POST["row_id"]."' "; 
  $query = mysql_query($sql_del);


}else if($_POST["submit"]=="select_product"){

if($_POST["id"]){
  $sql = "SELECT id,pcs,detail from product_real WHERE id = '".$_POST["id"]."' AND hn = '".$_POST["hn"]."' AND status = '1' ";
  $num = mysql_num_rows(Mysql_Query($sql));
  if(!empty($num)){
  	list($id,$pcs,$detail) = Mysql_fetch_row(Mysql_Query($sql));
  	$pcs++;

	$sql_update = "UPDATE product_real SET pcs='$pcs' WHERE id = '".$_POST["id"]."' AND hn = '".$_POST["hn"]."' AND status = '1'";
	$result_update= mysql_query($sql_update) or die(mysql_error());

  }else{
  	$sql = "SELECT detail from product WHERE row_id = '".$_POST["id"]."' ";
  	list($detail) = Mysql_fetch_row(Mysql_Query($sql));

	$strSQL = "INSERT INTO product_real SET "; 
	$strSQL .="hn = '".$_POST["hn"]."' ";
	$strSQL .=",id = '".$_POST["id"]."' ";
	$strSQL .=",detail = '".$detail."' ";
	$strSQL .=",pcs = '1' ";
  $strSQL .=",status = '1' ";
  $objQuery = mysql_query($strSQL);
	}
}


}else if($_POST["submit"]=="del_product"){

  $sql_del = "DELETE FROM product_real WHERE row_id = '".$_POST["row_id"]."' "; 
  $query = mysql_query($sql_del);

}else if($_POST["submit"]=="return_product"){

  $strSQL = "SELECT * FROM product_real WHERE hn = '".$_POST["hn"]."' AND status = '1' ";
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
    }
    array_push($resultArray,$arrCol);
  }
  
  echo json_encode($resultArray);

}else if($_POST["submit"]=="update_price"){

	$sql_update = "UPDATE product_real SET price='".$_POST["price"]."' WHERE id = '".$_POST["id"]."' AND hn = '".$_POST["hn"]."' AND status = '1'";
	$result_update= mysql_query($sql_update) or die(mysql_error());

$total=array();
$sql = "SELECT * from product_real where hn = '".$_POST["hn"]."' AND status = '1'";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {

array_push($total,($row["price"]*$row["pcs"]));
}
echo number_format(array_sum($total),2);


}else if($_POST["submit"]=="search_product"){
	$strSQL = "SELECT * FROM product WHERE";
	if($_POST["search"]){
    $strSQL.=" detail like '%".$_POST["search"]."%' OR code like '%".$_POST["search"]."%' ";
	}else{
	$strSQL.="1";	
	}
  $objQuery = mysql_query($strSQL) or die (mysql_error());
  $intNumField = mysql_num_fields($objQuery);
  $resultArray = array();
  while($obResult = mysql_fetch_array($objQuery))
  {
    $arrCol = array();
    for($i=0;$i<$intNumField;$i++)
    {
      $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
    }
    array_push($resultArray,$arrCol);
  }
  
  echo json_encode($resultArray);


}else if($_POST["submit"]=="save_opd_order"){

$nobill=date("YmdHis");

$sql = "SELECT * from product_real where hn = '".$_POST["hn"]."' AND status = '1'";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {

	for($t=1;$t<=$row["pcs"];$t++){
	$strSQL = "INSERT INTO opd_order SET "; 
	$strSQL .="hn = '".$row["hn"]."' ";
	$strSQL .=",nobill = '".$nobill."' ";
	$strSQL .=",course_id = '".$row["id"]."' ";
	$strSQL .=",pcs = '1' ";
	$strSQL .=",price = '".$row["price"]."' ";
	$strSQL .=",officer = '".$_SESSION["sIdname"]."' ";
	$strSQL .=",status = '1' ";
	$objQuery = mysql_query($strSQL);
	}

}
  $sql_del = "DELETE FROM product_real WHERE hn = '".$_POST["hn"]."' AND status = '1' "; 
  $query = mysql_query($sql_del);
  echo $nobill;
}
?>