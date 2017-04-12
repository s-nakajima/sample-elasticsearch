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
class AppIndex {

/**
 * ElasticSearch ClientBuilderオブジェクト
 *
 * @var object
 */
	protected $_client = null;

/**
 * ホスト
 *
 * @var string|false
 */
	public $hosts = ['localhost:9200'];

/**
 * インデックス
 *
 * @var string|false
 */
	public $index = false;

/**
 * タイプ
 *
 * @var array|false
 */
	public $types = false;

/**
 * タイプをロードしたかどうかを保持しておく変数
 *
 * @var array|false
 */
	protected $_typesMap = [];

/**
 * プラグイン
 *
 * @var string|false
 */
	public $plugin = false;

/**
 * コンストラクター
 *
 * @param null|string $index インデックス
 * @param null|array $types タイプリスト
 * @return void
 */
	public function __construct($index = null, $types = null) {
		$clientBuilder = Elasticsearch\ClientBuilder::create();
		$clientBuilder->setHosts($this->hosts);
		$this->_client = $clientBuilder->build();
var_dump(get_class($this->_client));

		if ($index) {
			$this->index = $index;
		}
		if ($types) {
			$this->types = $types;
		}

		if ($this->types) {
			foreach ($this->types as $camelType => $type) {
				//TODO: Cakeでは、MyPlugin.MyTypeの形として、App:usesをする
				//$type['type'], $type['class'], $type['plugin']をいい感じにセットする処理追加

				$class = $type['class'] . 'Type';

				//App::uses($class, $type['plugin'] . '.Elasticsearch/Type');
				require 'Elasticsearch/Type/' . $class . '.php'; //後で入れ替え

				$this->$camelType = new $class($this->_client, $this->index, $type['type']);
				$this->$camelType->plugin = $type['plugin'];

				$this->_typesMap[] = $camelType;
			}
		}
	}

///**
// * 定義していないメソッドは、Clientのメソッドを呼び出す
// *
// * @param string $method メソッド
// * @param array $params パラメータ
// * @return mixed
// */
//	public function __call($method, $params) {
//		return call_user_func_array(array($this->_client, $method), $params);
//	}

/**
 * indexを作成する
 *
 * 以下のように、indices()->createを実行してindexを生成するためのメソッド
 *
 * ~~~~
 * $client = ClientBuilder::create()->build();
 * $params = [
 *     'index' => 'my_index',
 *     'body' => [
 *         'mappings' => [
 *             'my_type' => [
 *                 'properties' => [
 *                     'first_name' => [
 *                         'type' => 'string',
 *                         'analyzer' => 'standard'
 *                     ],
 *                     'age' => [
 *                         'type' => 'integer'
 *                     ]
 *                 ]
 *            ]
 *         ]
 *     ]
 * ];
 * $response = $client->indices()->create($params);
 * ~~~~
 *
 * @param array $mappings 上記、'mappings'該当する部分のオプション
 * @return bool
 * @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_index_management_operations.html#_create_an_index_2
 */
	public function create($mappings) {
		if ($this->exists()) {
			return true;
		}

		$params = [
			'index' => $this->index,
			'body' => [
				'mappings' => $mappings,
			],
		];

		try {
			$results = $this->_client->indices()->create($params);
		} catch (Exception $ex) {
			//TODO: ログ出力
			var_dump($ex);
			throw $ex;
		}
var_dump($results);

		return $results['acknowledged'];
	}

/**
 * indexの存在チェック
 *
 * 以下のように、indices()->existsを実行してindexが存在チェックするためのメソッド
 *
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
	public function exists() {
		return $this->_client->indices()->exists(['index' => $this->index]);
	}

/**
 * indexを削除する
 *
 * 以下のように、indices()->deleteを実行してindexを削除するためのメソッド
 *
 * ~~~~
 * $client = ClientBuilder::create()->build();
 * $params = [
 *     'index' => 'my_index',
 * ];
 * $response = $client->indices()->delete($params);
 * ~~~~
 *
 * @return bool
 * @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_index_management_operations.html#_delete_an_index_2
 */
	public function delete() {
		if (! $this->exists()) {
			return true;
		}

		$params = [
			'index' => $this->index,
		];

		try {
			$results = $this->_client->indices()->delete($params);
		} catch (Exception $ex) {
			//TODO: ログ出力
			var_dump($ex);
			throw $ex;
		}
var_dump($results);

		return $results['acknowledged'];
	}

///**
// * データを取得する
// *
// * 以下のように、search()を実行してデータを取得するためのメソッド
// *
// * ~~~~
// * $client = Elasticsearch\ClientBuilder::create()->build();
// *
// * $params = [
// *     'index' => 'my_index',
// *     'type' => 'my_type',
// *     'body' => [
// *         'query' => [
// *             'match' => [
// *                 'testField' => 'abc'
// *             ]
// *         ]
// *     ]
// * ];
// *
// * $results = $client->search($params);
// * ~~~~
// *
// * @param string $type タイプ
// * @param string $hitsKey 結果(hits)のkey
// * @param null|array $body 上記'body'該当する部分のオプション
// * ~~~~
// * 'query' => [
// *		'match' => [
// *			'testField' => 'abc'
// *      ]
// * ]
// * ~~~~
// * @return array|false
// * @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_search_operations.html
// */
//	public function search($type, $hitsKey = 'hits', $body = null) {
//		if (! $this->existsIndex() ||
//				! $this->validateType($type)) {
//			return false;
//		}
//
//		$params = array(
//			'index' => $this->index,
//			'type' => $type,
//		);
//
//		if ($body) {
//			$params['body'] = $body;
//		}
//
//		try {
//			$results = $this->_client->search($params);
//		} catch (Exception $ex) {
//			//TODO: ログ出力
//			var_dump($ex);
//			throw $ex;
//		}
//
//		if ($hitsKey) {
//			return $results['hits'][$hitsKey];
//		} else {
//			return $results['hits'];
//		}
//	}
//
///**
// * データを一括登録(_bulk)する
// *
// * 以下のように、bulk()を実行してデータを取得するためのメソッド
// *
// * ~~~~
// * $client = Elasticsearch\ClientBuilder::create()->build();
// *
// * $params = [
// *     'index' => 'my_index',
// *     'type' => 'my_type',
// *     'body' => [
// *         ['index' => ['_index' => 'my_index', '_type' => 'my_type']],
// *         ['my_field' => 'my_value', 'second_field' => 'some more values'],
// *     ]
// * ];
// *
// * $results = $client->bulk($params);
// * ~~~~
// *
// * ### bodyのアクション
// * * index ：ドキュメントがなければ新規登録、あればリプレース
// * * create：ドキュメントがない場合だけ動作
// * * delete：ドキュメントを削除
// * * update：存在するドキュメントにマージする
// *
// * ただし、deleteは１行のみで残りは２行で１セット。
// *
// * #### サンプル
// * ~~~~
// * ['delete' => ['_index' => 'test_index', '_type' => 'lang', '_id' => '123']],
// * ['create' => ['_index' => 'test_index', '_type' => 'lang', '_id' => '123']},
// * ['name' => 'php5.3'],
// * ['index' => ['_index' => 'test_index', '_type' => 'lang']],
// * ['title' => 'php5.6'],
// * ['update' => ['_index' => 'test_index', '_type' => 'lang', '_id' => '123', '_retry_on_conflict'  => 3]],
// * ['doc'  => ['title' => 'php7']],
// * ~~~~
// *
// * @param string $type タイプ
// * @param null|array $body 上記'body'該当する部分のオプション
// * ~~~~
// * 'query' => [
// *		'match' => [
// *			'testField' => 'abc'
// *      ]
// * ]
// * ~~~~
// * @return array|false
// * @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_indexing_documents.html#_bulk_indexing
// */
//	public function bulk($type, $body) {
//		if (! $this->existsIndex() ||
//				! $this->validateType($type)) {
//			return false;
//		}
//
//		$params = array(
//			'index' => $this->index,
//			'type' => $type,
//			'body' => $body
//		);
//
//		try {
//			$results = $this->_client->bulk($params);
//		} catch (Exception $ex) {
//			//TODO: ログ出力
//			var_dump($ex);
//			throw $ex;
//		}
//
//var_dump($results);
//
//		return $results['acknowledged'];
//	}

}
