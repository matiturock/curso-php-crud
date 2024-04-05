<!--
  1. Crear una base de datos BD_camila
  2. Crear las tablas de laboratorios
    Campos
    cod_laboratorio numerico entero 4 autoincrementable y clave principal
    nom_laboratorio varchar
  3. Tabla equipos
    Campos:
    cod_equipos numerico entero 4 autoincrementable y clave principal
    descripcion varchar
    Serie vachar
    laboratorio entero 4
  4. Hacerlo formularios, para registrar cada equipo (con su descripción, numero de serie y el laboratorio en la cual se encuentra que deberá ser un deplegable cargado con los datos de la tabla laboratorio
  5. Diseñar 2 botones

  PASOS PARA SOLUCIONAR EL PROBLEMA
  Lo mejor es encarar el problema por partes, y a cada paso dado, validar que lo implementado funcione de forma correcta. En caso de obtener un error, leer la traza del mismo y revisar la línea de código que PHP dice que está la fuente del problema.

  1. Crear la base de datos, con el nombre bd_camila
  2. Crear la tabla de "laboratorios" con los campos que pide la consigna
  3. Crear la tabla de equipos, con los campos que pide la consigna
  4. Crear la relación entre tablas, desde la tabla "equipos" en su campo "laboratorio" hacia la tabla "labotaroios" en su campo "cod_laboratorio". Para ello hay que ir a la tabla "equipos" / Estructura / Vista de relaciones y crear la restriccion completando los campos de esa vista. En resumene, vamos a obtener que sólo se puede completar el campo "equipos.laboratorio" con los "cod_laboratorio" cargados en la tabla de "laboratorios".
  5. Una vez creadas las tablas y relaciones, cargar registros de ejemplo para contorlar que todo funcione de forma correcta.
  6. Crear el archivo index.php donde se van a crear las vistas que pide la consigna.
  7. Decidir qué vistas se van a crear y en qué orden. Se puede dibujar en un lápiz y papel, o Paint, las vistas a crear. En nuestro caso vamos a crear 3 cosas:
    a. Formulario de creación de registros de equipo
    b. Tabla que Equipos
    c. Tabla de Laboratorios
  8. Como nuestras acciones van a ser un CRUD (crear, leer, actualizar y borrar registros) sobre una base de datos, debemos arrancar establecientdo la conexión a la base de datos, lo hacemos mediante esta linea de codigo:
  ->  $conexion = mysqli_connect("localhost", "root", "", "bd_camila") or die("Algi sakui mal durante la conxión a la base de datos");
  Ahora tenemos guardada en la variable $conexion el enlace desde nuestro código a la base de datos, por lo que ya podemos realizar consultas.
  9. Creación de tablas. Como lo más fácil en principío es leer los registros, vamos a crear las tablas de Laboratorios y Equipos para rellenarlas con los registros de la base de datos. Para ello creamos las tablas, con la cantidad correcta de columnas (tantas columnas como tenga nuestra tabla en la base de datos) y con la función "mysqli_query" ejecutamos la consulta que se guarda en la variable $resultado y con la función "mysqli_fetch_array" y un bucle while transformamos ese $resultado de la consulta en un array de registros que podemos recorrer una a uno. Entonces, por cada registro creamos de forma programática (es decir de forma dinámica) una fila nueva en la tabla.
  10. Hasta acá debemos tener creadas las tablas de Laboratorios y Equipos, ahora toca crear el formulario de creación de Equipos. Para ello creamos la estructura HTML de formulario con el método POST, más los inputs necesarios para que el usuario cargue los valores para crear un registro en la tabla Equipos y el botón de tipo "submit" para generar disparar la solicitud. Importante agergar el atributo "require" (requerido) que obliga al usuario a rellenar el campo con un valor antes de enviar, sino puede enviar valores que son nulos o vaíos.
  11. Dato a tener en cuenta, el campo de labotarotios es uno de tipo select (https://developer.mozilla.org/es/docs/Web/HTML/Element/select), y debe presentar los nombres de los registros de la tabla "laboratorios", entonces se crea la consulta a esa tabla, y rellena de forma programática las opciones que puede el ususario seleccionar.
  12. Una vez armado el formulario, debemos crear la lógica encargada de tomar los datos del usuario y volcarlos en una consulta SQL, ver código comentado para el paso a paso en CREAR REGISTRO EN EQUIPOS.
  13. Ahora sólo queda poder borrar y modificar el registro. Para borrar un registro de la tabla de Equipos, vamos a valernos de una columna más en la tabla que contenga los links (o botones) para las acciones. Las acciones serían BORRAR y MODIFICIAR.
  14. Para borrar un registro, vamos a obtener su cod_equipo (llave primaria) mediante la URL. La URL tiene las siguientse partes: https://youtu.be/1hpc70_OoAg?t=18608
  15. Para obtener el $cod_equipo correspondiente a cada registro, le pasamos en el atributo href='./?id=$cod_equipos', lo que nos redirige a la misma
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laboratorios</title>
  <style>
    :root {
      font-family: Rubik, sans-serif;
    }
  </style>
</head>

<body class="container">
  <?php
  $conexion = mysqli_connect("localhost", "root", "", "bd_camila");
  if (isset($conexion)) {
    echo "Conexion a base de datos establecida.";
    echo "<hr>";
  } else {
    die("Algo salio mal durante la conxión a la base de datos: $conexion");
  }

  ?>
  <h1>Laboratorios y Equipos</h1>
  <p>Formulario, Leer y Botón de <strong>Guardar</strong> y <strong>Borrar</strong></p>
  <hr>

  <?php

  // CREAR REGISTRO EN EQUIPOS
  if (isset($_POST["guardar"])) { // validamos que el array $_POST venga cargado
    // recperamos los valores del array $_POST, como se las claves de los elementos se llaman igual que los nombres puestos en los atributos de los elementos inputs HTML del formulario
    $descripcion = $_POST["descripcion"];
    $serie = $_POST["serie"];
    $cod_laboratorio = $_POST["cod_laboratorio"];

    // Creamos la consulta, para ello se puede copiar y pegar la consulta que se genera dsede phpmyadmin para estar seguros de que no se cometen errores, mediante la concatenación de strings, se hace referencia a los valores capturados arriba para insertarlos en la consulta. En este caso con $descripcion, $serie y $cod_laboratorio
    $consulta = "INSERT INTO `equipos` (`cod_equipos`, `descripcion`, `serie`, `cod_laboratorio`) VALUES (NULL, '$descripcion', '$serie', '$cod_laboratorio')";
    // Corremos la consulta
    $resultado_guardar_equipos = mysqli_query($conexion, $consulta);
    // Validamos el resultado de la consulta, si todo fue bien mostramos un mensaje de "Registro creado"
    if ($resultado_guardar_equipos) {
      echo "<i>Se guardo el registro de equipos con exito</i></br>";
    } else {
      die("Algo salio mal al guardar el registro en equipos: $resultado_guardar_equipos");
    }
  }

  // BORRAR REGISTRO DE TABLA EQUIPOS
  if (isset($_GET["id"])) {
    $cod_equipos = $_GET["id"];
    $consulta = "DELETE FROM equipos WHERE `equipos`.`cod_equipos` = $cod_equipos";
    $resultado_borrar_registro_equipo = mysqli_query($conexion, $consulta);

    if (!$resultado_borrar_registro_equipo) {
      die("Algo salio mal: $resultado_borrar_registro_equipo");
    }
  }

  ?>

  <h2>Form de registro de Equipo</h2>
  <form action="" method="post">
    <div>
      <label for="descripcion">Descripción:</label>
      <input type="text" name="descripcion" require>
    </div>
    <div>
      <label for="serie">Número de serie:</label>
      <input type="numero" name="serie" require>
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
      <button type="submit" name="guardar">Guardar</button>
    </div>

  </form>

  <hr>

  <h2>Tabla de Equipos</h2>

  <table>
    <thead>
      <tr>
        <th>cod_equipos</th>
        <th>descripcion</th>
        <th>serie</th>
        <th>cod_laboratorio</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Necesitamos recuperar los registros de la tabla EQUIPOS para poder rellenar la tabla, por lo tanto armamos la consulta
      $consulta = "SELECT * FROM `equipos`";
      // Corremos la consulta
      $resultado_equipos = mysqli_query($conexion, $consulta);

      // Validamos la consulta
      if ($resultado_equipos) {
        // Iteramos el array de registros que trae la respuesta de la consulta, la función mysqli_fetch_array consigue los registros a iterar de $resultado_equios que se guarda en la variable temporal $equipo. Cada variable $equipo, por lo tanto, guarda un registro de la tabla en cada vuelta de la iteración.
        while ($equipo = mysqli_fetch_array($resultado_equipos)) {
          // Recuperamos los valores de los campos, ya que cada registro es una array de valores
          $cod_equipos  = $equipo["cod_equipos"];
          $descripcion = $equipo["descripcion"];
          $serie = $equipo["serie"];
          $cod_laboratorio = $equipo["cod_laboratorio"];
          // Con echo creamos los elementos HTML correspondondientes a la tabla, para rellenarla con los valores que vienen desde la base de datos
          echo "<tr>";
          echo "<td>$cod_equipos </td>";
          echo "<td>$descripcion</td>";
          echo "<td>$serie</td>";
          echo "<td>$cod_laboratorio </td>";
          echo "<td><a href='./actualizar.php?id=$cod_equipos'>Actualizar</a> <a href='?id=$cod_equipos'>Borrar</a></td>";
          echo "</tr>";
        }
      } else {
        die("Algo salio mal en la consulta:  $resultado_equipos");
      }

      ?>
    </tbody>
  </table>

  <hr>

  <h2>Tabla de Laboratorios</h2>

  <table>
    <thead>
      <tr>
        <th>cod_laboratorios</th>
        <th>nom_laboratorios</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Acá tenemos la misma situación que la tabla de arriba, sólo que esta vez rellenamos la tabla con los registros provenientes de la tabla de "Laboratorios". Los pasos son los mismos: crear la consulta, correr la consulta, validar el resultado, recorrer los elementos del resultado, crear los elementos de tabla que se van a rellenar con los valores obtenidos de la base de datos
      $consulta = "SELECT * FROM `laboratorios`";
      $resultado_personas = mysqli_query($conexion, $consulta);

      while ($laboratorios = mysqli_fetch_array($resultado_personas)) {
        $cod_laboratorio = $laboratorios["cod_laboratorio"];
        $nom_laboratorio = $laboratorios["nom_laboratorio"];
        echo "<tr>";
        echo "<td>$cod_laboratorio</td>";
        echo "<td>$nom_laboratorio</td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</body>

</html>