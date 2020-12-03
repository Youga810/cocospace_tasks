<?php
session_start();
require_once(realpath(__DIR__) . "/../smarty/Autoloader.php");
Smarty_Autoloader::register();

$smarty = new Smarty();
$SESSION_TIME = 1440;
$_SESSION['timeout'] = false;
  #cユーザ情報の取得(無ければログイン画面へ)
  if(!isset($_SESSION['myId'])){
    header('Location: ./login_form.php');
    //更新したら再びセッションIDが発行されるため
    if(session_id()) {
      $_SESSION = array();
      setcookie("PHPSESSID", '', time() - 1800);
    }
    session_destroy();
    exit();
  }
  #セッション時間が過ぎていた場合ログアウト処理を行う
  elseif(!$_SESSION['last_time'] || time() - $_SESSION['last_time'] > $SESSION_TIME){
    $_SESSION['timeout'] = true;
    header('Location: ./user_logout.php');
    exit();

  }

#最終表示時間の更新
$_SESSION['last_time'] = time();

include('pdo_connect.php');

#ユーザの名前の取得(続き)
  $sql = 'SELECT *FROM tmp_register';
  $stmt = $dbh->query($sql);
  $stmt-> execute();
  $cnt = $stmt->rowCount();
  if($cnt != 0){
    $res = $dbh-> query($sql);
      foreach($res as $value){
        if($value['id'] == $_SESSION['myId']){
          $user_name = $value['name'];
        }
      }
  }

#テーブル作成
$stmt = $dbh->query("CREATE TABLE D (id INT AUTO_INCREMENT PRIMARY KEY,name TEXT,comment TEXT,time TEXT, password TEXT,path TEXT,ext TEXT)");
#debug用

#$sql = "DELETE FROM B" ;
#$dbh->query($sql);

#$sql = "DROP TABLE D" ;
#$dbh->query($sql);
  #投稿処理
  if(!empty($_POST['name'])){
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $id = $_POST["ID"]; 
    $password = $_POST["post_password"];

      $upfile = $_FILES['upfile'];
      try{
      if($upfile['error'] == UPLOAD_ERR_FORM_SIZE || $upfile['error'] == UPLOAD_ERR_INI_SIZE){
          throw new EXception('ファイルサイズが大きすぎます');
      }
     }catch(EXception $e){
      echo $e -> getMessage();
     }

      $tmp_name = $upfile['tmp_name'];
      // ファイルタイプチェック
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mimetype = finfo_file($finfo, $tmp_name);
      // 許可するMIMETYPE
      $allowed_types = [
          'jpg' => 'image/jpeg'
          , 'png' => 'image/png'
          , 'gif' => 'image/gif'
          ,'mp4' => 'video/mp4'
      ];
      if (!in_array($mimetype, $allowed_types)) {
        throw new Exception('許可されていないファイルタイプです。');
    }
     
      $filename = sha1_file($tmp_name);
      $ext = array_search($mimetype, $allowed_types);
      $destination = sprintf('%s/%s.%s'
      , 'files'
      , $filename
      , $ext
      );
      move_uploaded_file($tmp_name,$destination);


    if(empty($password))echo "<script>alert('パスワードを入力してください。');</script>";
    else{
      $res = $dbh-> query('SELECT * FROM D');
      #編集時
      if($id != -1){
        $sql = 'UPDATE D set name = :name,comment = :comment, time = :time, password = :password, path= :path, ext = :ext where id = :id';
        $stmt = $dbh->prepare($sql);
        $params = array(':name' =>$name,':comment' =>$comment,':time' => date('Y年m月d日 H時i分s秒'),':password' => $password,'path' => $destination, 'ext' =>$ext, 'id' => $id);
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
        $res = $dbh-> query('SELECT * FROM D');
        foreach( $res as $value ) {
          $new_id = $value['id']  ;
        }
        $new_id++;
        $sql = $dbh->prepare("INSERT INTO D (id,name,comment,time,password,path,ext) VALUES (:id,:name,:comment,:time,:password,:path,:ext)");
        $sql->bindValue(':id',$new_id,PDO::PARAM_INT);
        $sql->bindValue(':name',$name,PDO::PARAM_STR);
        $sql->bindValue(':comment',$comment,PDO::PARAM_STR);
        $sql->bindValue(':time',date('Y年m月d日 H時i分s秒'),PDO::PARAM_STR);
        $sql->bindValue(':password',$password,PDO::PARAM_STR);
        $sql->bindValue(':path',$destination,PDO::PARAM_STR);
        $sql->bindValue(':ext',$ext,PDO::PARAM_STR);
        $sql->execute();
      }
     # #リロードによる二重投稿対策
     # if($_SERVER['REQUEST_METHOD'] === 'POST'){
     #   header('Location:http://co-19-265.99sv-coco.com/notice-board.php');
     # }
    }
  }

  #削除処理（指定して削除する）
  $delete_password = "";
  if(!empty($_POST['delete'])){
    $delete_ID = $_POST['delete'];
    if(is_numeric($delete_ID)){
      $res = $dbh-> query('SELECT * FROM D');
      $cnt = $res->rowCount();
      $sql = "SELECT * FROM D where id = $delete_ID";
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
                $sql = "DELETE FROM D where id = $delete_ID" ;
                $stmt = $dbh->query($sql);
                
                $sql = "ALTER table D drop column id"; //idそのものを消す
                $stmt = $dbh->query($sql);
                $sql = "ALTER table D add id int(11) primary key not null auto_increment first"; //AUTO_INCREMENTは主キーかつNULLでないことが条件
                $stmt = $dbh->query($sql);
                $sql = "ALTER TABLE D AUTO_INCREMENT =1"; //idを1から振りなおす
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
      $res = $dbh-> query('SELECT * FROM D');
      $cnt = $res->rowCount();
      $sql = "SELECT * FROM D where id = $edit_ID";
      $stmt = $dbh->query($sql);
      foreach($stmt as $row){
        $edit_password =  $row['password'];
      }
      if($cnt == 0 || $edit_password == "")echo "<script>alert('データがありません。');</script>";
      else{
        $password = $_POST['edit_password'];
        if(empty($password)) echo "<script>alert('パスワードを入力してください');</script>";
        else{
            $sql = "SELECT * FROM D where id = $edit_ID";
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
  
  #記述処理
  $sql = 'SELECT *FROM D';
  $stmt = $dbh->query($sql);
  $stmt-> execute();
  $cnt = $stmt->rowCount();
  if($cnt != 0){
    $res = $dbh-> query('SELECT * FROM D');
    $smarty->assign('view', $res);
  }
  $smarty->assign('session', $_SESSION);
  $smarty->assign('user_name', $user_name);
  $smarty->assign('edit_comment1', $edit_comment1);
  $smarty->assign('edit_ID', $edit_ID);
  $smarty->display('notice-board.tpl');


?>


