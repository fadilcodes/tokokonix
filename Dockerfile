FROM richarvey/nginx-php-fpm:3.1.6

# Copy kodingan
COPY . .

# Settingan Wajib
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# --- BAGIAN PENTING ---
# Install Library PHP (Biar folder vendor muncul)
RUN composer install --no-dev --optimize-autoloader

# CATATAN: Kita HAPUS perintah 'npm install' biar deploy gak gagal.
# ----------------------

CMD ["/start.sh"]