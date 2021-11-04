<?php
define('DB_SERVER', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
(HOST=127.0.0.1)(PORT=1521))(CONNECT_DATA=(SERVICE_NAME=XE)))');
define('DB_USERNAME', 'db_crud');
define('DB_PASSWORD', 'db_crud');

//Oracle database
try {
    $link = new PDO("oci:dbname=" . DB_SERVER, DB_USERNAME, DB_PASSWORD);
    if($link){
        echo 'Conexion Exitosa...';
    }
} catch (PDOException $e) {
    echo ($e->getMessage());
}
?>