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
  const p = document.createElement("p");
  p.classList.add("country");
  if (country === null || country.code === null) {
    p.textContent = STRINGS.unknown;
  } else {
    p.textContent = country.name;
    const flag_img = document.createElement("img");
    flag_img.src = "/assets/flags/" + country.code + ".svg";
    p.append(flag_img);
  }
  const td = document.createElement("td");
  td.append(p);
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

function showResults() {
  loader.style.display = "none";
  results.style.removeProperty("display");
}

loader.style.removeProperty("display");
