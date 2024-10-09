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

// Bejelentkezési folyamat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Lekérdezés az adatbázisból
    $stmt = $pdo->prepare("SELECT * FROM felhasznalok WHERE Felhasznalonev = :Felhasznalonev");
    $stmt->bindParam(':Felhasznalonev', $inputUsername);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    
   



    if ($user && password_verify($inputPassword, $user['Jelszo'])) {
        // Sikeres bejelentkezés, beállítjuk a session változót
        $_SESSION['user_logged_in'] = true;
        if($user['Jog_id'] == 3){
            $_SESSION['is_admin'] = true;
            }else{
            $_SESSION['is_admin'] = false;
        }
        

        $_SESSION['username'] = $inputUsername; // opcionális, ha meg akarod jeleníteni
        
        header('Location: home'); // Továbbirányítás a főoldalra
        exit;
    } else {
        // Hiba esetén üzenet
        $errorMessage = "Hibás felhasználónév vagy jelszó!";
    }
}
?>



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

<?php include 'nav/menu.php'; ?> <!-- Menü beillesztése -->
<div class="data">

<div class="login-container">
        <h2>Bejelentkezés</h2>
        <form method="POST" action="login">
            <input type="text" name="username" placeholder="Felhasználónév" required>
            <input type="password" name="password" placeholder="Jelszó" required>
            <input type="submit" class="gomb" value="Bejelentkezés">


            <?php if (!empty($errorMessage)): ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>


        
        </form>
        <div class="register">
            <p>Még nem regisztráltál?</p>
            <a href="register">Regisztrálok</a>
        </div>
    </div>
</div>

<script type="text/javascript" src="../js/menu.js"></script>

</body>
</html>


