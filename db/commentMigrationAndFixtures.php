<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Tudublin\CommentRepository;

$commentRespository = new CommentRepository();

// (1) drop then create table
$commentRespository->dropTable();
$commentRespository->createTable();

// (2) delete any existing objects
$commentRespository->deleteAll();

