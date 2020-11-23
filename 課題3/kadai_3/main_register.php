<?php
  #DB接続
    try{    
      $dsn = 'mysql:dbname=co_19_265_99sv_coco_com;host=localhost';
      $user = 'co-19-265.99sv-c';
      $password = 'N5dDfJih';
      $dbh = new PDO($dsn, $user, $password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sth = $dbh->prepare("SELECT * FROM tmp_register where id = ?");
      $sth -> bindParam(1, $_GET['param'],PDO::PARAM_STR);
      $sth ->execute(); 
      $result = $sth ->fetchAll(PDO::FETCH_ASSOC);
      if(!$result) throw new Exception('パラメータが正しくありません');
    
    #本登録のflag = 1 にする
    foreach($result as $value){
      $password = $value['password'];
      if($value['flag'] == 0){
        $stmt = $dbh -> prepare("UPDATE tmp_register SET flag = :flag WHERE id = :id");
        $params = array(':flag'=> 1, 'id' => $_GET['param']);
        $stmt -> execute($params);
      }else{
        throw new Exception('id:'.$_GET['param'].' は既に登録済みです');
      }
    }

    }catch(PDOException $e){
      echo 'error';
    }catch(Exception $e){
      ?>
      <span style="color:#ff0000;">
      <?php 
      echo $e -> getMessage();
      ?>
      <br>
      <a href="user_register.php">ユーザ登録フォームへ</a>
      <?php
      exit();
       ?>
      </span>
      <?php
    }
  ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
    認証が完了しました。<br>
    以下のidとpasswordは大切に保管してください。<br><br>
    id:<?php echo $_GET['param']."<br>"; ?>
    password:<?php echo $password."<br>"; ?><br>
    <form action="login_form.php" method="post">
      <input type="hidden" name="login_id" value="<?php echo $_GET['param'];?>">
      <input type="submit" value="ログインフォームへ">
    </form>
</body>
</html>