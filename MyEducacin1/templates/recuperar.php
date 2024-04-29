<?php
// Verificar si se ha enviado el formulario de recuperación de contraseña
if(isset($_POST['resetPassword'])) {
    // Obtener el correo electrónico ingresado en el formulario
    $email = $_POST['email'];

    // Aquí puedes agregar tu lógica para procesar la solicitud de recuperación de contraseña

    // Por ejemplo, puedes enviar un correo electrónico al usuario con un enlace para restablecer la contraseña

    // Redireccionar al usuario a una página de éxito o mostrar un mensaje de éxito en la misma página
    $msg = "Se ha enviado un correo electrónico con las instrucciones para restablecer la contraseña.";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="../recursos/css/recupar.css">
</head>
<body>
    <div class="container">
        <form action="reset-password.php" class="password-recovery-form" method="post">
            <h2 class="title">Recuperar Contraseña</h2>
            <?php if(isset($msg)): ?>
                <div class="notification"><?php echo $msg; ?></div>
            <?php else: ?>
                <div class="notification">Se ha enviado un mensaje de confirmación a tu correo electrónico.</div>
            <?php endif; ?>
            <div class="input-field" style="margin-right: 70px;">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Correo electrónico" name="email" required>
            </div>
            <input type="submit" name="resetPassword" value="Recuperar Contraseña" class="submit-btn">
            <p class="login-link">¿Recuerdas tu contraseña? <a href="login.php">Inicia sesión</a></p>
        </form>
    </div>
</body>
</html>

