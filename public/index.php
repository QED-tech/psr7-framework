<?php

use Framework\Http\Request;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$request = (new Request())
	->withParsedBody($_POST)
	->withQueryParams($_GET);

$get = $request->getQueryParams();

print_r($get);