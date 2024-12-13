<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Usuario</title>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <h1>Registro de Usuario</h1>
  <form id="registerForm">
    <input type="text" id="name" required placeholder="Nombre">
    <input type="email" id="email" required placeholder="Email">
    <input type="password" id="password" required placeholder="Contraseña">
    <button type="submit">Registrarse</button>
  </form>

  <script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const name = document.getElementById('name').value;
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      fetch('/api/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            name,
            email,
            password
          }),
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Registro exitoso');
            window.location.href = 'login.php';
          } else {
            alert('Error en el registro');
          }
        })
        .catch(error => console.error('Error:', error));
    });
  </script>
</body>

</html>