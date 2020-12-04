
  <?php
  // smartyの設定ファイル読み込み
  require_once(realpath(__DIR__) . "/../smarty/Autoloader.php");
  Smarty_Autoloader::register();
  include('./pdo_connect.php');

  if(!empty($_POST['name']) || !empty($_POST['password']) || !empty($_POST['address']) ){
    $register_name = $_POST['name'];
    $register_password = $_POST['password'];
    $register_address = $_POST['address'];
  }
  if((empty($register_name) || empty($register_password) || empty($register_address)) && empty($_POST['register_name'])){

    $register_name = "";
    $register_password = "";
    $register_address = "";
  }

    #ユーザ情報の登録・仮登録メールの送信
    if(isset($_POST['register_name'])){
      $register_name = $_POST['register_name'];
      $register_password = $_POST['register_password'];
      $register_address = $_POST['register_address'];
      #仮登録か本登録されていた時
      $sth = $dbh->prepare("SELECT * FROM tmp_register where id = ?");
      $sth -> bindParam(1, $_POST['register_id'],PDO::PARAM_STR);
      $sth ->execute(); 
      $result = $sth ->fetchAll(PDO::FETCH_ASSOC);
      if($result) {
        foreach($result as $value){
          if($value['flag']){
            echo '既に本登録済みです。';
          }else{
            echo '現在仮登録状態です。メールをご確認ください。';
          }
        }
        exit();
      }


      #DBに登録
      $sql = $dbh->prepare('INSERT INTO tmp_register (id,name,time,password,address,flag) VALUES (:id,:name,:time,:password,:address,:flag)');
      $id = $_POST['register_id'];
      
      $sql->bindValue(':id',$id,PDO::PARAM_STR);
      $sql->bindValue(':name',$_POST['register_name'],PDO::PARAM_STR);
      $sql->bindValue(':time',time(),PDO::PARAM_INT);
      $sql->bindValue(':password',$_POST['register_password'],PDO::PARAM_STR);
      $sql->bindValue(':address',$_POST['register_address'],PDO::PARAM_STR);
      $sql->bindValue(':flag',0,PDO::PARAM_INT);
      $sql->execute();
      $url = "http://co-19-265.99sv-coco.com/kadai4/main_register.php?param=".$id;
      $subject ='仮登録認証確認メール';
      $body =  ' 
      こんにちは'.$_POST['register_name'].'さん。
      以下のURLで認証を行ってください。
      '.$url;
      echo '以下のメールアドレスに認証URLを送信しました。<br>'
            .$_POST['register_address'].'<br><br>'.
            'クリックすると認証が完了します。';

      mb_send_mail($_POST['register_address'], $subject, $body);
      //URL送信後ユーザ確認を表示させないための初期化
      $register_name = "";
      $register_password = "";
      $register_address = "";
    }

  ?>
  
  <!--ユニークID生成,脆弱性を考慮してuniqidを使わずプログラム上で一意か判定-->
  <?php 

    while(1){
      $flag = true;
      $id = random_id();
      $sql = 'SELECT *FROM tmp_register';
      $stmt = $dbh->query($sql);
      $stmt-> execute();
      $cnt = $stmt->rowCount();
      if($cnt != 0){
        $res = $dbh-> query($sql);
          foreach($res as $value){
            if ($id == $value['id']){
              $flag = false;
            };
          }
        }else{
        break;
      }
      if($flag)break;
    } 
    function random_id($length = 6)
    {
        return substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, $length);
    }

    $smarty = new Smarty();
    $smarty->assign('register_name', $register_name);
    $smarty->assign('register_password', $register_password);
    $smarty->assign('register_address', $register_address);
    $smarty->assign('register_id', $id);
    $smarty->display('user_confirm.tpl');

  ?>