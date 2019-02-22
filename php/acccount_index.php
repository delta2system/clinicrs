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

function save_acc(){
    var nx = $("input[name=row_id]").val();
    var td = "&user=" + $("input[name=username]").val();
        td = td + "&pass=" + $("input[name=password]").val();
        td = td + "&pos=" + $("input[name=position]").val();
        td = td + "&full=" + $("input[name=fullname]").val();

if(nx==""){
   url = 'acc_mysql.php?submit=new_acc'+td;
}else{
    td = td + "&row_id="+nx;
   url = 'acc_mysql.php?submit=edit_acc'+td;
}

    var  xmlhttp = new XMLHttpRequest();
         xmlhttp.open("GET", url, false);
         xmlhttp.send(null); 
     var msg = xmlhttp.responseText;
     if(msg!=""){
        location.reload();  
     }

}

function del_acc(vx,dx){

    var r = confirm("ต้องการลบผู้ใช้งาน "+dx);
    if(r==true){
       url = 'acc_mysql.php?submit=del_acc&row_id='+vx;
    var  xmlhttp = new XMLHttpRequest();
         xmlhttp.open("GET", url, false);
         xmlhttp.send(null); 
     var msg = xmlhttp.responseText;
     if(msg!=""){
        location.reload();  
     }
 }
}

function edit_user(rd,ft,us,pa,po){


$("input[name=row_id]").val(rd);
$("input[name=username]").val(us);
$("input[name=password]").val(pa);
$("input[name=position]").val(po);
$("input[name=fullname]").val(ft);


$("#popup").show();
}

function new_acc() {
    
    $('input[name=row_id]').val('');
    $("input[name=username]").val('');
    $("input[name=password]").val('');
    $("input[name=position]").val('');
    $("input[name=fullname]").val('');
    $('input[name=username]').focus();
    $('#popup').toggle();
}

    </script>
</head>

<body>

            <div class="row">
                <div class="col-lg-12">
<!--                 <button class="btn btn-default">เพิ่มหน่วยงาน</button>
                <button class="btn btn-default">เพิ่มหน่วยงาน</button>
                <button class="btn btn-default">เพิ่มหน่วยงาน</button> -->
                    <div class="panel panel-green">

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead >
                                        <th style="width:50px;background-color: #008741;color:#ffffff;">Username</th>
                                        <th style="background-color: #008741;color:#ffffff;">ชื่อผู้ใช้งาน</th>
                                        <th style="background-color: #008741;color:#ffffff;">ตำแหน่ง</th>
                                        <th style="background-color: #008741;color:#ffffff;">เข้าใช้งานล่าสุด</th>
                                        <th style="background-color: #008741;width:100px;"></th>
                                    </thead>
                                    <tbody>
                                    <?

                                    $sql = "SELECT * from account_login  WHERE status='Y' ORDER By row_id  ASC";
                                    $result = mysql_query($sql);
                                    while ($row = mysql_fetch_array($result) ) {
                                        echo "<tr><td >$row[user]</td>"
                                             ."<td>$row[fullname]</td>"
                                             ."<td>$row[position]</td>"
                                             ."<td>".date_format( date_create($row[lastlogin]),"d-m-Y H:i:s")."</td>"
                                             ."<td> <button class='btn btn-warning' onclick=\"edit_user('$row[row_id]','$row[fullname]','$row[user]','$row[passwd]','$row[position]')\"><i class='fa fa-pencil'></i></button>"
                                             ." <button class='btn btn-danger' onclick=\"del_acc('$row[row_id]','$row[fullname]')\">X</button></td>"
                                             ."</tr>";
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                        <td colspan="3"><button class="btn btn-success" onclick="new_acc()">เพิ่มผู้ใช้งาน</button></td>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            <!-- /.row -->

           <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

</body>
<div id="popup" style="display:none;background-color: rgba(0,0,0,0.5);width:100%;height:100%;position: fixed;top:0px;left:0px;z-index: 5;">
  <div class="modal-dialog" style="margin-top: 200px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="$('#popup').hide()">×</button>
        <h4 class="modal-title">เพิ่มผู้ใช้งาน</h4>
      </div>
      <div class="modal-body">
        <label>Username</label>
        <input class="form-control" type="text" name="username" placeholder="Username">
        <label>Password</label>
        <input class="form-control" type="password" name="password" placeholder="Password">
        <label>ชื่อผู้ใช้งาน</label>
        <input class="form-control" type="text" name="fullname" placeholder="ชื่อผู้ใช้">
        <label>ตำแหน่ง</label>
        <input class="form-control" type="text" name="position" placeholder="ตำแหน่ง">
        <input type="hidden" name='row_id'>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#popup').hide()">ปิด</button>
        <button type="button" class="btn btn-success" onclick="save_acc()">บันทึก</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</html>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
