function showElement(e) {
  e.classList.remove("hidden");
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

function createIpTr(ip, country) {
  const ip_td = document.createElement("td");
  ip_td.textContent = ip;
  const tr = document.createElement("tr");
  tr.append(ip_td);
  tr.append(createCountryTd(country));
  return tr;
}
