<?php
  $dsn = 'mysql:dbname=*****************;host=localhost';
  $user = 'co-19-265.99sv-c';
  $password = '*********';
  #DB接続
  try{
    $dbh = new PDO($dsn, $user, $password);
  }catch(PDOException $e){
    echo $e->getMessage() . "\n";
    exit();
  }
  ?>
