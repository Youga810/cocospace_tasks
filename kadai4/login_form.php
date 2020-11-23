<?php

// smartyの設定ファイル読み込み
require_once(realpath(__DIR__) . "/smarty/Autoloader.php");
Smarty_Autoloader::register();

#echo $_SESSION['myId'];
  if(isset($_COOKIE['PHPSESSID'])){
    header('Location: ./notice-board.php');
  }

  if(isset($_POST['login_id'])){
  $id = $_POST['login_id'];
  }else{
    $id = "";
  }

$smarty = new Smarty();
$smarty->assign('id', $id);
$smarty->display('login_form.tpl');

?>