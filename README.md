# php-redis-dump

redis dump/restore tool

## Usage:

### Dump

Options:
+ -h host name (127.0.0.1)
+ -p port (6379)
+ -n DB number (0)
+ -s path to socket (null)

Example

```
php redis-dump.php -s /tmp/redis.sock -n 2 > dump.r
```

Example with gzip

```
php redis-dump.php | gzip --stdout > dump.gz
```

### Restore

Options:
+ -h host name (127.0.0.1)
+ -p port (6379)
+ -n DB number (0)
+ -s path to socket (null)
+ -m restore mode (replace)

Restore modes:
+ flush - DB is flushed, all keys from dump are inserted (fastest)
+ replace - Keys from dump will replace existing ones, new keys will be inserted as well (default)
+ insert - Only new keys from dump will be inserted, existing keys wouldn't be updated.

Example:

```
php redis-restore.php -h remote-redis.org -p 6379 -n 2 < dump.r
```

Example with gzip

```
gunzip -c dump.gz | php redis-restore.php
```