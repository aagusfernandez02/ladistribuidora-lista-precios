<?php
session_start();

require_once('php/component.php');
require_once('php/CreateDB.php');

$db_productos = new CreateDB(
  "ladistribuidora",
  "productos",
  "localhost",
  "root",
  "",
  "CREATE TABLE IF NOT EXISTS productos
  (id INT(10)NOT NULL AUTO_INCREMENT PRIMARY KEY,
  producto VARCHAR(100) NOT NULL,
  presentacion VARCHAR(100) NOT NULL,
  precio INT(6) NOT NULL,
  marca VARCHAR(100) NOT NULL,
  img VARCHAR(500) NOT NULL);"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>La Distribuidora</title>

  <!-- CSS RESET -->
  <link rel="stylesheet" href="styles/reset.css">
  <!-- FONTAWESOME -->
  <script src="https://kit.fontawesome.com/8d1cfe94fb.js" crossorigin="anonymous"></script>
  <!-- FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <!-- TOASTS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- CSS -->
  <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
  <header>
    <a href="#" class="logo">La<span class="logo_negrita">Distribuidora</span></a>
    <?php 
    if( isset($_SESSION['admin']) AND $_SESSION['admin']==true ){
      echo '
        <div>
          <button type="button" data-bs-toggle="modal" data-bs-target="#modal-new-product" class="login me-4"><i class="fa-solid fa-circle-plus"></i></button>
          <a href="php/logout.php" class="login"><i class="fa-solid fa-backward"></i></a>
        </div>';
    } else {
      echo '<button type="button" data-bs-toggle="modal" data-bs-target="#modal-login" class="login"><i class="fa-solid fa-user-lock"></i></button>';
    }
    ?>
  </header>
  <!-- Modal new product -->
  <div class="modal fade" id="modal-new-product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">NUEVO PRODUCTO</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="php/create_product.php" method="POST"  enctype="multipart/form-data">
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text" id="inputGroup-sizing-sm">Producto</span>
              <input type="text" class="form-control" name="producto" required>
            </div>
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text" id="inputGroup-sizing-sm">Presentación</span>
              <input type="text" class="form-control" name="presentacion" required>
            </div>
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text" id="inputGroup-sizing-sm">Precio</span>
              <input type="number" class="form-control" name="precio" required>
            </div>
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text" id="inputGroup-sizing-sm">Marca</span>
              <input type="text" class="form-control" name="marca" required>
            </div>
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text" id="inputGroup-sizing-sm">Imagen</span>
              <input type="file" class="form-control" name="img" required>
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-success">Crear producto</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal login -->
  <div class="modal fade" id="modal-login" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">INICIAR SESIÓN (Solo ADMIN)</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="php/login.php" method="POST">
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text" id="inputGroup-sizing-sm">DNI</span>
              <input type="text" minlength="8" maxlength="8" class="form-control" name="dni" required>
            </div>
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text" id="inputGroup-sizing-sm">Contraseña</span>
              <input type="password" class="form-control" name="contrasenia" required>
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-success">Iniciar sesión</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <main>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr class="table-secondary">
            <th scope="col">Imagen</th>
            <th scope="col">Producto</th>
            <th scope="col">Presentación</th>
            <th scope="col">Precio</th>
            <?php 
              if( isset($_SESSION['admin']) AND $_SESSION['admin']==true ){
                echo '                
                  <th scope="col"></th>
                  <th scope="col"></th>';
              }
            ?>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $db_productos->getProducts();
          while ($row = mysqli_fetch_assoc($result)) {
            component($row['img'], $row['producto'], $row['presentacion'], $row['precio']);
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <!-- JQUERY -->
  <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
  <!-- BOOTSTRAP -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  <!-- TOASTS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- JS -->
  <?php
  if (isset($_SESSION['estado_login']) && $_SESSION['estado_login'] == "LOGIN_OK") {
    $_SESSION['estado_login'] = null;
    
    echo "<script>
    toastr.options = {'positionClass': 'toast-top-center'};
    toastr.success('Control de administrador','LOGIN OK')
    </script>";
  }
  if (isset($_SESSION['estado_login']) && $_SESSION['estado_login'] == "LOGIN_FAIL") {
    $_SESSION['estado_login'] = null;
    echo "<script>
    toastr.options = {'positionClass': 'toast-top-center'};
    toastr.error('Credenciales incorrectas','ERROR');
    </script>";
  }
  if (isset($_SESSION['estado_login']) && $_SESSION['estado_login'] == "LOGOUT") {
    $_SESSION['estado_login'] = null;
    echo "<script>
    toastr.options = {'positionClass': 'toast-top-center'};
    toastr.success('Ha salido del control de administrador');
    </script>";
  }
  ?>
</body>

</html>