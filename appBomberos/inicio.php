<?php
session_start();

// Si NO hay usuario logueado, volver al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Gestión de Bomberos</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="dark">
  <div id="app">
    <header class="header-app">
      <div class="contenedor-img">
        <img src="img/logoBombero.png" width="70" height="70">
      </div>

      <h1>Sistema de Gestión de Bomberos</h1>

      <div class="user-controls">
        <span>Bienvenido, <?php echo htmlspecialchars($usuario); ?></span>
        <button id="togglethemeDos">☀️</button>
        <a href="logout.php"><button>Salir</button></a>
      </div>
    </header>
    
    <script>
      // Modo claro/oscuro
      let isDark = true;
      
      const togglethemeDos = document.getElementById('togglethemeDos');
      
      togglethemeDos.addEventListener('click', () => {
        isDark = !isDark;
        document.body.className = isDark ? 'dark' : 'light';
        togglethemeDos.textContent = isDark ? '☀️' : '🌙';
      });
    </script>
      
    <nav class="tabs">
      <button onclick="window.location.href='inicio.php'">Resumen</button>
      <button onclick="window.location.href='personal.php'">Personal</button>
      <button onclick="window.location.href='camiones.php'">Camiones</button>
      <button onclick="window.location.href='salidas.php'">Salidas</button>
    </nav>

    <main class="card-list">
      <div class="card">
        <h2>Bienvenido al Sistema</h2>
        <p>Seleccioná una pestaña para acceder al registro de personal o camiones.</p>
        <button onclick="window.location.href='login.php'">⬅️ Volver al Login</button>
      </div>
    </main>
  </div>

</body>
</html>

