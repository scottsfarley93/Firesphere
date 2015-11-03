<?php
echo getcwd();
$wd = getcwd();
$time = time();
$name = $_FILES['image']['name'];
$filename = "../userimages/" . time() . "_" . $name;
if(move_uploaded_file($_FILES['image']['tmp_name'], $filename)){
	echo "Success. File has been saved as: " . $filename;
}else{
	 echo "error in moving file... Current working dir is: " . getcwd();
}
?>