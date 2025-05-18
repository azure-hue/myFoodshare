# Step 1: Use official PHP image with required extensions
FROM php:8.2-cli

# Step 2: Install system dependencies + PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libpng-dev libonig-dev libxml2-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql zip

# Step 3: Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Step 4: Set working directory inside container
WORKDIR /var/www

# Step 5: Copy PHP and Vue files
COPY . .

# Step 6: Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Step 7: Install Node dependencies and build assets
RUN npm install && npm run prod

# Step 8: Expose port 8000 for Laravel server
EXPOSE 8000

# Step 9: Run Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
