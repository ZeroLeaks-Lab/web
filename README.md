# ZeroLeaks Web

Requires PHP 8.2 or later.

## Installation guide

For simplicity, it's assumed that the app will be installed at `/srv/zeroleaks-web`, but of course you can choose any path you like.

### Install system dependencies

For Debian-based distros:

```
sudo apt install composer python3
```

### Install zeroleaks-web

Clone this repo:

```
$ git clone --depth=1 https://github.com/ZeroLeaks-Lab/web.git /srv/zeroleaks-web
$ cd /srv/zeroleaks-web
```

Install app dependencies:

```
$ composer install
```

### Database setup

ZeroLeaks needs a dedicated SQL database, and preferably a dedicated user too.

For example, to create user named `zeroleaks` with password `password` having access to a database named `zeroleaks`, with [MariaDB](https://mariadb.org):

```
$ sudo mariadb <<EOF
create user 'zeroleaks'@'localhost' identified by 'password';
create database zeroleaks;
grant all privileges on zeroleaks.* to 'zeroleaks'@'localhost';
EOF
```

Once the database is setup, download the IPv4 and IPv6 GeoLite2 country databases from [https://github.com/sapics/ip-location-db](https://github.com/sapics/ip-location-db), then run the `update_ip_db.py` script to generate the corresponding SQL files:

```
$ python3 update_ip_db.py geolite2-country-ipv4.csv ipv4.sql
$ python3 update_ip_db.py geolite2-country-ipv6.csv ipv6.sql
```

These SQL files now need to be imported into the database. For example:

```
$ mariadb -u zeroleaks -p -D zeroleaks < ipv4.sql
$ mariadb -u zeroleaks -p -D zeroleaks < ipv6.sql
```

### Configure web server

Your web server must support PHP, and the root must be set to the `public` directory of this repository. Additionally, all requests must be redirected to the `public/index.php` file. Here is a sample nginx configuration file:

```nginx
server {
    listen 80;
    root   /srv/zeroleaks-web/public;
    index  index.php;

    location / {
        try_files $uri $uri/ /index.php;
    }

    location ~ \.php$ {
        include        fastcgi.conf;
        fastcgi_pass   unix:/run/php-fpm/php-fpm.sock;
        fastcgi_index  index.php;
        include        fastcgi_params;
    }
}
```

For apache servers, the provided `.htaccess` file already redirects the requests properly.

### App configuration

The configuration template is at `src/Config.example.php`. Just rename this file to `src/Config.php` and edit as needed.

The `HELPER_SERVER_URL` field must point to a running instance of the [ZeroLeaks helper](https://github.com/ZeroLeaks-Lab/helper).
