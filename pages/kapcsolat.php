<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="../img/paw.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAppancs</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include 'nav/menu.php'; 


$host = 'localhost';
$dbname = 'tappancs';
$username = 'root';
$password = '';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Adatbázis kapcsolódási hiba: " . $e->getMessage());
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
   
    $uzenet = htmlspecialchars($_POST['message']);
    $telefonszam = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);

    // Üzenet beszúrása az 'uzenofal' táblába
    $stmt = $pdo->prepare("INSERT INTO kapcsolat (Email, Telefonszam, Uzenet, Ido) VALUES (:email, :telefonszam, :uzenet, NOW())");
$stmt->execute([
    ':email' => $email,
    ':telefonszam' => $telefonszam, // Asszociatív tömb a paraméterekhez
    ':uzenet' => $uzenet
]);


    // Frissítjük az oldalt, hogy az új üzenet megjelenjen
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?> <!-- Menü beillesztése -->

<div class="data">

<div class="data-container">
<h1>Kapcsolat</h1>

<form method="POST" action="">
        <label for="email">E-mail cím (kötelező)</label>
        <input type="email" name="email" id="email" required placeholder="E-mail címed">

        <label for="phone">Telefonszám (nem kötelező)</label>
        <input type="text" name="phone" id="phone" placeholder="Telefonszámod (opcionális)">

        <label for="message">Üzenet (kötelező)</label>
        <textarea name="message" id="message" required placeholder="Az üzeneted..." rows="5"></textarea>

        <input type="submit" value="Küldés">
    </form>

</div>
</div>

<script type="text/javascript" src="../js/menu.js"></script>
</body>
</html>
