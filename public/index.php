<?php

use Framework\Http\Request;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$request = new Request();
$get = $request->getQueryParams();

print_r($get);