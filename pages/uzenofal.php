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

<?php
include 'nav/menu.php'; // Menü beillesztése

// Session indítása, ha még nem indult el
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Adatbázis kapcsolat létrehozása
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

// Új üzenet beszúrása, ha elküldték a formot
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $felhasznalo_id = isset($_SESSION['felhasznalo_id']) ? $_SESSION['felhasznalo_id'] : '1'; // Példa felhasználó azonosító (ha nincs bejelentkezve)
    $uzenet = htmlspecialchars($_POST['message']);

    // Üzenet beszúrása az 'uzenofal' táblába
    $stmt = $pdo->prepare("INSERT INTO uzenofal (Felhasznalo_id, Uzenet, Ido) VALUES (:felhasznalo_id, :uzenet, NOW())");
$stmt->execute([
    ':felhasznalo_id' => $felhasznalo_id, // Asszociatív tömb a paraméterekhez
    ':uzenet' => $uzenet
]);


    // Frissítjük az oldalt, hogy az új üzenet megjelenjen
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Üzenetek lekérdezése az adatbázisból
$sql = "SELECT f.Vezeteknev, f.Keresztnev, u.Uzenet, u.Ido 
        FROM uzenofal u 
        INNER JOIN felhasznalok f ON u.Felhasznalo_id = f.Felhasznalo_id 
        ORDER BY u.Ido DESC";$stmt = $pdo->prepare($sql);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="data">
    <div class="data-container">
        <h1>Üzenőfal</h1>

        <!-- Üzenetek megjelenítése -->
        <?php if (count($messages) > 0): ?>
            <?php foreach ($messages as $message): ?>
                <div class="message">
                    <p id="name"><strong><?php echo htmlspecialchars($message['Vezeteknev']) . ' ' . htmlspecialchars($message['Keresztnev']); ?></strong></p>
                    <?php
                    // Az Ido mező átkonvertálása olvashatóbb formátumra
                    $datetime = new DateTime($message['Ido']);
                    $formattedDate = $datetime->format('Y.m.d H:i'); // Formátum módosítása
                    ?>
                    
                    <p id="datum"><?php echo htmlspecialchars($formattedDate); ?></p>
                    <div class="uzenet">
                    <p><?php echo nl2br(htmlspecialchars($message['Uzenet'])); ?></p>
                </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nincs még üzenet.</p>
        <?php endif; ?>

        <!-- Üzenet beküldő form -->
        <form method="POST" action="">
            <input type="text" name="message" placeholder="Írd ide az üzeneted..." required>
            <input type="submit" value="Küldés">
        </form>
    </div>
</div>


<script type="text/javascript" src="../js/menu.js"></script>
</body>
</html>
