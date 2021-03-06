<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>notice-board</title>

  <!--　削除時の確認ダイアログ　-->
  <script type="text/javascript"> 
    function check(){
      if(window.confirm('本当に削除しますか？')){
        return true;
      }else{
        window.alert('キャンセルされました'); 
        return false; 
      }
    }
  </script>

</head>
<body>
<h1 style="display:inline;">掲示板</h1> 
<h2><a href="">ログアウト</a></h2>
<?php
#cユーザ情報の取得(無ければログイン画面へ)
if(isset($_COOKIE['myId'])){
  $myId = $_COOKIE['myId'];
  }else{
    header('Location: ./login_form.php');
  }

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

#ユーザの名前の取得(続き)
  $sql = 'SELECT *FROM user_information';
  $stmt = $dbh->query($sql);
  $stmt-> execute();
  $cnt = $stmt->rowCount();
  if($cnt != 0){
    $res = $dbh-> query($sql);
      foreach($res as $value){
        if($value['id'] == $myId){
          $name = $value['name'];
        }
      }
  }
?>
<div align="right">
  ID： <?php echo $myId; ?><br>
  名前：<?php echo $name; ?>
</div>

<?php
#テーブル作成
$stmt = $dbh->query("CREATE TABLE C (id INT AUTO_INCREMENT PRIMARY KEY,name TEXT,comment TEXT,time TEXT, password TEXT)");
#debug用

#$sql = "DELETE FROM C" ;
#$dbh->query($sql);

#ユーザ情報の登録
if(!empty($_POST['register_name'])){
  $sql = $dbh->prepare('INSERT INTO user_information (id,name,time,password) VALUES (:id,:name,:time,:password)');
  
  $newid = $_POST['register_id'];
  $sql->bindValue(':id',$newid,PDO::PARAM_STR);
  $sql->bindValue(':name',$_POST['register_name'],PDO::PARAM_STR);
  $sql->bindValue(':time',date('Y年m月d日 H時i分s秒'),PDO::PARAM_STR);
  $sql->bindValue(':password',$_POST['register_password'],PDO::PARAM_STR);
  $sql->execute();
}


  #投稿処理
  if(!empty($_POST['name'])){
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $id = $_POST["ID"]; 
    $password = $_POST["post_password"];
    if(empty($password))echo "<script>alert('パスワードを入力してください。');</script>";
    else{
      $res = $dbh-> query('SELECT * FROM B');
      #編集時
      if($id != -1){
        $sql = 'UPDATE B set name = :name,comment = :comment, time = :time, password = :password where id = :id';
        $stmt = $dbh->prepare($sql);
        $params = array(':name' =>$name,':comment' =>$comment,':time' => date('Y年m月d日 H時i分s秒'),':password' => $password, 'id' => $id);
        $stmt ->execute($params);
        #list($num, $name1, $comment1, $time, $password1) = explode("<>", $value);
        #if($id == $num){
        #  $dbh->query("INSERT INTO B VALUES ($id, $name,$comment,date('Y年m月d日 H時i分s秒'),$password)");
        #  #fwrite($fp,$id."<>".$name."<>".$comment."<>".date("Y年m月d日 H時i分s秒")."<>".$password."\n");
        #}else{
        #  $dbh->query("INSERT INTO B VALUES ($num, $name1,$comment1,$time,$password1)");
          #fwrite($fp,$num."<>".$name1."<>".$comment1."<>".$time."<>".$password1."\n");
        #}
      #通常投稿時
      }else{
        #lastInsertIDがうまく記述できなかったため
        $res = $dbh-> query('SELECT * FROM B');
        foreach( $res as $value ) {
          $new_id = $value['id']  ;
        }
        $new_id++;
        $sql = $dbh->prepare("INSERT INTO B (id,name,comment,time,password) VALUES (:id,:name,:comment,:time,:password)");
        $sql->bindValue(':id',$new_id,PDO::PARAM_INT);
        $sql->bindValue(':name',$name,PDO::PARAM_STR);
        $sql->bindValue(':comment',$comment,PDO::PARAM_STR);
        $sql->bindValue(':time',date('Y年m月d日 H時i分s秒'),PDO::PARAM_STR);
        $sql->bindValue(':password',$password,PDO::PARAM_STR);
        $sql->execute();
      }
      #リロードによる二重投稿対策
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
        header('Location:http://co-19-265.99sv-coco.com/notice-board.php');
      }
    }
  }

  #削除処理（指定して削除する）
  $delete_password = "";
  if(!empty($_POST['delete'])){
    $delete_ID = $_POST['delete'];
    if(is_numeric($delete_ID)){
      $res = $dbh-> query('SELECT * FROM B');
      $cnt = $res->rowCount();
      $sql = "SELECT * FROM B where id = $delete_ID";
      $stmt = $dbh->query($sql);
      foreach($stmt as $row){
        $delete_password =  $row['password'];
      }
      if($cnt == 0 || $delete_password == "")echo "<script>alert('データがありません。');</script>";
      else{
          $password = $_POST['delete_password'];
          if(empty($password)) echo "<script>alert('パスワードを入力してください');</script>";
          else{
              if($password != $delete_password){
                echo "<script>alert('パスワードが間違っています。');</script>";
              }
              else{
                $sql = "DELETE FROM B where id = $delete_ID" ;
                $stmt = $dbh->query($sql);
                
                $sql = "ALTER table B drop column id"; //idそのものを消す
                $stmt = $dbh->query($sql);
                $sql = "ALTER table B add id int(11) primary key not null auto_increment register"; //AUTO_INCREMENTは主キーかつNULLでないことが条件
                $stmt = $dbh->query($sql);
                $sql = "ALTER TABLE B AUTO_INCREMENT =1"; //idを1から振りなおす
                $stmt = $dbh->query($sql);
              }   
          }
      }
    }else{
      echo "<script>alert('数値を入力してください。');</script>";
    }
  }
  
  
  #編集処理
  $edit_name1 = "";
  $edit_comment1 = "";
  $edit_password = "";
  $edit_ID = -1;
  if(!empty($_POST['edit'])){
    $edit_ID = $_POST['edit'];
    if(is_numeric($edit_ID)){
      $res = $dbh-> query('SELECT * FROM B');
      $cnt = $res->rowCount();
      $sql = "SELECT * FROM B where id = $edit_ID";
      $stmt = $dbh->query($sql);
      foreach($stmt as $row){
        $edit_password =  $row['password'];
      }
      if($cnt == 0 || $edit_password == "")echo "<script>alert('データがありません。');</script>";
      else{
        $password = $_POST['edit_password'];
        if(empty($password)) echo "<script>alert('パスワードを入力してください');</script>";
        else{
            $sql = "SELECT * FROM B where id = $edit_ID";
            $stmt = $dbh->query($sql);
            foreach($stmt as $row){
              $edit_password =  $row['password'];
              $edit_name1 = $row['name'];
              $edit_comment1 = $row['comment'];            
            }
            if($password != $edit_password){
                  echo "<script>alert('パスワードが間違っています。');</script>";
                  $edit_name1 = "";
                  $edit_comment1 = "";
                  $edit_ID = -1;
            }
        }
      }
    }else{
      echo "<script>alert('数値を入力してください。');</script>";
    }  
  }
  
?>

  <form action="./notice-board.php" method="post">
    <dl>
      <p>
        <input type="hidden" name="ID" value="<?php echo $edit_ID;?>">
        <dt>お名前：</dt>
        <dd><input type="text" size="30" name="name" placeholder="ここに名前を入力してください。" value="<?php echo $edit_name1;?>"></dd>
      </p>
      <p>
        <dt>コメント：</dt>
        <dd>
          <textarea name="comment" cols="35" rows="10" placeholder="ここにコメントを入力してください。"><?php echo $edit_comment1;?></textarea>
        </dd>
      </p>
      <p>
        <dt>パスワード：</dt>
        <dd><input type="password" size="30" name="post_password" placeholder="ここにパスワードを入力してください。"></dd>
        <input type="submit" value="投稿">
      </p>
    </dl>
  </form>
--------------------------------------------------------------------------
  <form action="./notice-board.php" method="post" onSubmit="return check()">
    <dl>
      <p>
        <dt>削除番号：</dt>
        <dd>
          <input type="text" size="35" name="delete" placeholder="ここに削除したい番号を入力してください。">
        </dd>
      </p>

      <p>
        <dt>パスワード：</dt>
        <dd><input type="password" size="30" name="delete_password" placeholder="ここにパスワードを入力してください。"></dd>
        <input type="submit" value="削除">
      </p>
    </dl>
  </form>
--------------------------------------------------------------------------
  <form action="./notice-board.php" method="post">
    <dl>
      <p>
        <dt>編集番号：</dt>
        <dd>
          <input type="text" size="35" name="edit" placeholder="ここに編集したい番号を入力してください。">
        </dd>
      </p>

      <p>
        <dt>パスワード：</dt>
        <dd><input type="password" size="30" name="edit_password" placeholder="ここにパスワードを入力してください。"></dd>
        <input type="submit" value="編集">
      </p>
    </dl>
  </form><br>
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
<br><br>

<?php
  #記述処理
  $sql = 'SELECT *FROM B';
  $stmt = $dbh->query($sql);
  $stmt-> execute();
  $cnt = $stmt->rowCount();
  if($cnt != 0){
    $res = $dbh-> query('SELECT * FROM B');
      foreach($res as $value){
        echo "$value[id]"."番 ";
        echo "$value[name]"."さん ";
        echo "$value[comment]";
        echo "$value[time]";
        echo '<br>';
      }
  }else{
    echo '投稿がありません。';
  }
  
  
?>

</body>
</html>
