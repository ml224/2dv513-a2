<?php

require_once("configDotEnv.php");

$pw = getenv('DB_PW');
$user = getenv('DB_USER');
$host = getenv('DB_HOST');
$db = getenv('DB');

$mysqli = mysqli_connect($host, $user, $pw, $db);
if(mysqli_connect_errno())
{
    echo "failed to connect to MySQL:" . mysqli_connect_error();
}
else
{
    echo "connected to MySQL!";
}

$file = getenv('FILE_PATH');
$handle = bzopen($file, "r");

if ($handle) {
    $count = 1;
    while (($buffer = fgets($handle, 4096)) !== false && $count < 2) {
        $json = json_decode($buffer, true);
        
        $author = array_search('author', $json);
        echo $author;
    

        $count ++;
    }
    fclose($handle);
}