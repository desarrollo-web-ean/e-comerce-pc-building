<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <h1>Iniciar Sesión</h1>
  <form id="loginForm">
    <input type="email" id="email" required placeholder="Email">
    <input type="password" id="password" required placeholder="Contraseña">
    <button type="submit">Iniciar Sesión</button>
  </form>

  <script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      fetch('http://localhost/proyectos/armatucomputadora/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            email,
            password
          }),
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            console.log("🚀 ~ document.getElementById ~ data:", data)
            localStorage.setItem('session', data.token)
            // alert('Inicio de sesión exitoso');
            window.location.href = 'index.php';
          } else {
            alert('Error en el inicio de sesión');
          }
        })
        .catch(error => console.error('Error:', error));
    });
  </script>
</body>

</html>