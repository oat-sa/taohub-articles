Installation solr centos
========================

    yum install java-1.7.0-openjdk.x86_64

    cd /opt/
    wget http://apache.petsads.us/lucene/solr/4.10.2/solr-4.10.2.tgz
    tar -xvf solr-4.10.2.tgz 
    mv /opt/solr-4.10.2 /opt/solr
    mv /opt/solr/example /opt/solr/core

    sed -i 's|name="jetty.host"|name="jetty.host" default="solr.taocloud.org"|g' /opt/solr/core/etc/jetty.xml

Configure Solr as a service

    wget https://raw.githubusercontent.com/extremeshok/solr-init/master/solr.centos -O /etc/init.d/solr
    chmod +x /etc/init.d/solr

Start at boot

    chkconfig --add solr
