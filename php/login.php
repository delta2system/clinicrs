<?php
    session_start();

    if($_GET["logout"]){
        session_destroy();
        // setcookie("sIdname", "", time()-3600);
        // setcookie("sPword", "", time()-3600);
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

    <title>RS Product Supply Part.,Ltd</title>

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

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">RS Product Supply Part.,Ltd</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="login.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="username" value="<?php echo $_COOKIE['sIdname'];?>" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="<?php echo $_COOKIE['sPword'];?>">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="on" checked>จำฉันไว้ตลอด
                                    </label>
                                </div>
                                <div class="alert alert-danger fade in" style="display: none;" id="wrong">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                <strong>Error!</strong> User OR Password Wrong!!!!!!.</div>

                                <div class="alert alert-success fade in" style="display: none;" id="success">
                                     <a href="#" class="close" data-dismiss="alert">&times;</a>
                                 <strong>Success!</strong> Login successfully.
                                </div>

                                <!-- Change this to a button or input when using this as a form -->
                                <!-- <a href="index.html" class="btn btn-lg btn-success btn-block">Login</a> -->
                                <input type="submit" name="submit" value="Login" class="btn btn-lg btn-success btn-block">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>

<?php
if($_POST["submit"]=="Login"){
include("../data/connect.inc");
$dbquery = mysql_query("SELECT * FROM account_login where user='".$_POST["username"]."' AND passwd='".$_POST["password"]."'");
$num_rows = mysql_num_rows($dbquery);
if($num_rows == 1) {

    $_SESSION["sIdname"]=$_POST["username"];
    $_SESSION["sPword"]=$_POST["password"];

    echo("<script>document.getElementById('wrong').style.display='none';</script>");

if($_POST["remember"] == "on") { // ถ้าติ๊กถูก Login ตลอดไป ให้ทำการสร้าง cookie
setcookie("sIdname",$_POST["username"],time()+3600*24*356);
setcookie("sPword",$_POST["password"],time()+3600*24*356);
echo("<script>document.getElementById('success').style.display='';</script>");
//header("location:index.php"); //ไปไปตามหน้าที่คุณต้องการ
echo("<script>window.location='index.php'</script>");
} else {

echo("<script>document.getElementById('success').style.display='';</script>");
//header("location:index.php"); //ไปไปตามหน้าที่คุณต้องการ
echo("<script>window.location='index.php'</script>");
}
} else {
echo("<script>document.getElementById('success').style.display='none';</script>");
echo("<script>document.getElementById('wrong').style.display='';</script>");
//header("location: login.php"); //ไม่ถูกต้องให้กับไปหน้าเดิม
}
}
//echo $_COOKIE["sIdname"];
?>