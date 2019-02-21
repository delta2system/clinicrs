<?php
session_start();
include("../data/connect.inc");

if(empty($_SESSION["sIdname"])){
    echo("<script>alert('กรุณาลงทะเบียนก่อนใช้งาน!!');window.location='login.php'</script>");
}


function month_thai($month){

switch($month)
{
case "01":$month = "มกราคม";break;
case "02":$month = "กุมภาพันธ์";break;
case "03":$month = "มีนาคม";break;
case "04":$month = "เมษายน";break;
case "05":$month = "พฤษภาคม";break;
case "06":$month = "มิถุนายน";break;
case "07":$month = "กรกฏาคม";break;
case "08":$month = "สิงหาคม";break;
case "09":$month = "กันยายน";break;
case "10":$month = "ตุลาคม";break;
case "11":$month = "พฤศจิกายน";break;
case "12":$month = "ธันวาคม";break;
}
return $month;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>.::RS Product Supply Part., Ltd.::. </title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
      function search(val){
    $.ajax({
      type: "POST",
      url: "mysql_opdcard.php",
      data: 'submit=search_opd&data='+val,
      cache: false,
      success: function(result)
        {
            var r=0;
            $("#dataTables tbody tr").remove();
                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {                     
                          $.each(obj, function(key, val) {
                             r++;
                            var td = "<tr ondblclick=\"window.location='opdcard.php?hn="+val["hn"]+"'\">";
                                td = td +"<td>"+r+"</td>";
                                    td = td +"<td><img src='../images/img_opd/"+val["img_profile"]+"' style='width:120px;'></td>";
                                    td = td +"<td>"+val["hn"]+"</td>";
                                    td = td +"<td>"+val["firstname"]+" "+val["lastname"]+"</td>";
                                    td = td +"<td>"+val["nickname"]+"</td>";
                                    td = td +"<td>"+val["idcard"]+"</td>";
                                    td = td +"<td>"+val["phone"]+"</td>";
                                    td = td +"<td>"+val["sex"]+"</td>";
                                    td = td +"<td>"+val["blood"]+"</td>";
                                    td = td +"</tr>";
                                  $('#dataTables > tbody:last').append(td);  
                          });
                    }
           }
    });
}
      
    </script>


</head>

<body>
<div class="panel-body">
  <div><input type="search" name="search" onkeyup="search(this.value)" class="form-control" style="width:200px;"><i class="fa fa-search" style="position: absolute;margin-top: -25px;margin-left: 180px;"></i></div>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables" >
                                <thead>
                                    <tr><th>#</th>
                                        <th></th>
                                        <th>HN</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>ชื่อเล่น</th>
                                        <th>เลขที่บัตร</th>
                                        <th>เบอร์โทรศัพท์</th>
                                        <th>เพศ</th>
                                        <th>กรุ๊ปเลือด</th>
                                    </tr>
                                </thead>
                                <tbody>
                          <?
                          $sql = "SELECT * from opdcard  ORDER By hn  DESC limit 10";
                          $result = mysql_query($sql);
                          while ($row = mysql_fetch_array($result) ) {
                            $r++;
                              print "<tr ondblclick=\"window.location='opdcard.php?hn=$row[hn]'\">"
                                    ."<td>$r</td>"
                                    ."<td><img src='../images/img_opd/$row[img_profile]' style='width:120px;'></td>"
                                    ."<td>$row[hn]</td>"
                                    ."<td>$row[firstname] $row[lastname]</td>"
                                    ."<td>$row[nickname]</td>"
                                    ."<td>$row[idcard]</td>"
                                    ."<td>$row[phone]</td>"
                                    ."<td>$row[sex]</td>"
                                    ."<td>$row[blood]</td>"
                                    ."</tr>";
                          }

                          ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->

                        </div>

</body>

</html>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
<!--         <script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            responsive: true
        });
    });
    </script> -->