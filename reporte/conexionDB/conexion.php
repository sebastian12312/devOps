<?php
define("DB_DATABASE", "reporteTickts");
define("DB_HOST", "127.0.0.1");
define("DB_USER", "postgres");
define("DB_PASSWORD", "802605");
define("DB_PORT", "5432");

class db {
    private $connection;

    function __construct($database = DB_DATABASE, $host = DB_HOST, $user = DB_USER, $password = DB_PASSWORD) {
        $this->connection = $this->Conectarse($database, $host, $user, $password);
    }

    private function Conectarse($database, $host, $user, $password) {
        $connectionString = "host=$host dbname=$database port=" . DB_PORT . " user=$user password=$password";
        $connection = pg_connect($connectionString);

        if (!$connection) {
            echo "Error al conectarse a la base de datos.";
            exit;
        }

        return $connection;
    }

    function listarAll() {
        $result = pg_query($this->connection, "select  numero_ticket, fecha_creacion, fecha_cierre,asunto, creado_por,correo_cliente, asignado_usuario, razon_social from reportetickets order by numero_ticket asc");

        if (!$result) {
            echo "Error al ejecutar la consulta.";
            return [];
        }

        $tickets = [];
        while ($row = pg_fetch_assoc($result)) {
            $tickets[] = $row;
        }

        return $tickets;
    }

    function __destruct() {
        pg_close($this->connection); // Cierra la conexión al destruir el objeto
    }
}
?>