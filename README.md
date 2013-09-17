php-redis-dump
==============

redis dump tool

Usage: 
------

```
php redis-dump.php -s /tmp/redis.sock -n 2 > dump.r
cat dump.r | redis-cli -h remote-redis.org -p 6379 -n 2 -x
```
