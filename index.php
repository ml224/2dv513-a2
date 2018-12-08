<?php

require_once('./src/dbSeeder.php');
require_once('./src/db.php');

$db = new Reddit_database();
$seeder = new Populate_db($db);

$seeder->seed_db();

