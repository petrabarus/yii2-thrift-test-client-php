<?php

error_reporting(E_ALL);

include('vendor/autoload.php');

use Thrift\ClassLoader\ThriftClassLoader;

$GEN_DIR = realpath(dirname(__FILE__)).'/gen-php';
$loader = new ThriftClassLoader();
$loader->registerDefinition('petrabarus', $GEN_DIR);
$loader->register();

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;
use Thrift\Exception\TException;

$socket = new THttpClient('localhost', 80);
$transport = new TBufferedTransport($socket, 1024, 1024);
$protocol = new TBinaryProtocol($transport);

$client = new petrabarus\services\HelloServiceClient($protocol);

$transport->open();

echo $client->say_hello();

print_r($client->say_hello_repeat(4));

echo $client->say_foreign_hello(petrabarus\services\HelloLanguage::SPANISH);