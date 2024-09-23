FROM php:8.2-fpm-bullseye

RUN apt-get update && apt-get install -y nginx

WORKDIR /app
COPY . .


COPY ./nginx.conf /etc/nginx/nginx.conf

RUN pecl install redis && rm -rf /tmp/pear && docker-php-ext-enable redis

RUN docker-php-ext-install mysqli

EXPOSE 80


# CMD ["/usr/sbin/nginx"]
CMD ["sh", "-c", "service nginx start && php-fpm"]