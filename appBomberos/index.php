<?php
session_start();

// Si ya está logueado, redirigir
if (isset($_SESSION['usuario'])) {
    header("Location: inicio.php");
    exit;
}

// Si envían el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($usuario) && !empty($password)) {
        $_SESSION['usuario'] = $usuario;
        header("Location: inicio.php");
        exit;
    } else {
        $error = "Por favor, ingrese usuario y contraseña.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Sistema Bomberos</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="dark">
  <button id="toggletheme">☀️</button>

  <div id="login" class="container">
    <div class="card">
      <div class="header">
        <img src="img/logoBombero.png" alt="Logo de bomberos" width="150" height="150">
      </div>

      <div class="form">
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

        <form method="POST">
          <label>Usuario</label>
          <input type="text" name="username" placeholder="Ingrese su usuario">

          <label>Contraseña</label>
          <input type="password" name="password" placeholder="Ingrese su contraseña">

          <button type="submit" id="login-btn">Iniciar Sesión</button>
        </form>

        <p class="info">(use cualquier usuario/contraseña)</p>
      </div>

    </div>
  </div>

  <script>
    let isDark = true;
    const toggletheme = document.getElementById('toggletheme');

    toggletheme.addEventListener('click', () => {
      isDark = !isDark;
      document.body.className = isDark ? 'dark' : 'light';
      toggletheme.textContent = isDark ? '☀️' : '🌙';
    });
  </script>

</body>
</html>
