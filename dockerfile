# Usar a imagem oficial do PHP 8.3 com Apache
FROM php:8.3-apache

# Instalar extensões necessárias e utilitários
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    default-mysql-client \
    curl \
    gnupg \
    && docker-php-ext-install pdo pdo_mysql zip

# Habilitar o módulo rewrite do Apache
RUN a2enmod rewrite

# Instalar Node.js e npm
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar o Apache e copiar o código do aplicativo
COPY . /var/www/html/
WORKDIR /var/www/html

# Instalar dependências do Laravel
#RUN composer install --no-dev --optimize-autoloader

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html

# Configurar o diretório público
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Expor a porta 80 (não necessário na prática, mas é uma boa prática documentar)
EXPOSE 80
