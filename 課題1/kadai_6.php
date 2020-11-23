<?php
$name = $_GET["name"];
$filename = 'kadai_6.txt';
$fp = fopen($filename,"a");

fwrite($fp,$name."\n");
fclose($fp);
?>