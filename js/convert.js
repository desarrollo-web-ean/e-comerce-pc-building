document.addEventListener("DOMContentLoaded", () => {
  const convertButton = document.getElementById("convertButton");
  const resultDisplay = document.getElementById("result");

  convertButton.addEventListener("click", async () => {
    const fromCurrency = document.getElementById("fromCurrency").value;
    const toCurrency = document.getElementById("toCurrency").value;
    const amount = parseFloat(document.getElementById("amount").value);

    if (isNaN(amount)) {
      resultDisplay.textContent = "Por favor, ingrese una cantidad válida";
      return;
    }

    try {
      const options = {
        method: "GET",
        headers: { apikey: "9sBd0qUVQjzS8gFat4mguiziH3e9MXer" },
      };

      const response = await fetch(
        `https://api.apilayer.com/exchangerates_data/latest?base=${fromCurrency}&symbols=${toCurrency}`,
        options
      );

      const data = await response.json();

      if (data.error) {
        throw new Error(data.error.message);
      }

      if (data.rates[toCurrency.toUpperCase()]) {
        const convertedAmount = (
          amount * data.rates[toCurrency.toUpperCase()]
        ).toFixed(2);
        resultDisplay.textContent = `${amount} ${fromCurrency} = ${convertedAmount} ${toCurrency.toUpperCase()}`;
      } else {
        resultDisplay.textContent = "Moneda no soportada";
      }
    } catch (error) {
      resultDisplay.textContent = error;
    }
  });
});
