FROM mysql:8.0
LABEL version="1.0"
LABEL maintainer="Denys"

ARG TZ=UTC
ENV TZ ${TZ}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime  \
 && echo $TZ > /etc/timezone && chown -R mysql:root /var/lib/mysql/

COPY docker/mysql/conf.d/mysql.cnf /etc/mysql/conf.d/mysql.cnf
RUN chmod 0444 /etc/mysql/conf.d/mysql.cnf

CMD ["mysqld"]

EXPOSE 3306
