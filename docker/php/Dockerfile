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
RUN mkdir -p /usr/src/php/ext/xdebug && curl -fsSL https://pecl.php.net/get/xdebug | tar xvz -C "/usr/src/php/ext/xdebug" --strip 1 && docker-php-ext-install xdebug
RUN docker-php-ext-enable xdebug
COPY docker/php/config/php_dev.ini /usr/local/etc/php/php.ini

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
