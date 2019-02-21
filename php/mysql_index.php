<?php
session_start();
include("../data/connect.inc");

header("Content-Type: application/json; charset=UTF-8");

$obj = json_decode($_GET["x"], false);
// $arr=array();
// $arr["submit"]="menu_search";
// $arr["search"]="ใบแทน";
// $es=json_encode($arr);
// $obj = json_decode($es, false);

 if($obj->submit =="menu_search"){

                        $rowmenu=explode(",",$_SESSION[sMenutrue]); 
                        $result = array_unique( $rowmenu );
                        $arr_results = array_filter( $result );
                        $row_menu="";      
                        for($i=0;$i<count($arr_results);$i++){
                            if($arr_results[$i]!=""){$row_menu.=",".$arr_results[$i];}
                        }

  $strSQL="SELECT * from menulst where status = 'Y' AND menu like '%".$obj->search."%' AND row_id IN (".substr($row_menu,1).") ORDER By menu_sort ASC";
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



 echo "search_show(".json_encode($resultArray).")";


 }
?>