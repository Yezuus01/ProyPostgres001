<?php
// Conexión a la base de datos para la base de datos
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "udesDB";

// Intentar la conexión
$conexion = mysqli_connect($servidor, $usuario, $contrasena, $bd) or die("Error: No se pudo conectar al servidor");
mysqli_set_charset($conexion, "utf8");

// --- Función para la consulta de clientes ---
function consulta_clientes($conexion, $busqueda_general = "") {
    $clientes = array();

    // Preparar la consulta
    if ($busqueda_general == "") {
        $sql = "SELECT id_clientes, nombres, apellido_paterno, apellido_materno, direccion FROM clientes";
    } else {
        $sql = "SELECT id_clientes, nombres, apellido_paterno, apellido_materno, direccion FROM clientes WHERE nombres LIKE '%$busqueda_general%' OR apellido_paterno LIKE '%$busqueda_general%' OR apellido_materno LIKE '%$busqueda_general%' OR direccion LIKE '%$busqueda_general%' OR id_clientes = '$busqueda_general'";
    }

    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        // Almacenar los resultados en un array
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $clientes[] = $fila;
        }
    } else {
        echo "Mensaje: 'Error al actualizar' - mysqli_error($conexion)";
    }
    return $clientes;
}
// --- Fin Función consulta_clientes ---

// --- Lógica para modificar cliente (almacenar datos) ---
if (isset($_POST['modificar_cliente']) && $_POST['modificar_cliente'] == 1) {
    $id_cliente_a_modificar = $_POST['id_clientes'];
    $nuevos_nombres = $_POST['nombres'];
    $nuevo_apellido_paterno = $_POST['apellido_paterno'];
    $nuevo_apellido_materno = $_POST['apellido_materno'];
    $nueva_direccion = $_POST['direccion'];

    // Consulta de actualización
    $sql_update = "UPDATE clientes SET nombres='$nuevos_nombres', apellido_paterno='$nuevo_apellido_paterno', apellido_materno='$nuevo_apellido_materno', direccion='$nueva_direccion' WHERE id_clientes='$id_cliente_a_modificar'";

    $resultado_update = mysqli_query($conexion, $sql_update);

    if ($resultado_update) {
        echo "<script>alert('Cliente modificado exitosamente'); window.location.href='modificarClientes.php';</script>";
    } else {
        echo "Mensaje: 'Error al modificar el cliente: " . mysqli_error($conexion) . "'";
    }
}
// --- Fin Lógica para modificar cliente (almacenar datos) ---

// --- Lógica para buscar y listar ---
$clientes_lista = array();
$busqueda = "";

if (isset($_POST['buscar']) && $_POST['buscar'] == 1) {
    $busqueda = isset($_POST['busqueda_general']) ? mysqli_real_escape_string($conexion, $_POST['busqueda_general']) : "";
    $clientes_lista = consulta_clientes($conexion, $busqueda);
} else {
    // Si no se ha buscado, listar todos los clientes
    $clientes_lista = consulta_clientes($conexion);
}

// --- Lógica para mostrar formulario de modificación ---
$cliente_a_modificar = null;
if (isset($_POST['modificar']) && $_POST['modificar'] == 1) {
    $id_a_modificar = $_POST['id_clientes'];

    // Consulta para obtener los datos del cliente específico
    $sql_cliente = "SELECT * FROM clientes WHERE id_clientes = '$id_a_modificar'";
    $resultado_cliente = mysqli_query($conexion, $sql_cliente);

    if ($resultado_cliente && mysqli_num_rows($resultado_cliente) > 0) {
        $cliente_a_modificar = mysqli_fetch_assoc($resultado_cliente);
    } else {
        echo "Mensaje: 'Error al recuperar los datos del cliente'";
    }
}
// --- Fin Lógica para mostrar formulario de modificación ---
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Cliente</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .mensaje-exito {
            color: green;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <h1 style="text-align: center;">Modificar Cliente</h1>
    <hr>

    <?php
    if ($cliente_a_modificar) {
    // ------------------------------------------
    // --- Mostrar formulario para modificar ---
    // ------------------------------------------
    ?>
    <h2 style="text-align: center;">Modificar Cliente: <?php echo $cliente_a_modificar['nombres'] . " " . $cliente_a_modificar['apellido_paterno']; ?></h2>
    <form action="modificarClientes.php" method="post">
        <input type="hidden" name="modificar_cliente" value="1">
        <input type="hidden" name="id_clientes" value="<?php echo $cliente_a_modificar['id_clientes']; ?>">

        <p>
            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" value="<?php echo $cliente_a_modificar['nombres']; ?>" required>
        </p>
        <p>
            <label for="apellido_paterno">Apellido Paterno:</label>
            <input type="text" id="apellido_paterno" name="apellido_paterno" value="<?php echo $cliente_a_modificar['apellido_paterno']; ?>" required>
        </p>
        <p>
            <label for="apellido_materno">Apellido Materno:</label>
            <input type="text" id="apellido_materno" name="apellido_materno" value="<?php echo $cliente_a_modificar['apellido_materno']; ?>" required>
        </p>
        <p>
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" value="<?php echo $cliente_a_modificar['direccion']; ?>" required>
        </p>
        <p>
            <input type="submit" value="Guardar Cambios">
            <a href="modificarClientes.php">Cancelar Modificación</a>
        </p>
    </form>
    <hr>
    <?php
    }
    // ------------------------------------------
    // --- Fin Formulario para modificar ---
    // ------------------------------------------
    ?>

    <h2>Buscar Cliente</h2>
    <form action="modificarClientes.php" method="post">
        <input type="hidden" name="buscar" value="1">
        <input type="text" name="busqueda_general" placeholder="Buscar por nombre o apellido" value="<?php echo htmlspecialchars($busqueda); ?>">
        <input type="submit" value="Buscar">
        <a href="modificarClientes.php">Mostrar Todos</a>
    </form>
    <hr>

    <h2>Lista de Clientes</h2>
    <?php
    if (!empty($clientes_lista)) {
    ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Dirección</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($clientes_lista as $cliente) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($cliente['id_clientes']) . "</td>";
                echo "<td>" . htmlspecialchars($cliente['nombres']) . "</td>";
                echo "<td>" . htmlspecialchars($cliente['apellido_paterno']) . "</td>";
                echo "<td>" . htmlspecialchars($cliente['apellido_materno']) . "</td>";
                echo "<td>" . htmlspecialchars($cliente['direccion']) . "</td>";
                echo "<td>";
                echo "<form action='modificarClientes.php' method='post' style='display:inline;'>";
                echo "<input type='hidden' name='modificar' value='1'>";
                echo "<input type='hidden' name='id_clientes' value='" . htmlspecialchars($cliente['id_clientes']) . "'>";
                echo "<input type='submit' value='Modificar'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    } else {
        echo "<p>No se encontraron registros.</p>";
    }
    ?>

    <hr>
    <p>
        <a href="listarClientes.php">Volver a Lista de Clientes</a> |
        <a href="adicionarClientes.php">Adicionar</a> |
        <a href="eliminarClientes.php">Eliminar</a>
    </p>

</body>
</html>

<?php
// Cerrar la conexión al final del script
mysqli_close($conexion);
?>