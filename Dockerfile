FROM php:8.3-fpm

# supervisor
RUN apt-get update && apt-get install -y supervisor

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# PHP eklentileri
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    librdkafka-dev \
    && docker-php-ext-install zip \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka

# Supervisord config
COPY supervisor/supervisord.conf /etc/supervisord.conf
COPY supervisor/user-created-worker.conf /etc/supervisor/conf.d/user-created-worker.conf

# Supervisor config klasörü oluştur
RUN mkdir -p /etc/supervisor/conf.d

RUN mkdir -p /var/log/supervisor

WORKDIR /var/www
EXPOSE 9000

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]
# Define the entry point
CMD ["php-fpm"]