<?php


use Framework\Http\RequestFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$request = RequestFactory::fromGlobals();

$get = $request->getQueryParams();

$name = $get['name'] ?? 'Guest';

echo "Hello, $name";