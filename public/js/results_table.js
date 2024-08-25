const loader = document.querySelector("#loader");
const results = document.querySelector("#results");
const tbody = document.querySelector("#results tbody");

async function getCountry(ip) {
  const response = await fetch("/api/country/" + ip);
  if (!response.ok) {
    return null;
  }
  return await response.json();
}

function createCountryTd(country) {
  const td = document.createElement("td");
  td.classList.add("country");
  const p = document.createElement("p");
  td.append(p);
  if (country === null || country.code === null) {
    p.textContent = STRINGS.unknown;
  } else {
    p.textContent = country.name;
    const flag_img = document.createElement("img");
    flag_img.src = "/assets/flags/" + country.code + ".svg";
    td.append(flag_img);
  }
  return td
}

function addResult(ip) {
  getCountry(ip).then(country => {
    const tr = document.createElement("tr");
    const ip_td = document.createElement("td");
    ip_td.textContent = ip;
    tr.append(ip_td);
    tr.append(createCountryTd(country));
    tbody.append(tr);
    showResults();
  });
}

function hideLoader() {
  loader.style.display = "none";
}

function showResults() {
  hideLoader();
  results.style.removeProperty("display");
}

loader.style.removeProperty("display");
