FROM bitnami/php-fpm:8.3.13
RUN apt-get update && apt-get install -y \
    autoconf \
    build-essential \
    wget
RUN cd /root \
    && wget https://pecl.php.net/get/redis-6.1.0.tgz \
    && tar xzf redis-6.1.0.tgz && cd redis-6.1.0 \
    && phpize \
    && ./configure \
    && make \
    && make install
RUN echo "extension=redis.so" >> /opt/bitnami/php/etc/php.ini