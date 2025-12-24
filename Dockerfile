FROM richarvey/nginx-php-fpm:3.1.6

# Copy kodingan
COPY . .

# Settingan Wajib
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# --- PERBAIKAN DISINI ---
# Kita tambahin '--no-scripts' biar dia gak rewel nyari .env pas lagi build
# Kita tambahin '--no-progress' biar log-nya gak penuh sampah
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-progress
# ------------------------

# Paksa update permission folder storage biar bisa upload gambar
RUN chmod -R 777 storage bootstrap/cache

CMD ["/start.sh"]