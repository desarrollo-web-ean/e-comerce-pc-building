<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle del Producto - armatucomputadora</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../css/global.css">
  <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
</head>

<body>
  <header
    class="sticky top-0 z-40 shadow-md w-full backdrop-blur flex-none bg-white lg:flex lg:justify-between lg:items-center lg:px-36 h-16">
    <div class="">
      <span class="text-2xl">
        <a href="../index.php">Arma tu computadora</a>
      </span>
    </div>
    <div class="flex gap-4 items-center">
      <a href="../products" class="text-xl hover:text-sky-700">Products</a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <a class="text-xl hover:text-sky-700" href="cart.php">Carrito</a>
        <a class="text-xl hover:text-sky-700" href="../logout">Cerrar sesión</a>
      <?php else: ?>
        <a class="text-xl hover:text-sky-700" href="../../login">Iniciar sesión</a>
        <a class="text-xl hover:text-sky-700" href="../../register">Registrarse</a>
      <?php endif; ?>
    </div>
  </header>

  <main class="px-4 py-6 h-screen">
    <div id="productDetail"></div>
    <Section>
      <h2 class="text-center text-2xl font-bold uppercase">Reviews</h2>
      <div id="reviews" class="grid grid-cols-4 gap-4 my-16"></div>
    </Section>
    <section class="w-1/2 mx-auto bg-gray-100 px-12 py-12 rounded-md">
      <?php if (isset($_SESSION['user_id'])): ?>
        <h2 class="text-2xl text-center text-black">Deja tu reseña</h2>
        <form id="reviewForm" class="space-y-4">
          <div class="flex flex-col">
            <label for="rating" class="text-sm font-medium text-gray-700">Calificación:</label>
            <select id="rating" name="rating" required class="mt-1 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
              <option value="">Selecciona una calificación</option>
              <option value="1">1 estrella</option>
              <option value="2">2 estrellas</option>
              <option value="3">3 estrellas</option>
              <option value="4">4 estrellas</option>
              <option value="5">5 estrellas</option>
            </select>
          </div>
          <div class="flex flex-col">
            <label for="comment" class="text-sm font-medium text-gray-700">Comentario:</label>
            <textarea id="comment" name="comment" required class="mt-1 px-3 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
          </div>
          <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-green-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Enviar reseña</button>
        </form>
      <?php endif; ?>
    </section>
  </main>

  <footer class="flex justify-center items-center py-8 mt-32">
    <div>
      <span class="text-xl">
        ❮❯ by <a href="https://github.com/XINAD919/">Daniel Castaño </a>
      </span>
      <span class="text-xl">2024</span>
    </div>
  </footer>

  <script>
    const urlParams = window.location.pathname;
    const productId = urlParams.slice(-1);

    fetch(`http://localhost/proyectos/armatucomputadora/api/products/${productId}`)
      .then(response => response.json())
      .then(data => {
        const {
          product
        } = data;
        const productDetail = document.getElementById('productDetail');
        productDetail.innerHTML = `
              <h1 class='text-black uppercase text-2xl'>${product.name}</h1>
                    <p class='text-black'>${product.description}</p>
                    <p class='text-red-400 text-xl font-bold'>Precio: $${product.price}</p>
                <button onclick="addToCart(${product.id})">Añadir al carrito</button>
            `;
      })
      .catch(error => console.error('Error:', error));

    const listReviews = async () => {
      await fetch(`http://localhost/proyectos/armatucomputadora/api/reviews/list`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: `{"productId":${productId}}`
        })
        .then(response => response.json())
        .then(reviews => {
          const reviewsElement = document.getElementById('reviews');
          reviews.reviewList.forEach(review => {
            const reviewElement = document.createElement('div');
            reviewElement.className = 'bg-gray-400 rounded-md px-4 py-6 w-fit'
            reviewElement.innerHTML = `
                      <span class='flex gap-4'>
                        <p class='text-white uppercase font-bold'>
                          Calificación:
                        </p> 
                        <p class='font-bold'>
                          ${review.rating}/5
                        </p>
                      </span>
                      <span>${review.comment}</span>
                  `;
            reviewsElement.appendChild(reviewElement);
          });
        })
        .catch(error => console.error('Error:', error));
    }

    listReviews()

    document.getElementById('reviewForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const comment = document.getElementById('comment').value;
      const rating = document.getElementById('rating').value;

      fetch(`http://localhost/proyectos/armatucomputadora/api/reviews/add`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            productId: +productId,
            userId: 1,
            comment,
            rating
          }),
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            window.location.reload()
          } else {
            alert('Error al enviar la reseña');
          }
        })
        .catch(error => console.error('Error:', error));
    });

    function addToCart(productId) {
      fetch('/api/cart/add', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            productId
          }),
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Producto añadido al carrito');
          } else {
            alert('Error al añadir el producto al carrito');
          }
        })
        .catch(error => console.error('Error:', error));
    }
  </script>

  <script
    src="https://kit.fontawesome.com/86f3aeba5f.js"
    crossorigin="anonymous"></script>

</body>

</html>