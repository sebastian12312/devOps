<?php
require_once 'conexionDB/conexion.php';
$db = new db();
$tickets = $db->listarAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="flex pt-4">
        <div class="flex h-[200px]">
            <div class="mx-4 bg-white p-6 rounded-lg shadow-lg w-96">
                <form id="" action="" class="">
                    <label for="options" class="mb-4 block text-lg font-medium text-gray-700 mb-4">Selecciona una opción:
                        <a href="reporte.php" class="rounded-lg p-4 border">subir excel</a>
                    </label>
                    <select name="options" id="options_org" class="mt-2 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Seleccione una opción</option>
                        <option value="protecta">PROTECTA</option>
                        <option value="gerencia">GERENCIA</option>
                        <option value="jjc">JJC</option>
                        <option value="sonda">SONDA</option>
                        <option value="jockey">JOCKEY</option>
                        <option value="consorcio">CONSORCIO</option>
                    </select>
                </form>
                <div class="flex gap-4">
                    <select name="filter_mes" id="filter_mes" class="mt-2 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="" disabled selected>Seleccione un mes</option>
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>

                    <select name="filter_año" id="filter_año" class="mt-2 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="" disabled selected>Seleccione un año</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                        <option value="2019">2019</option>
                        <option value="2018">2018</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="w-[300px] bg-white shadow-lg py-8 rounded px-4">
            <div id="cantidad" class="mb-2"></div>
            <div id="tiempo_medio" class="mb-2"></div>
            <div id="horas" class="mb-2"></div>          
        </div>
    </div>

    <div class="flex justify-center mx-4 mb-8">
    <table id="ticketsTable" class="min-w-full bg-white p-6 rounded-xl shadow-lg mt-4 border border-gray-300">
        <thead>
            <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                <th class="py-3 px-4 text-left">Nº</th>
                <th class="py-3 px-4 text-left">Fecha Creación</th>
                <th class="py-3 px-4 text-left">Fecha Cierre</th>
                <th class="py-3 px-4 text-left">Diferencia (minutos)</th>
                <th class="py-3 px-4 text-left">Creado Por</th>
                <th class="py-3 px-4 text-left">Correo Cliente</th>
                <th class="py-3 px-4 text-left">Asignado Usuario</th>
                <th class="py-3 px-4 text-left">Razón Social</th>
                <th class="py-3 px-4 text-left">Asunto</th>
            </tr>
        </thead>
        <tbody id="table_body" class="text-gray-600 text-sm font-light">
            <?php foreach ($tickets as $ticket): ?>
                <tr class="border-b border-gray-200 hover:bg-gray-100" data-razon="<?= htmlspecialchars($ticket['razon_social']); ?>">
                    <td class="py-2 px-4"><?= htmlspecialchars($ticket['numero_ticket']); ?></td>
                    <td class="py-2 px-4 fecha-creacion"><?= htmlspecialchars($ticket['fecha_creacion']); ?></td>
                    <td class="py-2 px-4 fecha-cierre"><?= htmlspecialchars($ticket['fecha_cierre']); ?></td>
                    <td class="py-2 px-4 diferencia-minutos"></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($ticket['creado_por']); ?></td>
                    <td class="py-2 px-4 correo_cliente"><?= isset($ticket['correo_cliente']) ? htmlspecialchars($ticket['correo_cliente']) : 'No disponible' ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars(substr($ticket['asignado_usuario'], 0, 20)); ?></td>
                    <td class="py-2 px-4 razon_social"><?= htmlspecialchars($ticket['razon_social']); ?></td>
                    <td class="py-2 px-4 razon_social"><?= htmlspecialchars($ticket['asunto']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


    <script>
   document.addEventListener("DOMContentLoaded", function() {
    const optionsOrg = document.getElementById("options_org");
    const filterMes = document.getElementById("filter_mes");
    const filterAnio = document.getElementById("filter_año");
    const cantidadDisplay = document.getElementById("cantidad");
    const tiempoMedioDisplay = document.getElementById("tiempo_medio");
    const horasDisplay = document.getElementById("horas");
    const rows = document.querySelectorAll("#ticketsTable tbody tr");

    // Calcular la diferencia en minutos y mostrarla en la tabla
    rows.forEach(row => {
        const fechaCreacion = row.querySelector('.fecha-creacion').textContent.trim();
        const fechaCierre = row.querySelector('.fecha-cierre').textContent.trim();
        
        const diffInMinutes = calculateMinutesDifference(fechaCreacion, fechaCierre);
        row.querySelector('.diferencia-minutos').textContent = diffInMinutes;
    });

    // Función para filtrar filas
    function filterRows() {
        const selectedOption = optionsOrg.value.toLowerCase();
        const selectedMes = filterMes.value;
        const selectedAnio = filterAnio.value;
        let visibleCount = 0;
        let totalMinutes = 0; // Sumar minutos

        rows.forEach(row => {
            const razon = row.getAttribute("data-razon").toLowerCase();
            const fechaCierre = row.querySelector('.fecha-cierre').textContent.trim();
            const [anio, mes] = fechaCierre.split(' ')[0].split('-'); // Desglosar fecha

            const monthString = String(parseInt(mes)).padStart(2, '0'); // Asegurar que el mes tenga dos dígitos

            const matchesRazon = selectedOption === "" || razon.includes(selectedOption);
            const matchesMes = selectedMes === "" || monthString === String(selectedMes).padStart(2, '0');
            const matchesAnio = selectedAnio === "" || anio === selectedAnio;

            if (matchesRazon && matchesMes && matchesAnio) {
                row.style.display = "";
                visibleCount++;

                // Sumar minutos solo si la fila es visible
                const diferenciaMinutos = parseInt(row.querySelector('.diferencia-minutos').textContent) || 0;
                totalMinutes += diferenciaMinutos;
            } else {
                row.style.display = "none";
            }
        });

        cantidadDisplay.textContent = `Tickets encontrados: ${visibleCount}`;

        // Calcular y mostrar el tiempo medio
        if (visibleCount > 0) {
            const tiempoMedio = totalMinutes / visibleCount;
            tiempoMedioDisplay.textContent = `Tiempo Medio: ${tiempoMedio.toFixed(2)} minutos`;
            
            // Convertir a horas
            const horas = tiempoMedio / 60;
            horasDisplay.textContent = `Tiempo Medio en Horas: ${horas.toFixed(2)} horas`;
        } else {
            tiempoMedioDisplay.textContent = "Tiempo Medio: 0 minutos";
            horasDisplay.textContent = "Tiempo Medio en Horas: 0 horas";
        }
    }

    // Eventos de cambio en los selectores
    optionsOrg.addEventListener("change", filterRows);
    filterMes.addEventListener("change", filterRows);
    filterAnio.addEventListener("change", filterRows);
});

function calculateMinutesDifference(fechaCreacion, fechaCierre) {
    const start = new Date(fechaCreacion);
    const end = new Date(fechaCierre);
    const diff = (end - start) / (1000 * 60); // Diferencia en minutos
    return diff;
}

    </script>
</body>

</html>