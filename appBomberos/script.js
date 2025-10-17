// Elementos
const loginScreen = document.getElementById('login');
const app = document.getElementById('app');
const loginBtn = document.getElementById('login-btn');
const logoutBtn = document.getElementById('logout-btn');
const usernameInput = document.getElementById('username');
const passwordInput = document.getElementById('password');
const welcomeUser = document.getElementById('welcome-user');
const content = document.getElementById('content');
const tabs = document.querySelectorAll('.tabs button');
const toggleTheme = document.getElementById('toggle-theme');
const toggleTheme2 = document.getElementById('toggle-theme2');

let isDark = true;

// Datos
const incidents = [
  { type: 'Incendio estructural', location: 'Calle Principal 123', status: 'En curso', priority: 'Alta', time: '14:30' },
  { type: 'Rescate vehicular', location: 'Ruta 9 Km 45', status: 'Completado', priority: 'Media', time: '12:15' },
  { type: 'Fuga de gas', location: 'Av. Libertad 456', status: 'En curso', priority: 'Alta', time: '15:00' },
];

const personnel = [
  { name: 'Juan Pérez', rank: 'Capitán', status: 'Disponible' },
  { name: 'María González', rank: 'Teniente', status: 'En servicio' },
  { name: 'Carlos Ruiz', rank: 'Bombero', status: 'Disponible' },
  { name: 'Ana Martínez', rank: 'Cabo', status: 'Descanso' },
];

const vehicles = [
  { unit: 'Autobomba 1', status: 'Disponible', location: 'Cuartel Central' },
  { unit: 'Ambulancia 1', status: 'En servicio', location: 'Ruta 9 Km 45' },
  { unit: 'Rescate 1', status: 'Disponible', location: 'Cuartel Central' },
];

// Iniciar sesión
loginBtn.addEventListener('click', () => {
  const username = usernameInput.value.trim();
  const password = passwordInput.value.trim();

  if (username && password) {
    loginScreen.classList.add('hidden');
    app.classList.remove('hidden');
    welcomeUser.textContent = `Bienvenido, ${username}`;
    renderTab('dashboard');
  } else {
    alert("Por favor, ingrese usuario y contraseña.");
  }
});

// Cerrar sesión
logoutBtn.addEventListener('click', () => {
  app.classList.add('hidden');
  loginScreen.classList.remove('hidden');
  usernameInput.value = '';
  passwordInput.value = '';
});

// Tabs
tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    tabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    renderTab(tab.dataset.tab);
  });
});

// Renderizar contenido
function renderTab(tab) {
  switch (tab) {
    case 'dashboard':
      content.innerHTML = `
        <div class="card-list">
          <div class="item"> <b>Incidentes activos:</b> 2</div>
          <div class="item"> <b>Personal disponible:</b> 2 de 4</div>
          <div class="item"> <b>Unidades activas:</b> 1</div>
        </div>`;
      break;

    case 'incidents':
      content.innerHTML = incidents.map(i => `
        <div class="item">
          <b>${i.type}</b><br>
           ${i.location}<br>
           ${i.time}<br>
          ⚠️ Prioridad: ${i.priority}<br>
          Estado: ${i.status}
        </div>`).join('');
      break;

    case 'personnel':
      content.innerHTML = personnel.map(p => `
        <div class="item">
          <b>${p.name}</b> - ${p.rank}<br>
          Estado: ${p.status}<br>
        </div>`).join('');
      break;

    case 'vehicles':
      content.innerHTML = vehicles.map(v => `
        <div class="item">
          <b>${v.unit}</b><br>
          Estado: ${v.status}<br>
          Ubicación: ${v.location}
        </div>`).join('');
      break;

    case 'reports':
      content.innerHTML = `<div class="item"><b>Módulo de Informes</b><br>Genera y consulta informes de actividad.</div>`;
      break;

    case 'schedule':
      content.innerHTML = `<div class="item"><b>Gestión de Turnos</b><br>Planifica y administra los turnos del personal.</div>`;
      break;
  }
}

// Cambiar tema
function toggleThemeMode() {
  isDark = !isDark;
  document.body.className = isDark ? 'dark' : 'light';
  toggleTheme.textContent = isDark ? '☀️' : '🌙';
  toggleTheme2.textContent = isDark ? '☀️' : '🌙';
}
toggleTheme.addEventListener('click', toggleThemeMode);
toggleTheme2.addEventListener('click', toggleThemeMode);