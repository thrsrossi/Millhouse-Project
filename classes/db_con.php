<?php 

session_start();


try
{
     $pdo = new PDO("mysql:host=localhost;dbname=millhouse;charset=utf8","root","root");
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $error)
{
     echo $error->getMessage();
}