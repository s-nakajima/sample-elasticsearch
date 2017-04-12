<?php
/**
 * Elasticsearch UserProfile(usersインデックス、user_profileタイプ)処理
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

//App::uses('AppType', 'RmNetCommons.Elasticsearch/Type');
require 'Elasticsearch/Type/AppType.php'; //後で入れ替え

/**
 * Elasticsearch UserProfile(usersインデックス、user_profileタイプ)クラス
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package RmUsers\Elasticsearch
 */
class UserProfileType extends AppType {

/**
 * インデックス
 *
 * @var string|false
 */
	public $index = 'users';

/**
 * タイプ
 *
 * @var string|false
 */
	public $type = 'user_profile';

}
