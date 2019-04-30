<?php
session_start();

// print_r($_COOKIE);

// if($_COOKIE["index_page"]!="new2018" && $_GET["status"]=="1"){
// setcookie("index_page","new2018",time()+3600*24*356);
// }else if($_COOKIE["index_page"]=="oldpage"){
//     echo ("<script>window.location='../../../rs/php/index.php?'</script>");
//   //  header('Location: ../../../rs/php/index.php?');
// }


include("../data/connect.inc");

if(empty($_SESSION["sIdname"])){
    echo("<script>alert('กรุณาลงทะเบียนก่อนใช้งาน!!');window.location='login.php'</script>");
}else{

    $query = "SELECT * FROM account_login  WHERE user = '".$_SESSION[sIdname]."' and passwd='".$_SESSION[sPword]."' and status ='Y' ";
    $result = mysql_query($query) or die("Query failed1");
    if($row = mysql_fetch_object($result)){
        $_SESSION["smenucode"]=$row->menucode;
        $_SESSION["sPostition"]=$row->postition;
        $_SESSION["sMenutrue"]=$row->menutrue;
        $_SESSION["sRowid"]=$row->row_id;
        $_SESSION["sOfficer"]=$row->fullname;
    }
}
// $_SESSION["xfullname"]="Adminstrator";
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

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        function search(value){
        var obj, s
            obj = { "submit":"menu_search","search":value};
            s = document.createElement("script");
            s.src = "mysql_index.php?x=" + JSON.stringify(obj);
            document.body.appendChild(s);
        }

    function search_show(myObj) {
    var x, txt = "";
    for (x in myObj) {
        txt += "<li><a href='"+myObj[x].script+"'> <img src='../images/icon/"+myObj[x].icon+"' style='width:21px;height:21px;'>";
        txt += "&nbsp;&nbsp; "+myObj[x].menu+"</a></li>";
    }
    document.getElementById("menu-list").innerHTML = txt;
}

function login(){
    window.location='login.php?logout=Y'
}


function check_cut(ax,bx){

 var person = prompt("กรุณาใส่วันที่", bx);

if (person != null) {
  var sx = "../../../rs/php/insert_datecheck.php?datecheck="+person+"&nocheck="+ax;
    window.open( sx );
}

}
    </script>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">RS Product Supply Part., Ltd. </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right" >
                
                <li class="dropdown">
                   <!--  <a class="dropdown-toggle" data-toggle="dropdown" href="#"> -->
                         <!-- <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION["sOfficer"];?> &nbsp;<i class="fa fa-caret-down"></i> -->
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> <?php echo $_SESSION["sOfficer"];?></a></li>
                         <li><a href="login.php?logout=Y"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    <!-- </a> -->
<!--                     <ul class="dropdown-menu dropdown-user">
                        <li><a href="../../../rs/php/profile_edit.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.php?logout=Y"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul> -->
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" id="search" onkeyup="search(this.value)" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <div class="nav" id="menu-list">
                        <?



                        $rowmenu=explode(",",$_SESSION[sMenutrue]); 
                        $result = array_unique( $rowmenu );
                        $arr_results = array_filter( $result );
                        $row_menu="";
                        for($i=0;$i<count($rowmenu);$i++){
                            //echo $rowmenu[$i];
                            if($rowmenu[$i]!=""){$row_menu.=",".$rowmenu[$i];}
                        }
                        $sql = "SELECT * from menulst where status = 'Y' AND row_id IN (".substr($row_menu,1).") ORDER By menu_sort ASC";
                        $result = mysql_query($sql);
                        while ($menu = mysql_fetch_array($result) ) {
                            $target=$menu[target];
                            if(empty($target)){
                                $target="iframe_target";
                            }
                            print "<li><a href=\"$menu[script]\" target='$target'> <img src='../images/icon/$menu[icon]' style='width:21px;height:21px;'>&nbsp;&nbsp; $menu[menu]</a></li>";
                        }

                        ?>
                        </div>
                        
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- รายการ-->

        <div id="page-wrapper">
           <iframe id="iframe_target" name="iframe_target" src="display.php" style="width:100%;border:1px solid #000000;"></iframe>

    </div>
    <!-- /#wrapper -->



</body>

</html>
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../js/sb-admin-2.js"></script>