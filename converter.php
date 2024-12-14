 <?php
  session_start();
  ?>
 <!DOCTYPE html>
 <html lang="es">

 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>armatucomputadora | convertidor divisas</title>
   <script src="https://cdn.tailwindcss.com"></script>
   <link rel="stylesheet" href="./css/global.css" />
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
       <a href="products" class="text-xl hover:text-sky-700">Products</a>
       <?php if (isset($_SESSION['user_id'])): ?>
         <a class="text-xl hover:text-sky-700" href="cart.php">Carrito</a>
         <a class="text-xl hover:text-sky-700" href="./logout">Cerrar sesión</a>
       <?php else: ?>
         <a class="text-xl hover:text-sky-700" href="login">Iniciar sesión</a>
         <a class="text-xl hover:text-sky-700" href="register">Registrarse</a>
       <?php endif; ?>
     </div>
   </header>
   <section class="px-8 py-12 mx-auto">
     <h1 class="text-2xl text-center">Conversor de Divisas</h1>
     <form class="flex flex-col justify-self-center items-center gap-4 w-1/2">

       <div class="flex gap-4 items-center  w-1/2">
         <label for="fromCurrency" class="text-lg font-bold">
           De:
         </label>
         <input class='rounded-md border-2 border-gray-300 p-2 outline-none w-full ' type="text" id="fromCurrency" placeholder="USD">

       </div>
       <div class="flex gap-4 items-center w-1/2">
         <label for="toCurrency" class="text-lg font-bold">
           A:
         </label>
         <input class='rounded-md border-2 border-gray-300 p-2 outline-none w-full ' type="text" id="toCurrency" placeholder="COP">
       </div>
       <div class="flex gap-4 items-center w-1/2">
         <label for="amount" class="text-lg font-bold">
           Cantidad:
         </label>
         <input class='rounded-md border-2 border-gray-300 p-2 outline-none w-full ' type="number" id="amount" placeholder="100">
       </div>
       <button type="button" id="convertButton" class="px-4 py-2 w-1/2 rounded border bg-green-400 text-white">Convertir</button>
     </form>
   </section>
   <h2 id="result" class="text-3xl text-center font-bold text-red-400">
     </p>
     <script src="./js/convert.js"></script>
 </body>

 </html>