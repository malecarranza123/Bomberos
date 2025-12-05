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
  <title>Personal - Sistema Bomberos</title>
  <link rel="stylesheet" href="style.css">

  <style>
    /* === Modal === */
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

    /* === BOTÓN DE MODO CLARO/OSCURO === */
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
    <h1>Gestión del Personal</h1>

    <div class="user-controls">
      <button id="togglethemeDos">☀️</button>

      <button onclick="window.location.href='inicio.php'">Inicio</button>
      <a href="logout.php"><button>⬅ Salir</button></a>
    </div>
  </header>

  <main class="card-list">
    <div class="card">
      <h2>Lista de Personal</h2>
      <button id="abrirModal">➕ Agregar Nuevo</button>

      <table border="1" width="100%" id="tablaPersonal">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>DNI</th>
            <th>Cargo</th>
            <th>Teléfono</th>
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
      <h2>Agregar Nuevo Empleado</h2>

      <form id="formPersonal">
        <label>Nombre y Apellido</label>
        <input type="text" id="nombre" required>

        <label>DNI</label>
        <input type="text" id="dni" required>

        <label>Cargo</label>
        <input type="text" id="cargo" required>

        <label>Teléfono</label>
        <input type="text" id="telefono">

        <button type="submit">Guardar</button>
      </form>
    </div>
  </div>

  <script>
    const form = document.getElementById('formPersonal');
    const tabla = document.querySelector('#tablaPersonal tbody');
    let empleados = JSON.parse(localStorage.getItem('personal')) || [];

    function actualizarTabla() {
      tabla.innerHTML = '';
      empleados.forEach((emp, i) => {
        const fila = document.createElement('tr');
        fila.innerHTML = `
          <td>${emp.nombre}</td>
          <td>${emp.dni}</td>
          <td>${emp.cargo}</td>
          <td>${emp.telefono}</td>
          <td><button onclick="borrarEmpleado(${i})">❌</button></td>
        `;
        tabla.appendChild(fila);
      });
      localStorage.setItem('personal', JSON.stringify(empleados));
    }

    function borrarEmpleado(i) {
      empleados.splice(i, 1);
      actualizarTabla();
    }

    form.addEventListener('submit', e => {
      e.preventDefault();
      const nuevo = {
        nombre: form.nombre.value.trim(),
        dni: form.dni.value.trim(),
        cargo: form.cargo.value.trim(),
        telefono: form.telefono.value.trim()
      };
      empleados.push(nuevo);
      form.reset();
      cerrarModal();
      actualizarTabla();
    });

    document.getElementById('borrarTodo').addEventListener('click', () => {
      if (confirm('¿Seguro que querés borrar todo el personal?')) {
        empleados = [];
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

    /* === SCRIPT DEL TEMA === */
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

