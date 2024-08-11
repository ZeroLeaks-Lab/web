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

function displayIp(ip) {
  getCountry(ip).then(country => {
    const tr = document.createElement("tr");
    const ip_td = document.createElement("td");
    ip_td.textContent = ip;
    tr.append(ip_td);
    const country_p = document.createElement("p");
    country_p.classList.add("country");
    const country_td = document.createElement("td");
    country_td.append(country_p);
    if (country === null || country.code === null) {
      country_p.textContent = STRINGS.unknown;
    } else {
      country_p.textContent = country.name;
      const flag_img = document.createElement("img");
      flag_img.src = "/assets/flags/" + country.code + ".svg";
      country_p.append(flag_img);
    }
    tr.append(country_td);
    loader.style.display = "none";
    results.style.removeProperty("display");
    tbody.append(tr);
  })
}

function loadIPs() {
  const p = new RTCPeerConnection({ iceServers: [{ urls: "stun:" + STUN_SERVER }] });
  p.onicecandidate = (event) => {
    if (event.candidate && event.candidate.candidate) {
      console.log(event.candidate)
      const split = event.candidate.candidate.split(" ");
      if (split[7] !== "host") {
        displayIp(split[4]);
      }
    }
  };
  p.createDataChannel("");
  p.createOffer().then((offer) => p.setLocalDescription(offer))
}

loader.style.removeProperty("display");
loadIPs();
