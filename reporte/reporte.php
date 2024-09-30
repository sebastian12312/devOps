<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>


<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="border rounded-lg shadow-lg bg-white p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">Subir Archivo Excel</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data" class="flex flex-col items-center">
            <input type="file" name="file" accept=".xlsx" class="mb-4 p-2 border border-gray-300 rounded-md" />

            <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition">subir archivo!</button>
            <a href="index.php" class="mt-4 bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition">regresar</a>
        </form>
    </div>
</div>


</body>
</html>
