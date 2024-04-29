<?php
include("../private/Config.php");

if (!empty($_POST["registrarme"])){
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $repassword = $_POST['repassword'];
  $genero = $_POST['genero'];
  $edad = $_POST['edad'];

  if (empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"]) ||
      empty($_POST["repassword"]) || empty($_POST["genero"]) || empty($_POST["edad"])){
    $msg = 'Complete todos los campos.';
  }else if ($password != $repassword) {
    $msg = 'Las contraseñas no coinciden.';
  }else if (strlen($password) < 8){
    $msg = 'La contraseña debe tener al menos 8 caracteres.';
  }else{
    $sql = $connect->query("INSERT INTO usuarios (nombre, email, passwords, genero, edad) VALUES ('$username','$email','$password','$genero','$edad')");

    if($sql){
      $msg = 'Registrado correctamente.';
      header("Location: homepage.php");
      exit();
    }else{
      $msg = 'Ocurrió un error al registrarse.';
    }
  }
}
?>

<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script
    src="https://kit.fontawesome.com/64d58efce2.js"
    crossorigin="anonymous"
  ></script>
  <link href="https://fonts.googleapis.com/css?family=Comic+Sans+MS" rel="stylesheet">
  <link rel="stylesheet" href="../recursos/css/login.css" />
  <title>Registrarme</title>
</head>
<body>
  <div class="container">
    <div class="wave" style="height: 721px; overflow: hidden;" ><svg class="wave" viewBox="0 0 500 150" preserveAspectRatio="none" 
      style="height: 100%; width: 100%;"><path d="M159.37,-2.66 C115.35,75.09 199.99,70.16 155.42,153.83 L-0.00,149.60 L-0.00,-0.00 Z" 
      style="stroke: none; fill: #08f;"></path></svg>
    <div class="forms-container">
      <div class="signin-signup">
        <form action="#" class="sign-in-form" method="post">
          <h2 class="title">Regístrate</h2>

          <?php if(isset($msg)): ?>
            <div id="notification" class="notification" style="background: red; color:black; heigth: 20px; width: 300px; justify-content: center; text-align: center; align-items: center; border-radius: 5px;"><?php echo $msg; ?></div>
            <script>
              // Agregar JavaScript para ocultar la notificación después de cierto tiempo
              setTimeout(function() {
                  var notification = document.getElementById('notification');
                  if (notification) {
                      notification.style.display = 'none';
                      window.location.hash = '';
                  }
              }, 5000); // 5000 milisegundos (5 segundos)
            </script>
          <?php endif; ?>

          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Username" name="username"/>
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" name="email" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="password" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirm Password" name="repassword" />
          </div>
          <div class="input-field">
              <i class="fas fa-venus-mars"></i>
              <input type="text" placeholder="Genero" name="genero" />
          </div>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Edad" name="edad"/>
          </div>
          <input type="submit" name="registrarme" value="Registrarme" style="width: 150px; background-color: #5995fd; border: none;
          outline: none; height: 49px; border-radius: 49px; color: #fff; text-transform: uppercase; font-weight: 600; margin: 10px 0;
          cursor: pointer; transition: 0.5s;"/>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>¿Ya eres uno de nosotros?</h3>
          <a href="login.php" class="btn transparent" style="display: inline-block;
            padding: 10px 20px;
            background-color: #155acb;
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            border: none;">Iniciar Sesión</a>
          <!--<div class="iconos a">
            <div style="margin-top: 30px; margin-left: 210px;" class="circul-g"></div>
            <div class="boton_g">
                <img src="../recursos/img/icon_google.svg" alt="">
                <span>Google</span>
            </div>
        </div>-->
        </div>
      </div>
    </div>
  </div>

  <script src="../recursos/app.js"></script>
</body>
</html>
