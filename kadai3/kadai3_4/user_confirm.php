<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>user_confirm</title>
</head>

<body>
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


  if(!empty($_POST['name']) || !empty($_POST['password']) || !empty($_POST['address']) ){
    $register_name = $_POST['name'];
    $register_password = $_POST['password'];
    $register_address = $_POST['address'];
  }
  if(empty($register_name) || empty($register_password) || empty($register_address)){
    echo "入力漏れがあります";
  }

    #ユーザ情報の登録・仮登録メールの送信
    if(isset($_POST['register_name'])){

      #仮登録か本登録されていた時
      $sth = $dbh->prepare("SELECT * FROM tmp_register where id = ?");
      $sth -> bindParam(1, $_POST['register_id'],PDO::PARAM_STR);
      $sth ->execute(); 
      $result = $sth ->fetchAll(PDO::FETCH_ASSOC);
      if($result) {
        foreach($result as $value){
          if($value['flag']){
            echo '既に本登録済みです。';
          }else{
            echo '現在仮登録状態です。メールをご確認ください。';
          }
        }
        exit();
      }


      #DBに登録
      $sql = $dbh->prepare('INSERT INTO tmp_register (id,name,time,password,address,flag) VALUES (:id,:name,:time,:password,:address,:flag)');
      $id = $_POST['register_id'];
      
      $sql->bindValue(':id',$id,PDO::PARAM_STR);
      $sql->bindValue(':name',$_POST['register_name'],PDO::PARAM_STR);
      $sql->bindValue(':time',time(),PDO::PARAM_INT);
      $sql->bindValue(':password',$_POST['register_password'],PDO::PARAM_STR);
      $sql->bindValue(':address',$_POST['register_address'],PDO::PARAM_STR);
      $sql->bindValue(':flag',0,PDO::PARAM_INT);
      $sql->execute();
      $url = "http://co-19-265.99sv-coco.com/main_register.php?param=".$id;
      $subject ='仮登録認証確認メール';
      $body =  ' 
      こんにちは'.$_POST['register_name'].'さん。
      以下のURLで認証を行ってください。
      '.$url;
      echo '以下のメールアドレスに認証URLを送信しました。<br>'
            .$_POST['register_address'].'<br><br>'.
            'クリックすると認証が完了します。';

      mb_send_mail($_POST['register_address'], $subject, $body);

    }

  ?>

  <!--名前とパスワードとアドレスが入力されている場合-->
  <?php if(!empty($register_name) && !empty($register_password) && !empty($register_address ) && preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$register_address)):
  ?>

  <h1>ーユーザ情報の確認ー</h1>
  お名前：
  <?php echo $register_name."<br>"; ?>
  パスワード：
  <?php echo $register_password; ?>
  メールアドレス：
  <?php echo $register_address; ?>
  
  <?php endif; ?>
  <br>

  <!--戻るボタン-->
  <form action="/user_register.php" method="get">
    <input type="submit" value="戻る">
  </form>
  
  <?php if(!empty($register_name) && !empty($register_password) && preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$register_address)): ?>
  

  <!--ユニークID生成,脆弱性を考慮してuniqidを使わずプログラム上で一意か判定-->
  <?php 

    while(1){
      $flag = true;
      $id = random_id();
      $sql = 'SELECT *FROM tmp_register';
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

    <!-- 確認フォーム -->
    <form action="./user_confirm.php" method="post">
    <input type="hidden" name="register_name" value="<?php echo $register_name;?>">
    <input type="hidden" name="register_password" value="<?php echo $register_password;?>">
    <input type="hidden" name="register_id" value="<?php echo $id;?>">
    <input type="hidden" name="register_address" value="<?php echo $register_address;?>">
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
