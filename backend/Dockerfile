FROM php:7.4-cli

COPY . /var/www/html

# Встановлюємо веб-сервер PHP
# Встановлюємо необхідні пакети та залежності
RUN apt-get update && \
    apt-get install -y zlib1g-dev libzip-dev && \
    rm -rf /var/lib/apt/lists/*

# Встановлюємо PHP розширення для libzip
RUN docker-php-ext-install zip

# Встановлюємо скрипт запуску сервера
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Вказуємо робочий каталог
WORKDIR /var/www/html

# Виконуємо команду запуску сервера
CMD ["/usr/local/bin/docker-entrypoint.sh"]
