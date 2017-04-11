ElasticSearch のコマンド
=======

## kibanaによるコマンド

### インデックス（DB）作成
~~~~
$ curl -XPUT http://localhost:9200/hoge_index
~~~~

### インデックス（DB）の削除
~~~~
$ curl -XDELETE http://localhost:9200/hoge_index
~~~~

### 全インデックス（DB）の削除
~~~~
$ curl -XDELETE http://localhost:9200/*
~~~~

### インデックス（DB）の一覧（SHOW TABLES）
~~~~
$ curl -XGET http://localhost:9200/_aliases
~~~~

### タイプ（table)のデータ取得（SELECT * FROM）
~~~~
$ curl -XGET http://localhost:9200/hoge_index/hoge_type/_search
~~~~

### タイプ（table)へドキュメント登録（追加）
~~~~
$ curl -XPUT http://localhost:9200/hoge_index/hoge_type/2
{
 "field_01": "hoge1",
 "field_02": "hoge2",
 "field_03": "hoge3"
}

＜確認＞
$ curl -XGET http://localhost:9200/hoge_index/hoge_type/_search
~~~~

### タイプ（table)へドキュメント登録（削除）
~~~~
$ curl -XDELETE http://localhost:9200/hoge_index/hoge_type/1

＜確認＞
$ curl -XGET http://localhost:9200/hoge_index/hoge_type/_search
~~~~

### タイプ（table)へドキュメント登録（更新）
~~~~
$ curl -XPOST http://localhost:9200/hoge_index/hoge_type/1
{
 "field_01": "hoge1_upd",
 "field_02": "hoge2",
 "field_03": "hoge3"
}

＜確認＞
$ curl -XGET http://localhost:9200/hoge_index/hoge_type/_search
~~~~
