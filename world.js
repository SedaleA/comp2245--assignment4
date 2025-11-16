document.addEventListener("DOMContentLoaded", () => {
  const lkupBtn = document.getElementById("lookup");
  const countryInput = document.getElementById("country");
  const resultDiv = document.getElementById("result");

  function searchCountry() {
    const country = encodeURIComponent(countryInput.value.trim());

    fetch(`world.php?country=${country}`)
      .then((response) => response.text())
      .then((data) => {
        resultDiv.innerHTML = data;
      })
      .catch((error) => {
        resultDiv.innerHTML = `<p style="color:red;">Error fetching data.</p>`;
        console.error(error);
      });
  }

  lkupBtn.addEventListener("click", searchCountry);

  // Enter key listener
  countryInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault(); // Prevent form submission / page refresh
      searchCountry();
    }
  });
});
