<?php
/**
 * Elasticsearch 共通処理
 *
 * 各インデックスは、当ファイルを継承して使用する
 *
 * @author Japan Science and Technology Agency
 * @author National Institute of Informatics
 * @link http://researchmap.jp researchmap Project
 * @link http://www.netcommons.org NetCommons Project
 * @license http://researchmap.jp/public/terms-of-service/ researchmap license
 * @copyright Copyright 2017, researchmap Project
 */

//App::uses('AppElasticsearch', 'RmNetCommons.Elasticsearch');
//require dirname(__DIR__) . '/Lib/Elasticsearch/AppClientBuilder.php'; //後で入れ替え

/**
 * Elasticsearch 共通クラス
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package RmNetCommons\Elasticsearch
 */
class AppType {

/**
 * タイプ
 *
 * @var string|false
 */
	public $type = false;

/**
 * コンストラクター
 *
 * @param Client $client Clientオブジェクト
 * @param null|string $index インデックス
 * @param null|string $type タイプ
 * @return void
 */
	public function __construct(Elasticsearch\Client $client, $index = null, $type = null) {
		$this->_client = $client;

		if ($index) {
			$this->index = $index;
		}
		if ($type) {
			$this->type = $type;
		}
	}

/**
 * 定義していないメソッドは、Clientのメソッドを呼び出す
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 */
	public function __call($method, $params) {
		if (! $this->existsType()) {
			return false;
		}

		$options['index'] = $this->index;
		$options['type'] = $this->type;

		if ($params) {
			$options['body'] = $params;
		}

		try {
			$results = call_user_func_array(array($this->_client, $method), $options);
		} catch (Exception $ex) {
			//TODO: ログ出力
			var_dump($ex);
			throw $ex;
		}

		return $results;
	}

/**
 * indexの存在チェック
 *
 * 以下のように、indices()->existsを実行してindexが存在チェックするためのメソッド
 * ~~~~
 * $client = ClientBuilder::create()->build();
 * $params = [
 *     'index' => 'my_index',
 * ];
 * $response = $client->indices()->exists($params);
 * ~~~~
 *
 * @return bool
 */
	public function existsIndex() {
		return $this->_client->indices()->exists(['index' => $this->index]);
	}

/**
 * Typeが存在するかどうか
 *
 * 以下のように、indices()->existsTypeを実行してindexが存在チェックするためのメソッド
 * ~~~~
 * $client = ClientBuilder::create()->build();
 * $params = [
 *     'index' => 'my_index',
 *     'type' => 'my_type',
 * ];
 * $response = $client->indices()->existsType($params);
 * ~~~~
 *
 * @return bool
 */
	public function existsType() {
		return $this->_client->indices()->existsType(['index' => $this->index, 'type' => $this->type]);
	}

/**
 * Typeが存在するかどうか
 *
 * 以下のように、client->existsを実行してindexが存在チェックするためのメソッド
 * ~~~~
 * $client = ClientBuilder::create()->build();
 * $params = [
 *     'index' => 'my_index',
 *     'type' => 'my_type',
 *	   'id' => 'my_id',
 * ];
 * $response = $client->exists($params);
 * ~~~~
 *
 * @return bool
 */
	public function exists($id) {
		return $this->_client->exists([
			'index' => $this->index,
			'type' => $this->type,
			'id' => $id
		]);
	}

/**
 * データを取得する
 *
 * 以下のように、client->get()を実行してデータを取得するためのメソッド
 *
 * ~~~~
 * $client = Elasticsearch\ClientBuilder::create()->build();
 * $params = [
 *     'index' => 'my_index',
 *     'type' => 'my_type',
 *	   'id' => 'my_id',
 * ];
 * $results = $client->get($params);
 * ~~~~
 * @return array|false
 * @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_search_operations.html
 */
	public function get($id) {
		$params = array(
			'index' => $this->index,
			'type' => $this->type,
			'id' => $id
		);

		try {
			$results = $this->_client->get($params);
		} catch (Exception $ex) {
			//見つからない場合、エラーにしない
			$message = $ex->getMessage();
			$results = json_decode($message, true);
			return $results['found'];
		}

		if ($results['found']) {
			return $results['_source'];
		} else {
			return false;
		}
	}

/**
 * データを取得する
 *
 * 以下のように、search()を実行してデータを取得するためのメソッド
 *
 * ~~~~
 * $client = Elasticsearch\ClientBuilder::create()->build();
 *
 * $params = [
 *     'index' => 'my_index',
 *     'type' => 'my_type',
 *     'body' => [
 *         'query' => [
 *             'match' => [
 *                 'testField' => 'abc'
 *             ]
 *         ]
 *     ]
 * ];
 *
 * $results = $client->search($params);
 * ~~~~
 *
 * @param string|null $hitsKey 結果(hits)のkey。指定しない場合、hitsの中身を返却する
 * @param null|array $body 上記'body'該当する部分のオプション
 * ~~~~
 * 'query' => [
 *		'match' => [
 *			'testField' => 'abc'
 *      ]
 * ]
 * ~~~~
 * @return array|false
 * @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_search_operations.html
 */
	public function search($hitsKey = 'hits', $body = null) {
		$params = array(
			'index' => $this->index,
			'type' => $this->type,
		);

		if ($body) {
			$params['body'] = $body;
		}

		try {
			$results = $this->_client->search($params);
		} catch (Exception $ex) {
			//TODO: ログ出力
			var_dump($ex);
			throw $ex;
		}

		if ($hitsKey) {
			return $results['hits'][$hitsKey];
		} else {
			return $results['hits'];
		}
	}

/**
 * データを一括登録(_bulk)する
 *
 * 以下のように、client->bulk()を実行してデータを取得するためのメソッド
 *
 * ~~~~
 * $client = Elasticsearch\ClientBuilder::create()->build();
 * $params = [
 *     'index' => 'my_index',
 *     'type' => 'my_type',
 *     'body' => [
 *         ['index' => ['_index' => 'my_index', '_type' => 'my_type']],
 *         ['my_field' => 'my_value', 'second_field' => 'some more values'],
 *     ]
 * ];
 * $results = $client->bulk($params);
 * ~~~~
 *
 * ### bodyのアクション
 * * index ：ドキュメントがなければ新規登録、あればリプレース
 * * create：ドキュメントがない場合だけ動作
 * * delete：ドキュメントを削除
 * * update：存在するドキュメントにマージする
 *
 * ただし、deleteは１行のみで残りは２行で１セット。
 *
 * #### サンプル
 * ~~~~
 * ['delete' => ['_index' => 'test_index', '_type' => 'lang', '_id' => '123']],
 * ['create' => ['_index' => 'test_index', '_type' => 'lang', '_id' => '123']},
 * ['name' => 'php5.3'],
 * ['index' => ['_index' => 'test_index', '_type' => 'lang']],
 * ['title' => 'php5.6'],
 * ['update' => ['_index' => 'test_index', '_type' => 'lang', '_id' => '123', '_retry_on_conflict'  => 3]],
 * ['doc'  => ['title' => 'php7']],
 * ~~~~
 *
 * @param null|array $body 上記'body'該当する部分のオプション
 * @return false
 * @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_indexing_documents.html#_bulk_indexing
 */
	public function bulk($body) {
		if (! $this->existsType()) {
			return false;
		}

		$params = array(
			'index' => $this->index,
			'type' => $this->type,
			'body' => $body
		);

		try {
			$results = $this->_client->bulk($params);
		} catch (Exception $ex) {
			//TODO: ログ出力
			var_dump($ex);
			throw $ex;
		}

var_dump($results);

		return ! $results['errors'];
	}

}
