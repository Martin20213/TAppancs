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


include 'nav/menu.php';





if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    // Ha nem admin, írjuk ki, hogy nincs joga hozzáférni az oldalhoz
    header('Location: home');
    
    exit; 
}


?> <!-- Menü beillesztése -->

<div class="data">

<div class="data-container">
<h1>Kapcsolat</h1>

<form method="POST" action="contact">
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
