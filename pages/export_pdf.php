<?php
require('fpdf/fpdf.php');
include('db.php'); // Az adatbázis kapcsolódás beillesztése

// SQL lekérdezés a felhasználók adatainak lekérésére
$sql = "SELECT Felhasznalo_id, Vezeteknev, Keresztnev, Felhasznalonev, Email, Telefonszam FROM users";
$result = $conn->query($sql);

// PDF objektum létrehozása
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Fejléc beállítása

$pdf->Cell(40, 10, 'Vezeteknev', 1);
$pdf->Cell(40, 10, 'Keresztnev', 1);
$pdf->Cell(30, 10, 'Felhasznalonev', 1);
$pdf->Cell(50, 10, 'Email', 1);
$pdf->Cell(30, 10, 'Telefonszam', 1);
$pdf->Ln();

// Adatok kiírása
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
       
        $pdf->Cell(40, 10, $row['Vezeteknev'], 1);
        $pdf->Cell(40, 10, $row['Keresztnev'], 1);
        $pdf->Cell(30, 10, $row['Felhasznalonev'], 1);
        $pdf->Cell(50, 10, $row['Email'], 1);
        $pdf->Cell(30, 10, $row['Telefonszam'], 1);
        $pdf->Ln();
    }
}

// PDF letöltésre kínálása
$pdf->Output('D', 'felhasznalok.pdf');
?>
