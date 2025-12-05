<?php
// Archivo donde se guardan las salidas
$archivo = "salidas.json";

// Si no existe el archivo, crearlo vacío
if (!file_exists($archivo)) {
    file_put_contents($archivo, json_encode([]));
}

// Leer salidas
$salidas = json_decode(file_get_contents($archivo), true);

// Guardar nueva salida
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["agregar"])) {

    $nueva = [
        "tipo" => $_POST["tipo"],
        "direccion" => $_POST["direccion"],
        "hora" => $_POST["hora"],
        "descripcion" => $_POST["descripcion"]
    ];

    $salidas[] = $nueva;

    file_put_contents($archivo, json_encode($salidas, JSON_PRETTY_PRINT));
    header("Location: salidas.php");
    exit;
}

// Borrar una salida
if (isset($_GET["borrar"])) {
    $i = intval($_GET["borrar"]);
    array_splice($salidas, $i, 1);
    file_put_contents($archivo, json_encode($salidas, JSON_PRETTY_PRINT));
    header("Location: salidas.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Salidas de Emergencia</title>
  <link rel="stylesheet" href="style.css">

  <style>
    .modal {
      display: none;
      position: fixed;
      z-index: 10;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.7);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: #222;
      color: #fff;
      padding: 2rem;
      border-radius: 12px;
      width: 400px;
      max-width: 90%;
    }
    .light .modal-content {
      background: #fff;
      color: #000;
    }
    .close {
      float: right;
      font-size: 1.5rem;
      cursor: pointer;
    }
  </style>
</head>

<body class="dark">

<header class="header-app">
  <div class="contenedor-img">
    <img src="img/logoBombero.png" width="70" height="70">
  </div>
  <h1>Salidas de Emergencia</h1>

  <div class="user-controls">
    <button id="togglethemeDos">☀️</button>
    <button onclick="window.location.href='inicio.php'">Inicio</button>
    <button onclick="window.location.href='index.php'">⬅ Salir</button>
  </div>
</header>

<main class="card-list">
  <div class="card">
    <h2>Registro de Salidas</h2>

    <button id="abrirModal">➕ Nueva Salida</button>

    <table border="1" width="100%">
      <thead>
        <tr>
          <th>Tipo</th>
          <th>Dirección</th>
          <th>Hora</th>
          <th>Descripción</th>
          <th>Acción</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($salidas as $i => $s): ?>
        <tr>
          <td><?= htmlspecialchars($s["tipo"]) ?></td>
          <td><?= htmlspecialchars($s["direccion"]) ?></td>
          <td><?= htmlspecialchars($s["hora"]) ?></td>
          <td><?= htmlspecialchars($s["descripcion"]) ?></td>
          <td>
            <a href="salidas.php?borrar=<?= $i ?>" onclick="return confirm('¿Eliminar salida?')">❌</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>

<!-- MODAL -->
<div id="modal" class="modal">
  <div class="modal-content">
    <span id="cerrarModal" class="close">&times;</span>

    <h2>Registrar Salida</h2>

    <form method="POST">
      <label>Tipo de salida</label>
      <select name="tipo" required>
        <option>Incendio</option>
        <option>Rescate</option>
        <option>Accidente</option>
        <option>Fuga de gas</option>
      </select>

      <label>Dirección</label>
      <input type="text" name="direccion" required>

      <label>Hora</label>
      <input type="time" name="hora" required>

      <label>Descripción</label>
      <textarea name="descripcion" required></textarea>

      <button type="submit" name="agregar">Guardar</button>
    </form>
  </div>
</div>

<script>
  // Modal
  const modal = document.getElementById('modal');
  document.getElementById('abrirModal').onclick = () => modal.style.display = 'flex';
  document.getElementById('cerrarModal').onclick = () => modal.style.display = 'none';
  window.onclick = e => { if (e.target == modal) modal.style.display = 'none'; }

  // Tema
  let isDark = true;
  const togglethemeDos = document.getElementById('togglethemeDos');
  togglethemeDos.addEventListener('click', () => {
    isDark = !isDark;
    document.body.className = isDark ? 'dark' : 'light';
    togglethemeDos.textContent = isDark ? '☀️' : '🌙';
  });
</script>

</body>
</html>
