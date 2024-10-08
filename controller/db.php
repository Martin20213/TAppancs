<?php
// Session indítása, ha még nem indult el
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Adatbázis csatlakozás
$host = 'localhost';
$dbname = 'tappancs';
$username = 'root';  // A te felhasználóneved
$password = '';      // A te jelszavad

try {
    // Létrehozzuk a PDO kapcsolatot
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Adatbázis kapcsolódási hiba: " . $e->getMessage());
}
?>
