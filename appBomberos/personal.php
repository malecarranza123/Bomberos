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

      <button onclick="window.locati
