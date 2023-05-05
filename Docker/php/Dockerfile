# PHPの公式イメージを指定
FROM php:7.2-apache

# sedコマンドでApacheのルートを変更 cakeに必要
ENV APACHE_DOCUMENT_ROOT /var/www/html/app/webroot
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
&& sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
&& a2enmod rewrite

# linuxの拡張モジュールをインストール
RUN apt-get update && apt-get install -y \
    libicu-dev \
    zip \
    unzip \
&& docker-php-ext-install -j$(nproc) intl \
&& docker-php-ext-install -j$(nproc) pdo_mysql

# linuxタイムゾーンを設定
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

# カレンとディレクトリのファイルをユーザー側のhtmlにコピー
# これによりGitcloneしてきたファイルをローカルにも落とせる
COPY . /var/www/html

# composer1.7のイメージからバイナリファイルをコピー
# composer1では色々更新しろと言われるがコンテなので無視でいいか。
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer:1.7 /usr/bin/composer /usr/bin/composer


# composer installを実行
RUN cd ./app && \
    composer install --no-dev -o


