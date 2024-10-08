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

// Regisztrációs folyamat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Bemeneti adatok fogadása
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null; // Nem kötelező
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ellenőrizzük, hogy a felhasználónév vagy email már foglalt-e
    $stmt = $pdo->prepare("SELECT * FROM felhasznalok WHERE Felhasznalonev = :username OR Email = :email");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
    $errorMessage = "";
    if ($existingUser) {
        $errorMessage = "Ez a felhasználónév vagy email már létezik!";
    } else {
        // Jelszó hashelése
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Felhasználó adatainak beszúrása az adatbázisba
        $stmt = $pdo->prepare(
            "INSERT INTO felhasznalok (Vezeteknev, Keresztnev, Email, Telefonszam, Felhasznalonev, Jelszo, Jog_id) 
            VALUES (:lastname, :firstname, :email, :phone, :username, :password, 2)"
        );
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        // Sikeres regisztráció esetén beállítjuk a session-t
        $_SESSION['user_logged_in'] = false;
        $_SESSION['username'] = $username;

        // Továbbirányítás a főoldalra
        header('Location: login');
        exit;
    }
}
?>

<?php include 'nav/menu.php'; ?> <!-- Menü beillesztése -->
<div class="data">

<div class="login-container">
        <h2>Regisztráció</h2>
        <form method="POST" action="register">
            <input type="text" name="lastname" placeholder="Vezetéknév" required>
            <input type="text" name="firstname" placeholder="Keresztnév" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="text" name="phone" placeholder="Telefonszám (nem kötelező)">
            <input type="text" name="username" placeholder="Felhasználónév" required>
            <input type="password" name="password" placeholder="Jelszó" required>
            <input type="submit" class="gomb"  value="Regisztrálok">


            <?php if (!empty($errorMessage)): ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>


        </form>
        <div class="register">
            <p>Már van fiókod?</p>
            <a href="login">Bejelentkezés</a>
        </div>
    </div>
</div>

<script type="text/javascript" src="../js/menu.js"></script>

</body>
</html>
