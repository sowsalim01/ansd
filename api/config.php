<?php
$host = 'localhost';
$dbname = 'ansd';
$dbuser = 'postgres';
$dbpass = 'Mamadou281201';
$port=5432;

try{
    $conn = new PDO("pgsql:dbname=$dbname;host=$host;port=$port", $dbuser, $dbpass);
    //echo "Connexion à la base réussie"."</br>";
}
catch (PDOException $e) { echo "Erreur : " . $e->getMessage();}
?>