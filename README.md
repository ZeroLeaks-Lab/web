# ZeroLeaks Web

Requires PHP 8.3 or later.

## Setup

Install dependencies:

```
$ composer install
```

Copy `src/Config.example.php` to `src/Config.php` and edit as needed.

## Database

Download the IPv4 and IPv6 GeoLite2 country databases from [https://github.com/sapics/ip-location-db](https://github.com/sapics/ip-location-db), then run the `update_ip_db.py` script to generate the corresponding SQL files:

```
$ python3 update_ip_db.py geolite2-country-ipv4.csv ipv4.sql
$ python3 update_ip_db.py geolite2-country-ipv6.csv ipv6.sql
```

These SQL files now need to be imported to the database. For example with [MariaDB](https://mariadb.org):

```
$ mariadb -u <USERNAME> -p -D <DATABASE NAME> < ipv4.sql
$ mariadb -u <USERNAME> -p -D <DATABASE NAME> < ipv6.sql
```

## Web server configuration

The root needs to be set to the `public` directory. Here is a sample nginx configuration file:

```nginx
server {
    listen 80;
    root   /var/www/html/public;
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
