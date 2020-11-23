<?php
$filename = 'kadai_6.txt';
$file_array = file($filename);
foreach ($file_array as $value){
  echo $value;
}
?>