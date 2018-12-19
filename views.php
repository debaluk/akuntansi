<?php 

if (isset($_GET['page'])) {
	$path = "pages/".$_GET['page'].".php";
	if (file_exists($path)) {
		require_once($path);
	}
	else {
		require_once("pages/404.php");
	}
}
else {
	
	//ini tidak terpakai
	//require_once("pages/home.php");
}

 ?>
 
<div id="add"></div>
