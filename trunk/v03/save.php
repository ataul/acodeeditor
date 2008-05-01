<?
	$code=$_GET['code'];
	
    header ("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');   
    header('Content-Disposition: attachment; filename=code.txt');
	
	echo $code;
?>