# Pake PHP 8.3 biar support Laravel 12 & Plugin lu
FROM php:8.3-apache

# Install library yang dibutuhin Laravel (Zip, Git, dll)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev

# Bersihin cache biar ringan
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Ekstensi PHP Wajib
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Aktifin mod_rewrite buat URL cantik Laravel
RUN a2enmod rewrite

# Ganti settingan Apache biar root folder-nya ke /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf \ /etc/apache2/conf-available/*.conf

# Set folder kerja
WORKDIR /var/www/html

# Copy file composer dulu (biar cache jalan)
COPY composer.json composer.lock ./

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies (tanpa dev dependencies biar ringan di server)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy sisa file project lu
COPY . .

# Set permission folder storage biar bisa write log/gambar
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 (standar web)
EXPOSE 80

# Script buat jalanin pas container start
# (Migrate database otomatis + jalanin Apache)
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    apache2-foreground