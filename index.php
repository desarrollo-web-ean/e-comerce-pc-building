<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Arma tucomputadora</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="./css/global.css" />
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body>
  <!-- header -->
  <?php include './php/partials/header.php'; ?>

  <!-- modal -->
  <div id="buyModal" class="modal absolute bottom-0 left-0 m-auto">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Complete Your Purchase</h2>
      <textarea
        placeholder="Enter any additional comments or requests here..."></textarea>
      <button class="submit-btn" id="submitModal">Submit</button>
    </div>
  </div>

  <!-- main section -->
  <section class="main__section min-h-screen">
    <div class="flex flex-col justify-center items-center pt-32 gap-4 h-full">
      <h1 class="text-5xl font-bold w-1/2 mb-8">
        Discover Top-Quality Computer Parts
      </h1>
      <span class="w-1/2 text-xl">
        armatucomputadora offers a wide range of computer parts and
        accessories at unbeatable prices. Experience exceptional service and
        find everything you need to enhance your computing experience.
      </span>
      <div class="flex gap-4">
        <button
          id="buyNowBtn"
          class="bg-white text-black px-6 py-3 rounded-md hover:opacity-75">
          shop now
        </button>
        <button
          class="border border-white px-6 py-3 rounded-md hover:bg-white hover:text-black">
          learn more
        </button>
      </div>
    </div>
  </section>

  <!-- meet our team -->
  <section class="mt-28 min-h-screen">
    <div class="flex justify-center items-center">
      <div class="flex justify-center w-1/2">
        <img
          class="w-4/5 rounded"
          src="./assets/tenweb_media_8MDW5z5B.webp"
          alt="imagen equipo de trabajo" />
      </div>
      <div class="flex flex-col w-1/2">
        <div class="pb-16 px-6">
          <h2 class="text-black text-4xl font-bold mb-4">Meet our team</h2>
          <span>
            At armatucomputadora, we are dedicated to providing top-notch
            computer repair services and quality parts. Our mission is to
            empower customers with the best technology solutions while
            ensuring satisfaction and transparency in every interaction.
          </span>
        </div>
        <div
          class="grid grid-flow-row-dense grid-cols-2 grid-rows-2 gap-4 place-content-center">
          <div class="px-6">
            <h2 class="font-bold text-black text-4xl mb-4">50%</h2>
            <span>
              We pride ourselves on our integrity and customer focus, ensuring
              that every client receives personalized service tailored to
              their needs.
            </span>
          </div>
          <div class="px-6">
            <h2 class="font-bold text-black text-4xl capitalize mb-4">
              3 team members
            </h2>
            <span>
              Our team consists of passionate individuals like Daniel Castaño,
              our Founder & CEO, who brings over 10 years of experience, and
              Oscar Daniel Lanceros, our Lead Technician, known for his
              expertise in solving complex issues.
            </span>
          </div>
          <div class="px-6">
            <h2 class="font-bold text-black text-4xl capitalize mb-4">
              200 satisfied customers
            </h2>
            <span>
              With a commitment to innovation and teamwork, we strive to be
              the go-to destination for all your computer-related needs.
            </span>
          </div>
          <div class="px-6">
            <h2 class="font-bold text-black text-4xl capitalize mb-4">
              5 core values
            </h2>
            <span>
              Our core values include integrity, customer focus, innovation,
              and teamwork, which guide us in every aspect of our business.
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- featured products -->
  <section class="min-h-screen mt-22 text-center">
    <div class="w-1/2 m-auto">
      <h2 class="text-black text-center font-bold text-4xl capitalize mb-4">
        Featured Products
      </h2>
      <span class="text-lg">
        Explore our top selections of computer parts and accessories, all at
        unbeatable prices.
      </span>
    </div>
    <div
      class="carrousel__container relative flex overflow-hidden justify-center items-center mt-8 rounded-md">
      <div id="carousel__images" class="carousel__images flex w-full">
        <img
          class="w-screen"
          src="./assets/teclado.webp"
          alt="teclado gay mer" />
        <img class="w-screen" src="./assets/pc.webp" alt="teclado gay mer" />
        <img
          class="w-screen"
          src="./assets/setup.webp"
          alt="teclado gay mer" />
      </div>
      <div
        class="controls absolute flex justify-between px-8 w-full text-white text-4xl">
        <button id="prev">
          <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button id="next">
          <i class="fa-solid fa-chevron-right"></i>
        </button>
      </div>
    </div>
  </section>

  <!-- customer feedback hecho con js manipulando el DOM donde se renderizan los elementos de un array como cards  -->
  <section class="min-h-screen mt-28 px-8">
    <div class="text-center w-1/2 m-auto">
      <h2 class="text-black text-center font-bold text-4xl capitalize mb-4">
        Customer Feedback
      </h2>
      <span class="text-xl">
        <b> See what our clients say </b> about their experience with our
        computer repair services. We value every opinion!
      </span>
    </div>

    <!-- Contenedor de testimonios -->
    <div
      id="customerFeedbackContainer"
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 place-content-center"></div>
  </section>

  <!-- footer -->
  <?php include './php/partials/footer.php'; ?>

  <!-- scripts js -->
  <?php include './php/partials/scripts.php'; ?>

</body>

</html>