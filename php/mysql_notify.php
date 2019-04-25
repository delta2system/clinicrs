<?
session_start();
include("../data/connect.inc");


if($_POST["submit"]=="del_notify"){

  $sql_del = "DELETE FROM notify WHERE row_id = '".$_POST["row_id"]."' "; 
  $query = mysql_query($sql_del);


}else if($_POST["submit"]=="save_notify"){

      $sql_hn = "SELECT firstname,lastname from opdcard WHERE hn = '".$_POST["opd"]."'  ";
      list($firstname,$lastname) = Mysql_fetch_row(Mysql_Query($sql_hn));

$course="";
$sql = "SELECT * from product where row_id IN (".substr($_POST["course_id"],1).")";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result) ) {
$course.=" ".$row[detail]." ";
}



    $strat=$_POST["dateday"]."T".$_POST["times"].":00-0500";

    $title = $_POST["opd"]." คุณ ".$firstname." ".$lastname." มีนัดทำคอร์ส ".$course." ".$_POST["other"];
    $strSQL = "INSERT INTO notify SET "; 
    $strSQL .="start = '".$strat."' ";
    $strSQL .=",title = '".$title."' ";
    $strSQL .=",color = '#ff80d5' ";
    $strSQL .=",opd = '".$_POST["opd"]."' ";
    $strSQL .=",course_id = '".$_POST["course_id"]."' ";
    $strSQL .=",other = '".$_POST["other"]."' ";
    $strSQL .=",officer = '".$_POST["officer"]."' ";
    $objQuery = mysql_query($strSQL);

      $sql_hn = "SELECT row_id from notify WHERE 1 ORDER By row_id DESC limit 1  ";
      list($row_id) = Mysql_fetch_row(Mysql_Query($sql_hn));
echo $row_id;

}
   ?>
