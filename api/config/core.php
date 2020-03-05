<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// home page url
$homeUrl = 'http://localhost/api/';

$page = $_GET['page'] ?? 1;

$recordsPerPage = 5;

// calculate for the query LIMIT clause
$fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;