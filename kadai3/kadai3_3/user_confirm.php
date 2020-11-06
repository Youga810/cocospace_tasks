<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>user_confirm</title>
</head>

<body>
  <?php
    $register_name = $_POST['name'];
    $register_password = $_POST['password'];
    if(empty($register_name) && empty($register_password)){
      echo "名前とパスワードを入力してください。";
    }elseif(empty($register_name)){
      echo "名前を入力してください。";
    }elseif(empty($register_password)){
      echo "パスワードを入力してください。";
    }

  ?>

  <!--名前とパスワードが入力されている場合-->
  <?php if(!empty($register_name) && !empty($register_password)) : ?>
  <h1>ーユーザ情報の確認ー</h1>
  お名前：
  <?php echo $register_name."<br>"; ?>
  パスワード：
  <?php echo $register_password; ?>
  
  <?php endif; ?>
  <br>

  <!--戻るボタン-->
  <form action="/user_register.php" method="post">
    <input type="hidden" name="name" value="<?php echo $register_name;?>">
    <input type="hidden" name="password" value="<?php echo $register_password;?>">
    <input type="submit" value="戻る">
  </form>
  
  <?php if(!empty($register_name) && !empty($register_password)) : ?>
  

  <!--ユニークID生成,脆弱性を考慮してuniqidを使わずプログラム上で一意か判定-->
  <?php 
  $dsn = 'mysql:dbname=***************;host=localhost';
  $user = 'co-19-265.99sv-c';
  $password = '********';
  #DB接続
  try{
    $dbh = new PDO($dsn, $user, $password);
  }catch(PDOExeption $e){
    echo $e->getMessage() . "\n";
    exit();
  }
    while(1){
      $flag = true;
      $id = random_id();
      $sql = 'SELECT *FROM user_information';
      $stmt = $dbh->query($sql);
      $stmt-> execute();
      $cnt = $stmt->rowCount();
      if($cnt != 0){
        $res = $dbh-> query($sql);
          foreach($res as $value){
            if ($id == $value['id']){
              $flag = false;
            };
          }
        }else{
        break;
      }
      if($flag)break;
    }
  ?>


    <form action="./user_login.php" method="post">
    <input type="hidden" name="register_name" value="<?php echo $register_name;?>">
    <input type="hidden" name="register_password" value="<?php echo $register_password;?>">
    <input type="hidden" name="register_id" value="<?php echo $id;?>">
    <input type="submit" value="登録">
  </form>
  <?php endif; ?>



</body>

</html>



<?php 
    function random_id($length = 6)
    {
        return substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, $length);
    }
?>
