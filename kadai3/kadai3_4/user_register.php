<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>kadai_3_1</title>
</head>
<body>

<?php

include('auto_delete_id.php');

  if(!empty($_POST['name']) || !empty($_POST['password'])|| !empty($_POST['address'])){
    $name = $_POST['name'];
    $password = $_POST['password'];
    $address = $_POST['address'];
  }else{
    $name = "";
    $password = "";
    $address = '';
  }

?>

  <h1>ーユーザー登録フォームー</h1>
  <form action="/user_confirm.php" method="post">
  お名前：
  <input type="text" size="30" name="name" placeholder="鈴木太郎" value="<?php echo $name; ?>"><br>
  パスワード
  <input type="password" size="30" name="password" placeholder="password" value="<?php echo $password; ?>"><br>
  メールアドレス
  <input type="email" size="30" name="address" placeholder="abc@example.jp" value="<?php echo $address;?>">
  <input type="submit" value="確認">
</form>

<p>登録済みの方は<a href="./login_form.php">こちら</a></p>
<br><br>
--------------------------------＜以下デバッグ用＞---------------------------------------
<br>
<br>
<?php
$dsn = 'mysql:dbname=co_19_265_99sv_coco_com;host=localhost';
$user = 'co-19-265.99sv-c';
$password = 'N5dDfJih';
#DB接続
try{
  $dbh = new PDO($dsn, $user, $password);
}catch(PDOException $e){
  echo $e->getMessage() . "\n";
  exit();
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
  if($cnt != 0){ ?>
    
    <table border="2">
    <tr>
      <td>名前</td>
      <td>パスワード</td>
      <td>登録日時</td>
      <td>本登録かどうか</td>
      <td>一意のID</td>
      <td>メールアドレス</td>
    </tr>
    <?php foreach($stmt as $value){  ?>
        
          <tr>
           <td> <?php echo "$value[name]";?></td>
           <td> <?php echo "$value[password]";?></td>
           <td> <?php echo date('Y年m月d日 H時i分s秒', $value['time']);?></td>
           <td> <?php echo "$value[flag]";?></td>
           <td> <?php echo "$value[id]"; ?></td>
           <!-- <td> <?php echo "$value[address]";?></td> -->
          </tr>
        
      
      <?php }?>
      </table>

      <?php 
  }else{
    echo '登録しているユーザーはいません。';
  }

  
  
?>


</body>
</html>
