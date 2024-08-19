# Prueba técnica Ulices Ochoa

# How To Deploy

### For first time only !
- `git clone https://github.com/ulisesOchoa/test-back.git`
- `cd test-back`
- `docker compose up -d --build`
- `docker compose exec php bash`
- `chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache`
- `chmod -R 775 /var/www/storage /var/www/bootstrap/cache`
- `composer setup`
- `php artisan db:seed`
