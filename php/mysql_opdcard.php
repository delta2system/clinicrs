<?php
session_start();
include("../data/connect.inc");


if($_POST["submit"]=="new_opd"){
if(empty($_POST["hn"])){
  $sql = "SELECT no,year from runno WHERE row_id = '1'";
  list($no,$year) = Mysql_fetch_row(Mysql_Query($sql));

  if($year!=(date("y")+43)){
  	$year=date("y")+43;
  	$no = "0";
  }
  	$no++;

 	$sql_update = "UPDATE runno SET no='$no',year='$year' WHERE row_id='1' ";
	$result_update= mysql_query($sql_update) or die(mysql_error());	

	$hn=$year.str_pad($no,4,'0',STR_PAD_LEFT);
}else{
	$hn=$_POST["hn"];
}			

	 		if($_POST["img_profile"]=="Y" && $_POST["hn"]==""){
 			if($_POST["img_profile"]=="Y"){
	 			$img_profile=$hn.".png";
	 		}else{
	 			$img_profile="noImage.png";
	 		}
	 		}else if($_POST["img_profile"]=="Y" && $_POST["hn"]!=""){
 			if($_POST["img_profile"]=="Y"){
	 			$img_profile=$hn.".png";
	 		}
	 		}

			if($_POST["hn"]){
			$strSQL = "UPDATE opdcard SET ";
			}else{
			$strSQL = "INSERT INTO opdcard SET "; 
			}
	 		$strSQL .="hn = '".$hn."'";
	 		$strSQL .=",sale = '".$_POST["sale"]."'";
	 		$strSQL .=",firstname = '".$_POST["firstname"]."'";
	 		$strSQL .=",lastname = '".$_POST["lastname"]."'";
	 		$strSQL .=",idcard = '".$_POST["idcard"]."'";
	 		$strSQL .=",nickname = '".$_POST["nickname"]."'";
	 		$strSQL .=",birthday = '".$_POST["birthday"]."'";
	 		$strSQL .=",height_opd = '".$_POST["height_opd"]."'";
	 		$strSQL .=",weight_opd = '".$_POST["weight_opd"]."'";
	 		$strSQL .=",sex = '".$_POST["sex"]."'";
	 		$strSQL .=",blood = '".$_POST["blood"]."'";
	 		$strSQL .=",phone = '".$_POST["phone"]."'";
	 		$strSQL .=",email = '".$_POST["email"]."'";
	 		$strSQL .=",allergic = '".$_POST["allergic"]."'";
	 		$strSQL .=",disease = '".$_POST["disease"]."'";
	 		if($_POST["img_profile"]=="Y"){
	 		$strSQL .=",img_profile = '".$img_profile."'";
	 		}
	 		$strSQL .=",status = 'Y' ";
	 		if(empty($_POST["hn"])){
	 		$strSQL .=",regis_date = '".date("Y-m-d H:i:s")."'";	 		
	 		}else{	
	 		$strSQL .="WHERE row_id = '".$_POST["row_id"]."' ";
	 		}
	 		$objQuery = mysql_query($strSQL);

if($_POST["img_profile"]=="Y"){	 	
copy("../images/img_opd/new_img.png","../images/img_opd/".$hn.".png");
unlink("../images/img_opd/new_img.png");
}

}else if($_POST["submit"]=="return_hn"){

  $strSQL = "SELECT * FROM opdcard WHERE hn = '".$_POST["hn"]."' ";
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
  
  //mysql_close($Conn);
  
  echo json_encode($resultArray);
}else if($_POST["submit"]=="del_img"){

$sql_update = "UPDATE opdcard SET img_profile='noImage.png' WHERE hn='".$_POST["hn"]."' ";
$result_update= mysql_query($sql_update) or die(mysql_error());

unlink("../images/img_opd/".$_POST["hn"].".png");

}else if($_POST["submit"]=="search_opd"){

if($_POST["data"]){
  $strSQL = "SELECT * FROM opdcard WHERE ";
  $strSQL.= "hn like '%".$_POST["data"]."%' OR ";
  $strSQL.= "sale like '%".$_POST["data"]."%' OR ";
  $strSQL.= "firstname like '%".$_POST["data"]."%' OR ";
  $strSQL.= "lastname like '%".$_POST["data"]."%' OR ";
  $strSQL.= "idcard like '%".$_POST["data"]."%' OR ";
  $strSQL.= "nickname like '%".$_POST["data"]."%' OR ";
  $strSQL.= "phone like '%".$_POST["data"]."%' ";
  $strSQL.= "ORDER By hn DESC";
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
  
  //mysql_close($Conn);
  }else{

  $strSQL = "SELECT * FROM opdcard WHERE 1 ORDER By hn DESC limit 10";
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

  }
  echo json_encode($resultArray);


}else if($_POST["submit"]=="return_course"){
  
  $strSQL = "SELECT opd_order.row_id,opd_order.hn,opd_order.pcs,opd_order.price,product.detail FROM opd_order INNER JOIN product ON opd_order.course_id = product.row_id WHERE opd_order.hn = '".$_POST["hn"]."' AND opd_order.status = '1' order by status ASC,course_id ASC,row_id ASC";
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

}else  if($_POST["submit"]=="return_select_course"){

  $sql = "SELECT * from account_login where user!='admin' ORDER By row_id  ASC";
  $result = mysql_query($sql);
  $officer="<option value=''></option>";
  while ($row = mysql_fetch_array($result) ) {
    $officer.="<option value='$row[row_id]'>$row[fullname]</option>";
  }

    $strSQL = "SELECT opd_order.row_id,opd_order.hn,opd_order.pcs,opd_order.price,opd_order.worker,product.detail FROM opd_order INNER JOIN product ON opd_order.course_id = product.row_id WHERE opd_order.hn = '".$_POST["hn"]."' AND opd_order.status = '2' order by status ASC,course_id ASC,row_id ASC";
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
      $arrCol["officer"]=$officer;
      array_push($resultArray,$arrCol);
    }
    
    echo json_encode($resultArray);
  
  }else if($_POST["submit"]=="add_course"){

    $sql_update = "UPDATE opd_order SET status='2' WHERE row_id = '".$_POST["row_id"]."' AND hn = '".$_POST["hn"]."' ";
    $result_update= mysql_query($sql_update) or die(mysql_error());

  }else if($_POST["submit"]=="del_course"){
    $sql_update = "UPDATE opd_order SET status='1',worker='' WHERE row_id = '".$_POST["row_id"]."' AND hn = '".$_POST["hn"]."' ";
    $result_update= mysql_query($sql_update) or die(mysql_error()); 
  }else if($_POST["submit"]=="course_worker"){
    $sql_update = "UPDATE opd_order SET worker='".$_POST["worker"]."' WHERE row_id = '".$_POST["row_id"]."' ";
    $result_update= mysql_query($sql_update) or die(mysql_error()); 
  }else if($_POST["submit"]=="print_course_worker"){
    $no=date("YmdHis");
    $datedo=date("Y-m-d");
    $timedo=date("H:i:s");
    $sql = "SELECT * from opd_order where hn='".$_POST["hn"]."' AND status ='2' ORDER By row_id  ASC";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result) ) {

      $strSQL = "UPDATE opd_order SET ";
      $strSQL .="no_ordersheet = '".$no."' ";
      $strSQL .=",datedo = '".$datedo."' ";
      $strSQL .=",timedo = '".$timedo."' ";
      $strSQL .=",officerdo = '".$_SESSION["sIdname"]."' ";
      $strSQL .=",status = '3' ";
      $strSQL .="WHERE row_id = '".$row[row_id]."' ";
      $objQuery = mysql_query($strSQL);    

      $sql_tools = "SELECT * from product_tools where id='".$row[course_id]."'";
      $result_tools = mysql_query($sql_tools);
      while ($tools = mysql_fetch_array($result_tools) ) {

        $sqls = "SELECT pcs from tools_product WHERE row_id = '".$tools["id_tools"]."'  ";
        list($pcs) = Mysql_fetch_row(Mysql_Query($sqls));

        $sql_update = "UPDATE tools_product SET pcs='".($pcs-$tools[pcs])."' WHERE row_id = '".$tools["id_tools"]."' ";
        $result_update= mysql_query($sql_update) or die(mysql_error());  

        
    }
 
  }
  echo $no;
}else if($_POST["submit"]=="del_opd"){


  $sql = "SELECT img_profile from opdcard WHERE hn = '".$_POST["hn"]."'  ";
  list($img_profile) = Mysql_fetch_row(Mysql_Query($sql));
  if($img_profile!="noImage.png"){
    $unlink="../images/img_opd/".$img_profile;
    unlink($unlink);  // ฟังก์ชั่นลบไฟล์ที่มี พาธ images/test.jpg
  }

  $sql_del = "DELETE FROM opdcard WHERE hn = '".$_POST["hn"]."' "; 
  $query = mysql_query($sql_del);

}
?>