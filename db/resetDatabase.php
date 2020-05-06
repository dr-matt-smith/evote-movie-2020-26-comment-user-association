<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Tudublin\DotEnvLoader;

// load DB constants from DOTENV
$dotEnvLoader = new DotEnvLoader();
$dotEnvLoader->loadDBConstantsFromDotenv();

require_once __DIR__ . '/userMigrationAndFixtures.php';
require_once __DIR__ . '/movieMigrationAndFixtures.php';
require_once __DIR__ . '/commentMigrationAndFixtures.php';