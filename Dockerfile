FROM php:8.2-fpm-bullseye

RUN apt-get update && apt-get install -y nginx

WORKDIR /app
COPY . .


COPY ./docker/nginx.conf /etc/nginx/nginx.conf

RUN pecl install redis && rm -rf /tmp/pear && docker-php-ext-enable redis

RUN docker-php-ext-install mysqli sockets

RUN apt-get install -y libssl-dev libssh-dev librabbitmq-dev \
    && pecl install amqp \
    && docker-php-ext-enable amqp


# Copia o script de inicialização
COPY ./docker/start.sh /usr/local/bin/start.sh

# Dá permissão de execução ao script
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 80
CMD ["/usr/local/bin/start.sh"]
# CMD ["sh", "-c", "service nginx start && php-fpm"]