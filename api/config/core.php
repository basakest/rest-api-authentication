<?php
error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');

// variables for json web token
$key = "the test key";
$iss = 'http://rest-api-auth.localhost/';
$aud = 'http://rest-api-auth.localhost/';
$iat = 1356999524;
$nbf = 1357000000;