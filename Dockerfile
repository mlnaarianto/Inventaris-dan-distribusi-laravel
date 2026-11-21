FROM php:8.4-fpm

# Dependensi sistem untuk PHP, Composer, GD, PDF, dan Excel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libfontconfig1 \
    libxrender1 \
    && rm -rf /var/lib/apt/lists/*

# Fix "dubious ownership" Git di dalam container
RUN git config --global --add safe.directory /var/www

# Ekstensi PHP (pdo, mbstring, xml sudah bawaan image PHP, jadi tidak perlu diinstall lagi)
RUN docker-php-ext-install \
    pdo_mysql \
    zip \
    bcmath \
    exif \
    pcntl

# GD (untuk manipulasi gambar di PDF/Excel)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Samakan UID/GID www-data dengan user host supaya tidak ada konflik ownership
ARG UID=1000
ARG GID=1000
RUN groupmod -g ${GID} www-data && \
    usermod -u ${UID} -g ${GID} www-data

WORKDIR /var/www

# Entrypoint untuk memperbaiki permission otomatis tiap container start
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh \
    && chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]