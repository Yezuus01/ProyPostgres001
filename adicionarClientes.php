<?php
// 1. Definición de variables para la conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "udesDB"; // Base de datos cambiada a udesDB

// 2. Establecer conexión con el servidor MySQL
$conexion = mysqli_connect($servidor, $usuario, $contrasena, $bd) or die("Error: No se pudo conectar al servidor. Verifique la configuración de la BD udesDB.");
mysqli_set_charset($conexion, "utf8");

// Variable para mensajes de estado
$mensaje_estado = "";

// 3. Lógica para Adicionar (Insertar) un nuevo cliente
if (isset($_POST['adicionar']) && $_POST['adicionar'] == 1) {
    // Sanitizar y obtener los datos del formulario
    $nombres = mysqli_real_escape_string($conexion, $_POST['nombres']);
    $apellido_paterno = mysqli_real_escape_string($conexion, $_POST['apellido_paterno']);
    $apellido_materno = mysqli_real_escape_string($conexion, $_POST['apellido_materno']);
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);

    // Consulta SQL para insertar el nuevo cliente
    $sql_insert = "INSERT INTO clientes (nombres, apellido_paterno, apellido_materno, direccion) 
                   VALUES ('$nombres', '$apellido_paterno', '$apellido_materno', '$direccion')";
    
    $resultado_insert = mysqli_query($conexion, $sql_insert);

    if ($resultado_insert) {
        $mensaje_estado = "<p style='color: green; font-weight: bold;'>✅ Cliente agregado exitosamente.</p>";
        // Limpiar las variables del formulario para que los campos queden vacíos
        $nombres = $apellido_paterno = $apellido_materno = $direccion = "";
    } else {
        $mensaje_estado = "<p style='color: red; font-weight: bold;'>❌ Error al adicionar el cliente: " . mysqli_error($conexion) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Adicionar Cliente</title>
</head>
<body>

    <h1 style="text-align: center;">Adicionar Nuevo Cliente</h1>
    <hr>

    <?php echo $mensaje_estado; ?>

    <form action="adicionarClientes.php" method="post">
        <input type="hidden" name="adicionar" value="1">
        
        <p>
            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" value="<?php echo isset($nombres) ? htmlspecialchars($nombres) : ''; ?>" required>
        </p>
        <p>
            <label for="apellido_paterno">Apellido Paterno:</label>
            <input type="text" id="apellido_paterno" name="apellido_paterno" value="<?php echo isset($apellido_paterno) ? htmlspecialchars($apellido_paterno) : ''; ?>" required>
        </p>
        <p>
            <label for="apellido_materno">Apellido Materno:</label>
            <input type="text" id="apellido_materno" name="apellido_materno" value="<?php echo isset($apellido_materno) ? htmlspecialchars($apellido_materno) : ''; ?>" required>
        </p>
        <p>
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" value="<?php echo isset($direccion) ? htmlspecialchars($direccion) : ''; ?>" required>
        </p>
        
        <p>
            <input type="submit" value="Guardar Cliente">
        </p>
    </form>
    <hr>
    
    <p>
        <a href="listarClientes.php">Volver a Lista de Clientes</a> |
        <a href="eliminarClientes.php">Eliminar Clientes</a>
    </p>

</body>
</html>

<?php
// 6. Cerrar la conexión
mysqli_close($conexion);
?>