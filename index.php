<?php

require_once('./src/controller/dbSeeder.php');
require_once('./src/model/dbConnection.php');


$db = new DatabaseConnection();
$seeder = new DatabaseSeeder($db);
$file_path = getenv('BZ2_2007');
$seeder->seed_db($file_path);

