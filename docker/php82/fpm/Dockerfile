FROM php:8.2-fpm-bullseye
LABEL version="1.0"
LABEL maintainer="Denys"

RUN apt-get update && apt-get install -y \
    git \
    curl \
	libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libmemcached-dev

RUN docker-php-ext-install bcmath mbstring pdo pdo_mysql soap zip gd exif pcntl opcache

RUN pecl install igbinary apcu \
    && docker-php-ext-enable igbinary apcu

ENV MEMCACHED_VERSION="3.2.0"
RUN pecl download memcached-$MEMCACHED_VERSION \
    && tar xzvf memcached-$MEMCACHED_VERSION.tgz \
    && cd memcached-$MEMCACHED_VERSION \
    && phpize \
    && ./configure --enable-memcached-igbinary --disable-memcached-sasl \
    && make \
    && make install \
    && docker-php-ext-enable memcached


RUN pecl install redis && docker-php-ext-enable redis

###########################################################################
# Set Timezone
###########################################################################

ARG TZ=UTC
ENV TZ ${TZ}`

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone


COPY docker/php82/php82.ini $PHP_INI_DIR/conf.d
COPY docker/php82/xdebug.ini $PHP_INI_DIR/conf.d
COPY docker/php82/fpm/xlaravel.pool.conf /usr/local/etc/php-fpm.d/

###########################################################################
# xDebug:
###########################################################################

USER root

ARG INSTALL_XDEBUG=true
RUN if [ ${INSTALL_XDEBUG} = true ]; then  \
      pecl install xdebug && docker-php-ext-enable xdebug \
    ;else echo "Skip xDebug"; \
    fi


#--------------------------------------------------------------------------
# Node Js
#--------------------------------------------------------------------------
RUN groupadd --gid 1001 node \
  && useradd --uid 1001 --gid node --shell /bin/bash --create-home node

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    gpg \
    dirmngr \
    gpg-agent


ENV NODE_VERSION 20.8.0

RUN ARCH= && dpkgArch="$(dpkg --print-architecture)" \
  && case "${dpkgArch##*-}" in \
    amd64) ARCH='x64';; \
    ppc64el) ARCH='ppc64le';; \
    s390x) ARCH='s390x';; \
    arm64) ARCH='arm64';; \
    armhf) ARCH='armv7l';; \
    i386) ARCH='x86';; \
    *) echo "unsupported architecture"; exit 1 ;; \
  esac \
  # gpg keys listed at https://github.com/nodejs/node#release-keys
  && set -ex \
  && for key in \
    4ED778F539E3634C779C87C6D7062848A1AB005C \
    141F07595B7B3FFE74309A937405533BE57C7D57 \
    74F12602B6F1C4E913FAA37AD3A89613643B6201 \
    DD792F5973C6DE52C432CBDAC77ABFA00DDBF2B7 \
    61FC681DFB92A079F1685E77973F295594EC4689 \
    8FCCA13FEF1D0C2E91008E09770F7A9A5AE15600 \
    C4F0DFFF4E8C1A8236409D08E73BC641CC11F4C8 \
    890C08DB8579162FEE0DF9DB8BEAB4DFCF555EF4 \
    C82FA3AE1CBEDC6BE46B9360C43CEC45C17AB93C \
    108F52B48DB57BB0CC439B2997B01419BD92F80A \
    A363A499291CBBC940DD62E41F10027AF002F8B0 \
  ; do \
      gpg --batch --keyserver hkps://keys.openpgp.org --recv-keys "$key" || \
      gpg --batch --keyserver keyserver.ubuntu.com --recv-keys "$key" ; \
  done \
  && curl -fsSLO --compressed "https://nodejs.org/dist/v$NODE_VERSION/node-v$NODE_VERSION-linux-$ARCH.tar.xz" \
  && curl -fsSLO --compressed "https://nodejs.org/dist/v$NODE_VERSION/SHASUMS256.txt.asc" \
  && gpg --batch --decrypt --output SHASUMS256.txt SHASUMS256.txt.asc \
  && grep " node-v$NODE_VERSION-linux-$ARCH.tar.xz\$" SHASUMS256.txt | sha256sum -c - \
  && tar -xJf "node-v$NODE_VERSION-linux-$ARCH.tar.xz" -C /usr/local --strip-components=1 --no-same-owner \
  && rm "node-v$NODE_VERSION-linux-$ARCH.tar.xz" SHASUMS256.txt.asc SHASUMS256.txt \
  && ln -s /usr/local/bin/node /usr/local/bin/nodejs \
  # smoke tests
  && node --version \
  && npm --version



#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------

USER root

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

WORKDIR /var/www/laravel-weather-app

# Configure non-root user.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}
#
RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data
