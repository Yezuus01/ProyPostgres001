<?php
require_once 'conexionpg.php';

$mostrar_lista=TRUE;
$mensaje="";

// Logica de Actualizacion
if (isset($_POST['guardar'])) {
    $id = $_POST['id_estudiantes'];
    $nombres = $_POST['nombres'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $ci = $_POST['ci'];
    $direccion = $_POST['direccion'];
    $fecha_de_nacimiento = $_POST['fecha_de_nacimiento'];
    $rude = $_POST['rude'];

    //consulta SQL para actualizar
    $sql_update = "UPDATE estudiantes SET nombres= '$nombres', apellido_paterno='$apellido_paterno', apellido_materno='$apellido_materno', ci='$ci', direccion='$direccion', fecha_de_nacimiento='$fecha_de_nacimiento', rude='$rude' WHERE id_estudiantes='$id'";

    if (pg_query($conectar, $sql_update)) {
        $mensaje = "Estudiante actualizado correctamente.";
    } else {
        $mensaje = "Error al actualizar: " . pg_last_error($conectar);
    }
}

// Logica para mostrar el formulario de edicion
if (isset($_POST['modificar'])) {
    if(isset($_POST['ids']) && count($_POST['ids']) == 1) {
        $id_editar = $_POST['ids'][0];

        $sql_buscar = "SELECT * FROM estudiantes WHERE id_estudiantes='$id_editar'";
        $resultado = mysqli_query($conectar, $sql_buscar);

        if ($estudiante = mysqli_fetch_array($resultado)) {
            $mostrar_lista = false; //ocultar lista para mostrar el formulario
        } else {
            $mensaje = "Error al recuperar los datos del cliente.";
        }
    } else {
        $mensaje = "Por favor, seleccione exactamente un cliente para modificar.";
    }       
}

// logica del Buscador y Listado
$where = "";
$busqueda = "";
if (isset($_GET['buscar'])) {
    $busqueda = $_GET['buscar'];
    $busqueda_segura = pg_escape_string($conectar, $busqueda);
    $where = "WHERE nombres LIKE '%$busqueda_segura%' OR apellido_paterno LIKE '%$busqueda_segura%' OR apellido_materno LIKE '%$busqueda_segura%'";
}

$sql_lista = "SELECT * FROM estudiantes $where";
$consulta = pg_query($conectar, $sql_lista);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Estudiante</title>
    <link rel="stylesheet" href="misestilos.css">
</head>
<body>
    <h2>Modificar Estudiante</h2>

    <?php if ($mensaje): ?>
        <p style="color:blue; font-weight: bold;"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <?php if (!$mostrar_lista && isset($estudiante)): ?>

        <h3>Editar Datos del Estudiante</h3>
        <form method="post" action="ModificarEstudiantes.php">
            <input type="hidden" name="id_estudiantes" value="<?php echo $estudiante['id_estudiantes']; ?>">

            <label>Nombres</label><br>
            <input type="text" name="nombres" value="<?php echo $estudiante['nombres']; ?>" required><br><br>

            <label>Apellido Paterno</label><br>
            <input type="text" name="apellido_paterno" value="<?php echo $estudiante['apellido_paterno']; ?>" required><br><br>

            <label>Apellido Materno</label><br>
            <input type="text" name="apellido_materno" value="<?php echo $estudiante['apellido_materno']; ?>" required><br><br>

            <label>CI</label><br>
            <input type="number" name="ci" value="<?php echo $estudiante['ci']; ?>" required><br><br>
            
            <label>Direccion</label><br>
            <input type="text" name="direccion" value="<?php echo $estudiante['direccion']; ?>" required><br><br>
            
            <label>Fecha de Nacimiento</label><br>
            <input type="date" name="fecha_de_nacimiento" value="<?php echo $estudiante['fecha_de_nacimiento']; ?>" required><br><br>
             
            <label>rude</label><br>
            <input type="number" name="rude" value="<?php echo $estudiante['rude']; ?>" required><br><br>

            <input type="submit" name="guardar" value="Guardar Cambios">
            <a href="ModificarEstudiantes.php"><button type="button">Cancelar</button></a>
        </form>

    <?php else: ?>

        <form method="get" action="ModificarEstudiantes.php">
            <input type="text" name="buscar" value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Buscar por nombre o apellido">
            <input type="submit" values="Buscar">
            <a href="ModificarEstudiantes.php"><button type="button">Ver Todos</button></a>
        </form>
        <br>

        <form method="post" action="ModificarEstudiantes.php">
        <table border="1">
            <tr>
            <th>Sel</th>   
            <th>ID</th>
            <th>Nombres</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>CI</th>
            <th>Dirección</th>
            <th>Fecha de Nacimiento</th>
            <th>rude</th>
            </tr>
            <?php
            if (pg_num_rows($consulta) > 0) {
                while ($columna = pg_fetch_array($consulta)) {
                    echo "<tr>";
                    echo "<td><input type=\"checkbox\" name=\"ids[]\" value=\"" . $columna['id_estudiantes'] . "\"></td>";
                    echo "<td>" . $columna['id_estudiantes'] . "</td>";
                    echo "<td>" . $columna['nombres'] . "</td>";
                    echo "<td>" . $columna['apellido_paterno'] . "</td>";
                    echo "<td>" . $columna['apellido_materno'] . "</td>";
                    echo "<td>" . $columna['ci'] . "</td>";
                    echo "<td>" . $columna['direccion'] . "</td>";
                    echo "<td>" . $columna['fecha_de_nacimiento'] . "</td>";
                    echo "<td>" . $columna['rude'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No se encontraron registros.</td></tr>";
            }
            ?>
        </table>
        <br>
        <input type="submit" name="modificar" value="Modificar Seleccionado">
        </form>
    <?php endif; ?>

    <br>
    <a href="estudiantes.php">Volver a lista de estudiantes</a> | <a href="AdicionarEstudiantes.php">Adicionar</a> | <a href="EliminarEstudiantes.php">Eliminar</a>
</body>
</html>
       
<?php
pg_close($conectar);
?>