FROM php:8.2.23-fpm
WORKDIR /app

COPY . .
COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./supervisord.conf /etc/supervisord.conf

# install packages
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    vim \
    net-tools \
    supervisor
# install php extensions
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions mysqli ctype curl dom fileinfo filter hash mbstring openssl pcre pdo pdo_mysql session tokenizer xml
# install composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN cp .env.example .env
RUN composer install
RUN php artisan key:generate
RUN composer install
RUN chmod -R 777 storage
RUN chmod 777 -R bootstrap/cache
RUN rm -rf public/storage
RUN php artisan storage:link
RUN php artisan optimize
#RUN crond && /usr/bin/supervisord -n -c /etc/supervisord.conf

CMD ["php-fpm"]
EXPOSE 9000