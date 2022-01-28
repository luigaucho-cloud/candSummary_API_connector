<?php
//use queries in queries.txt file to create database and tables required
//this are test values for local xampp and can be altered based on the database you are using
$host="localhost";//database host
$user="root";// database user
$password=""; //database password
$dbname="reports"; //database name
try{
$dsn="mysql:host=".$host."; dbname=".$dbname.";charset=utf8";
$pdo=new PDO($dsn,$user,$password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo 'There was an error encountered in our system, Please try again after sometime ';
}
 ?>
