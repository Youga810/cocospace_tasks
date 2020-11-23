<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>mysql</title>
</head>
<body>
<?php

$dsn = 'mysql:dbname=****************;host=localhost';
$user = 'co-19-265.99sv-c';
$password = '********';


#DB接続
try{
  $dbh = new PDO($dsn, $user, $password);
  echo "接続成功<br>";
}catch(PDOExeption $e){
  echo $e->getMessage() . "\n";
  exit();
}

#テーブル作成
  $stmt = $dbh->query("CREATE TABLE A (id INT,name TEXT)");

#insert
#  $stmt = $dbh-> prepare("INSERT INTO hot_spring(id, names, place)VALUES(:id,:names,:place)");
#  $stmt -> bindValue(':id',1);
#  $stmt -> bindValue(':names','kinosaki');
#  $stmt -> bindValue(':place','hyogo');
#  $stmt->execute();

#テーブル一覧表示
echo "テーブル一覧<br>";
  $st = $dbh->query('SHOW TABLES');
  while($ret = $st->fetch(PDO::FETCH_ASSOC)){
    var_dump($ret);
    echo '<br>';
  }
  echo "<br>";

#データ入力
echo "データ入力<br>";
$stmt = $dbh->query("INSERT INTO A VALUES (2, 'arima')");
#var_dump($results);
$res = $dbh-> query('SELECT * FROM A');
foreach( $res as $value ) {
  echo "id:"."$value[id]  ";
  echo "name:"."$value[name]";
  echo "<br>";
}
echo "<br>";

#データ編集
echo "データ編集<br>";
$sql = 'UPDATE A set name = "kurokawa" where id = 2'; #ダブルクオートだと通らない
$stmt = $dbh->prepare($sql);
$stmt->execute();
$res = $dbh-> query('SELECT * FROM A');
foreach( $res as $value ) {
  echo "id:"."$value[id]  ";
  echo "name:"."$value[name]";
  echo "<br>";
}
echo "<br>";

#データ削除
echo "データ削除<br>";
$sql = 'DELETE FROM A WHERE id = 2';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$res = $dbh-> query('SELECT * FROM A');
foreach( $res as $value ) {
  echo "id:"."$value[id]  ";
  echo "name:"."$value[name]";
  echo "<br>";
}
echo "<br>";

#	$res = $dbh-> query('SELECT * FROM another_table');
#  foreach( $res as $value ) {
#    echo "$value[id]";
#    echo "$value[names]";
#    echo "$value[place]";
#	}


$dbh = null;

?>

</body>
</html>
