# All-in-One Leak Test

Install dependencies:

```
$ composer install
```

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

To configure your installation, copy `src/Config.example.php` to `src/Config.php` and edit as needed.

To run a development PHP server:

```
$ php -S localhost:8000 -t public
```
