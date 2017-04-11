ElasticSearchサンプルプログラム
=======

## ElasticSearch本体のインストール

### 環境構築
~~~~
# sudo -s

#-- JAVAのインストール
# yum -y install java

#-- elasticsearch、kibanaのインストール
# rpm --import https://artifacts.elastic.co/GPG-KEY-elasticsearch
# cp /home/vagrant/default/elasticsearch/elasticsearch.repo /etc/yum.repos.d/
# cp /home/vagrant/default/elasticsearch/kibana.repo /etc/yum.repos.d/
# yum -y install elasticsearch kibana
# vi /etc/kibana/kibana.yml
#--以下をserver.host: "0.0.0.0"に修正
#server.host: "localhost"
server.host: "0.0.0.0"

#-- 起動設定 
# systemctl restart elasticsearch
# systemctl enable elasticsearch
# systemctl is-enabled elasticsearch
# systemctl daemon-reload
# systemctl enable kibana
# systemctl start kibana
# systemctl is-enabled kibana

#--プラグインの追加
# /usr/share/elasticsearch/bin/elasticsearch-plugin install mapper-attachments
# /usr/share/elasticsearch/bin/elasticsearch-plugin install analysis-icu
# /usr/share/elasticsearch/bin/elasticsearch-plugin install analysis-kuromoji
# systemctl restart elasticsearch

#-- 以下sudoでなくて良い

#-- elasticsearchの動作確認
$ curl -XGET http://localhost:9200
{
  "name" : "24gWFF6",
  "cluster_name" : "elasticsearch",
  "cluster_uuid" : "CKSL8iQ0RLqhgshH4Shxag",
  "version" : {
    "number" : "5.3.0",
    "build_hash" : "3adb13b",
    "build_date" : "2017-03-23T03:31:50.652Z",
    "build_snapshot" : false,
    "lucene_version" : "6.4.1"
  },
  "tagline" : "You Know, for Search"
}

#-- インデックス（DB）作成
$ curl -XPUT http://localhost:9200/hoge_index

#-- インデックス（DB）の削除
$ curl -XDELETE http://localhost:9200/hoge_index

~~~~

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
    or
PUT /hoge_index
~~~~

* インデックス（DB）の削除
~~~~
DELETE hoge_index
    or
DELETE /hoge_index
~~~~

* 全インデックス（DB）の削除
~~~~
DELETE /*
    or
DELETE /*
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


