<?php
require_once('../controller/db.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
            <li><a class="menugomb" href="home">Home</a></li>
            <li><a class="menugomb" href="uzenofal">Üzenőfal</a></li>
            <li><a class="menugomb" href="kapcsolat">Kapcsolat</a></li>
        <?php else: ?>
            <li><a class="menugomb" href="home">Home</a></li>
            <li><a class="menugomb" href="kapcsolat">Kapcsolat</a></li>
        <?php endif; ?>
    </ul>
</div>

<nav>
    <div class="left-menu">
        <?php 
        // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
        if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
            // Lekérdezzük a felhasználó adatait az adatbázisból
            $stmt = $pdo->prepare("SELECT * FROM felhasznalok WHERE Felhasznalonev = :Felhasznalonev");
            $stmt->bindParam(':Felhasznalonev', $_SESSION['username']);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC); // Felhasználói adatok lekérése
        ?>
            <div class="user-info" id="user-info">
                <strong>
                <?php
                if ($userData) {
                    echo htmlspecialchars($userData['Vezeteknev']) . " " . htmlspecialchars($userData['Keresztnev'])
                    . " (" . htmlspecialchars($userData['Felhasznalonev']) . ")";
                }
                ?>
                </strong>
            </div>
        <?php 
        } 
        ?>
    </div>

    <div class="centered-image-container">
        <a href="../pages/home"><img src="../img/TAppancs_logo.png" alt="Logo"></a>
    </div>

    <div class="right-menu" id="right-menu">
        <?php 
        if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
            <a id="myLink" href="profile"><i class="fas fa-user" class="login"></i></a>
            <a id="logoutLink" href="logout"><i class="fas fa-sign-out-alt" class="login"></i></a>
        <?php else: ?>
            <a id="myLink" href="login"><i class="fas fa-user" class="login"></i></a>
        <?php endif; ?>
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
    var link2 = document.getElementById('logoutLink');
    var userInfo = document.getElementById('user-info');
    var rightMenu = document.getElementById('right-menu');
    var offScreenMenu = document.querySelector('.off-screen-menu'); // Kiválasztja a menüt

    // Ha a link látszik, akkor gombnyomásra tűnjön el
    if (link.style.display === 'inline' || link.style.display === '') {
        link.style.display = 'none';
        link2.style.display = 'none'; // Elrejtés
        //userInfo.classList.add('hidden'); // Felhasználói információk elrejtése
        rightMenu.classList.add('hidden'); // Jobb oldali menü elrejtése
       
       
    } else {
        setTimeout(function() {
            link.style.display = 'inline'; // Link megjelenítése
            link2.style.display = 'inline';
            userInfo.classList.remove('hidden'); // Felhasználói információk megjelenítése
            rightMenu.classList.remove('hidden'); // Jobb oldali menü megjelenítése
            //offScreenMenu.style.backgroundColor = 'green'; // Zöld háttér
        }, 200); // Megjelenítés 200ms után
    }
}
</script>



</body>
</html>
