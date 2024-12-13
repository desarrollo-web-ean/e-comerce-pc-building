<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/global.css">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body>
  <header
    class="sticky top-0 z-40 shadow-md w-full backdrop-blur flex-none bg-white lg:flex lg:justify-between lg:items-center lg:px-36 h-16">
    <div class="">
      <span class="text-2xl">
        <a href="index.php">Arma tu computadora</a>
      </span>
    </div>
    <div class="flex gap-4 items-center">
      <?php if (isset($_SESSION['user_id'])): ?>
        <a class="text-xl hover:text-sky-700" href="cart.php">Carrito</a>
        <a class="text-xl hover:text-sky-700" href="/logout.php">Cerrar sesión</a>
      <?php else: ?>
        <a class="text-xl hover:text-sky-700" href="http://localhost/proyectos/armatucomputadora/login">Iniciar sesión</a>
        <a class="text-xl hover:text-sky-700" href="register">Registrarse</a>
      <?php endif; ?>
    </div>
  </header>
  <section class="px-8 py-4 h-screen">
    <h1 class="text-3xl text-bold uppercase mb-8">Productos</h1>
    <div id="productList" class="grid grid-cols-4 gap-4"></div>
  </section>

  <footer class="flex justify-center items-center py-8">
    <div>
      <span class="text-xl">
        ❮❯ by <a href="https://github.com/XINAD919/">Daniel Castaño </a>
      </span>
      <span class="text-xl">2024</span>
    </div>
  </footer>

  <script>
    fetch('http://localhost/proyectos/armatucomputadora/api/products/list')
      .then(response => response.json())
      .then(data => {
        console.log("🚀 ~ data:", data)
        const productList = document.getElementById('productList');
        data.products.forEach(product => {
          const productElement = document.createElement('div');
          productElement.className = 'border rounded-lg px-6 py-4 hover:shadow-md'
          productElement.innerHTML = `
                    <h2 class='text-black uppercase text-2xl'>${product.name}</h2>
                    <p class='text-black'>${product.description}</p>
                    <p class='text-red-400 text-xl font-bold'>Precio: $${product.price}</p>
                    <a class='hover:text-red-500 underline' href="product/${product.id}">Ver detalles</a>
                `;
          productList.appendChild(productElement);
        });
      })
      .catch(error => console.error('Error:', error));
  </script>

  <script
    src="https://kit.fontawesome.com/86f3aeba5f.js"
    crossorigin="anonymous"></script>

</body>

</html>