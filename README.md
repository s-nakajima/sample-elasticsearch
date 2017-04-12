ElasticSearchサンプルプログラム
=======

## ElasticSearch本体のインストール

### インストール方法構築

詳しくは、[こちら](https://github.com/s-nakajima/sample-elasticsearch/blob/master/docs/environment.md)


### ElasticSearch のコマンド
#### curlによるコマンド

詳しくは、[こちら](https://github.com/s-nakajima/sample-elasticsearch/blob/master/docs/curl-cmd.md)



#### kibanaによるコマンド

詳しくは、[こちら](https://github.com/s-nakajima/sample-elasticsearch/blob/master/docs/kibana-cmd.md)



## サンプルプログラム

### インストール
~~~~
cd /var/www/html
git clone https://github.com/s-nakajima/sample-elasticsearch.git

cd sample-elasticsearch
composer install
~~~~

### ElasticSearchのドキュメント

 * Firefoxのアドオンインストール「[asciidoctorjslivepreview](https://github.com/asciidoctor/asciidoctor-firefox-addon)」
 * [elasticsearch/docs/index.asciidoc](http://html.local:9096/sample-elasticsearch/vendors/elasticsearch/elasticsearch/docs/index.asciidoc) にアクセスする

### サンプル実行
 * [elasticsearch/src/index.php](http://html.local:9096/sample-elasticsearch/src/index.php) にアクセスする


## 参考

### ElasticSearch
 * [elasticsearch documents](https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/index.html)
 * http://morizyun.github.io/blog/elasticsearch-server-basic-api/ (mappingについて)
 * http://qiita.com/4cteru/items/074d8dc956103c36b7fa (bulkについて)
 * https://medium.com/hello-elasticsearch/elasticsearch-9a8743746467 (mappingについて)
 * http://qiita.com/kompiro/items/5abeae93dc386ab669bf (mappingについて)
