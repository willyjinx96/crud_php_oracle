<?php
// Incluimos el archivo config.php
require_once "config.php";

// Definimos variables e inicializamos vacio
$nombre = $direccion = $salario = "";
$nombre_err = $direccion_err = $salario_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validacion nombre
    $input_nombre = trim($_POST["nombre"]);
    if (empty($input_nombre)) {
        $nombre_err = "Por favor ingresa un nombre.";
    } elseif (!filter_var($input_nombre, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $nombre_err = "Ingresa un nombre valido.";
    } else {
        $nombre = $input_nombre;
    }

    // Validacion direccion
    $input_direccion = trim($_POST["direccion"]);
    if (empty($input_direccion)) {
        $direccion_err = "Por favor ingresa una direccion.";
    } else {
        $direccion = $input_direccion;
    }

    // Validacion salario
    $input_salario = trim($_POST["salario"]);
    if (empty($input_salario)) {
        $salario_err = "Ingresa un monto de salario";
    } elseif (!ctype_digit($input_salario)) {
        $salario_err = "Ingresa un valor positivo.";
    } else {
        $salario = $input_salario;
    }

    // Revisamos errores antes de continuar
    if (empty($nombre_err) && empty($direccion_err) && empty($salario_err)) {
        // preparamos la sentancia INSERT
        $sql = "INSERT INTO EMPLEADOS (nombre, direccion, salario) VALUES (?, ?, ?)";

        if ($stmt = $link->prepare($sql)) {

            // Se hace el bindeo de variables para la sentencia
            $stmt->bindParam(1, $param_nombre, PDO::PARAM_STR);
            $stmt->bindParam(2, $param_direccion, PDO::PARAM_STR);
            $stmt->bindParam(3, $param_salario, PDO::PARAM_STR);

            // settear variables
            $param_nombre = $nombre;
            $param_direccion = $direccion;
            $param_salario = $salario;

            // Intentando ejecutar la declaración preparada
            if ($stmt->execute()) {
                // Registros creados con éxito. Redirigiendo a la página de destino
                header("location: index.php");
                exit();
            } else {
                echo "Paso algo, intente mas tarde...";
            }
        }

        // Cerrando sentencia
        $stmt->closeCursor(); //PDO close
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Registro</title>
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
                        <h2>Crear Registro</h2>
                    </div>
                    <p>Llena este formulario para agregar un empleado a la base de datos</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <input type="submit" class="btn btn-primary" value="Crear">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>