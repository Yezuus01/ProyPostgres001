<?php
require_once 'conexionpg.php';
//CONSULTA
$query="SELECT id_estudiantes, nombres, apellido_paterno, apellido_materno, ci, direccion, rude, fecha_de_nacimiento FROM estudiantes ORDER BY id_estudiantes ASC";

$resultado=pg_query($conectar, $query);
if (!$resultado){
    die(" error en la consulta");
    
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>listado de estudiantes</title>
    <link rel="stylesheet" href="misestilos.css">

</head>
<body>
    <h2>listado de estudiantes</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nombres</th>         
        <th>Apellido_paterno</th>
        <th>Apellido_materno</th>
        <th>CI</th>        
        <th>Direccion</th>
        <th>RUDE</th>
        <th>Fecha_de_nacimiento</th> </tr> 
<?php
while($fila=pg_fetch_assoc($resultado)){
    echo "<tr>";
    echo "<td>".$fila['id_estudiantes']."</td>";
    echo "<td>".$fila['nombres']."</td>";
    echo "<td>".$fila['apellido_paterno']."</td>";
    echo "<td>".$fila['apellido_materno']."</td>";
    echo "<td>".$fila['ci']."</td>";
    echo "<td>".$fila['direccion']."</td>";
    echo "<td>".$fila['rude']."</td>";
    echo "<td>".$fila['fecha_de_nacimiento']."</td>";
    echo "</tr>";

}?> 
</table> 
</body> 
</html>

// cerrar la conexion
<?php
pg_close($conectar);
?>

    

                 







 