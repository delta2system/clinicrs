<?
session_start();
include("../data/connect.inc");
if($_POST["submit"]=="add_product"){

    if($_POST["id"]){
        $sql = "SELECT id,pcs,detail from product_real WHERE id = '".$_POST["id"]."' AND hn = '".$_POST["hn"]."' AND status = '4' ";
        $num = mysql_num_rows(Mysql_Query($sql));
        if(!empty($num)){
            list($id,$pcs,$detail) = Mysql_fetch_row(Mysql_Query($sql));
            $pcs++;
      
          $sql_update = "UPDATE product_real SET pcs='$pcs' WHERE id = '".$_POST["id"]."' AND hn = '".$_POST["hn"]."' AND status = '4'";
          $result_update= mysql_query($sql_update) or die(mysql_error());
      
        }else{
            $sql = "SELECT detail,price from tools_product WHERE row_id = '".$_POST["id"]."' ";
            list($detail,$price) = Mysql_fetch_row(Mysql_Query($sql));
      
          $strSQL = "INSERT INTO product_real SET "; 
          $strSQL .="hn = '".$_POST["hn"]."' ";
          $strSQL .=",id = '".$_POST["id"]."' ";
          $strSQL .=",detail = '".$detail."' ";
          $strSQL .=",price = '".$price."' ";
          $strSQL .=",pcs = '1' ";
        $strSQL .=",status = '4' ";
        $objQuery = mysql_query($strSQL);
          }
      }
      

}else if($_POST["submit"]=="del_product"){

    $sql_del = "DELETE FROM product_real WHERE row_id = '".$_POST["row_id"]."' "; 
    $query = mysql_query($sql_del);
  
  }else if($_POST["submit"]=="return_product"){
  
    $strSQL = "SELECT tools_product.unit,tools_product.detail,product_real.pcs,product_real.price FROM product_real inner join tools_product on product_real.id=tools_product.row_id WHERE product_real.status = '4' ";
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
      $arrCol["total"]=$obResult["price"]*$obResult["pcs"];
      array_push($resultArray,$arrCol);
    }
    
    echo json_encode($resultArray);
  
  }else if($_POST["submit"]=="save_pos"){

    $nobill=date("YmdHis");

    $ds=explode("/",$_POST["dateday"]);
    if($_POST["hn"]){
        $hn=$_POST["hn"];
    }else{
        $hn="000000";
    }
    $discount=$_POST["discount"];


    $sql = "SELECT * from product_real where status = '4'";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result) ) {
    
        $strSQL = "INSERT INTO opd_order SET "; 
        $strSQL .="hn = '".$hn."' ";
        $strSQL .=",nobill = '".$nobill."' ";
        $strSQL .=",course_id = '".$row["id"]."' ";
        $strSQL .=",pcs = '".$row["pcs"]."' ";
        $strSQL .=",price = '".$row["price"]."' ";
        $strSQL .=",datedo= '".$ds[2]."-".$ds[1]."-".$ds[0]."'";
        $strSQL .=",officer = '".$_POST["officer"]."' ";
        $strSQL .=",discount = '".$discount."'";
        $strSQL .=",status = '4' ";
        $objQuery = mysql_query($strSQL);

        $sqls = "SELECT pcs from tools_product WHERE row_id = '".$row["id"]."' ";
        list($pcsx) = Mysql_fetch_row(Mysql_Query($sqls));

        $pcsv=$pcsx-$row["pcs"];
        $sql_update = "UPDATE tools_product SET pcs='$pcsv' WHERE row_id = '".$row["id"]."' ";
        $result_update= mysql_query($sql_update) or die(mysql_error());
        
        $discount='';
    }
      $sql_del = "DELETE FROM product_real WHERE  status = '4' "; 
      $query = mysql_query($sql_del);
      echo $nobill;
    }
?>