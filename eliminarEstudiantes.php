<?php
require_once 'conexionpg.php';
$mostrar_lista=true;
$mensaje="";

//Logica para eliminar registros seleccionados
if (isset($_POST['eliminar']) && isset($_POST['id'])) {
    $ids_a_eliminar = $_POST['id'];
    if (!empty($ids_a_eliminar)) {


        $ids_seguros = array_map('intval', $ids_a_eliminar);
        $lista_ids = implode(',', $ids_seguros);

        $sql_delete ="DELETE FROM estudiantes WHERE id_estudiantes IN ($lista_ids)";

        if (pg_query($conectar, $sql_delete)) {
            echo "<p>Registros eliminados correctamente.</p>";
        } else {
            echo "Error al eliminar: " . pg_last_error($conectar);
        }
    }
}

// Logica para el buscador
$where = "";
$busqueda = "";
if (isset($_GET['buscar'])) {
    $busqueda = $_GET['buscar'];
    //Escapar caracteres especiales para evitar inyeccion SQL
    $busqueda_segura = pg_escape_string($conectar, $busqueda);
    $where = "WHERE nombres LIKE '%$busqueda_segura%' OR apellido_paterno LIKE '%$busqueda_segura%' OR apellido_materno LIKE '%$busqueda_segura%'";
}

//Consulta para obtener los clientes
$sql = "SELECT * FROM estudiantes $where";
$consulta = pg_query($conectar, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Estudiantes</title>
<link rel="stylesheet" href="misestilos.css">

    <script>
        function seleccionarTodos(source) {
            checkboxes = document.getElementsByName('ids[]');
            for(var i=0, n=checkboxes.length; i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
</head>
<body>
    <h2>Eliminar Estudiantes</h2>

    <form method="get" action="EliminarEstudiantes.php">
        <input type="text" name="buscar" value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Buscar por nombre o apellido">
        <input type="submit" values="Buscar">
        <a href="EliminarEstudiantes.php"><button type="button">Ver Todos</button></a>
        </form>
        <br>

    <form method="post" action="EliminarEstudiantes.php">
        <table >
            <tr>
            <th><input type="checkbox" onClick="seleccionarTodos(this)"></th>
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
                    echo "<td><input type=\"checkbox\" name=\"id[]\" value=\"" . $columna['id_estudiantes'] . "\"></td>";
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
                echo "<tr><td colspan='7'>No se encontraron registros.</td></tr>";
            }
            ?>
        </table>
        <br>
        <input type="submit" name="eliminar" value="Eliminar Seleccionados" onclick="return confirm('¿Está seguro de que desea eliminar los registros seleccionados?');">
    </form>
    <br>
    <a href="estudiantes.php">Volver a lista de estudiantes</a> | <a href="AdicionarEstudiantes.php">Adicionar Nuevo Estudiante</a>
</body>
</html>

<?php
pg_close($conectar);
?>