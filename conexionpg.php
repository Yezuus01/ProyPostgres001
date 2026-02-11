<?php
// Definición de variables para la conexión a la base de datos
$servidor="localhost";
$baseDatos="udesdb";
$puerto="5432";
$usuario="postgres";
$contraseña="12345";
$conexion=("host=$servidor port=$puerto dbname=$baseDatos user=$usuario password=$contraseña");
$conectar=pg_connect($conexion) or die ("error en la conexion");
//echo("se conecto a la BD correctamente <br>");//CONSULTA
//$query="SELECT id_estudiantes, nombres, apellido_paterno, apellido_materno, ci, direccion, rude, fecha_de_nacimiento FROM estudiantes ORDER BY id_estudiantes ASC";
//$resultado=pg_query($conectar, $query);
//if ($resultado){
//    die("error en la consulta");
//}
?>