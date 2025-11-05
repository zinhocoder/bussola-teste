FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    default-mysql-client

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar diretório de trabalho
WORKDIR /var/www/html

# Copiar código do projeto antes de instalar dependências (exceto itens ignorados em .dockerignore)
COPY . .

# Garantir diretórios necessários antes da instalação das dependências
RUN mkdir -p bootstrap/cache \
    storage/logs \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    && chmod -R 775 bootstrap/cache storage

# Instalar dependências PHP (incluindo dev para ambiente local)
RUN composer install --optimize-autoloader --prefer-dist --no-interaction

# Preparar ambiente para o Composer e Artisan
RUN mkdir -p bootstrap/cache \
    && chmod -R 775 bootstrap/cache \
    && git config --global --add safe.directory /var/www/html

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expor porta
EXPOSE 8000

# Comando para iniciar o servidor
CMD php artisan serve --host=0.0.0.0 --port=8000

