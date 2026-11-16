<?php
$host     = "localhost";
$port     = 3306;
$baza     = "skola";
$korisnik = "root";
$lozinka  = "";

$dsn = "mysql:host=$host;port=$port;dbname=$baza;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $korisnik, $lozinka, [
        PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_EMULATE_PREPARES => false,                 
    ]);
} catch (PDOException $e) {
    exit("Greška pri spajanju na bazu. Provjeri radi li MySQL i postoji li baza 'skola'.");
}
