<?php
// Comprobando la existencia del parámetro id antes de seguir procesando
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Incluir el archivo config.php
    require_once "config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM EMPLEADOS WHERE id = ?";

    //if($stmt = mysqli_prepare($link, $sql)){
    if ($stmt = $link->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        //mysqli_stmt_bind_param($stmt, "i", $param_id);
        $stmt->bindParam(1, $param_id, PDO::PARAM_INT);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        //if(mysqli_stmt_execute($stmt)){
        if ($stmt->execute()) {
            //$result = mysqli_stmt_get_result($stmt);
            $result = $stmt->fetchAll();

            //if(mysqli_num_rows($result) == 1){
            if (count($result) == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                //$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $row = $result[0];

                // Retrieve individual field value
                $nombre = $row["NOMBRE"];
                $direccion = $row["DIRECCION"];
                $salario = $row["SALARIO"];
            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Algo salio mal, intente mas tarde...";
        }
    }

    // Close statement
    //mysqli_stmt_close($stmt);
    $stmt->closeCursor(); //PDO close

    // Close connection
    //mysqli_close($link);
} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ver Registro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Ver Registro</h1>
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <p class="form-control-static"><?php echo $nombre; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Direccion</label>
                        <p class="form-control-static"><?php echo $direccion; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Salario</label>
                        <p class="form-control-static"><?php echo $salario; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Volver</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>