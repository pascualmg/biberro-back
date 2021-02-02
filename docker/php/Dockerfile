FROM php:fpm as basic
RUN apt-get update && \
    apt-get install -y \
        apt-utils \
        bash \
        zip && \
    mkdir /var/app

COPY docker/php/config/php_prod.ini /usr/local/etc/php/php.ini
ENV PATH /var/app/bin:/var/app/vendor/bin:$PATH
WORKDIR /var/app

FROM basic as development
RUN apt-get install -y git

RUN pecl install xdebug &&\
 docker-php-ext-enable xdebug &&\
 echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&\
 echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY docker/php/config/php_dev.ini /usr/local/etc/php/php.ini

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
php composer-setup.php && \
php -r "unlink('composer-setup.php');" && \
mv -v /var/app/composer.phar /usr/bin/composer && \
chmod 755 /usr/bin/composer

FROM development as test
ENV APP_ENV=prod
ADD bin/ ./bin
ADD composer.json .
ADD composer.lock .
ADD symfony.lock .
RUN composer install --prefer-dist --no-scripts --no-autoloader
ADD . .
RUN composer dump-autoload && composer run-script post-install-cmd

FROM basic as result
ENV APP_ENV=prod
ADD bin/ ./bin
ADD composer.json .
ADD composer.lock .
ADD symfony.lock .
RUN composer install --no-dev --prefer-dist --no-scripts --no-autoloader
ADD . .
RUN composer dump-autoload --optimize && composer run-script post-install-cmd \
    && rm -rf \
        docker \
        tests \
        .env.test \
        grumphp.yml \
        phpcs.xml.dist \
        phpstan.neon \
        phpunit.xml.dist

FROM basic as production
COPY --from=result /var/app ./
RUN chown -R www-data:www-data /var/app
USER www-data
