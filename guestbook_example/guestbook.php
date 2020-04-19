<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'Predis/Autoloader.php';

Predis\Autoloader::register();

if (isset($_GET['cmd']) === true) {
  $host = getenv('REDIS_HOST');
  $port = getenv('REDIS_PORT');
  $password = getenv('REDIS_PASSWORD');
  $client = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => $host,
    'port'   => $port,
  ]);
  header('Content-Type: application/json');
  if ($_GET['cmd'] == 'set') {
    $client->set($_GET['key'], $_GET['value']);
    print('{"message": "Updated"}');
  } else {
    $value = $client->get($_GET['key']);
    print('{"data": "' . $value . '"}');
  }
} else {
  phpinfo();
} ?>