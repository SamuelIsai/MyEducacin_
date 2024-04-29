<?php
session_start();

require_once('../private/Config.php'); // Asegúrate de que este archivo contiene la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo_ingresado = $_POST['email'];
    $contrasena_ingresada = $_POST['password'];

    $msg = "";

    if (empty($correo_ingresado) || empty($contrasena_ingresada)) {
        $msg = "Por favor, completa todos los campos.";
    } else {
        // Consulta a la base de datos para verificar las credenciales
        $consulta = "SELECT id, email, passwords, rol FROM usuarios WHERE email = ? AND passwords = ?";
        $stmt = $mysqli->prepare($consulta);

        if ($stmt) {
            $stmt->bind_param("ss", $correo_ingresado, $contrasena_ingresada);
            $stmt->execute();

            $stmt->bind_result($id, $email, $password, $rol);
            $stmt->fetch();

            if ($email) {
                $_SESSION['usuario'] = [
                    'id' => $id,
                    'email' => $email,
                    'rol' => $rol
                ];

                $_SESSION['sesion_iniciada'] = true;

                // Verificar el rol del usuario y redirigir a la vista correspondiente
                if ($rol == 'admin') {
                    header("Location: vista_admin.php");
                } else {
                    
                    header("Location: homepage.php");
                }

                exit();
            } else {
                $msg = "Los datos ingresados no coinciden.";
            }

            $stmt->close();
        } else {
            die("Error en la preparación de la consulta: " . $mysqli->error);
        }
    }
}
?>



<!DOCTYPE html>
<body>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"
    ></script>
    <link href="https://fonts.googleapis.com/css?family=Comic+Sans+MS" rel="stylesheet">
    <link rel="stylesheet" href="../recursos/css/login.css">
    <title>Login</title>
  </head>
  <body>
    <div class="container">
      <div class="wave" style="height: 721px; overflow: hidden;" ><svg class="wave" viewBox="0 0 500 150" preserveAspectRatio="none" 
        style="height: 100%; width: 100%;"><path d="M159.37,-2.66 C115.35,75.09 199.99,70.16 155.42,153.83 L-0.00,149.60 L-0.00,-0.00 Z" 
        style="stroke: none; fill: #08f;"></path></svg>
      <div class="forms-container">
      <p style="margin-left: 100px; margin-top: 300px; font-size: 25px; color: #fff;">¿Aun no tienes cuenta?</p>
      <div>
        <input style="background: #fff; border: none; border-radius: 20px; padding: 10px 40px; margin-top: 40px; margin-left: 150px; cursor:pointer;" type="submit" value="Registrarme" onclick="redirectToRegistrar()">
      </div>
        <div class="signin-signup">
        <form action="#" class="sign-in-form" method="post">
        <h2 class="title">Iniciar sesión</h2>
        
        <?php if(isset($msg)): ?>
           <div id="notification" class="notification" style="background: red; color:black; heigth: 20px; width: 250px; justify-content: center;align-items: center; border-radius:5px;"><?php echo $msg; ?></div>
           <script>
          // Agregar JavaScript para ocultar la notificación después de cierto tiempo
          setTimeout(function() {
            var notification = document.getElementById('notification');
            if (notification) {
              notification.style.display = 'none';
            }
          }, 5000); // 5000 milisegundos (5 segundos)
          </script>
        <?php endif; ?>

        <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Correo" name="email" />
        </div>
        <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Contraseña" name="password" />
        </div>
        <!--<a class="recuperar" href="recuperar.php">¿Haz olvidado la contraseña?</a>-->
        
        <input type="submit" value="Iniciar Sesión" class="iniciar_sesion transparent"  style="border-radius: 50px; cursor:pointer;"/>
        
        <img class="image" src="../recursos/img/niñofinance_low (1).png" alt="">
        </form >

        </div>
      </div>

        <div class="panel left-panel">
          <div class="content">
            <h3>Eres nuevo?</h3>
            <p>
              ¡No te quedes afuera de la diversión! Regístrate ahora y descubre todo lo que tenemos para ti.
            </p>
            <a href="../templates/registar.php" style="display: inline-block;
            padding: 10px 20px;
            background-color: #155acb;
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            border: none;" class="boton-registro">Registrarme</a>
          </div>
        </div>
  

  </body>
  <script>
    function redirectToRegistrar() {
      // Redirige a la página de registro
      window.location.href = "registar.php"; // Asegúrate de que el nombre del archivo sea correcto
    }
  </script>
</html>
</body>
</html>