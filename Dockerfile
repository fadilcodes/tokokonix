FROM richarvey/nginx-php-fpm:3.1.6

# Copy semua file (termasuk folder vendor yang bakal kita upload)
COPY . .

# Settingan Wajib
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# --- KUNCI SUKSES ---
# Kita bilang: "Udah gausah install composer lagi, gw udah bawa!"
ENV SKIP_COMPOSER 1
# --------------------

CMD ["/start.sh"]