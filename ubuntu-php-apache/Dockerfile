FROM ubuntu:18.04

#general upadte
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update
RUN apt-get -y upgrade
RUN apt-get install -y software-properties-common
RUN apt-get install -y curl

#avoid prompt for tzdata
ENV TZ=America/Los_Angeles
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

#install Apache
RUN apt-get install -y apache2

#enable ssl and other Apache bits
RUN a2enmod ssl
RUN a2enmod headers
RUN a2ensite default-ssl
RUN a2enmod rewrite

#install PHP
RUN add-apt-repository ppa:ondrej/php
RUN apt-get install -y php7.3 php7.3-cli php7.3-common php7.3-json php7.3-opcache php7.3-mysql php7.3-mbstring php7.3-zip php7.3-fpm php7.3-intl php7.3-simplexml php7.3-gd php7.3-curl
RUN apt-get install -y libapache2-mod-php7.3

# ** If you are testing provisioning/destroying your environment over and over, you can get copies of these files from an Ubuntu Apache install and add below **
#these cert files are here only as a convenince to not have to accept new self-signed cert in browser each time if doing multiple destroy/rebuilds of the env
#if left out, the auto generated files of same names and locations will be there but will have different cert values and have to be accepted again
#(these will eventually expire and need to be replaced by a freshly generated set in the git repo to continue to be used in this way)
#COPY ssl-cert-snakeoil.pem /etc/ssl/certs/
#COPY ssl-cert-snakeoil.key /etc/ssl/private/

#Modify docroot value
RUN sed -ri 's!/var/www/html!/var/www/docroot!g' /etc/apache2/sites-available/default-ssl.conf

#Modify apache conf to allow redirects
RUN sed -ri 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

#open ports and run apache
EXPOSE 443
CMD apachectl -D FOREGROUND