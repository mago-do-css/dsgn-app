# Usando a imagem oficial do PHP 8.2 com Apache
FROM php:8.2-apache

# Instala pacotes adicionais necessários
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring mysqli pdo pdo_mysql xml

# Habilita módulos do Apache necessários
RUN a2enmod rewrite

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o DocumentRoot para a pasta public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Ajustar o arquivo de configuração padrão do Apache para usar a pasta public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Copia o código da aplicação para o diretório padrão do Apache
COPY . /var/www/html

# Ajusta as permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expondo a porta padrão do Apache
EXPOSE 80

# Inicia o Apache
CMD ["apache2-foreground"]
