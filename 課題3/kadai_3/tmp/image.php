<?php
/**
 * image.php
 */
require 'common.php';

try {
    $id = filter_input(INPUT_GET, 'id');

    // データベースからレコードを取得
    $sql = 'SELECT `id`, `title`, `path` FROM `images` WHERE `id` = :id';
    $arr = [];
    $arr[':id'] = $id;
    $rows = select($sql, $arr);
    $row = reset($rows);
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style type="text/css">
            .error {
                color: red;
            }
        </style>
    </head>
    <body>
        <div id="wrap">
            <?php if (isset($error)) : ?>
                <p class="error"><?= h($error); ?></p>
            <?php endif; ?>

            <p><?= h($row['title']); ?></p>
            <p>
                <video controls width="1000">
                 <source src="<?= $row['path']; ?>">
                 </video>
                <?php echo h($row['path']); ?>
            </p>
        </div>
    </body>
</html>