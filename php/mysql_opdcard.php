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

  function room_rs($str){
         $sql_r = "SELECT title from room_work WHERE id = '".$str."' ";
         list($room) = Mysql_fetch_row(Mysql_Query($sql_r));
         return $room;
  }

    $strSQL = "SELECT opd_order.row_id,opd_order.hn,opd_order.pcs,opd_order.price,opd_order.worker,opd_order.datedo,opd_order.timedo,opd_order.room,product.detail FROM opd_order INNER JOIN product ON opd_order.course_id = product.row_id WHERE opd_order.hn = '".$_POST["hn"]."' AND opd_order.status = '2' order by status ASC,course_id ASC,row_id ASC";
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
      $arrCol["room_title"]=room_rs($obResult["room"]);
      $arrCol["dateshow"]= date_format((date_create($obResult["datedo"]." ".$obResult["timedo"])),"d/m/Y H:i");
      array_push($resultArray,$arrCol);
    }
    
    echo json_encode($resultArray);
  
  }else if($_POST["submit"]=="add_course"){

    $sql_update = "UPDATE opd_order SET status='2' WHERE row_id = '".$_POST["row_id"]."' AND hn = '".$_POST["hn"]."' ";
    $result_update= mysql_query($sql_update) or die(mysql_error());

  }else if($_POST["submit"]=="del_course"){
    $sql_update = "UPDATE opd_order SET status='1',worker='' WHERE row_id = '".$_POST["row_id"]."' AND hn = '".$_POST["hn"]."' ";
    $result_update= mysql_query($sql_update) or die(mysql_error()); 
  }else if($_POST["submit"]=="del_time"){
   $sql_del = "DELETE FROM calendar WHERE id = '".$_POST["row_id"]."' "; 
   $query = mysql_query($sql_del);

   $sql_update = "UPDATE opd_order SET datedo='0000-00-00',timedo='00:00:00',room='' WHERE row_id = '".$_POST["row_id"]."' ";
   $result_update= mysql_query($sql_update) or die(mysql_error()); 

  }else if($_POST["submit"]=="course_worker"){
    $sql_update = "UPDATE opd_order SET worker='".$_POST["worker"]."' WHERE row_id = '".$_POST["row_id"]."' ";
    $result_update= mysql_query($sql_update) or die(mysql_error()); 
  }else if($_POST["submit"]=="print_course_worker"){
    $no=date("YmdHis");
    //$datedo=date("Y-m-d");
    //$timedo=date("H:i:s");
    $sql = "SELECT * from opd_order where hn='".$_POST["hn"]."' AND status ='2' ORDER By row_id  ASC";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result) ) {

      $strSQL = "UPDATE opd_order SET ";
      $strSQL .="no_ordersheet = '".$no."' ";
      // $strSQL .=",datedo = '".$datedo."' ";
      // $strSQL .=",timedo = '".$timedo."' ";
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

}else if($_POST["submit"]=="settime_room"){

function random_color($str){

switch($str)
{
case "1": $str = "#ff6f69"; break;
case "2": $str = "#622569"; break;
case "3": $str = "#c83349"; break;
case "4": $str = "#A4C639"; break;
case "5": $str = "#4285F4"; break;
case "6": $str = "#34A853"; break;
case "7": $str = "#EA4335"; break;
case "8": $str = "#55ACEE"; break;
case "9": $str = "#292F33"; break;
case "10": $str = "#66757F"; break;
case "11": $str = "#7CBB00"; break;
case "12": $str = " #7B0099"; break;
}
return $str;



}

      $sql = "SELECT product.time_do,product.detail,opd_order.hn,opd_order.worker from opd_order inner join product on opd_order.course_id=product.row_id WHERE opd_order.row_id = '".$_POST["id"]."' ";
      list($time_do,$detail,$hn,$worker) = Mysql_fetch_row(Mysql_Query($sql));

      $sql_r = "SELECT title from room_work WHERE id = '".$_POST["room"]."' ";
      list($room) = Mysql_fetch_row(Mysql_Query($sql_r));

      $sql_f = "SELECT fullname from account_login WHERE row_id = '".$worker."' ";
      list($fullname) = Mysql_fetch_row(Mysql_Query($sql_f));

      $title="OPD:".$hn." คอร์ส :".$detail." ห้อง : ".$room." ผู้ปฏิบัติงาน :".$fullname;

     // $dx=explode("T", $_POST["datestart"]);

      $tx=explode(":",$_POST["timestart"]);

      $end=date("H:i:s", mktime($tx[0], ($tx[1]+$time_do), 0, date("m")+0  , date("d")+0, date("Y")+0));

      $strSQL = "INSERT INTO calendar SET "; 
      $strSQL .="id = '".$_POST["id"]."'";
      $strSQL .=",resourceId = '".$_POST["room"]."'";
      $strSQL .=",title = '".$title."'";
      $strSQL .=",start = '".$_POST["datestart"]."T".$_POST["timestart"].":00-05:00'";
      $strSQL .=",end = '".$_POST["datestart"]."T".$end."-05:00'";
      $strSQL .=",color = '".random_color(rand(1,12))."'";
      $objQuery = mysql_query($strSQL)or die(mysql_error());

      
        $sql_update = "UPDATE opd_order SET datedo='".$_POST["datestart"]."',timedo='".$_POST["timestart"].":00',room='".$_POST["room"]."' WHERE row_id = '".$_POST["id"]."' ";
        $result_update= mysql_query($sql_update) or die(mysql_error());  

echo "ห้อง ".$room." <span style='color:#0099ff;'>".date_format((date_create($_POST["datestart"]." ".$_POST["timestart"])),"d/m/Y H:i")." น.</span>";

}
?>