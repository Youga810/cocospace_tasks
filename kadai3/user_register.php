<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>kadai_3_1</title>
</head>
<body>

<?php
  if(!empty($_POST['name']) || !empty($_POST['password'])){
    $name = $_POST['name'];
    $password = $_POST['password'];
  }else{
    $name = "";
    $password = "";
  }

?>

  <h1>ーユーザー登録フォームー</h1>
  <form action="/user_confirm.php" method="post">
  お名前：
  <input type="text" size="30" name="name" placeholder="ここに名前を入力してください。" value="<?php echo $name; ?>"><br>
  パスワード
  <input type="password" size="30" name="password" placeholder="ここにパスワードを入力してください。" value="<?php echo $password; ?>">
  <input type="submit" value="確認">
</form>

<p>登録済みの方は<a href="./login_form.php">こちら</a></p>
<br><br>
-----------------------------------------------------------------------
<br>
登録済みID パスワード(デバッグ用)
<br>
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

#$sql = "DROP TABLE user_information" ;
#$dbh->query($sql);

#テーブル作成
$stmt = $dbh->query("CREATE TABLE user_information (id TEXT,name TEXT,time TEXT, password TEXT)");

#記述処理
  $sql = 'SELECT *FROM user_information';
  $stmt = $dbh->query($sql);
  $stmt-> execute();
  $cnt = $stmt->rowCount();
  if($cnt != 0){
    $res = $dbh-> query($sql);
      foreach($res as $value){
        echo "$value[id]　　";
        echo "$value[password]";
        echo '<br>';
      }
  }else{
    echo '登録しているユーザーはいません。';
  }
  
  
?>


</body>
</html>
