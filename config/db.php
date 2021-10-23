<?php

return [
	'pdo' => [
		'options' => [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		],
		'dsn' => 'sqlite:db/db.sqlite',
		'username' => '',
		'password' => '',
	],
];