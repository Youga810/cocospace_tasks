<?php

include('auto_delete_id.php');
include('pdo_connect.php');

// smartyの設定ファイル読み込み
require_once(realpath(__DIR__) . "/smarty/Autoloader.php");
Smarty_Autoloader::register();

  if(!empty($_POST['name']) || !empty($_POST['password'])|| !empty($_POST['address'])){
    $name = $_POST['name'];
    $password = $_POST['password'];
    $address = $_POST['address'];
  }else{
    $name = "";
    $password = "";
    $address = '';
  }

  
  #$sql = "DROP TABLE tmp_register" ;
  #$dbh->query($sql);
  
  #テーブル作成
  $stmt = $dbh->query("CREATE TABLE tmp_register (id TEXT,name TEXT,time TEXT, password TEXT, address TEXT, flag INT)");
  
  #記述処理
    $sql = 'SELECT *FROM tmp_register';
    $stmt = $dbh->query($sql);
    $stmt-> execute();
    $cnt = $stmt->rowCount();

  
$smarty = new Smarty();
$smarty->assign('cnt', $cnt);
$smarty->assign('stmt', $stmt);
$smarty->assign('name', $name);
$smarty->assign('password', $password);
$smarty->assign('address', $address);
$smarty->display('user_register.tpl');


/*
<td> <?php echo "$value[password]";?></td>
<td> <?php echo date('Y年m月d日 H時i分s秒', $value['time']);?></td>
<td> <?php echo "$value[flag]";?></td>
<td> <?php echo "$value[id]"; ?></td>
<td> <?php echo "$value[address]";?></td>
*/
?>


