<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header('Location: index.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administración</title>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <h1>Panel de Administración</h1>
  <button onclick="showProductForm()">Crear Nuevo Producto</button>
  <div id="productForm" style="display: none;">
    <h2>Crear/Editar Producto</h2>
    <form id="productFormElement">
      <input type="hidden" id="productId">
      <input type="text" id="productName" required placeholder="Nombre del producto">
      <textarea id="productDescription" required placeholder="Descripción del producto"></textarea>
      <input type="number" id="productPrice" required placeholder="Precio">
      <button type="submit">Guardar Producto</button>
    </form>
  </div>
  <div id="productList"></div>

  <script>
    function loadProducts() {
      fetch('http://localhost/proyectos/armatucomputadora/api/products')
        .then(response => response.json())
        .then(products => {
          const productList = document.getElementById('productList');
          productList.innerHTML = '';
          products.forEach(product => {
            const productElement = document.createElement('div');
            productElement.innerHTML = `
                        <h2>${product.name}</h2>
                        <p>${product.description}</p>
                        <p>Precio: $${product.price}</p>
                        <button onclick="editProduct(${product.id})">Editar</button>
                        <button onclick="deleteProduct(${product.id})">Eliminar</button>
                    `;
            productList.appendChild(productElement);
          });
        })
        .catch(error => console.error('Error:', error));
    }

    function showProductForm() {
      document.getElementById('productForm').style.display = 'block';
    }

    function editProduct(productId) {
      fetch(`/api/products/${productId}`)
        .then(response => response.json())
        .then(product => {
          document.getElementById('productId').value = product.id;
          document.getElementById('productName').value = product.name;
          document.getElementById('productDescription').value = product.description;
          document.getElementById('productPrice').value = product.price;
          showProductForm();
        })
        .catch(error => console.error('Error:', error));
    }

    function deleteProduct(productId) {
      if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
        fetch(`/api/products/${productId}`, {
            method: 'DELETE',
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              loadProducts();
            } else {
              alert('Error al eliminar el producto');
            }
          })
          .catch(error => console.error('Error:', error));
      }
    }

    document.getElementById('productFormElement').addEventListener('submit', function(e) {
      e.preventDefault();
      const productId = document.getElementById('productId').value;
      const name = document.getElementById('productName').value;
      const description = document.getElementById('productDescription').value;
      const price = document.getElementById('productPrice').value;

      const method = productId ? 'PUT' : 'POST';
      const url = productId ? `http://localhost/proyectos/armatucomputadora/api/products/${productId}` : '/api/products';

      fetch(url, {
          method: method,
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            name,
            description,
            price
          }),
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            loadProducts();
            document.getElementById('productFormElement').reset();
            document.getElementById('productForm').style.display = 'none';
          } else {
            alert('Error al guardar el producto');
          }
        })
        .catch(error => console.error('Error:', error));
    });

    loadProducts();
  </script>
</body>

</html>