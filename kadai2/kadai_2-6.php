<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>kadai_2-6</title>

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

<?php
  $filename = "kadai_2-6.txt";

  #投稿処理
  if(!empty($_POST['name'])){
  $name = $_POST["name"];
  $comment = $_POST["comment"];
  $id = $_POST["ID"]; 
  $password = $_POST["post_password"];
  
  if(empty($password))echo "<script>alert('パスワードを入力してください。');</script>";
  else{
    #$cnt = count(file($filename));
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if($id != -1){
      unlink($filename);  #＄linesでデータは保存できているので上書きのためにファイルを削除する
      $fp = fopen($filename,"a");
      foreach($lines as $value){
        list($num, $name1, $comment1, $time, $password1) = explode("<>", $value);
        if($id == $num){
          fwrite($fp,$id."<>".$name."<>".$comment."<>".date("Y年m月d日 H時i分s秒")."<>".$password."\n");
        }else{
          fwrite($fp,$num."<>".$name1."<>".$comment1."<>".$time."<>".$password1."\n");
        }
      }
    }else{
    list($last_num, $_, $_, $_, $_) = explode("<>", array_pop($lines));
    $last_num++;
    $fp = fopen($filename,"a");
    fwrite($fp,$last_num."<>".$name."<>".$comment."<>".date("Y年m月d日 H時i分s秒")."<>".$password."\n");
    }
    fclose($fp);

    #リロードによる二重投稿対策
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
        header('Location:http://co-19-265.99sv-coco.com/kadai_2-6.php');
      }
    }
  }

  #削除処理（上書き保存形式）
  if(!empty($_POST['delete'])){
    $delete_ID = $_POST['delete'];
    if(!file_exists($filename))echo "<script>alert('ファイルがありません。');</script>";
    else{
        $password = $_POST['delete_password'];
        if(empty($password)) echo "<script>alert('パスワードを入力してください');</script>";
        else{
          if(is_numeric($delete_ID)){
            $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            unlink($filename);  #＄linesでデータは保存できているので上書きのためにファイルを削除する
            $fp = fopen($filename,"a");
            foreach($lines as $value){
              list($num, $name1, $comment1, $time,$password1) = explode("<>", $value);
              if($num == $delete_ID){
                if($password != $password1){
                  echo "<script>alert('パスワードが間違っています。');</script>";
                  fwrite($fp,$num."<>".$name1."<>".$comment1."<>".$time."<>".$password1."\n");#unlinkでデータを消しているのでパスが間違っていた場合は同じ内容を上書き保存する
                }
                else continue;
              }
              else fwrite($fp,$num."<>".$name1."<>".$comment1."<>".$time."<>".$password1."\n");
            }
            fclose($fp);
          }
          else{
            echo "<script>alert('数値を入力してください。');</script>";
          }
        }
    }
  }
  
  #編集処理
  $edit_name1 = "";
  $edit_comment1 = "";
  $edit_ID = -1;
  if(!empty($_POST['edit'])){
    if(!file_exists($filename))echo "<script>alert('ファイルがありません。');</script>";
    else{
      $password = $_POST['edit_password'];
      if(empty($password)) echo "<script>alert('パスワードを入力してください');</script>";
      else{
      $edit_ID = $_POST['edit'];
        if(is_numeric($edit_ID)){
          $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
          #unlink($filename);  #＄linesでデータは保存できているので上書きのためにファイルを削除する
          #$fp = fopen($filename,"a");
          foreach($lines as $value){
            list($edit_num, $edit_name1, $edit_comment1, $edit_time,$edit_password) = explode("<>", $value);
            if($edit_num == $edit_ID){
              if($password != $edit_password){
                echo "<script>alert('パスワードが間違っています。');</script>";
                $edit_name1 = "";
                $edit_comment1 = "";
                $edit_ID = -1;
                break;
              }
            break;
            }
          }
          #fclose($fp);
        }
        else{
          echo "<script>alert('数値を入力してください。');</script>";
        }      
      }

    }
  }
  
?>

  <form action="./kadai_2-6.php" method="post">
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
  <form action="./kadai_2-6.php" method="post" onSubmit="return check()">
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
  <form action="./kadai_2-6.php" method="post">
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
  if(file_exists($filename)){
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if(empty($lines)) echo "投稿がありません。";
    else{
      foreach($lines as $value){
        list($num, $name1, $comment1, $time) = explode("<>", $value);
        echo $num."番  ".$name1."さん  ".$comment1."  ".$time."<br>"; 
      }
    }
    
  }else{
    echo "投稿がありません。";
  }
  
  
?>

</body>
</html>
