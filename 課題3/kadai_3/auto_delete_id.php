<?php 
      try{    
        $dsn = 'mysql:dbname=co_19_265_99sv_coco_com;host=localhost';
        $user = 'co-19-265.99sv-c';
        $password = 'N5dDfJih';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $flag = 0;
        $sth = $dbh->prepare("SELECT * FROM tmp_register where flag = ?");
        $sth -> bindParam(1, $flag,PDO::PARAM_INT);
        $sth ->execute(); 
        $result = $sth ->fetchAll(PDO::FETCH_ASSOC);
        if($result){
          foreach($result as $value){
            if(time() - $value['time'] > 86400){
              $sth = $dbh->prepare("DELETE FROM tmp_register where id = ?");
              $sth -> bindParam(1, $value['id'],PDO::PARAM_STR);
              $sth ->execute();
            }
          }
        }
      }catch(PDOException $e){
        echo $e -> getMessage();
      }












?>