docker-compose down -v
docker-compose up -d --build

docker-compose exec php-fpm /usr/bin/supervisord -n -c /etc/supervisord.conf