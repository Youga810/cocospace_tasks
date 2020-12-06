<?php
  // smartyの設定ファイル読み込み
  require_once(realpath(__DIR__) . "/../smarty/Autoloader.php");
  Smarty_Autoloader::register();

  $smarty = new Smarty();
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
      if(!$result){
        $eflag = 1;
        throw new Exception($eflag);
      } 
    
    #本登録のflag = 1 にする
    foreach($result as $value){
      $password = $value['password'];
      if($value['flag'] == 0){
        $stmt = $dbh -> prepare("UPDATE tmp_register SET flag = :flag WHERE id = :id");
        $params = array(':flag'=> 1, 'id' => $_GET['param']);
        $stmt -> execute($params);
      }else{
        $eflag = 2;
        throw new Exception($eflag);
      }
    }

    }catch(PDOException $e){
      echo 'error';
    }catch(Exception $e){
    $smarty->assign('error', $e -> getMessage());
    }

    $smarty->assign('id', $_GET['param']);
    $smarty->assign('password', $password);
    $smarty->display('main_register.tpl');
    

  ?>


