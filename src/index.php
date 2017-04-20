<?php
ob_start();

require '../vendors/autoload.php';
require 'Elasticsearch/UsersIndex.php';

//インデックス作成
$UsersIndex = new UsersIndex();
print_r(get_class($UsersIndex));
echo "\n";
echo "\n";

$result = $UsersIndex->create([
	'user_profile' => [
		'properties' => [
			//'title' => ['type' => 'string', 'store' => 'yes', 'index' => 'analyzed', 'analyzer' => 'ja_analyzer']
			//'id' => ['type' => 'logn'],
			'title' => ['type' => 'string', 'store' => 'yes', 'index' => 'analyzed']
		]
	]
]);
print_r($result);
echo "\n";
echo "\n";

//データ登録(_bluk)
$data = [];
for ($i = 1; $i <= 5; $i++) {
	$data[] = [
		'index' => ['_index' => $UsersIndex->index, '_type' => 'user_profile', '_id' => $i]
	];
	$data[] = [
		'id' => (string)$i,
		'title' => 'テスト ' . $i
	];
}
$result = $UsersIndex->UserProfile->bulk($data);
print_r($result);
echo "\n";
echo "\n";

//データ(search)取得
$result = $UsersIndex->UserProfile->search();
print_r($result); 
echo "\n";
echo "\n";

$result = $UsersIndex->UserProfile->get('5');
print_r($result);
echo "\n";
echo "\n";

//$result = $UsersIndex->delete();
//print_r($result);


$contents = ob_get_contents();

ob_end_clean();

echo nl2br(preg_replace("/ /", '&nbsp;', $contents));