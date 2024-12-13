<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle del Producto</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/global.css">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body>
  <div id="productDetail"></div>
  <div id="reviews"></div>
  <form id="reviewForm">
    <textarea id="reviewText" required placeholder="Escribe tu reseña"></textarea>
    <select id="rating" required>
      <option value="">Selecciona una calificación</option>
      <option value="1">1 estrella</option>
      <option value="2">2 estrellas</option>
      <option value="3">3 estrellas</option>
      <option value="4">4 estrellas</option>
      <option value="5">5 estrellas</option>
    </select>
    <button type="submit">Enviar Reseña</button>
  </form>

  <script>
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    fetch(`/api/products/${productId}`)
      .then(response => response.json())
      .then(product => {
        const productDetail = document.getElementById('productDetail');
        productDetail.innerHTML = `
                <h1>${product.name}</h1>
                <p>${product.description}</p>
                <p>Precio: $${product.price}</p>
                <button onclick="addToCart(${product.id})">Añadir al carrito</button>
            `;
      })
      .catch(error => console.error('Error:', error));

    fetch(`/api/products/${productId}/reviews`)
      .then(response => response.json())
      .then(reviews => {
        const reviewsElement = document.getElementById('reviews');
        reviews.forEach(review => {
          const reviewElement = document.createElement('div');
          reviewElement.innerHTML = `
                    <p>Calificación: ${review.rating}/5</p>
                    <p>${review.text}</p>
                `;
          reviewsElement.appendChild(reviewElement);
        });
      })
      .catch(error => console.error('Error:', error));

    document.getElementById('reviewForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const text = document.getElementById('reviewText').value;
      const rating = document.getElementById('rating').value;

      fetch(`/api/products/${productId}/reviews`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            text,
            rating
          }),
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Reseña enviada con éxito');
            location.reload();
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
</body>

</html>