<?php 
require_once(__DIR__ . '/../classes/database.php');


$database = new Database();

$conn = $database->connect();

// if($conn->connect_error){

//     die("no connection".$conn->connect_error);
// }
// echo "Connected successfully";