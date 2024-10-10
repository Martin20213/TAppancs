<?php
require 'vendor/autoload.php'; // Ha a Composer-t használod
include('db.php'); // Az adatbázis kapcsolódás beillesztése

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// SQL lekérdezés a felhasználók adatainak lekérésére
$sql = "SELECT Felhasznalo_id, Vezeteknev, Keresztnev, Felhasznalonev, Email, Telefonszam FROM users";
$result = $conn->query($sql);

// Spreadsheet objektum létrehozása
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Fejléc beállítása

$sheet->setCellValue('B1', 'Vezeteknev');
$sheet->setCellValue('C1', 'Keresztnev');
$sheet->setCellValue('D1', 'Felhasznalonev');
$sheet->setCellValue('E1', 'Email');
$sheet->setCellValue('F1', 'Telefonszam');

// Adatok beillesztése
if ($result->num_rows > 0) {
    $rowIndex = 2; // Az adatok a második sorból indulnak
    while ($row = $result->fetch_assoc()) {

        $sheet->setCellValue('B' . $rowIndex, $row['Vezeteknev']);
        $sheet->setCellValue('C' . $rowIndex, $row['Keresztnev']);
        $sheet->setCellValue('D' . $rowIndex, $row['Felhasznalonev']);
        $sheet->setCellValue('E' . $rowIndex, $row['Email']);
        $sheet->setCellValue('F' . $rowIndex, $row['Telefonszam']);
        $rowIndex++;
    }
}

// Excel fájl letöltése
$writer = new Xlsx($spreadsheet);
$filename = 'felhasznalok.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
