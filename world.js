document.addEventListener("DOMContentLoaded", () => {
  const lkupBtn = document.getElementById("lookup");
  const countryInput = document.getElementById("country");
  const resultDiv = document.getElementById("result");
  const lkupCityBtn = document.getElementById("lookupCities");

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

  function searchCities() {
    const country = encodeURIComponent(countryInput.value.trim());

    // UPDATED: Now calls world.php with lookup=cities
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

  // Search countries (Button)
  lkupBtn.addEventListener("click", searchCountry);

  // Search countries (Enter key)
  countryInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      searchCountry();
    }
  });

  // Search cities (Button)
  lkupCityBtn.addEventListener("click", searchCities);
});
