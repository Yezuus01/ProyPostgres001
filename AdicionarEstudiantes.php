<?php
require_once 'conexionpg.php';


//Verificar si se ha enviado el formulario
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $nombres = $_POST['nombres'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $ci = $_POST['ci'];
    $direccion = $_POST['direccion'];
    $rude = $_POST['rude'];
    $fecha_de_nacimiento = $_POST['fecha_de_nacimiento'];

    //Consulta SQL para insertar datos
    $sql = "INSERT INTO estudiantes (nombres, apellido_paterno, apellido_materno, ci, direccion, rude, fecha_de_nacimiento) VALUES('$nombres','$apellido_paterno', '$apellido_materno','$ci', '$direccion', '$rude', '$fecha_de_nacimiento')" ;

    //Ejecutar la consulta
    if (pg_query($conectar, $sql)) {
        echo "<p>Estudiante agregado correctamente.</p>";
    } else {
        echo "Error: " . $sql . "<br>" . pg_last_error($conectar);
    }
}

pg_close($conectar);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Estudiantes</title>
    <link rel="stylesheet" href="misestilos.css">

</head>
<body>
    <h2>Adicionar Nuevo Estudiante</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="nombres">Nombres:</label><br>
        <input type="text" id="nombres" name="nombres" required><br><br>

        <label for="apellido_paterno">Apellido Paterno:</label><br>
        <input type="text" id="apellido_paterno" name="apellido_paterno" required><br><br>

        <label for="apellido_materno">Apellido Materno:</label><br>
        <input type="text" id="apellido_materno" name="apellido_materno" required><br><br>

        <label for="ci">CI:</label><br>
        <input type="number" id="ci" name="ci" required><br><br>

        <label for="direccion">Direccion:</label><br>
        <input type="text" id="direccion" name="direccion" required><br><br>

        <label for="fecha_de_nacimiento">Fecha de Nacimiento:</label><br>
        <input type="date" id="fecha_de_nacimiento" name="fecha_de_nacimiento" required><br><br>
        
        <label for="rude">RUDE:</label><br>
        <input type="number" id="rude" name="rude" required><br><br>

        <input type="submit" values="Adicionar Estudiante">
    </form>
    <br>
    <a href="estudiantes.php">Ver lista de Estudiantes</a>
</body>
</html>