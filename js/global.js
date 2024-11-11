// Selecciona los elementos del DOM (documento HTML) que se usarán en el script
const btn = document.getElementById("buyNowBtn"); // Botón para abrir el modal de compra
const submitButton = document.getElementById("submitModal"); // Botón para cerrar el modal después de hacer una acción
const modal = document.getElementById("buyModal"); // Modal donde se muestra la información de compra
const closeSpan = document.getElementsByClassName("close")[0]; // Botón de cerrar (ícono de la 'x') en el modal

// Cuando el botón de "Comprar ahora" es clickeado, muestra el modal y bloquea el desplazamiento de la página
btn.onclick = function () {
  modal.style.display = "block"; // Muestra el modal
  document.body.style.overflow = "hidden"; // Bloquea el desplazamiento de la página
};

// Cuando el botón de cerrar dentro del modal es clickeado, se cierra el modal y se permite el desplazamiento nuevamente
closeSpan.onclick = function () {
  modal.style.display = "none"; // Oculta el modal
  document.body.style.overflow = "auto"; // Permite el desplazamiento nuevamente
};

// Al hacer clic en el botón de enviar en el modal, también se cierra el modal y se permite el desplazamiento
submitButton.onclick = function () {
  modal.style.display = "none"; // Oculta el modal
  document.body.style.overflow = "auto"; // Permite el desplazamiento nuevamente
};

// Si se hace clic fuera del modal, también se cierra el modal y se permite el desplazamiento
window.onclick = function (event) {
  if (event.target == modal) {
    // Verifica si el clic fue en el área del modal (y no en otro lugar)
    modal.style.display = "none"; // Oculta el modal
    document.body.style.overflow = "auto"; // Permite el desplazamiento nuevamente
  }
};

// Variables para el carrusel de imágenes
let currentIndex = 0; // Índice de la imagen actual que se está mostrando
const maxIndex = 2; // El índice máximo de las imágenes (en este caso, 3 imágenes)
const minIndex = 0; // El índice mínimo de las imágenes
const carouselImages = document.getElementById("carousel__images"); // El contenedor de las imágenes del carrusel
const prevBtn = document.getElementById("prev"); // Botón para retroceder a la imagen anterior
const nextBtn = document.getElementById("next"); // Botón para avanzar a la siguiente imagen

// Función para actualizar la posición del carrusel al mostrar una imagen específica
function updateCarouselPosition() {
  carouselImages.style.transform = `translateX(-${80 * currentIndex}vw)`; // Mueve las imágenes del carrusel
}

// Cuando el botón de "siguiente" es clickeado, avanza a la siguiente imagen
nextBtn.onclick = () => {
  currentIndex = currentIndex + 1 > maxIndex ? 0 : currentIndex + 1; // Si el índice es mayor que el máximo, se reinicia al inicio
  updateCarouselPosition(); // Actualiza la posición del carrusel
};

// Cuando el botón de "anterior" es clickeado, retrocede a la imagen anterior
prevBtn.onclick = () => {
  currentIndex = currentIndex - 1 < minIndex ? maxIndex : currentIndex - 1; // Si el índice es menor que el mínimo, se vuelve a la última imagen
  updateCarouselPosition(); // Actualiza la posición del carrusel
};

// Esta función se ejecuta cada 5 segundos para avanzar automáticamente a la siguiente imagen
setInterval(() => {
  currentIndex = currentIndex + 1 > maxIndex ? 0 : currentIndex + 1; // Si el índice supera el máximo, se reinicia al inicio
  updateCarouselPosition(); // Actualiza la posición del carrusel
}, 5000); // El intervalo de 5000 milisegundos es igual a 5 segundos

// Espera a que la página cargue antes de ejecutar este código
document.addEventListener("DOMContentLoaded", function () {
  // Selecciona el contenedor donde se van a mostrar los testimonios de los clientes
  const customerFeedbackContainer = document.getElementById(
    "customerFeedbackContainer"
  );
  customerFeedbackContainer.innerHTML = ""; // Limpia el contenido actual del contenedor

  // Datos de los testimonios (simulando los testimonios de los clientes)
  const testimonios = [
    {
      nombre: "Carlos Mendoza",
      imagen: "assets/carlos.webp",
      calificacion: 5,
      texto:
        "The service was quick and my computer runs like new again! Highly recommend armatucomputadora.",
      rol: "Satisfied Customer",
    },
    {
      nombre: "Lucia Torres",
      imagen: "assets/carlos.webp",
      calificacion: 5,
      texto:
        "I was impressed with the professionalism and expertise. They fixed my laptop in no time!",
      rol: "Happy Client",
    },
    {
      nombre: "Javier Ruiz",
      imagen: "assets/javier.webp",
      calificacion: 5,
      texto:
        "Always reliable and affordable. I trust armatucomputadora with all my computer needs.",
      rol: "Regular Customer",
    },
    {
      nombre: "Sofia Jimenez",
      imagen: "assets/sofia.webp",
      calificacion: 4,
      texto:
        "Great service! They explained everything clearly and my computer is working perfectly now.",
      rol: "Tech Enthusiast",
    },
    {
      nombre: "Diego Salazar",
      imagen: "assets/daniel.png",
      calificacion: 5,
      texto:
        "Fast and efficient service. They saved my business from a major tech issue!",
      rol: "Business Owner",
    },
    {
      nombre: "Ana Morales",
      imagen: "assets/anna.webp",
      calificacion: 5,
      texto:
        "I was nervous about repairs, but the team made it easy and stress-free. Thank you!",
      rol: "First-Time Customer",
    },
  ];

  // Recorre el arreglo de testimonios y crea una tarjeta para cada uno
  testimonios.forEach((testimonio) => {
    const card = document.createElement("div"); // Crea un nuevo contenedor para cada testimonio

    // Crea una cadena de estrellas según la calificación del cliente (por ejemplo: "★★★★★" o "★★★☆☆")
    const rating =
      "★".repeat(testimonio.calificacion) +
      "☆".repeat(5 - testimonio.calificacion);

    // Agrega clases de estilo para la tarjeta del testimonio
    card.classList.add(
      "bg-white",
      "p-4",
      "rounded-lg",
      "shadow-lg",
      "my-4",
      "text-center",
      "flex",
      "flex-col",
      "items-center"
    );

    // Rellena la tarjeta con los datos del testimonio
    card.innerHTML = `
        <div class="stars mb-2">${rating}</div> <!-- Muestra las estrellas -->
        <p class="mb-4 text-black">${testimonio.texto}</p> <!-- Muestra el texto del testimonio -->
        <img src="${testimonio.imagen}" alt="${testimonio.nombre}" class="user-image w-16 h-16 rounded-full mb-4"> <!-- Muestra la imagen del cliente -->
        <h3 class="font-semibold text-lg mb-1">${testimonio.nombre}</h3> <!-- Muestra el nombre del cliente -->
        <p class="role text-sm text-gray-500">${testimonio.rol}</p> <!-- Muestra el rol del cliente -->
    `;

    // Agrega la tarjeta al contenedor de testimonios
    customerFeedbackContainer.appendChild(card);
  });
});
