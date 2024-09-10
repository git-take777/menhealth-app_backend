FROM php:8.3-fpm

# ポートの公開
EXPOSE 9000
# 必要なパッケージのインストール
RUN apt-get update && apt-get install -y \
    vim-tiny \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# PHP拡張のインストール
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composerのインストール→versionを固定したほうがいい。。理由: build時常に最新版になり使えないパッケージが存在した際に不具合が生じる可能性が高いため
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# アプリケーションディレクトリの設定
WORKDIR /var/www/entry-point

# エントリーポイントスクリプトのコピー
COPY docker/php/entrypoint.sh ./entrypoint.sh
RUN chmod +x ./entrypoint.sh
# CMD ["entrypoint"]

ENTRYPOINT ["/var/www/entry-point/entrypoint.sh"]
CMD ["php-fpm"]
