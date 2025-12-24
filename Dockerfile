FROM richarvey/nginx-php-fpm:3.1.6

# Copy semua file
COPY . .

# Settingan Wajib
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# --- PERUBAHAN DISINI ---
# 1. Kita set SKIP_COMPOSER jadi 0 (false). 
# Artinya: "Eh server, tolong installin composer pas lu nyala ya"
ENV SKIP_COMPOSER 0

# 2. Kita kasih akses memori tak terbatas buat composer biar gak crash
ENV COMPOSER_MEMORY_LIMIT -1

# 3. KITA HAPUS baris 'RUN composer install...'
# Biar proses Build-nya cepet dan gak error di awal.
# ------------------------

CMD ["/start.sh"]