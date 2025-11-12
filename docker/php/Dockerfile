# 最新のPHP 8.3 FPMバージョンを使用 (M1でも公式イメージはarm64対応)
FROM php:8.3-fpm

# 必要なシステムパッケージとPHP拡張をインストール
RUN apt update && apt install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libmcrypt-dev \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# NodeSourceリポジトリを追加し、Node.js LTSバージョンをインストール
RUN apt install -y curl \
    && curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Laravel開発に一般的に必要なPHP拡張をインストール
# pdo_mysql, zip, gd, mbstring, exif, pcntl, bcmath, intl
RUN docker-php-ext-install pdo_mysql zip opcache gd mbstring exif pcntl bcmath intl

# PHP設定ファイルをコピー
COPY php.ini /usr/local/etc/php/

# ComposerのインストールとグローバルPATHへの移動
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer self-update

# プロンプト設定をカスタマイズするため、ユーザーのホームディレクトリにPS1設定を追記します。
# PHP-FPMベースイメージは通常、rootとwww-dataユーザーを使用するため、両方に対応します。
# USER=appuser 環境変数を強制的に反映させることを目的とします。
RUN echo 'export PS1="${USER}@\h:\w\$ "' >> /root/.bashrc \
    && echo 'export PS1="${USER}@\h:\w\$ "' >> /var/www/.bashrc \
    && echo 'export PS1="${USER}@\h:\w\$ "' >> /etc/bash.bashrc

# アプリケーションの作業ディレクトリを設定
WORKDIR /var/www

# 本番環境を見据えたセキュリティ対策として、root以外のユーザーを作成・使用することを推奨します。
# 例: RUN useradd -G www-data -d /var/www appuser && chown -R appuser:www-data /var/www
# ただし、現在の雛形は開発環境用としてuser:rootで動く前提で進めます。