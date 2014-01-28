<?php

if (!extension_loaded('redis')) {
    die("redis extension not loaded\n");
};

$opt = getopt('h:p:s:n:m:');

$host = isset($opt['h']) ? $opt['h'] : '127.0.0.1';
$port = isset($opt['p']) ? $opt['p'] : 6379;
$socket = isset($opt['s']) ? $opt['s'] : null;
$dbnum = isset($opt['n']) ? $opt['n'] : 0;
$mode = (isset($opt['m']) && in_array($opt['m'], array('flush', 'replace', 'insert'))) ? $opt['m'] : 'replace';

$redis = new Redis();

try {
    $socket && $redis->connect($socket) || $redis->connect($host, $port);
    $redis->select($dbnum);
} catch (Exception $e) {
    die("cannot connect to redis\n");
};

$input = fopen('php://stdin', 'r');

if ($mode == 'flush') {
    $redis->flushDB();
}    

while($line = stream_get_line($input, 65535, "\n")) {
    sscanf($line, "%s %d %s\n", $key, $ttl, $value);
    if ($mode == 'replace') {
        $redis->del($key);
    }    
    $redis->restore($key, $ttl, pack("H*" , $value));
};

$redis->close();
