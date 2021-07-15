<?php

use Framework\Http\Request;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$request = new Request();
$post = $request->getParsedBody();

print_r($post);