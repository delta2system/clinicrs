<?
session_start();
include("../data/connect.inc");
?>
<!DOCTYPE html>
<html>
<head>
	<title>ใบนัด</title>
		 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="autdor" content="">
	 <link href="../css/rs_style.css" rel="stylesheet">
	  <script src="../vendor/jquery/jquery.min.js"></script>
	   <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
	   <style type="text/css">
	   	.ptm{
	   		border-bottom: 1px solid #e0e0e0;
	   		padding: 10px;
	   		width:100%;

	   	}
	   	.ptm:hover{
	   		background-color: #ffffcc;
	   	}
	   </style>
	   <script type="text/javascript">
	   	function return_product(){
    $.ajax({
      type: "POST",
      url: "mysql_product.php",
      data: 'submit=search_product',
      cache: false,
      success: function(result)
        {
        	
 		var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {
                    	
                           $("#product").html('');
                          $.each(obj, function(key, val) {                           
                            var tr = "<div class='ptm'>";
                                //tr = tr + "<div style='flaot:left;width:60%;border:1px solid #e0e0e0;'>"+val["detail"]+"</div>";
			 					tr = tr + "<div style='text-align:left;'><input type='checkbox' value='"+val["row_id"]+"'style='width:21px;height:21px;cursor:pointer;' onclick=\"code_menuedit(this)\"> &nbsp;&nbsp;"+val["detail"]+"</div>";
								tr = tr + "</div>";
                            $('#product').append(tr);
                          });

                    }
                              
           }
    });	
}

   function hn_detail(hn){
    var hnl = hn.length;
    if(hnl==6){
    $.ajax({
      type: "POST",
      url: "mysql_opdcard.php",
      data: 'submit=return_hn&hn='+hn,
      cache: false,
      success: function(result)
        {
                var obj = jQuery.parseJSON(result);
                    if(obj != '')
                    {
                          $.each(obj, function(key, val) {
	 			$("#name_customer").val("คุณ "+val["firstname"]+" "+val["lastname"]);
                          });
                    }else{
                    	$("#name_customer").val("");
                    }
           }
    });
}
}

function calendar(){

		$("#calendar_popup").show();
		window.open('../js/fullcalendar-1.9.4/demos/calendar_notify.html' ,'iframe_calendar');
		//window.open("../js/fullcalendar-1.9.4/demos/calendar_ordersheet.html?id="+rd,"iframe_target") ;
}

function close_popup(){
	//$("#course_id").val('');
	$("#calendar_popup").hide();
}


function select_timeday(timestart){
	var chk = timestart.length;
	if(chk>10){
		var res = timestart.substr(0, 10);
		var tes = timestart.substr(11, 5);
		$("#dateday").val(res);
		$("#times").val(tes);
		
	}else{
		$("#dateday").val(timestart);
		$("#times").val("09:00");

	}
$("#opd").focus();
close_popup();
}

		function code_menuedit(str){
			var vx = document.getElementById("course_id").value;
			if(str.checked==true){
				vl = vx + ","+str.value
				//document.getElementById("code_menu").value = vl ;
				var code_array = vl.split(',');
				code_array.sort();
				document.getElementById("course_id").value = code_array.toString();

				}else{

			var code_array = vx.split(',');
			
			var i = code_array.indexOf(str.value);
			if(i != -1) {
				code_array.splice(i, 1);
				}
				code_array.sort();
				document.getElementById("course_id").value = code_array.toString();
				}
			}

function save_notify(){

	var data = "&dateday="+$("#dateday").val();
		data = data + "&times="+$("#times").val();
		data = data + "&opd="+$("#opd").val();
		data = data + "&course_id="+$("#course_id").val();
		data = data + "&other="+$("#other").val(); 
		data = data + "&officer="+$("#officer").val(); 

 $.ajax({
      type: "POST",
      url: "mysql_notify.php",
      data: 'submit=save_notify'+data,
      cache: false,
      success: function(result)
        {
        	//alert(result);
        	//appointment_print.php?
        	window.location='appointment_print.php?no='+result;
        }
    });


}

	   </script>
</head>
<body>
<table id="tabledata" style="width:400px;margin:0px auto;">

	<thead>
		<td colspan="2" style="text-align: center;"><img src="../images/logo.jpg" style="height:120px;"></td>
		<tr><td  colspan="2" style="text-align: center;font-size: 18px;">ออกใบนัดลูกค้า</td>
		<tr><td>วันที่ <input type="date" id="dateday" class="form-control" onfocus="calendar()"></td><td>เวลา <input type="time" id="times" class="form-control"></td>
		<tr><td>OPD <input type="text" id="opd" class="form-control" onkeyup="hn_detail(this.value)"></td><td>ชือ <input type="text" id="name_customer" class="form-control"></td>
		<tr><td style="padding-top: 15px;padding-bottom: 10px;">รายการนัด</td>
	</thead>
	<tbody>
		<td colspan="2" style="height:350px;overflow: hidden;">
			<div id="product" style="width:100%;height:350px;overflow: auto;">
				
			</div>
		</td>
	</tbody>
	<tfoot>
		<td colspan="2" style="padding-top: 15px;">อื่นๆ<input type="text" id="other" class="form-control">
			<input type='hidden' id="course_id"></td>
		<tr><td colspan="2">
			              ผู้นัด <select id="officer" class="form-control" style="background-color:#ffe6ff;border-color:#ff66ff;">
                <?
                $stroff="SELECT * FROM account_login WHERE status = 'Y' ";
                $result=mysql_query($stroff);
                while($of = mysql_fetch_array($result)){
                  if($_SESSION["sIdname"]==$of[user]){
                    $sel = "selected";
                  }else{
                    $sel = '';
                  }
                  echo "<option $sel value='$of[user]'>$of[fullname]</option>";
                }
                ?>
              </select>

		</td>
		<tr><td colspan="2" style="text-align: center;"><button class="btn btn-info" onclick="save_notify()">บันทึก</button></td>
	</tfoot>
	
</table>
</body>
</html>
<div id="calendar_popup" style="display:none;position: fixed;width:100%;height:100%;top:0px;left:0px;background-color: rgba(0,0,0,0.6);">
	<input type="hidden" id="calendar_id">
	<div style="position:fixed;font-size: 20px;left:50%;margin-left: 500px;margin-top: 10px;cursor: pointer;color:#ffffff;" onclick="close_popup()">&#10006;</div>
	<iframe name="iframe_calendar" id="iframe_calendar" src="" style="position:fixed;width:900px;height: 730px;background-color: #ffffff;left:50%;margin-left:-400px;margin-top: 40px;border:0px solid #e2e2e2;padding:20px;border-radius: 5px;" ></iframe>
</div>
<?echo("<script>return_product()</script>");?>