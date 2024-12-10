  <?php include '../../../partials/header.php'; ?>

  <div id="products__list"></div>
  <script>
    document.addEventListener('DOMContentLoaded', async function() {
      try {
        const defaultUrl = 'http://localhost/proyectos/armatucomputadora/api';
        const response = await fetch(`${defaultUrl}/products/list`);
        const data = await response.json();
        console.log("🚀 ~ document.addEventListener ~ data:", data)

        const root = document.querySelector('#products__list');
        root.className = 'grid grid-cols-4 gap-4 px-8 py-8'
        root.innerHTML = ''

        data.products.map(async (p) => {
          const divProduct = document.createElement('div');
          divProduct.className = 'flex flex-col border rounded-lg w-full px-4 py-8';

          divProduct.innerHTML += `
         <div class="flex flex-col gap-4">
           <h2 class='product_name text-xl uppercase'></h2>
           <div class="flex flex-col">
           <span class='text-slate-500'>${p.description}</span>
             <span class='text-red-500 font-bold text-xl'>$${p.price} USD</span>
           </div>
           <div class='categories__container'></div>
         </div>
          `
          const h2Element = divProduct.querySelector(".product_name");
          h2Element.textContent = p.name;

          const categories = divProduct.querySelector(".categories__container");
          p.categories.map(async (c) => {
            const categoryChip = document.createElement('div')
            categories.className = 'flex gap-4';
            categories.innerHTML += `
            <div class='border rounded-xl px-3 py-1'>
              <span class=''>${c.name}</span>
            </div>
            `
          })

          root.appendChild(divProduct)
        })
      } catch (error) {
        console.error(error);
      }
    })
  </script>
  <?php include '../../../partials/footer.php'; ?>