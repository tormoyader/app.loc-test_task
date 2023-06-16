FROM php:7.4-cli

COPY . /var/www/html

RUN apt-get update && \
    apt-get install -y zlib1g-dev libzip-dev && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install zip

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

WORKDIR /var/www/html

CMD ["/usr/local/bin/docker-entrypoint.sh"]
