<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper {
            width: 650px;
            margin: 0 auto;
        }

        .page-header h2 {
            margin-top: 0;
        }

        table tr td:last-child a {
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Detalles de Empleados</h2>
                        <a href="create.php" class="btn btn-success pull-right">Agregar nuevo Empleado</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";

                    // Attempt select query execution
                    $sql = "SELECT * FROM EMPLEADOS";
                    //if($result = mysqli_query($link, $sql)){
                    if ($result = $link->query($sql)) {
                        //if(mysqli_num_rows($result) > 0){
                        if ($result->fetchColumn() > 0) {
                            echo "<table class='table table-bordered table-striped'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>#</th>";
                            echo "<th>Nombre</th>";
                            echo "<th>Direccion</th>";
                            echo "<th>Salario</th>";
                            echo "<th>Acciones</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            //while($row = mysqli_fetch_array($result)){
                            foreach ($link->query($sql) as $row) {
                                echo "<tr>";
                                echo "<td>" . $row['ID'] . "</td>";
                                echo "<td>" . $row['NOMBRE'] . "</td>";
                                echo "<td>" . $row['DIRECCION'] . "</td>";
                                echo "<td>" . $row['SALARIO'] . "</td>";
                                echo "<td>";
                                echo "<a href='read.php?id=" . $row['ID'] . "' title='Ver Registro' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                echo "<a href='update.php?id=" . $row['ID'] . "' title='Actualizar Registro' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                echo "<a href='delete.php?id=" . $row['ID'] . "' title='Borrar Registro' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            //mysqli_free_result($result);
                            $result->closeCursor(); //PDO close
                        } else {
                            echo "<p class='lead'><em>No hay registros que mostrar.</em></p>";
                        }
                    } else {
                        echo "ERROR: No se pudo ejecutar $sql. ";
                    }

                    // Close connection
                    //mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>