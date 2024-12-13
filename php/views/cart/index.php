<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrito de Compras</title>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <h1>Carrito de Compras</h1>
  <div id="cartItems"></div>
  <div id="total"></div>
  <button onclick="checkout()">Realizar Pedido</button>

  <script>
    function loadCart() {
      fetch('/api/cart')
        .then(response => response.json())
        .then(cart => {
          const cartItems = document.getElementById('cartItems');
          cartItems.innerHTML = '';
          let total = 0;
          cart.items.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.innerHTML = `
                        <h2>${item.name}</h2>
                        <p>Precio: $${item.price}</p>
                        <p>Cantidad: ${item.quantity}</p>
                        <button onclick="removeFromCart(${item.id})">Eliminar</button>
                    `;
            cartItems.appendChild(itemElement);
            total += item.price * item.quantity;
          });
          document.getElementById('total').textContent = `Total: $${total.toFixed(2)}`;
        })
        .catch(error => console.error('Error:', error));
    }

    function removeFromCart(productId) {
      fetch('/api/cart/remove', {
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
            loadCart();
          } else {
            alert('Error al eliminar el producto del carrito');
          }
        })
        .catch(error => console.error('Error:', error));
    }

    function checkout() {
      fetch('/api/cart/checkout', {
          method: 'POST',
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Pedido realizado con éxito');
            loadCart();
          } else {
            alert('Error al realizar el pedido');
          }
        })
        .catch(error => console.error('Error:', error));
    }

    loadCart();
  </script>
</body>

</html>