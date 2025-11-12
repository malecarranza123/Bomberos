// ---- Datos simulados de la base bdbomberos ----

// Cargos
const cargos = [
  { id_cargo: 1, nombre_cargo: 'Chofer' },
  { id_cargo: 2, nombre_cargo: 'Bombero' },
  { id_cargo: 3, nombre_cargo: 'Jefe de dotación' },
];

// Empleados
const empleados = [
  { id_empleado: 1, nombre: 'Juan', apellido: 'Pérez', dni: 30111222, id_cargo: 1 },
  { id_empleado: 2, nombre: 'Ana', apellido: 'Gómez', dni: 28999888, id_cargo: 2 },
  { id_empleado: 3, nombre: 'Luis', apellido: 'Ramírez', dni: 31222333, id_cargo: 3 },
];

// Camiones
const camiones = [
  { id_camion: 1, patente: 'ABC123', modelo: 'Mercedes', capacidad: 3000 },
  { id_camion: 2, patente: 'XYZ789', modelo: 'Volvo', capacidad: 4000 },
];

// Salidas de emergencia
const salidas = [
  { id_salida: 1, fecha: '2025-09-30', hora: '14:30', motivo: 'Incendio' },
  { id_salida: 2, fecha: '2025-09-30', hora: '18:15', motivo: 'Rescate' },
];

// Relaciones
const detalleCamionSalida = [
  { id_salida: 1, id_camion: 1 },
  { id_salida: 1, id_camion: 2 },
  { id_salida: 2, id_camion: 1 },
];

const detalleEmpleadoCamion = [
  { id_camion: 1, id_empleado: 1 },
  { id_camion: 1, id_empleado: 2 },
  { id_camion: 2, id_empleado: 3 },
];

// ---- Interfaz ----
const tabs = document.querySelectorAll('.tabs button');
const content = document.getElementById('content');
const toggleTheme2 = document.getElementById('toggle-theme2');

let isDark = true;

// Tab switching
tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    tabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    renderTab(tab.dataset.tab);
  });
});

// Render content by tab
function renderTab(tab) {
  switch (tab) {
    case 'dashboard':
      const totalEmpleados = empleados.length;
      const totalCamiones = camiones.length;
      const totalSalidas = salidas.length;
      content.innerHTML = `
        <div class="card-list">
          <div class="item"><b>Personal registrado:</b> ${totalEmpleados}</div>
          <div class="item"><b>Camiones operativos:</b> ${totalCamiones}</div>
          <div class="item"><b>Salidas registradas:</b> ${totalSalidas}</div>
        </div>`;
      break;

    case 'personal':
      content.innerHTML = empleados.map(e => {
        const cargo = cargos.find(c => c.id_cargo === e.id_cargo)?.nombre_cargo || 'N/A';
        return `
          <div class="item">
            <b>${e.nombre} ${e.apellido}</b><br>
            DNI: ${e.dni}<br>
            Cargo: ${cargo}
          </div>`;
      }).join('');
      break;

    case 'camiones':
      content.innerHTML = camiones.map(c => `
        <div class="item">
          <b>${c.modelo}</b> (${c.patente})<br>
          Capacidad: ${c.capacidad} L<br>
          Personal asignado: ${
            detalleEmpleadoCamion
              .filter(d => d.id_camion === c.id_camion)
              .map(d => {
                const emp = empleados.find(e => e.id_empleado === d.id_empleado);
                return emp ? `${emp.nombre} ${emp.apellido}` : '';
              })
              .join(', ')
          }
        </div>`).join('');
      break;

    case 'salidas':
      content.innerHTML = salidas.map(s => {
        const camionesUsados = detalleCamionSalida
          .filter(d => d.id_salida === s.id_salida)
          .map(d => camiones.find(c => c.id_camion === d.id_camion)?.modelo)
          .join(', ');
        return `
          <div class="item">
            <b>${s.motivo}</b><br>
            Fecha: ${s.fecha} ${s.hora}<br>
            Camiones: ${camionesUsados}
          </div>`;
      }).join('');
      break;
  }
}

// Tema
toggleTheme2.addEventListener('click', () => {
  isDark = !isDark;
  document.body.className = isDark ? 'dark' : 'light';
  toggleTheme2.textContent = isDark ? '☀️' : '🌙';
});

// Render inicial
renderTab('dashboard');