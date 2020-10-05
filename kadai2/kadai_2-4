<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>kadai_2-4</title>
</head>
<body>
  <form action="./kadai_2-4.php" method="post">
    <dl>
      <p>
        <dt>お名前：</dt>
        <dd><input type="text" size="30" name="name" placeholder="ここに名前を入力してください。"></dd>
      </p>
      <p>
        <dt>コメント：</dt>
        <dd>
          <textarea name="comment" cols="35" rows="10" placeholder="ここにコメントを入力してください。"></textarea>
          <input type="submit" value="投稿">
        </dd>
      </p>
    </dl>
  </form>

  <form action="./kadai_2-4.php" method="post">
    <dl>
      <p>
        <dt>削除番号：</dt>
        <dd>
          <input type="text" size="35" name="delete" placeholder="ここに削除したい番号を入力してください。">
          <input type="submit" value="削除">
        </dd>
      </p>

    </dl>
  </form>

  <?php
  $filename = "kadai_2-4.txt";

  #投稿処理
  if(!empty($_POST['name'])){
  $name = $_POST["name"];
  $comment = $_POST["comment"];
  $fp = fopen($filename,"a");
  #$cnt = count(file($filename));
  $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  list($last_num, $_, $_, $_) = explode("<>", array_pop($lines));
  $last_num++;
  fwrite($fp,$last_num."<>".$name."<>".$comment."<>".date("Y年m月d日 H時i分s秒")."\n");
  fclose($fp);

  #リロードによる二重投稿対策
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      header('Location:http://co-19-265.99sv-coco.com/kadai_2-4.php');
    }
  }

  #削除処理（上書き保存形式）
  if(isset($_POST['delete'])){
    if(!file_exists($filename)){
      echo "<script>alert('ファイルがありません。');</script>";
    }else{
      $delete_ID = $_POST['delete'];
        if(is_numeric($delete_ID)){
          $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
          unlink($filename);  #＄linesでデータは保存できているので上書きのためにファイルを削除する
          $fp = fopen($filename,"a");
          foreach($lines as $value){
            list($num, $name1, $comment1, $time) = explode("<>", $value);
            if($num == $delete_ID){
              continue;
            }
            elseif($num > $delete_ID){
              $num--;
            }
            fwrite($fp,$num."<>".$name1."<>".$comment1."<>".$time."\n");
          }
          fclose($fp);
        }
        else{
          echo "<script>alert('数値を入力してください。');</script>";
        }
    }
  }
  



  if(file_exists($filename)){
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach($lines as $value){
      list($num, $name1, $comment1, $time) = explode("<>", $value);
      echo $num."番  ".$name1."さん  ".$comment1."  ".$time."<br>"; 
    }
  }
  
  
?>

</body>
</html>
