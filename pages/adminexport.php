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

?>

<div class="data">
    <div class="data-container">
        
        <h1>Felhasználói adatok exportálása</h1>
        <div id="kozepre">
        <form action="export_pdf.php" method="POST" class = "data-container-export">
        <button type="submit" class="exportbutton">Exportálás PDF-be</button>
    </form>

    <!-- Excel export gomb -->
    <form action="export_xlsx.php" method="POST" class = "data-container-export">
        <button type="submit" class="exportbutton">Exportálás Excel-be</button>
    </form>
    </div>
</div>
</div>


<script type="text/javascript" src="../js/menu.js"></script>
</body>
</html>

