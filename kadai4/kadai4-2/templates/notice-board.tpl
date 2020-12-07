<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>notice-board</title>
  <link rel="stylesheet" href="./css/common.css">
  <link rel="stylesheet" href="./css/notice-board.css">

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

  <style>
  img, video {
    max-width: 100%;
    height: auto;
  }
  </style>
</head>
<body>
<div class="split">
  <header class="header">
    <div class="head-wrap">
      <h1 class="notice-board-head">Notice-Board</h1> 
        <ul class="ul-wrap">
            <li>ID：{$session['myId']}</li>
            <li>NAME：{$user_name}</li>
          <li>
          <form action="./user_logout" method="get">
              <input type="submit" class="logout" value="Logout">
          </form>
          </li>
        </ul>
    </div>
  </header>

  <div class="split-item split-left">
    <div class="post-wrap">
      <form action="./notice-board.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="ID" value="{$edit_ID}">
            <dt>お名前：</dt>
            <dd><input type="text" size="30" name="name" placeholder="ここに名前を入力してください。" value="{$user_name}"></dd>

            <dt>コメント：</dt>
            <dd>
              <textarea name="comment" cols="35" rows="10" placeholder="ここにコメントを入力してください。">{$edit_comment1}</textarea>
            </dd>

            <dt>添付ファイル：(対応拡張子：jpg,png,gif,mp4)</dt>
            <dd><input type="file" name="upfile" accept="image/jpeg,image/png,image/gif,video/mp4"></dd>

            <dt>パスワード：</dt>
            <dd><input type="password" size="30" name="post_password" placeholder="ここにパスワードを入力してください。"></dd>
            <input type="submit" value="投稿">
      </form>
    </div>
    <div class="delete-wrap">
      <form action="./notice-board.php" method="post" onSubmit="return check()">

            <dt>削除番号：</dt>
            <dd>
              <input type="text" size="35" name="delete" placeholder="ここに削除したい番号を入力してください。">
            </dd>
            <dt>パスワード：</dt>
            <dd><input type="password" size="30" name="delete_password" placeholder="ここにパスワードを入力してください。"></dd>
            <input type="submit" value="削除">
      </form>
    </div>
    <div class="edit-wrap">
      <form action="./notice-board.php" method="post">

            <dt>編集番号：</dt>
            <dd>
              <input type="text" size="35" name="edit" placeholder="ここに編集したい番号を入力してください。">
            </dd>

            <dt>パスワード：</dt>
            <dd><input type="password" size="30" name="edit_password" placeholder="ここにパスワードを入力してください。"></dd>
            <input type="submit" value="編集">
      </form>
    </div>
  </div>
  <div class="split-item split-right">
    {if isset($view)}
    <h1 class="listmsg"> Post List </h1>
    {foreach $view as $value}

        <table border="1">
          <thead>
            <tr>
              <td>
                {$value['id']} 番
                {$value['name']}さん
                {$value['comment']}
                {$value['time']}

                {if $value['ext'] == 'mp4'}
                  <video controls src= "{$value['path']}"width="400" >
                {else}
                <img src= "{$value['path']}"width="400" >
                {/if}
                <br>
              </td>
            </tr>
          </thead>
        </table>
    {/foreach}
    {else}
      投稿がありません。
    {/if}
  </div>
</div>
</body>
</html>