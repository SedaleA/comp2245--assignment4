document.addEventListener("DOMContentLoaded", () => {
  const lkupBtn = document.getElementById("lookup");
  const countryInput = document.getElementById("country");
  const resultDiv = document.getElementById("result");
  const lkupCityBtn = document.getElementById("lookupCities");

  function searchCountry() {
    const country = encodeURIComponent(countryInput.value.trim());
    // Default lookup for countries
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
  // Function to search for cities
  function searchCities() {
    const country = encodeURIComponent(countryInput.value.trim());

    fetch(`world.php?country=${country}&lookup=cities`)
      .then((response) => response.text())
      .then((data) => {
        resultDiv.innerHTML = data;
      })
      .catch((error) => {
        resultDiv.innerHTML = `<p style="color:red;">Error fetching data.</p>`;
        console.error(error);
      });
  }
  // Event listeners
  lkupBtn.addEventListener("click", searchCountry);

  countryInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      searchCountry();
    }
  });

  lkupCityBtn.addEventListener("click", searchCities);
});
