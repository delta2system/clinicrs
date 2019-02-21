<?php
session_start();
include("../data/connect.inc");

if($_GET["submit"]=="new_acc"){

//INSERT SQL
$strSQL = "INSERT INTO account_login SET "; 
$strSQL .="user = '".$_GET["user"]."' ";
$strSQL .=",passwd = '".$_GET["pass"]."' ";
$strSQL .=",fullname = '".$_GET["full"]."' ";
$strSQL .=",position = '".$_GET["pos"]."' ";
$strSQL .=",status = 'Y' ";
$objQuery = mysql_query($strSQL);
if($objQuery){
  echo "Succuss";
}

 }else if($_GET["submit"]=="edit_acc"){

$strSQL = "UPDATE account_login SET "; 
$strSQL .="user = '".$_GET["user"]."' ";
$strSQL .=",passwd = '".$_GET["pass"]."' ";
$strSQL .=",fullname = '".$_GET["full"]."' ";
$strSQL .=",position = '".$_GET["pos"]."' ";
$strSQL .=",status = 'Y' ";
$strSQL .="WHERE row_id = '".$_GET["row_id"]."' ";
$objQuery = mysql_query($strSQL);
if($objQuery){
  echo "Succuss";
}

 }else if($_GET["submit"]=="del_acc"){

  $sql_del = "DELETE FROM account_login WHERE row_id = '".$_GET["row_id"]."'"; 
  $query = mysql_query($sql_del);
  
if($query){
  echo "Succuss";
}

 }
?>