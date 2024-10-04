<?php
// Session indítása, ha még nem indult el
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Csatlakozás az adatbázishoz
$host = 'localhost';
$dbname = 'tappancs';
$username = 'root';  // vagy a te felhasználóneved
$password = '';      // vagy a te jelszavad

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Adatbázis kapcsolódási hiba: " . $e->getMessage());
}



?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinamikus Menü</title>
    <link rel="stylesheet" href="../css/menu.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="off-screen-menu" onclick="toggleMenu2()">
    <ul>
        <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
            <!-- Bejelentkezett felhasználóknak szóló menüpontok -->
            <li><a class="menugomb" href="home">Home</a></li>
            <li><a class="menugomb" href="uzenofal">Üzenőfal</a></li>
            <li><a class="menugomb" href="kapcsolat">Kapcsolat</a></li>
        <?php else: ?>
            <!-- Vendégeknek szóló menüpontok -->
            <li><a class="menugomb" href="home">Home</a></li>
            <li><a class="menugomb" href="kapcsolat">Kapcsolat</a></li>
        <?php endif; ?>
    </ul>
</div>

<nav>
    <div class="centered-image-container">
        <a href="../pages/home"><img src="../img/TAppancs_logo.png" alt="Logo"></a>
    </div>

    <div>
        <?php 
// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
    // Lekérdezzük a felhasználó adatait az adatbázisból
    $stmt = $pdo->prepare("SELECT * FROM felhasznalok WHERE Felhasznalonev = :Felhasznalonev");
    $stmt->bindParam(':Felhasznalonev', $_SESSION['username']);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC); // Felhasználói adatok lekérése
  

?>

<div>
<?php
if ($userData) {
    echo "" . htmlspecialchars($userData['Vezeteknev']) . " " . htmlspecialchars($userData['Keresztnev'])
. " ( " . htmlspecialchars($userData['Felhasznalonev']) . " )";

}
    ?>
    <a id="myLink" href="profile"><i class="fas fa-user" id="login"></i> Profil</a>
    <a id="logoutLink" href="logout"><i class="fas fa-sign-out-alt"></i> Kijelentkezés</a>
</div>

<?php 
} else { 
?>

<div>
    <a id="myLink" href="login"><i class="fas fa-user" id="login"></i> Bejelentkezés</a>
</div>

<?php 
} 
?>

    </div>

    <div class="ham-menu" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </div>
</nav>

<script>
function toggleMenu() {
    var link = document.getElementById('myLink');
    
    // Ha a link látszik, akkor gombnyomásra tűnjön el
    if (link.style.display === 'inline' || link.style.display === '') {
        link.style.display = 'none'; // Elrejtés
    } else {
        setTimeout(function() {
            link.style.display = 'inline';
        }, 200); // Megjelenítés 200ms után
    }
}
</script>

</body>
</html>
