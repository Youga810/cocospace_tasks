<?php
  session_start();

  require_once(realpath(__DIR__) . "/../smarty/Autoloader.php");
  Smarty_Autoloader::register();
  $smarty = new Smarty();

  if(session_id()) { 
    if(isset($_SESSION['timeout'])&& $_SESSION['timeout']){
      $comment = 'Session has timed out.';
    }else{
        $comment = 'Logged out.';
    }
    $_SESSION = array();
    setcookie("PHPSESSID", '', time() - 1800,'/');
  }
  session_destroy();
  $smarty->assign('comment', $comment);
  $smarty->display('user_logout.tpl');
  

?>
