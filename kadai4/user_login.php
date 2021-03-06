<?php
  include('./pdo_connect.php');
  // smartyの設定ファイル読み込み
  require_once(realpath(__DIR__) . "/smarty/Autoloader.php");
  Smarty_Autoloader::register();
  $smarty = new Smarty();


  
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
              throw new Exception('仮登録状態です。メールを確認して本登録を完了させて下さい。');
              exit();
            }
            break;
          }
        }
      }
  }
}else{
    header('Location: ./notice-board.php');
}

  if($id_flag && $password_flag){
    ini_set('session.gc_probability', 1);
    ini_set( 'session.gc_divisor', 1 );  
    ini_set( 'session.gc_maxlifetime', 5); 
    session_start();
    $_SESSION['myId'] = $id;
    $_SESSION['last_time'] = time();
  }
  if($id_flag && !$password_flag){
    throw new Exception('パスワードが間違っています。');
  }
  if(!$id_flag){
    throw new Exception('IDがありません。');
  }
}catch(Exception $e){
  $smarty->assign('error', $e -> getMessage());
}
  $smarty->assign('id', $id);
  $smarty->display('user_login.tpl');
?>