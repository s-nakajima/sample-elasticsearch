<?php
require '../vendors/autoload.php';
require 'Elasticsearch/UsersIndex.php';

//インデックス作成
$UsersIndex = new UsersIndex();
var_dump(get_class($UsersIndex));

$result = $UsersIndex->create([
	'user_profile' => [
		'properties' => [
			//'title' => ['type' => 'string', 'store' => 'yes', 'index' => 'analyzed', 'analyzer' => 'ja_analyzer']
			//'id' => ['type' => 'logn'],
			'title' => ['type' => 'string', 'store' => 'yes', 'index' => 'analyzed']
		]
	]
]);
var_dump($result);

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
var_dump($result);

//データ(search)取得
$result = $UsersIndex->UserProfile->search();
var_dump($result);

$result = $UsersIndex->UserProfile->get('5');
var_dump($result);

$result = $UsersIndex->delete();
var_dump($result);
