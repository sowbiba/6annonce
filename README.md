# 6annonce

## Dev environment setup

### First get the project files :

git clone

### Install dependencies :

composer install

### Build containers : MySQL, ElasticSearch and Kibana

docker-compose up -d

### Create DB

bin/console doctrine:database:create

bin/console doctrine:schema:create

### Populate DB with dev values

Execute scripts :

[tools/DB/init-db.sql](tools/DB/init-db.sql)

[tools/DB/dev/populate-db.sql](tools/DB/dev/populate-db.sql)