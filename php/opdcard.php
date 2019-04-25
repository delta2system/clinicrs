<?PHP
session_start();
include("../data/connect.inc");
if(empty($_COOKIE["sIdname"])){
	echo("<script>alert('กรุณาลงชื่อเข้าใช้');window.top.window.login();</script>");
}
// if(empty($_GET["hn"])){

//   $sql = "SELECT no,year from runno WHERE row_id = '1'";
//   list($no,$year) = Mysql_fetch_row(Mysql_Query($sql));

//   if($year!=(date("Y")+43)){
//   	$year=date("Y")+43;
//   	$no = "1";
//   }
//   	$no++;
//  	$sql_update = "UPDATE runno SET no='$no',year='$year' WHERE row_id='1' ";
// 	$result_update= mysql_query($sql_update) or die(mysql_error());	
// 	$hn=$year.str_pad($no,2,'0',STR_PAD_LEFT);

// }else{
// 	$hn=$_GET["hn"];
// }


?>
<!DOCTYPE html>
<html>
<head>
	<title>..:OPD CARD:..</title>
	 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="autdor" content="">
	 <link href="../css/rs_style.css" rel="stylesheet">
	  <script src="../vendor/jquery/jquery.min.js"></script>
	   <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
	 <script type="text/javascript">
	 	function save_opd() {

	 		var data = "&hn="+$("input[name=hn]").val();
	 			data = data + "&sale="+$("select[name=sale]").val();
	 			data = data + "&firstname="+$("input[name=firstname]").val();
	 			data = data + "&lastname="+$("input[name=lastname]").val();
	 			data = data + "&idcard="+$("input[name=idcard]").val();
	 			data = data + "&nickname="+$("input[name=nickname]").val();
	 			data = data + "&birthday="+$("input[name=birthday]").val();
	 			data = data + "&height_opd="+$("input[name=height_opd]").val();
	 			data = data + "&weight_opd="+$("input[name=weight_opd]").val();
	 			data = data + "&sex="+$("select[name=sex]").val();
	 			data = data + "&blood="+$("select[name=blood]").val();
	 			data = data + "&phone="+$("input[name=phone]").val();
	 			data = data + "&email="+$("input[name=email]").val();
	 			data = data + "&allergic="+$("input[name=allergic]").val();
	 			data = data + "&disease="+$("input[name=disease]").val();
	 			data = data + "&img_profile="+$("input[name=img_profile]").val();
	 			data = data + "&row_id="+$("input[name=row_id]").val();
	 			
    	 		$.ajax({
    	 		type: "POST",
    	 		url: "mysql_opdcard.php?",
    	 		data: "submit=new_opd"+data,
    	 		cache: false,
    	 		success: function(html)
    	 		{
    	 			alert("บันทึกเรียบร้อย");
    	 			window.location="opdcard_print.php?hn="+html;
    	 		}
    	 		});




	 	} 


		function SaveImage(){
   		var canvas = document.getElementById('canvas');
		var dataImage = canvas.toDataURL("image/png");
        $.ajax({
            type: "POST",
            url: "img_hn.php",
            data: { 
                data:dataImage
            }
        });
    }

    function hn_detail(hn){
    
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

	 			$("input[name=hn]").val(hn);
	 			$("input[name=sale]").val(val["sale"]);
	 			$("input[name=firstname]").val(val["firstname"]);
	 			$("input[name=lastname]").val(val["lastname"]);
	 			$("input[name=idcard]").val(val["idcard"]);
	 			$("input[name=nickname]").val(val["nickname"]);
	 			$("input[name=birthday]").val(val["birthday"]);
	 			$("input[name=height_opd]").val(val["height_opd"]);
	 			$("input[name=weight_opd]").val(val["weight_opd"]);
	 			$("select[name=sex]").val(val["sex"]);
	 			$("select[name=blood]").val(val["blood"]);
	 			$("input[name=phone]").val(val["phone"]);
	 			$("input[name=email]").val(val["email"]);
	 			$("input[name=allergic]").val(val["allergic"]);
	 			$("input[name=disease]").val(val["disease"]);
	 			$("input[name=img_profile]").val('');
	 			$("input[name=row_id]").val(val["row_id"]);
	 			$("#canvas").hide();
	 			$("#video").hide();
	 			//$("#canvas").html("<img src='../images/img_opd/"+val["img_profile"]+"'>");
	 			$("#img_preview").show();
	 			$("#img_preview").attr("src","../images/img_opd/"+val["img_profile"]+"");
                          });
                    }
           }
    });
}

function del_img(){
	var data = "&hn="+$("input[name=hn]").val();
	    	$.ajax({
    	 		type: "POST",
    	 		url: "mysql_opdcard.php?",
    	 		data: "submit=del_img"+data,
    	 		cache: false,
    	 		success: function(html)
    	 		{
    	 			//alert(html);
    	 		}
    	 		});

}
function doctor_order(){
	var hn = $("input[name=hn]").val();
	window.location='order_sheet.php?hn='+hn;
}

function pro_order(){
	var hn = $("input[name=hn]").val();
	window.location='order_course.php?hn='+hn;
}

function del_opd(){
	var r = confirm("การยกเลิก OPD Card จะไม่สามารถกู้คืนข้อมูลกลับมาได้");
	if(r==true){
		var data = "&hn="+$("input[name=hn]").val();
	    	$.ajax({
    	 		type: "POST",
    	 		url: "mysql_opdcard.php?",
    	 		data: "submit=del_opd"+data,
    	 		cache: false,
    	 		success: function(html)
    	 		{
						 //alert(html);
						 window.location='opd_search.php?';
    	 		}
    	 		});
	}
}
	 </script>
	<style type="text/css">
		input[type=text],input[type=date],select{
			border-radius:5px;
			border:1px solid #b2b2b2;
			padding:5px 5px;
			width:90%;
			font-size: 16px;
		}

		td{
			height:40px;
		}
		table{
			border-collapse: collapse;
		}



	</style>
</head>
<body>
	<div id="opdcard" style="width:850px;margin:0px auto;padding:10px 10px;background-color: #ffffff;border-radius: 5px;border:1px solid #c2c2c2;box-shadow: 5px 5px 5px rgba(0,0,0,0.1)">
		<table style="width:100%;">
	<tdead>
		<td colspan="7" style="color:#626262;text-align: center;">OPD Card</td>
		<tr>
		<td>OPD <input type="text" name="hn" style="width:120px;background-color:#cceeff;border-color:#66ccff; "></td><td style="height:80px;text-align: right;"> </td><td style="text-align: left;"></td><td></td>
		<td  style="text-align: right;" colspan="3">ชื่อเซลล์ 
			<!-- <input type="text" name="sale" style="width:150px;background-color:#ffe6ff;border-color:#ff66ff; "> -->
			<select name="sale" id="sale" style="width:160px;background-color:#ffe6ff;border-color:#ff66ff;">
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
		</tdead>
		<tbody >
		<tr>
		<td style="height: 15px;" colspan="6"></td>
		<tr>
			<td rowspan="7" style="text-align:center;">
<video id="video" width="240" height="180"  style="border:1px solid #b2b2b2;"></video>
<canvas id="canvas" width="240" height="180" style="display:none;"></canvas>

<img id="img_preview" src="" style="display:none;border-radius: 10px;box-shadow: 5px 5px 5px rgba(0,0,0,0.3);">

<br><br><br>
<button id="new_cap" class="btn btn-primary">เพิ่มรูป</button>
<button id="snap" class="btn btn-success">ถ่ายรูป</button>
<button id="del_img" class="btn btn-danger">ลบรูป</button>
			</td>
			<tr>
		<td style="text-align: right;">ชื่อ :</td><td style="text-align: left;"><input type="text" name="firstname" style="width:100%;"></td>
		<td style="text-align: right;">สกุล :</td><td style="text-align: left;"><input type="text" name="lastname" style="width:100%;"></td>
		<tr>
		<td style="text-align: right;">ชื่อเล่น :</td><td style="text-align: left;"><input type="text" name="nickname" style="width:100%;"></td>
		<td style="text-align: right;" >วันเกิด :</td><td style="text-align: left;"><input type="date" name="birthday" style="width:100%;">
		<tr><td style="text-align: right;">บัตรประชาชน : </td><td><input type="text" name="idcard"  style="width:100%;"></td>
		<td style="text-align: right;">โทร : </td><td> <input type="text" name="phone"  style="width:100%;"></td>
		<tr><td style="text-align: right;">ส่วนสูง :</td><td><input type="text" name="height_opd"  style="width:100px;"> ซม.</td>
		<td style="text-align: right;">น้ำหนัก :</td><td> <input type="text" name="weight_opd"  style="width:100px;"> Kg.</td>
		<tr><td  style="text-align: right;">เพศ : </td><td><select name="sex"  style="width:80px;"><option>ชาย</option><option>หญิง</option></select>
		<td  style="text-align: right;">กรุ๊ปเลือด : </td><td><select name="blood" style="width:50px;"><option>O</option><option>A</option><option>B</option><option>AB</option><option>ABO</option></select></td><tr>
			<td style="text-align: right;">อีเมล์ :</td><td > <input type="text" name="email" >
			<td style="text-align: right;">โรคประจำตัว : </td><td style="text-align: left;" ><input type="text" name="disease"></td>
		</td>
		<tr>
			<td></td><td style="text-align: right;">ประวัติแพ้ยา : </td><td style="text-align: left;" colspan='4'><input type="text" name="allergic" style="width:100%;"></td>
			
		<tr>
		<td colspan="7" style="height: 15px;"><hr></td>
		<tr>
			<td><button class="btn btn-primary" onclick="doctor_order()">ออกใบรักษา</button>
			<button class="btn btn-info" onclick="pro_order()">คอร์ส</button>
		</td>
			<td colspan="3" style="height: 15px;text-align: center;">
				
				<input type="hidden" name="row_id">
				<input type="hidden" name="img_profile" id="img_profile" value="">
				<button class="btn btn-success" onclick="save_opd()">บันทึก</button>
				</td>
				<td style="text-align:right;"><button class="btn btn-danger" onclick="del_opd()">ยกเลิก OPD Card</button></td>
	</tbody>
</table>

</div>
<?if(isset($_GET["hn"])){

function course_detail($str){

$sql = "SELECT detail from product where row_id = '$str'   ";
list($course) = Mysql_fetch_row(Mysql_Query($sql));
return $course ;
}

function worker($str){
$sql = "SELECT fullname from account_login where row_id = '$str'   ";
list($fullname) = Mysql_fetch_row(Mysql_Query($sql));
return $fullname ;	
}

	?>
<div style="width:850px;margin:0px auto;padding:10px 10px;background-color: #ffffff;border-radius: 5px;border:1px solid #c2c2c2;box-shadow: 5px 5px 5px rgba(0,0,0,0.1)">
<table style="width:100%;">
	<thead>
		<td colspan="6" style="text-align: center;border:1px solid #f0f0f0;font-size: 20px;">
			รายการที่ลูกค้ามีอยู่
		</td>
		<tr><td style="text-align: center;background-color: #f2f2f2;border:1px solid #f0f0f0;">คอร์ส</td>
		<td style="text-align: center;background-color: #f2f2f2;border:1px solid #f0f0f0;">เลขที่บิล</td>
		<td style="text-align: center;background-color: #f2f2f2;border:1px solid #f0f0f0;">ราคา</td>
	</thead>
<tbody>
<?
$sql_r = "SELECT * from opd_order where hn = '".$_GET["hn"]."' AND status = '1' ORDER By row_id  ASC";
$result_r = mysql_query($sql_r);
while ($data = mysql_fetch_array($result_r) ) {
print "<tr style='border-bottom:1px solid #e2e2e2;'><td>".course_detail($data[course_id])."</td>"
	  ."<td>$data[nobill_system]</td>"
	  ."<td style='text-align: right;'>$data[price]&nbsp;&nbsp;</td>"
	  ."</tr>";
}
	?>
</tbody>
</table>	


<br><br><br>

<table style="width:100%;">
	<thead>
		<td colspan="6" style="text-align: center;border:1px solid #f0f0f0;font-size: 20px;">
			รายการที่ลูกค้าทำแล้ว
		</td>
		<tr><td style="text-align: center;background-color: #f2f2f2;border:1px solid #f0f0f0;">คอร์ส</td>
		<td style="text-align: center;background-color: #f2f2f2;border:1px solid #f0f0f0;">เลขที่บิล</td>
		<td style="text-align: center;background-color: #f2f2f2;border:1px solid #f0f0f0;">ราคา</td>
		<td style="text-align: center;background-color: #f2f2f2;border:1px solid #f0f0f0;">วันที่ทำ</td>
		<td style="text-align: center;background-color: #f2f2f2;border:1px solid #f0f0f0;">เวลา</td>
		<td style="text-align: center;background-color: #f2f2f2;border:1px solid #f0f0f0;">ผู้ปฏิบัติงาน</td>
	</thead>
<tbody>
<?
$sql_r = "SELECT * from opd_order where hn = '".$_GET["hn"]."' AND status = '3' ORDER By row_id  ASC";
$result_r = mysql_query($sql_r);
while ($data = mysql_fetch_array($result_r) ) {
print "<tr style='border-bottom:1px solid #e2e2e2;'><td>".course_detail($data[course_id])."</td>"
	  ."<td>$data[nobill_system]</td>"
	  ."<td style='text-align: right;'>$data[price]&nbsp;&nbsp;</td>"
	  ."<td style='text-align: center;'>".date_format(date_create($data[datedo]),"d/m/Y")."</td>"
	  ."<td style='text-align: center;'>$data[timedo]</td>"
	  ."<td>".worker($data[worker])."</td></tr>";
}
	?>
</tbody>
</table>	
</div>
<?}?>
</body>
</html>
<?
if(isset($_GET["hn"])){
	echo "<script>hn_detail('".$_GET["hn"]."');</script>";
}
?>
<script type="text/javascript">
  // Grab elements, create settings, etc.
var video = document.getElementById('video');



  // Elements for taking the snapshot
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('video');

// Trigger photo take
document.getElementById("snap").addEventListener("click", function() {
   document.getElementById('canvas').style.display = '';	
  context.drawImage(video, 0, 0, 240, 180);
  document.getElementById('video').style.display = 'none';
  	document.getElementById('img_profile').value = 'Y';
  	document.getElementById('img_preview').style.display = 'none';
  	SaveImage();
});

document.getElementById("new_cap").addEventListener("click", function() {

// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        //video.src = window.URL.createObjectURL(stream);
        video.srcObject = stream;
        //video.play();
    });
}
	document.getElementById('video').play();
   	document.getElementById('canvas').style.display = 'none';	
  	document.getElementById('video').style.display = '';
  	document.getElementById('img_profile').value = '';
  	document.getElementById('img_preview').style.display = 'none';
  	
});

document.getElementById("del_img").addEventListener("click", function() {
context.fillStyle = "#ffffff";
context.fillRect(0, 0, 240,180);
context.strokeStyle = "#b2b2b2";
context.strokeRect(0, 0, 240, 180);
document.getElementById('img_profile').value = '';
document.getElementById('img_preview').style.display = 'none';
del_img();
	});



</script>
    <!-- jQuery -->
   

