<?php
$usuarios = [
  'duenia',
  'gerente',
  'jefetaller',
  'tecnico1',
  'vendedor1',
  'jefeventas'
];

$hash = password_hash('123456', PASSWORD_DEFAULT);
echo "<h3>Ejemplo de hash válido: $hash</h3>";

$mysqli = new mysqli('sql10.freesqldatabase.com', 'sql10806623', '7BuYGRwXUt', 'sql10806623');
if ($mysqli->connect_error) {
  die('Error de conexión: ' . $mysqli->connect_error);
}

foreach ($usuarios as $usuario) {
  $hash = password_hash('123456', PASSWORD_DEFAULT);
  $sql = "UPDATE usuarios SET password='$hash' WHERE usuario='$usuario'";
  if ($mysqli->query($sql)) {
    echo "✅ Contraseña actualizada para $usuario<br>";
  } else {
    echo "❌ Error con $usuario: " . $mysqli->error . "<br>";
  }
}
