<?php
// 1. Definición de variables para la conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "udesDB"; // Base de datos udesDB

// 2. Establecer conexión con el servidor MySQL
$conexion = mysqli_connect($servidor, $usuario, $contrasena, $bd) or die("Error: No se pudo conectar al servidor.");
mysqli_set_charset($conexion, "utf8");

// 3. Consulta para obtener todos los clientes
$sql = "SELECT id_clientes, nombres, apellido_paterno, apellido_materno, direccion FROM clientes ORDER BY id_clientes ASC";

$resultado = mysqli_query($conexion, $sql);

// Verificar si la consulta fue exitosa
if (!$resultado) {
    die("Error al consultar clientes: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1, p {
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>📝 Lista de Clientes</h1>
    <hr>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 5. Iterar sobre los resultados y mostrar en la tabla
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($fila['id_clientes']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['nombres']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['apellido_paterno']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['apellido_materno']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['direccion']) . "</td>";
                    
                    // Columna de Acciones: Aquí se suelen poner botones para Modificar o Eliminar
                    echo "<td>";
                    
                    // Enlace/Formulario para modificar
                    echo "<form action='modificarClientes.php' method='post' style='display: inline; margin-right: 5px;'>";
                    echo "<input type='hidden' name='id_clientes' value='" . htmlspecialchars($fila['id_clientes']) . "'>";
                    echo "<input type='hidden' name='modificar' value='1'>";
                    echo "<input type='submit' value='Modificar'>";
                    echo "</form>";

                    // Puedes añadir un enlace directo a eliminar.php aquí si es necesario
                    // Ejemplo de enlace a eliminar:
                    // echo "<a href='eliminarClientes.php?id=" . htmlspecialchars($fila['id_clientes']) . "'>Eliminar</a>";

                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align: center;'>No se encontraron clientes registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <hr>
    
    <p>
        <a href="adicionarClientes.php">➕ Adicionar Nuevo Cliente</a> |
        <a href="modificarClientes.php">✏️ Modificar Clientes</a> |
        <a href="eliminarClientes.php">🗑️ Eliminar Clientes</a>
    </p>

</body>
</html>

<?php
// 7. Liberar resultados y cerrar la conexión
mysqli_free_result($resultado);
mysqli_close($conexion);
?>