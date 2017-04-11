ElasticSearch のコマンド
=======

## kibanaによるコマンド

### インデックス（DB）作成
~~~~
PUT hoge_index
~~~~

### インデックス（DB）の削除
~~~~
DELETE hoge_index
~~~~

### 全インデックス（DB）の削除
~~~~
DELETE *
~~~~

### インデックス（DB）の一覧（SHOW TABLES）
~~~~
GET _aliases
~~~~

### タイプ（table)のデータ取得（SELECT * FROM）
~~~~
GET hoge_index/hoge_type/_search
~~~~

### タイプ（table)へドキュメント登録（追加）
~~~~
PUT hoge_index/hoge_type/2
{
 "field_01": "hoge1",
 "field_02": "hoge2",
 "field_03": "hoge3"
}

＜確認＞
GET hoge_index/hoge_type/_search
~~~~

### タイプ（table)へドキュメント登録（削除）
~~~~
DELETE hoge_index/hoge_type/1

＜確認＞
GET hoge_index/hoge_type/_search
~~~~

### タイプ（table)へドキュメント登録（更新）
~~~~
POST hoge_index/hoge_type/1
{
 "field_01": "hoge1_upd",
 "field_02": "hoge2",
 "field_03": "hoge3"
}

＜確認＞
GET hoge_index/hoge_type/_search
~~~~
