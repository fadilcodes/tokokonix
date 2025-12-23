# Pake base image yang udah lengkap sama Nginx & PHP
FROM richarvey/nginx-php-fpm:3.1.6

# Copy semua kodingan lu ke server
COPY . .

# Settingan server biar Laravel jalan lancar
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Biarin composer jalan sebagai root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Perintah start (otomatis jalanin migrasi & serve)
CMD ["/start.sh"]