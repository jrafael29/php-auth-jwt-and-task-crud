FROM php:8.2-fpm

RUN apt-get update && apt-get install -y nginx

WORKDIR /app
COPY . .


COPY ./nginx.conf /etc/nginx/nginx.conf

RUN pecl install redis mysqli
# RUN apt-get update && apt-get install -y mysqli

EXPOSE 80


# CMD ["/usr/sbin/nginx"]
CMD ["sh", "-c", "service nginx start && php-fpm"]