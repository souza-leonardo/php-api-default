<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// home page url
$homeUrl = 'http://localhost/api/';

$page = $_GET['page'] ?? 1;

$recordsPerPage = 5;

// calculate for the query LIMIT clause
$fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;

date_default_timezone_set('America/Bahia');
$key = "example_key";
$iss = "http://example.org";
$aud = "http://example.org";
$iat = 1356999524;
$nbf = 1357000000;