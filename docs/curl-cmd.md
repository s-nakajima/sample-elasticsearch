ElasticSearch のコマンド
=======

## curlによるコマンド

### インデックス（DB）作成
~~~~
$ curl -XPUT http://localhost:9200/hoge_index
~~~~

### インデックス（DB）の削除
~~~~
### curl -XDELETE http://localhost:9200/hoge_index
~~~~

### 全インデックス（DB）の削除
~~~~
$ curl -XDELETE http://localhost:9200/*
~~~~

### インデックス（DB）の一覧（SHOW TABLES）
~~~~
### curl -XGET http://localhost:9200/_aliases
~~~~
