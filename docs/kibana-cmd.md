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
