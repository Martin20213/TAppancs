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
        <form method="POST" action="login_process.php">
            <input type="text" name="username" placeholder="Felhasználónév" required>
            <input type="password" name="password" placeholder="Jelszó" required>
            <input type="submit" value="Bejelentkezés">
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
