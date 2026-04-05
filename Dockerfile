FROM php:8.2-cli
 
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql intl zip
 
COPY . /app
 
WORKDIR /app
 
RUN mkdir -p /app/writable/session \
    && mkdir -p /app/writable/cache \
    && mkdir -p /app/writable/logs \
    && mkdir -p /app/writable/uploads \
    && chmod -R 777 /app/writable
 
EXPOSE 8080
 
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public", "public/index.php"]
 