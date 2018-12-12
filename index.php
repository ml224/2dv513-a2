<?php

require_once('./src/controller/dbSeeder.php');
require_once('./src/model/db.php');


$db = new Reddit_database();
$seeder = new Database_Seeder($db);
$file_path = getenv('BZ2_2007');
$seeder->seed_db($file_path);

