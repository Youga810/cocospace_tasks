<?php
  $dsn = 'mysql:dbname=co_19_265_99sv_coco_com;host=localhost';
  $user = 'co-19-265.99sv-c';
  $password = 'N5dDfJih';
  #DB接続
  try{
    $dbh = new PDO($dsn, $user, $password);
  }catch(PDOException $e){
    echo $e->getMessage() . "\n";
    exit();
  }
  ?>