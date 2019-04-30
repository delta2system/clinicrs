<?PHP
session_start();
include("../data/connect.inc");
if(empty($_COOKIE["sIdname"])){
	//echo("<script>alert('กรุณาลงชื่อเข้าใช้');window.top.window.login();</script>");
}

function addcomma($str){
	if($str!=""){
		return number_format($str,2);
	}else{
		return "";
	}
}

function mount_full($str){
switch($str)
{
case "01": $str = "มกราคม"; break;
case "02": $str = "กุมภาพันธ์"; break;
case "03": $str = "มีนาคม"; break;
case "04": $str = "เมษายน"; break;
case "05": $str = "พฤษภาคม"; break;
case "06": $str = "มิถุนายน"; break;
case "07": $str = "กรกฏาคม"; break;
case "08": $str = "สิงหาคม"; break;
case "09": $str = "กันยายน"; break;
case "10": $str = "ตุลาคม"; break;
case "11": $str = "พฤศจิกายน"; break;
case "12": $str = "ธันวาคม"; break;
}
return $str;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>..::Report::..</title>
		 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="autdor" content="">
     <script src="../vendor/jquery/jquery.min.js"></script>
	 <link href="../css/rs_style.css" rel="stylesheet">
	     <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">
	 <style type="text/css">
	 table{
	 	border-collapse: collapse;
	 }
	 	.body_cursor{
	 		border-bottom: 1px solid #a0a0a0;
	 		cursor: pointer;
	 	}
	 	.body_cursor:hover{
	 		background-color: #ffee00;
	 	}
	 	select{
	 		font-size: 17px;
	 		padding: 5px;
	 		border-radius: 5px;
	 		color:#606060;

	 	}
	 	.head_bt{
	 		width:290px;
	 		height:19px;
	 		text-align: center;
	 		border:1px solid #e0e0e0;
	 		float: left;
	 		padding:5px;
	 		cursor: pointer;
	 		background-color: #f0f0f0;
	 	}
	 	.head_bt:hover{
	 		background-color: #ffcc00;
	 	}
	 </style>
	 <script type="text/javascript">
	 	function addCommas(nStr)
      {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        if(x2==""){
        	x2=".00";
        }
        return x1 + x2;
      }

	 	function show_detail(ds){
	 		bt_report(1);
	 $.ajax({
    type: "POST",
    url: "mysql_report.php",
    data:"submit=detailbill&dateday="+ds,
    cache: false,
    success: function(html)
    {
   	$("#right_menu").html(html);
    }
    });


	 	}
	 	function show_bill(bill,cs){
	 		window.open("print_slip_show.php?nobill="+bill+"&status="+cs,"_blank","toolbar=no,scrollbars=yes,resizable=yes,width=400,height=600");
	 	}

	 	function search_m(){
	 		var m = $("#month").val();
	 		var y = $("#year").val();
	 		
	 		$("#show_bill_table tbody tr").remove();
                //url: "mysql_report.php" ,
                //type: "POST",
               // data: 'submit=return_bill_month&month='+m+'&year='+y,
	 $.ajax({
    type: "POST",
    url: "mysql_report.php",
    data:"submit=return_bill_month&month="+m+'&year='+y,
    cache: false,
    success: function(html)
    {
   
    var obj = jQuery.parseJSON(html);
     if(obj != ''){
     	var total_fi = 0;
     	$.each(obj, function(key, val) {
                                var tr = "<tr class='body_cursor' onclick=\"show_detail('"+val["datereturn"]+"')\">";
                                    tr = tr + "<td style='text-align:center;padding:5px 0px;'>"+val["dateday"]+"</td>";
                                    tr = tr + "<td style='text-align:right;padding:5px 0px;'>"+val["total"]+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                                   	tr = tr + "</tr>";
                                    $('#show_bill_table > tbody:last').append(tr);
                                    total_fi = total_fi + parseFloat(val["total_fi"]);
     	});
     	var td = "<tr class='body_cursor'><td style='text-align:center;background-color: #a0a0a0;padding:7px 0px;'>รวมรายการทั้งเดือน</td><td style='text-align:right;color:#ff0000;font-weight:bold;'>"+addCommas(total_fi)+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
     	 $('#show_bill_table > tbody:last').append(td);

   	 }

    }
    });

	 
        }
        function bt_report(n){
        	if(n==1){
        		$('#right_menu').html('');
        		$("#bt_month").css({"background-color": "#4d94ff","color":"#ffffff"});
        		$("#bt_year").css({"background-color": "#f0f0f0","color":"#606060"});
        		$("#bt_emp").css({"background-color": "#f0f0f0","color":"#606060"});
        	}else if(n==3){
        		$('#right_menu').html('');
        		$("#bt_month").css({"background-color": "#f0f0f0","color":"#606060"});
        		$("#bt_year").css({"background-color": "#f0f0f0","color":"#606060"});
        		$("#bt_emp").css({"background-color": "#4d94ff","color":"#ffffff"});
        		var y = $("#year").val();
        		var m = $("#month").val();
        		var dt = "<div style='padding-top:50px;padding-bottom:30px;width:400px;height:30px;font-size:21px;font-weight:bold;color:#606060;margin:0px auto;'>รายงานการทำงานพนักงาน "+y+"</div>";
        			dt = dt + "<div id='morris-bar-chart' style='width:95%;margin:0px auto;'></div>";
        			dt = dt + "<table id='morris-status' style='width:90%;margin:0px auto;text-align:center;'></table>";
        		$('#right_menu').append(dt);
    $.ajax({
    type: "POST",
    url: "mysql_report.php",
    data:"submit=return_morrisemp&month="+m+"&year="+y,
    cache: false,
    success: function(html)
    {

    	var obj = jQuery.parseJSON(html);

      Morris.Bar({
        element: 'morris-bar-chart',
        data: obj,
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Series A'],
        hideHover: 'auto',
        barColors:['#ffb366'],
        gridTextColor:'#606060',
        gridTextSize:'14',
        grid:true,
        resize: true
    });	

    $.each(obj, function(key, val) {
    var td = "<td style='padding:5px;text-align:center;width:160px;color:#ffffff;background-color:#3399ff;'>"+val["y"]+" : </td>";
    // var td =  "<td style='padding:5px;text-align:right;color:#606060;'>"+addCommas(val["a"])+"</td>";
        $('#morris-status').append(td);
   });
    $('#morris-status').append("<tr>");
    $.each(obj, function(key, val) {
    //var td = "<tr><td style='padding:5px;text-align:right;width:160px;color:#606060;'>"+val["y"]+" : </td>";
    var td =  "<td style='padding:5px;text-align:center;color:#606060;'>"+addCommas(val["a"])+"</td>";
        $('#morris-status').append(td);
   });
    }
	  });
        	}else if(n==2){
        		$('#right_menu').html('');
        		$("#bt_month").css({"background-color": "#f0f0f0","color":"#606060"});
        		$("#bt_year").css({"background-color": "#4d94ff","color":"#ffffff"});
        		$("#bt_emp").css({"background-color": "#f0f0f0","color":"#606060"});
        		var y = $("#year").val();
        		var dt = "<div style='padding-top:50px;padding-bottom:30px;width:400px;height:30px;font-size:21px;font-weight:bold;color:#606060;margin:0px auto;'>รายงานประจำปี "+y+"</div>";
        			dt = dt + "<div id='morris-bar-chart' style='width:95%;margin:0px auto;'></div>";
        			dt = dt + "<table id='morris-status' style='width:400px;margin:0px auto;text-align:center;'></table>";
        		$('#right_menu').append(dt);
				total_year(y);
        		

     $.ajax({
    type: "POST",
    url: "mysql_report.php",
    data:"submit=return_morrisjs&year="+y,
    cache: false,
    success: function(html)
    {
    	var obj = jQuery.parseJSON(html);

      Morris.Bar({
        element: 'morris-bar-chart',
        data: obj,
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Series A'],
        hideHover: 'auto',
        barColors:['#ffb366'],
        gridTextColor:'#606060',
        gridTextSize:'14',
        grid:true,
        resize: true
    });	

    $.each(obj, function(key, val) {
    var td = "<tr><td style='padding:5px;text-align:right;width:160px;color:#606060;'>"+val["y"]+" : </td>";
        td = td + "<td style='padding:5px;text-align:right;padding-right:80px;color:#606060;'>"+addCommas(val["a"])+"</td>";
        $('#morris-status').append(td);

   });




    }
        	});
        }

    }

    function total_year(ds){
    $.ajax({
    type: "POST",
    url: "mysql_report.php",
    data:"submit=return_totalyear&year="+ds,
    cache: false,
    success: function(html)
    {
    	//$('#morris-status').css({"height": height + "px"})
    	var datax = "<tr><td colspan='2'><span style='color:#606060;font-size:22px;'> ยอดรวมทั้งหมด </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#ff0000;font-size:22px;'>"+ addCommas(html)+" ฿</sapn></td>";
    	$('#morris-status').append(datax);
    	//alert(html);
    }
        	});

    }


	 </script>
</head>
<body>
<div style="position:absolute;left:0px;top:0px;width:99%;height:30px;border:1px solid #e0e0e0;">
	<div id="bt_month" class="head_bt" style="background-color:#4d94ff;color: #ffffff;" onclick="bt_report(1)">รายงานประจำเดือน</div>
	<div  id="bt_year" class="head_bt" style="color:#606060;" onclick="bt_report(2)">รายงานประจำปี</div>
	<div  id="bt_emp" class="head_bt" style="color:#606060;" onclick="bt_report(3)">รายงานการทำงานพนักงาน</div>
</div>
<div id="left_menu" style="position:absolute;left:0px;top:30px;width:300px;border:1px solid #addadd;">
	<div style="width:280px;height:60px;border-bottom:1px solid #e1e1e1;padding:10px 10px;color:#808080;text-align: center;">
<!-- 		ค้นหา <input type="text" id="search" style="padding: 5px;text-align: center;width:200px;font-size: 16px;color:#606060;border-radius: 5px;border:1px solid #a0a0a0;"> -->
<span style="font-size: 21px;font-family: Tahoma;color:#1a75ff;">รายงานประจำเดือน</span> <br>
<select id="month" onchange="search_m()">
<?
for($m=1;$m<=12;$m++){
	if($m==date("m")){$se="selected";}else{$se="";}
	echo "<option $se value='".str_pad($m,2,'0',STR_PAD_LEFT)."'>".mount_full(str_pad($m,2,'0',STR_PAD_LEFT))."</option>";
}
?>
</select>
<select id="year" onchange="search_m()">
	<option><?=date("Y")?></option>
	<option><?=date("Y")-1?></option>
	<option><?=date("Y")-2?></option>

</select>
	</div>
<div id="report_day" style="width:300px;overflow-x:  auto;">
<table id="show_bill_table" style="width:100%;">
	<thead>
		<td style="text-align: center;background-color: #a0a0a0;padding:7px 0px;">วันที่</td>
		<td style="text-align: center;background-color: #a0a0a0;padding:7px 0px;">จำนวนเงิน</td>
	</thead>
	<tbody>
		
	
	<?
$arr_total=array();

	for($d=1;$d<=31;$d++){
$total=0;
$date=date("Y").str_pad(date("m"),2,"0",STR_PAD_LEFT).str_pad($d,2,"0",STR_PAD_LEFT);
$sql = "SELECT * from opd_order WHERE nobill_system like '".$date."%' ";
$result = mysql_query($sql);
$num = mysql_num_rows($result);
if($num){
while ($row = mysql_fetch_array($result) ) {
$total=$total+($row[pcs]*$row[price]);

	}
echo "<tr class='body_cursor' onclick=\"show_detail('$date')\"><td style='text-align:center;padding:5px 0px;'>".substr($date,6,2)."/".substr($date,4,2)."/".substr($date,0,4)."</td><td style='text-align:right;padding:5px 0px;'>".addcomma($total)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

	}
array_push($arr_total,$total);
}
echo "<tr class='body_cursor'><td style='text-align:center;background-color: #a0a0a0;padding:7px 0px;'>รวมรายการทั้งเดือน</td><td style='text-align:right;color:#ff0000;font-weight:bold;'>".addcomma(array_sum($arr_total))."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

	?>
	</tbody>
	</table>
</div>
</div>
<div id="right_menu" style="position:absolute;left:300px;top:30px;overflow-x: auto;">
	
	

</div>
</body>
</html>
<script type="text/javascript">
	  $(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        
        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        width = width-302;
            $("#left_menu").css({"height": height + "px"});
            $("#right_menu").css({"width": width + "px"});
            $("#right_menu").css({"height": height + "px"});
            $("#report_day").css({"height": (height-80) + "px"});
            
     });

});

</script>

    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
