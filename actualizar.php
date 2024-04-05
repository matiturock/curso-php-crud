<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualizar registro de la Tabla Equipos</title>
  <style>
    body {
      font-family: Rubik, sans-serif;
    }
  </style>
</head>

<body>
  <h1>Actualizar registro de la tabla Equipos</h1>

  <?php
  $conexion = mysqli_connect("localhost", "root", "", "bd_camila") or die("Algi sakui mal durante la conxión a la base de datos");
  if (isset($conexion)) {
    echo "Conexion a base de datos establecida.";
    echo "<hr>";
  }

  // Trabajamos cuando el usuario le da clic al botón de Actualizar
  if (isset($_POST["actualizar"])) {
    $id = $_GET["id"];
    $descripcion = $_POST["descripcion"];
    $serie = $_POST["serie"];
    $cod_laboratorio = $_POST["cod_laboratorio"];

    $consulta = "UPDATE `equipos` SET `descripcion` = '$descripcion', `serie` = '$serie', `cod_laboratorio` = '$cod_laboratorio' WHERE `equipos`.`cod_equipos` = $id";
    $result = mysqli_query($conexion, $consulta);

    // Validamos si el resultado de la consulta fue exitoso
    if ($result) {
      // Si es exitoso, redirigimos a la página principal
      header("Location: index.php");
    } else {
      // Si no es exitoso, mostramos el mensaje de error
      die("Error al actualizar tarea: $result");
    }
  }
  ?>

  <!-- Creamos la vista de formulario para poder actualizar nuestro registro. Los campos deben estar completos en su atributo placeholder para que sepamos cuales eran los valores iniciales del registro -->
  <form action="" method="post">
    <?php
    $descripcion;
    $serie;
    $cod_laboratorio;
    if (isset($_GET["id"])) {
      $id = $_GET["id"];
      echo "Código de equipo=$id"; // Con esto validamos de que estamos obteniendo el ID correcto

      // Creamos la consulta para recurpear el registro específico para que podamos completar el atributo placeholder (opcional)
      $consulta = "SELECT * FROM equipos WHERE cod_equipos=$id";
      $resultado = mysqli_query($conexion, $consulta);

      // Validamos que el resultado de la consulta fue exitoso e igual a un registro
      if (mysqli_num_rows($resultado) == 1) {
        // Recuperamos los datos del registro
        $equipo = mysqli_fetch_array($resultado);
        // Recuperamos los valores de los campos del registro
        $descripcion = $equipo["descripcion"];
        $serie = $equipo["serie"];
        $cod_laboratorio = $equipo["cod_laboratorio"];
      } else {
        die("Error al actualizar el registro: $resultado");
      }
    }

    ?>
    <div>
      <label for="descripcion">Descripción:</label>
      <!-- Seteamos el placeholder -->
      <input type="text" name="descripcion" require placeholder="<?php echo $descripcion ?>">
    </div>
    <div>
      <label for="serie">Número de serie:</label>
      <!-- Seteamos el placeholder -->
      <input type="numero" name="serie" require placeholder="<?php echo $serie ?>">
    </div>
    <div>
      <label for="cod_laboratorio">Laboratorio PK</label>
      <select name="cod_laboratorio">

        <?php
        // Mostrar las materias en el desplegable
        $consulta = "SELECT * FROM `laboratorios`";
        $resultado_laboratorios = mysqli_query($conexion, $consulta);
        print_r($resultado_laboratorios);

        while ($laboratorio = mysqli_fetch_array($resultado_laboratorios)) {
          $cod_laboratorio  = $laboratorio['cod_laboratorio'];
          $nom_laboratorio = $laboratorio['nom_laboratorio'];
          echo "<option value='$cod_laboratorio'>$nom_laboratorio</option>";
        }
        ?>
      </select>
    </div>

    <div>
      <button type="submit" name="actualizar">Actualizar</button>
    </div>

  </form>
</body>

</html>