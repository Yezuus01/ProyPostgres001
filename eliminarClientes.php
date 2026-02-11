<?php
// 1. Definición de variables para la conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "udesDB";

// 2. Establecer conexión con el servidor MySQL
$conexion = mysqli_connect($servidor, $usuario, $contrasena, $bd) or die("Se produjo un error al conectar");
mysqli_set_charset($conexion, "utf8");

// --- Lógica de Eliminación ---
if (isset($_POST['eliminar']) && $_POST['eliminar'] == 1) {
    if (isset($_POST['id_a_eliminar'])) {
        $lista_ids = $_POST['id_a_eliminar'];

        // Sanitizar los IDs (asegurando que sean enteros) para evitar inyección SQL
        $ids_seguros = array_map('intval', $lista_ids);
        $lista_ids_implode = implode(",", $ids_seguros); // Convertir array a string separado por comas

        // Consulta DELETE que elimina todos los IDs seleccionados
        $sql_delete = "DELETE FROM clientes WHERE id_clientes IN ($lista_ids_implode)";
        $resultado_delete = mysqli_query($conexion, $sql_delete);

        if ($resultado_delete) {
            echo "<p style='color: green; font-weight: bold;'>Registros eliminados correctamente.</p>";
        } else {
            echo "<p style='color: red; font-weight: bold;'>Error al eliminar: " . mysqli_error($conexion) . "</p>";
        }
    } else {
        echo "<p style='color: orange; font-weight: bold;'>Por favor, seleccione al menos un cliente para eliminar.</p>";
    }
}

// --- Lógica de Búsqueda y Listado ---
$where = "";
$busqueda = "";
if (isset($_POST['buscar'])) {
    $busqueda = $_POST['busqueda_general'];
    // Sanitizar el término de búsqueda
    $busqueda_segura = mysqli_real_escape_string($conexion, $busqueda);

    // Condición WHERE para buscar por nombre, apellido paterno o materno
    $where = "WHERE nombres LIKE '%$busqueda_segura%' OR apellido_paterno LIKE '%$busqueda_segura%' OR apellido_materno LIKE '%$busqueda_segura%'";
}

// Consulta principal para listar clientes (con o sin filtro)
$sql = "SELECT * FROM clientes $where";
$consulta = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Eliminar Cliente</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
    <script>
        // Función para seleccionar/deseleccionar todas las casillas
        function seleccionarTodos(source) {
            checkboxes = document.getElementsByName('id_a_eliminar[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script> 
<body>

    <h2>Eliminar Clientes</h2>
    <hr>

    <form action="eliminarClientes.php" method="post">
        <input type="text" name="busqueda_general" value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Buscar por nombre o apellido">
        <input type="submit" name="buscar" value="Buscar">
        <a href="eliminarClientes.php"><button type="button">Ver Todos</button></a>
    </form>
    <hr>

    <form action="eliminarClientes.php" method="post">
        <table border="1">
            <thead>
                <tr>
                    <th><input type="checkbox" onclick="seleccionarTodos(this)"></th>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Dirección</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar resultados de la consulta
                if (mysqli_num_rows($consulta) > 0) {
                    while ($fila = mysqli_fetch_array($consulta)) {
                        echo "<tr>";
                        // Casilla de selección con el ID del cliente
                        echo "<td><input type='checkbox' name='id_a_eliminar[]' value='" . htmlspecialchars($fila['id_clientes']) . "'></td>";
                        echo "<td>" . htmlspecialchars($fila['id_clientes']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['nombres']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['apellido_paterno']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['apellido_materno']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['direccion']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No se encontraron registros.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <br>
        <input type="submit" name="accion_eliminar" value="Eliminar Seleccionados" onclick="return confirm('¿Está seguro de que desea eliminar los registros seleccionados?')">
        <input type="hidden" name="eliminar" value="1">
    </form>
    <hr>
    
    <p>
        <a href="listarClientes.php">Volver a Lista de Clientes</a> |
        <a href="adicionarClientes.php">Adicionar Nuevo Cliente</a>
    </p>

</body>
</html>

<?php
// Cerrar la conexión
mysqli_close($conexion);
?>