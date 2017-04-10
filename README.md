ElasticSearchサンプルプログラム
=======

## ElasticSearch本体のインストール

### 
~~~~
# sudo -s

### JAVAのインストール
# yum -y install java

#-- elasticsearch、kibanaのインストール
# rpm --import https://artifacts.elastic.co/GPG-KEY-elasticsearch
# cp /home/vagrant/default/elasticsearch/elasticsearch.repo /etc/yum.repos.d/
# cp /home/vagrant/default/elasticsearch/kibana.repo /etc/yum.repos.d/
# yum -y install elasticsearch kibana
# cp /home/vagrant/default/elasticsearch/kibana.yml /etc/kibana/
# mv /etc/kibana/kibana.yml /etc/kibana/kibana.yml.dist

#-- 起動設定 
# systemctl restart elasticsearch
# systemctl enable elasticsearch
# systemctl is-enabled elasticsearch
# systemctl daemon-reload
# systemctl enable kibana
# systemctl start kibana
# systemctl is-enabled kibana

#-- elasticsearchの動作確認
# curl -XGET http://localhost:9200
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


