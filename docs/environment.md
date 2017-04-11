ElasticSearchの導入方法
=======

~~~~
# sudo -s

#-- JAVAのインストール
# yum -y install java

#-- elasticsearch、kibanaのインストール
# rpm --import https://artifacts.elastic.co/GPG-KEY-elasticsearch
# vi/etc/yum.repos.d/elasticsearch.repo
[elasticsearch-5.x]
name=Elasticsearch repository for 5.x packages
baseurl=https://artifacts.elastic.co/packages/5.x/yum
gpgcheck=1
gpgkey=https://artifacts.elastic.co/GPG-KEY-elasticsearch
enabled=1
autorefresh=1
type=rpm-md

# vi /etc/yum.repos.d/kibana.repo
[kibana-4.5]
name=Kibana repository for 4.5.x packages
baseurl=http://packages.elastic.co/kibana/4.5/centos
gpgcheck=1
gpgkey=http://packages.elastic.co/GPG-KEY-elasticsearch
enabled=1

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

#-- ブラウザからkibanaの動作確認
http://127.0.0.1:5601
