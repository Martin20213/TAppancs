<?php
session_start(); // Session indítása

// Session változók törlése
session_unset(); // Eltávolítja az összes session változót
session_destroy(); // Lezárja a session-t

// Átirányítás a főoldalra (vagy bejelentkezési oldalra)
header('Location: login'); // Változtasd meg a megfelelő oldalra
exit;
?>
