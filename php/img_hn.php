<?php
//save.php code
$fileName = "../images/img_opd/new_img.png";
//Get the base-64 string from data
$filteredData=substr($_POST['data'], strpos($_POST['data'], ",")+1);
//Decode the string
$unencodedData=base64_decode($filteredData);
//Save the image
file_put_contents($fileName, $unencodedData);

echo json_encode($fileName);

?>