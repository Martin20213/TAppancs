<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="icon" href="../img/paw.png" type="image/png">
    <!-- További meta és stílus elemek -->


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAppancs</title>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<?php include 'nav/menu.php'; 



// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve

    // Az azonosító lekérése a session-ból
    
    $felhasznalo_id = $_SESSION['id'];
    // Adatok lekérdezése az adatbázisból
    $stmt = $pdo->prepare("SELECT * FROM felhasznalok WHERE Felhasznalo_id = :felhasznalo_id");
    $stmt->bindParam(':felhasznalo_id', $felhasznalo_id);
    $stmt->execute();

    // Az adatokat asszociatív tömbként lekérdezzük
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    
    





?> <!-- Menü beillesztése -->




<div class="data">
<h1>Felhasználói Adatok</h1>

</div>
<div class="data">
            <div class="data-container" id="konti">
                
                <table>
                    <tr>
                        <th>Név</th>
                        <td><?php echo htmlspecialchars($userData['Vezeteknev']) . ' ' . htmlspecialchars($userData['Keresztnev']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($userData['Email']); ?></td>
                    </tr>
                    <tr>
                        <th>Telefonszám</th>
                        <td><?php echo htmlspecialchars($userData['Telefonszam']); ?></td>
                    </tr>
                </table>
            </div>
        </div>


<script type="text/javascript" src="../js/menu.js"></script>

</body>
</html>
