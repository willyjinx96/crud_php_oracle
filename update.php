<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$nombre = $direccion = $salario = "";
$nombre_err = $direccion_err = $salario_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate nombre
    $input_nombre = trim($_POST["nombre"]);
    if (empty($input_nombre)) {
        $nombre_err = "Por favor ingresa un nombre.";
    } elseif (!filter_var($input_nombre, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $nombre_err = "Ingresa un nombre valido";
    } else {
        $nombre = $input_nombre;
    }

    // Validate direccion direccion
    $input_direccion = trim($_POST["direccion"]);
    if (empty($input_direccion)) {
        $direccion_err = "Ingresa una direccion valida";
    } else {
        $direccion = $input_direccion;
    }

    // Validate salario
    $input_salario = trim($_POST["salario"]);
    if (empty($input_salario)) {
        $salario_err = "Porfavor ingresa un salario";
    } elseif (!ctype_digit($input_salario)) {
        $salario_err = "Ingresa un valor positivo";
    } else {
        $salario = $input_salario;
    }

    // Check input errors before inserting in database
    if (empty($nombre_err) && empty($direccion_err) && empty($salario_err)) {
        // Prepare an update statement
        $sql = "UPDATE EMPLEADOS SET nombre=?, direccion=?, salario=? WHERE id=?";

        //if($stmt = mysqli_prepare($link, $sql)){
        if ($stmt = $link->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "sssi", $param_nombre, $param_direccion, $param_salario, $param_id);
            $stmt->bindParam(1, $param_nombre, PDO::PARAM_STR);
            $stmt->bindParam(2, $param_direccion, PDO::PARAM_STR);
            $stmt->bindParam(3, $param_salario, PDO::PARAM_STR);
            $stmt->bindParam(4, $param_id, PDO::PARAM_INT);

            // Set parameters
            $param_nombre = $nombre;
            $param_direccion = $direccion;
            $param_salario = $salario;
            $param_id = $id;

            // Attempt to execute the prepared statement
            //if(mysqli_stmt_execute($stmt)){
            if ($stmt->execute()) {
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        //mysqli_stmt_close($stmt);
        $stmt->closeCursor(); //PDO close
    }

    // Close connection
    //mysqli_close($link);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM EMPLEADOS WHERE id = ?";
        //if($stmt = mysqli_prepare($link, $sql)){
        if ($stmt = $link->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "i", $param_id);
            $stmt->bindParam(1, $param_id, PDO::PARAM_INT);

            // Set parameters
            $param_id = $id;

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
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Actualizar Registro</title>
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
                        <h2>Actualizar Registro</h2>
                    </div>
                    <p>Edita los espacios y actualiza el registro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nombre_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                            <span class="help-block"><?php echo $nombre_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($direccion_err)) ? 'has-error' : ''; ?>">
                            <label>Direccion</label>
                            <textarea name="direccion" class="form-control"><?php echo $direccion; ?></textarea>
                            <span class="help-block"><?php echo $direccion_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salario_err)) ? 'has-error' : ''; ?>">
                            <label>Salario</label>
                            <input type="text" name="salario" class="form-control" value="<?php echo $salario; ?>">
                            <span class="help-block"><?php echo $salario_err; ?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Actualizar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>