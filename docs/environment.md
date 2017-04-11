ElasticSearchサンプルプログラム
=======

## 環境構築

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

