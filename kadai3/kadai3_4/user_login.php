<?php

  $dsn = 'mysql:dbname=co_19_265_99sv_coco_com;host=localhost';
  $user = 'co-19-265.99sv-c';
  $password = 'N5dDfJih';
  #DB接続
  try{
    $dbh = new PDO($dsn, $user, $password);
  }catch(PDOExeption $e){
    echo $e->getMessage() . "\n";
    exit();
  }


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
              echo '仮登録状態です。メールを確認して本登録を完了させて下さい。';
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
    echo 'ログインに成功しました。';
    //ini_set( 'session.gc_divisor', 1 );  // 分母(デフォルト:100)
    //ini_set( 'session.gc_maxlifetime', $session_time );  // 秒(デフォルト:1440)
    ini_set('session.gc_probability', 1);
    ini_set( 'session.gc_divisor', 1 );  
    ini_set( 'session.gc_maxlifetime', 5); 
    session_start();
    $_SESSION['myId'] = $id;
    $_SESSION['last_time'] = time();
  ?>
    <form action="./notice-board.php" method="post">
    <input type="hidden" name="login_id" value="<?php echo $id;?>">
    <input type="submit" value="掲示板へ">
    </form>
  <?php
#cookie情報保存
    #setcookie('myId',$id, time() + 60 * 60 * 24, '', '', FALSE, TRUE);#7⇒httponly(js弾く)
    echo 'ログイン情報を記録しました。';
  }
  ?>
  <?php
  if($id_flag && !$password_flag){
    echo 'パスワードが間違っています。';
  ?>
    <form action="./login_form.php" method="post">
    <input type="hidden" name="login_id" value="<?php echo $id;?>">
    <input type="submit" value="戻る">
    </form>
  <?php
  }
  ?>
  <?php
  if(!$id_flag){
    echo 'IDがありません。';
  ?>
  <a href="./login_form.php">戻る</a>
  <?php
  }
?>
