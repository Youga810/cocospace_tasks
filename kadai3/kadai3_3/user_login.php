<?php

  $dsn = 'mysql:dbname=****************;host=localhost';
  $user = 'co-19-265.99sv-c';
  $password = '********';
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
  echo '<br><br>';

  $sql = 'SELECT *FROM user_information';
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
            break;
          }
        }
      }
  }
}else{
    header('Location: ./notice-board.php');
}

#ユーザ情報の登録
if(isset($_POST['register_name'])){
  $sql = $dbh->prepare('INSERT INTO user_information (id,name,time,password) VALUES (:id,:name,:time,:password)');
  $id = $_POST['register_id'];
  $sql->bindValue(':id',$id,PDO::PARAM_STR);
  $sql->bindValue(':name',$_POST['register_name'],PDO::PARAM_STR);
  $sql->bindValue(':time',date('Y年m月d日 H時i分s秒'),PDO::PARAM_STR);
  $sql->bindValue(':password',$_POST['register_password'],PDO::PARAM_STR);
  $sql->execute();
  $id_flag = true;
  $password_flag = true;
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
