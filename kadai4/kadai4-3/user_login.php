<?php
  include('./pdo_connect.php');
  // smartyの設定ファイル読み込み
  require_once(realpath(__DIR__) . "/../smarty/Autoloader.php");
  Smarty_Autoloader::register();
  $smarty = new Smarty();

  error_reporting(E_ALL & ~E_NOTICE);
  
try{
  $id_flag = false;
  $password_flag = false;

  if(isset($_POST['id'])){
    $id = $_POST['id'];
  if(isset($_POST['password']))$login_password = $_POST['password']; 

  $sql = 'SELECT *FROM tmp_register';
  $stmt = $dbh->query($sql);
  $stmt-> execute();
  $cnt = $stmt->rowCount();
  if($cnt != 0){
    $res = $dbh-> query($sql);
      foreach($res as $value){
        if($id == $value['id']){
          $id_flag = true;        
          if($login_password == $value['password']){
            $password_flag = true;
            if($value['flag'] == 0){
              throw new Exception("In the state of 'Temporary registration'.<br>
              Please check an email.");
              exit();
            }
            break;
          }
        }
      }
  }
}

  if($id_flag && !$password_flag){
    throw new Exception('Wrong Password');
  }
  if(!$id_flag){
    throw new Exception('No Id');
  }
}catch(Exception $e){
  $smarty->assign('error', $e -> getMessage());
}
  $smarty->assign('id', $id);
  $smarty->assign('current_time', time());  
  $smarty->display('user_login.tpl');
?>