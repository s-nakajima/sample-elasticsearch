ElasticSearchサンプルプログラム
=======

## ElasticSearch本体のインストール

### 環境構築

詳しくは、こちら


### ElasticSearch のコマンド
#### curlによるコマンド
* インデックス（DB）作成
~~~~
$ curl -XPUT http://localhost:9200/hoge_index
~~~~

* インデックス（DB）の削除
~~~~
$ curl -XDELETE http://localhost:9200/hoge_index
~~~~

* 全インデックス（DB）の削除
~~~~
$ curl -XDELETE http://localhost:9200/*
~~~~

* インデックス（DB）の一覧（SHOW TABLES）
~~~~
$ curl -XGET http://localhost:9200/_aliases
~~~~


#### kibanaによるコマンド
* インデックス（DB）作成
~~~~
PUT hoge_index
~~~~

* インデックス（DB）の削除
~~~~
DELETE hoge_index
~~~~

* 全インデックス（DB）の削除
~~~~
DELETE *
~~~~

* インデックス（DB）の一覧（SHOW TABLES）
~~~~
GET _aliases
~~~~


## PHPからElasticSearchにアクセスする

### インストール
~~~~
cd /var/www/html
git clone https://github.com/s-nakajima/sample-elasticsearch.git

cd sample-elasticsearch
composer install
~~~~

### ElasticSearchのドキュメント

 * Firefoxのアドオンインストール「asciidoctorjslivepreview( https://github.com/asciidoctor/asciidoctor-firefox-addon )」
 * http://html.local:9096/sample-elasticsearch/vendors/elasticsearch/elasticsearch/docs/index.asciidoc にアクセスする


