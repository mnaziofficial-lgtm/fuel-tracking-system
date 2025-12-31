FROM php:8.2-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y git curl zip unzip && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader 2>&1 || composer install --no-interaction --prefer-dist

RUN chmod -R 755 storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

