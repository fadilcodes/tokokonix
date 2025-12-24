FROM richarvey/nginx-php-fpm:3.1.6

# Copy semua file kodingan ke dalam server
COPY . .

# Image ini butuh environment variable buat skip composer di awal biar kita bisa jalanin manual
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# --- BAGIAN PENTING YANG KURANG KEMARIN ---
# Kita suruh server install library (bikin folder vendor)
RUN composer install --no-dev --optimize-autoloader

# Kita suruh server build asset (bikin CSS/JS)
RUN npm install && npm run build
# ------------------------------------------

CMD ["/start.sh"]