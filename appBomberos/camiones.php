<?php
session_start();

// Control de sesión
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
  <title>Camiones - Sistema Bomberos</title>
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

    #togglethemeDos {
      background: transparent;
      padding: 8px 14px;
      border-radius: 10px;
      backdrop-filter: blur(5px);
      cursor: pointer;
      transition: 0.2s ease;
      font-size: 18px;
      margin-right: 10px;
    }
    #togglethemeDos:hover {
      transform: scale(1.08);
      opacity: 0.9;
    }
    .light #togglethemeDos {
      color: black;
      border-color: rgba(0,0,0,0.3);
    }
  </style>
</head>

<body class="dark">
  <header class="header-app">
    <div class="contenedor-img">
      <img src="img/logoBombero.png" width="70" height="70">
    </div>

    <h1>Gestión de Camiones</h1>

    <div class="user-controls">
      <button id="togglethemeDos">☀️</button>

      <button onclick="window.location.href='inicio.php'">Inicio</button>
      <a href="logout.php"><button>⬅ Salir</button></a>
    </div>
  </header>

  <main class="card-list">
    <div class="card">
      <h2>Lista de Camiones</h2>
      <button id="abrirModal">➕ Agregar Nuevo</button>

      <table border="1" width="100%" id="tablaCamiones">
        <thead>
          <tr>
            <th>Patente</th>
            <th>Modelo</th>
            <th>Año</th>
            <th>Estado</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>

      <button id="borrarTodo" style="margin-top:10px; background:#e53935; color:white;">Borrar Todo</button>
    </div>
  </main>

  <!-- Modal -->
  <div id="modal" class="modal">
    <div class="modal-content">
      <span class="close" id="cerrarModal">&times;</span>
      <h2>Agregar Nuevo Camión</h2>

      <form id="formCamion">
        <label>Patente</label>
        <input type="text" id="patente" required>

        <label>Modelo</label>
        <input type="text" id="modelo" required>

        <label>Año</label>
        <input type="number" id="anio" required>

        <label>Estado</label>
        <select id="estado">
          <option>Operativo</option>
          <option>En mantenimiento</option>
          <option>Fuera de servicio</option>
        </select>

        <button type="submit">Guardar</button>
      </form>
    </div>
  </div>

  <script>
    const form = document.getElementById('formCamion');
    const tabla = document.querySelector('#tablaCamiones tbody');
    let camiones = JSON.parse(localStorage.getItem('camiones')) || [];

    function actualizarTabla() {
      tabla.innerHTML = '';
      camiones.forEach((c, i) => {
        const fila = document.createElement('tr');
        fila.innerHTML = `
          <td>${c.patente}</td>
          <td>${c.modelo}</td>
          <td>${c.anio}</td>
          <td>${c.estado}</td>
          <td><button onclick="borrarCamion(${i})">❌</button></td>
        `;
        tabla.appendChild(fila);
      });
      localStorage.setItem('camiones', JSON.stringify(camiones));
    }

    function borrarCamion(i) {
      camiones.splice(i, 1);
      actualizarTabla();
    }

    form.addEventListener('submit', e => {
      e.preventDefault();
      const nuevo = {
        patente: form.patente.value.trim(),
        modelo: form.modelo.value.trim(),
        anio: form.anio.value.trim(),
        estado: form.estado.value
      };
      camiones.push(nuevo);
      form.reset();
      cerrarModal();
      actualizarTabla();
    });

    document.getElementById('borrarTodo').addEventListener('click', () => {
      if (confirm('¿Seguro que querés borrar todos los camiones?')) {
        camiones = [];
        actualizarTabla();
      }
    });

    // Modal
    const modal = document.getElementById('modal');
    const abrir = document.getElementById('abrirModal');
    const cerrar = document.getElementById('cerrarModal');

    abrir.addEventListener('click', () => modal.style.display = 'flex');
    cerrar.addEventListener('click', cerrarModal);

    function cerrarModal() { modal.style.display = 'none'; }

    window.onclick = e => { if (e.target == modal) cerrarModal(); }

    actualizarTabla();

    // Script del modo claro/oscuro
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


