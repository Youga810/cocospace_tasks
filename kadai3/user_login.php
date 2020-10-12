<?php
  if(isset($_COOKIE['myId'])){
    header('Location: ./notice-board.php');
  }
  $id = $_POST['id'];
  echo $id;

  $login_password = $_POST['password']; 
  echo $login_password;
  echo '<br><br>';
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
  $sql = 'SELECT *FROM user_information';
  $stmt = $dbh->query($sql);
  $stmt-> execute();
  $cnt = $stmt->rowCount();
  $id_flag = false;
  $password_flag = false;
  if($cnt != 0){
    $res = $dbh-> query($sql);
      foreach($res as $value){
        echo $value['id'].'<br>';
        if($id == $value['id']){
          $id_flag = true;        
          if($login_password == $value['password']){
            $password_flag = true;
            break;
          }
        }
      }
  }

  if($id_flag && $password_flag){
    echo 'ログインに成功しました。';
  ?>
    <form action="./notice-board.php" method="post">
    <input type="hidden" name="login_id" value="<?php echo $id;?>">
    <input type="submit" value="掲示板へ">
    </form>
  <?php
#cookie情報保存
    setcookie('myId',$id, time() + 60 * 60 * 24);
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
