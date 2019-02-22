<?
session_start();
include("../data/connect.inc");

if($_POST["submit"]=="new_product"){

if(empty($_POST["row_id"])){

$strSQL = "INSERT INTO tools_product SET "; 
$strSQL .="detail = '".$_POST["detail"]."' ";
$strSQL .=",price = '".$_POST["price"]."' ";
$strSQL .=",unit = '".$_POST["unit"]."' ";
$strSQL .=",pcs = '".$_POST["pcs"]."' ";
$objQuery = mysql_query($strSQL);
}else{
	$sql_update = "UPDATE tools_product SET detail='".$_POST["detail"]."',pcs='".$_POST["pcs"]."',unit='".$_POST["unit"]."',price='".$_POST["price"]."' WHERE row_id = '".$_POST["row_id"]."'";
	$result_update= mysql_query($sql_update) or die(mysql_error());	
}


}else if($_POST["submit"]=="del_product"){

  $sql_del = "DELETE FROM tools_product WHERE row_id = '".$_POST["row_id"]."' "; 
  $query = mysql_query($sql_del);


}else if($_POST["submit"]=="search_product"){

  $strSQL = "SELECT * FROM tools_product WHERE ";
  if(empty($_POST["search"])){
    $strSQL.=" 1";
  }else{
    $strSQL.="detail like '%".$_POST["search"]."%' OR code like '%".$_POST["search"]."%'";
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

}else if($_POST["submit"]=="addtools"){


  if($_POST["row_id"]){

    $sql = "SELECT id_tools,pcs from product_tools WHERE id_tools = '".$_POST["row_id"]."' AND id = '".$_POST["row_id_tools"]."' ";
    $num = mysql_num_rows(Mysql_Query($sql));
    if(!empty($num)){
      list($id,$pcs) = Mysql_fetch_row(Mysql_Query($sql));
      $pcs++;
  
    $sql_update = "UPDATE product_tools SET pcs='$pcs' WHERE id_tools = '".$_POST["row_id"]."' AND id = '".$_POST["row_id_tools"]."' ";
    $result_update= mysql_query($sql_update) or die(mysql_error());
  
    }else{
      $sql = "SELECT detail from tools_product WHERE row_id = '".$_POST["row_id"]."' ";
      list($detail) = Mysql_fetch_row(Mysql_Query($sql));
  
    $strSQL = "INSERT INTO product_tools SET "; 
    $strSQL .="id = '".$_POST["row_id_tools"]."' ";
    $strSQL .=",id_tools = '".$_POST["row_id"]."' ";
    $strSQL .=",pcs = '1' ";
    $strSQL .=",status = '1' ";
    $objQuery = mysql_query($strSQL);
    }
  }


}else if($_POST["submit"]=="return_real_tools"){
    $strSQL = "SELECT tools_product.detail,tools_product.unit,product_tools.pcs,product_tools.row_id FROM product_tools inner join tools_product ON product_tools.id_tools=tools_product.row_id WHERE product_tools.id = '".$_POST["row_id"]."' GROUP By id_tools ";
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
}else if($_POST["submit"]=="deltools"){
  $sql_del = "DELETE FROM product_tools WHERE row_id = '".$_POST["row_id"]."' "; 
  $query = mysql_query($sql_del);
}
?>