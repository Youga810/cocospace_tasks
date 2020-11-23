<?php
  $filename = "kadai_2-2.txt";
  $name = $_GET["name"];
  $comment = $_GET["comment"];
  echo "お名前に[".$name."],コメントに[".$comment."]が入力されました。";

  
  $fp = fopen($filename,"a");
  $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  if(empty($lines)){
    $last_num = 0;
  }else{
    list($last_num, $last_name,$last_comment,$last_time) = explode("<>", array_pop($lines));
    $last_num++;
  }
  fwrite($fp,$last_num."<>".$name."<>".$comment."<>".date("Y年m月d日 H時i分s秒")."\n");
  fclose($fp);
?>