FROM php:8.3-apache

# Установка необходимых расширений PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Включение mod_rewrite и mod_alias для Apache
RUN a2enmod rewrite
RUN a2enmod alias

# Копирование конфигурации Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Установка рабочей директории
WORKDIR /var/www/html

# Установка прав доступа
RUN chown -R www-data:www-data /var/www/html

# Открытие порта
EXPOSE 80
