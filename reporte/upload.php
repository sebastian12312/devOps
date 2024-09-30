<?php
session_start(); // Iniciar la sesión
ob_start(); // Iniciar el almacenamiento de salida
require 'vendor/autoload.php'; // Asegúrate de que la ruta es correcta

use PhpOffice\PhpSpreadsheet\IOFactory;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de la conexión a la base de datos
$host = '127.0.0.1';
$dbname = 'reporteTickts';
$user = 'postgres';
$password = '802605';
$port = '5432';

// Conexión a la base de datos
$connection = pg_connect("host=$host dbname=$dbname port=$port user=$user password=$password");
if (!$connection) {
    die('Error de conexión a la base de datos.');
}

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
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $insertedData = []; // Para almacenar datos insertados

            foreach ($sheetData as $rowIndex => $row) {
                if ($rowIndex === 0) continue; // Salta la primera fila si es el encabezado

                // Verificar que la fila tenga al menos 26 columnas
                if (count($row) < 26) {
                    continue; // Saltar a la siguiente fila
                }

                // Reemplazar campos vacíos
                foreach ($row as $key => $value) {
                    // Si es string y está vacío, poner "NO DISPONIBLE"
                    if (is_string($value) && trim($value) === '') {
                        $row[$key] = 'NO DISPONIBLE';
                    } 
                    // Si es int y está vacío, poner 0
                    elseif (trim($value) === '' && ($key === 0 || $key === 18 || $key === 19 || $key === 20)) {
                        $row[$key] = 0; // Para los campos que deberían ser enteros
                    }
                }

                // Verificar "razón social" y otros campos
                for ($i = 21; $i <= 25; $i++) {
                    if (trim($row[$i]) === '' || strtolower($row[$i]) === 'null') {
                        $row[$i] = 'NO DISPONIBLE'; // Cambiar a "NO DISPONIBLE" si es vacío o null
                    }
                }

                // Insertar los datos en la base de datos
                $query = "INSERT INTO public.reportetickets (
                    numero_ticket, fecha_creacion, asunto, creado_por, correo_cliente, prioridad, departamento,
                    tema_ayuda, fuente, estado_actual, ultima_actualizacion, due_date, fecha_vencimiento,
                    fecha_cierre, atrasado, respondio, asignado_usuario, asignado_equipo, hilos,
                    reopen_count, recuento_datos, dominio_plataforma, razon_social, usuario,
                    correo_electronico, telefono) VALUES (
                    {$row[0]}, '{$row[1]}', '{$row[2]}', '{$row[3]}', '{$row[4]}', '{$row[5]}', '{$row[6]}',
                    '{$row[7]}', '{$row[8]}', '{$row[9]}', '{$row[10]}', '{$row[11]}', '{$row[12]}',
                    '{$row[13]}', '{$row[14]}', '{$row[15]}', '{$row[16]}', '{$row[17]}', {$row[18]},
                    {$row[19]}, {$row[20]}, '{$row[21]}', '{$row[22]}', '{$row[23]}', '{$row[24]}', '{$row[25]}')";

                // Ejecutar la consulta de inserción
                if (!pg_query($connection, $query)) {
                    echo "Error en la inserción de datos: " . pg_last_error($connection) . "<br>";
                } else {
                    $insertedData[] = $row; // Agregar fila a los datos insertados
                }
            }

            // Guardar los datos insertados en la sesión
            $_SESSION['inserted_data'] = $insertedData;

            // Redireccionar al index después de procesar el archivo
            header("Location: index.php");
            exit(); // Asegúrate de que se detenga la ejecución después de la redirección

        } catch (Exception $e) {
            die('Error al cargar el archivo: ' . $e->getMessage());
        }
    } else {
        die('Error en la subida del archivo.');
    }
}
?>
