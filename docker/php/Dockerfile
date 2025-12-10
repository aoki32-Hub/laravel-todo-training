# 新人研修向けLaravel開発環境
# PHP 8.2 with Laravel
FROM php:8.2-fpm

# 作業ディレクトリ設定
WORKDIR /var/www/html

# システムパッケージの更新とインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# PHP拡張機能のインストール
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# PHPの設定ファイルをコピー
COPY php.ini /usr/local/etc/php/conf.d/laravel.ini

# ユーザーの作成（開発環境用）
RUN useradd -m -u 1000 laravel && \
    chown -R laravel:laravel /var/www/html

# ユーザーを切り替え
USER laravel

# ポート9000を公開（PHP-FPM用）
EXPOSE 9000

CMD ["php-fpm"]
