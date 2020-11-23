<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>kadai_1</title>
</head>
<body>
  <form action="./kadai_2-3.php" method="post">
    <dl>
      <p>
        <dt>お名前：</dt>
        <dd><input type="text" size="30" name="name" placeholder="ここに名前を入力してください。"></dd>
      </p>
      <p>
        <dt>コメント：</dt>
        <dd><textarea name="comment" cols="35" rows="10" placeholder="ここにコメントを入力してください。"></textarea></dd>
      </p>
      <input type="submit" value="送信">
  </dl>
  </form>

  <?php
  $filename = "kadai_2-3.txt";

  if(!empty($_POST['name'])){
  $name = $_POST["name"];
  $comment = $_POST["comment"];
  $fp = fopen($filename,"a");
  $cnt = count(file($filename));
  $cnt++;
  fwrite($fp,$cnt."<>".$name."<>".$comment."<>".date("Y年m月d日 H時i分s秒")."\n");
  fclose($fp);

  #リロードによる二重投稿対策
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      header('Location:http://co-19-265.99sv-coco.com/kadai_2-3.php');
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