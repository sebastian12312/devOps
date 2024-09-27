<?php
require 'vendor/autoload.php'; // Asegúrate de que la ruta es correcta

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];

        // Validar la extensión del archivo
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        if ($fileExtension != 'xls' && $fileExtension != 'xlsx') {
            die('Por favor sube un archivo Excel válido.');
        }

        // Cargar el archivo Excel
        try {
            $spreadsheet = IOFactory::load($fileTmpPath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            
            // Mostrar los datos en una tabla HTML
            echo '<table border="1" cellpadding="5" cellspacing="0">';
            foreach ($sheetData as $row) {
                echo '<tr>';
                foreach ($row as $cell) {
                    echo '<td>' . htmlspecialchars($cell) . '</td>'; // Escapar caracteres especiales
                }
                echo '</tr>';
            }
            echo '</table>';
        } catch (Exception $e) {
            die('Error al cargar el archivo: ' . $e->getMessage());
        }
    } else {
        die('Error en la subida del archivo.');
    }
}
?>
