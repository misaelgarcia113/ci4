FROM php:8.2-cli
 
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql intl zip
 
COPY . /app
 
WORKDIR /app
 
RUN chmod -R 755 /app/writable
 
EXPOSE 8080
 
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public", "public/index.php"]
 