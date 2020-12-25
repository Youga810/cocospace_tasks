<?php
//--------------------------------------Cache_Lite読み込み
require_once "Cache/Lite.php";

//--------------------------------------キャッシュオプション
$cacheOptions = array(
		'cacheDir' => 'Cache/tmp/', //キャッシュファイルの保存先ディレクトリ
		'lifeTime' => '86400', //キャッシュの有効期限(一秒単位)。例の86400は一日
		//'automaticCleaningFactor' => '20'　//新規キャッシュファイル保存時の期限切れファイル自動削除設定。例の場合1/20の確率で削除される
             	);

//--------------------------------------オブジェクト生成
$Cache_Lite = new Cache_Lite($cacheOptions);

//--------------------------------------キャッシュID設定
$cacheid = "sample"; //キャッシュIDでキャッシュを識別
echo 'cache='.$Cache_Lite->get($cacheid).'aaa<br>';
if ($cache = $Cache_Lite->get($cacheid)) {
//キャッシュがあった場合の処理。キャッシュを$aaaに代入
$aaa = $cache;	
echo 'AA';
} else {
//キャッシュがなかった場合の処理
$aaa = "test";

//キャッシュの保存。$aaaを$cacheidで保存
$Cache_Lite->save($aaa,$cacheid);
}

print $aaa; //「test」と表示される

?>