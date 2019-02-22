<?php
$ServerName = "localhost";
$DatabaseName = "rs_menu";
$User = "root"; 
$Password = "12345678";

$Conn = mysql_connect($ServerName,$User,$Password) or die ("ไม่สามารถติดต่อกับเซิร์ฟเวอร์ได้ ");
mysql_select_db($DatabaseName,$Conn) or die ("ไม่สามารถติดต่อกับฐานข้อมูลได้");

mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");
$add_complete="บันทึกข้อมูลเรียบร้อยแล้ว";
$edit_complete="แก้ไขข้อมูลเรียบร้อยแล้ว";


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


</head>

<body>
<div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables" style="border:0px solid #e2e2e2;">
                                <thead>
                                    <tr>
                                        <th colspan="5" style="border:0px solid #e2e2e2;"></th>
                                        <th style="border:0px solid #e2e2e2;text-align: right;font-size: 20px;"><i class="fa fa-search"></i></th>
                                        <th colspan="2" style="border:0px solid #e2e2e2;"> <input type="search" name="search" class="form-control"></th>
                                    <tr><th>#</th>
                                        <th></th>
                                        <th>HN</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>ชื่อเล่น</th>
                                        <th>เลขที่บัตร</th>
                                        <th>เบอร์โทรศัพท์</th>
                                        <th>เพศ</th>
                                    </tr>
                                </thead>
                                <tbody>
                          <?
                          $sql = "SELECT * from order_food  ORDER By row_id  DESC limit 200";
                          $result = mysql_query($sql);
                          while ($row = mysql_fetch_array($result) ) {
                            $r++;
                              print "<tr >"
                                    ."<td>$r</td>"
                                    ."<td>$row[dateday]</td>"
                                    ."<td>$row[nobill]</td>"
                                    ."<td>$row[table_id]</td>"
                                    ."<td>$row[food_name]</td>"
                                    ."<td>$row[pcs]</td>"
                                    ."<td>$row[price]</td>"
                                    ."<td>".$row[pcs]*$row[price]."</td>"
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
