sudo docker run --rm -it -p 8000:8000 \
  -v "$PWD:/app" -w /app \
  php:7.2-cli php artisan serve --host=0.0.0.0