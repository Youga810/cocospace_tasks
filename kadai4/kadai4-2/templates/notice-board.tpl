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
            <input type="hidden" name="name" value="{$user_name}">
            <input type="hidden" name="post_password" value="{$user_password}">
            
            <div class="comment">
              <h1>Comment</h1>
              <textarea name="comment" cols="35" rows="10" placeholder="Comment">{$edit_comment1}</textarea>
            </div>
            <div class="attachment">
              <h1>Attachment</h1>
              <input type="file" name="upfile" accept="image/jpeg,image/png,image/gif,video/mp4">
            </div>
            <input class="post" type="submit" value="POST">
      </form>
    </div>
    <div class="delete-wrap">
      <form action="./notice-board.php" method="post" onSubmit="return check()">
            <div class="delete">
              <h1> Delete Number </h1>
              <input type="text" size="3" name="delete" placeholder="ID">
            </div>
            <div>
              <h1>Password</h1>
              <input type="password" size="10" name="delete_password"></dd>
            </div>
            <input class="delete" type="submit" value="DELETE">
      </form>
    </div>
    <div class="edit-wrap">
      <form action="./notice-board.php" method="post">
            <div class="edit">
              <h1> Edit Number </h1>
              <input type="text" size="3" name="edit" placeholder="ID">
            </div>
            <div>
              <h1>Password</h1>
              <input type="password" size="10" name="edit_password">
            </div>
            <input class="edit" type="submit" value="EDIT">
      </form>
    </div>
  </div>
  <div class="split-item split-right">
    {if isset($view)}
    <h1 class="listmsg"> Post List </h1>
    {foreach $view as $value}

        <table border="1">
          <thead>
            <tr class="id">
              <th>ID</th>
              <td>{$value['id']} </td>
            </tr>
            <tr>
              <th>NAME</th>
              <td>{$value['name']}</td>
            </tr>            
            <tr>
              <th>COMMENT</th>
              <td>{$value['comment']}</td>
            </tr>
            <tr>
              <th>TIME</th>
              <td>{$value['time']}</td>
            </tr>
            <tr>
            <th>SOURCE</th>
              <td class="src">
                {if $value['ext'] == 'mp4'}
                  <video controls src= "{$value['path']}" >
                {else}
                <img  src= "{$value['path']}">
                {/if}
              </td>
            </tr>
            </thead>
        </table>
    {/foreach}
    {else}
      <div class="nothing">
        There are no posts.
      </div>
    {/if}
  </div>
</div>
</body>
</html>