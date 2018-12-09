<?php

require_once('./src/controller/dbSeeder.php');
require_once('./src/model/db.php');

$db = new Reddit_database();
$seeder = new Database_Seeder($db);

$seeder->seed_db();

