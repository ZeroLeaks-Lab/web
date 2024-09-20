const loader = document.querySelector("#loader");
const tbody = document.querySelector("#results tbody");
const inner = document.getElementById("inner");

let nbResults = 0;
let error = false;

async function getCountry(ip) {
  const response = await fetch("/api/country/" + ip);
  if (!response.ok) {
    return null;
  }
  return await response.json();
}

function addResult(ip) {
  getCountry(ip).then(country => {
    tbody.append(createIpTr(ip, country));
    if (nbResults++ == 0) {
      hideLoader();
      showElement(document.querySelector("#results"));
      const refresh = document.querySelector("button.refresh");
      if (refresh !== null) {
        showElement(refresh);
      }
    }
    if (typeof ipHistory !== 'undefined') {
      ipHistory.add(ip, country);
    }
  });
}

function hideLoader() {
  loader.classList.add("hidden");
}

function showError(error) {
  const p = document.querySelector("p.error");
  p.textContent = STRINGS.error + ": " + error;
  hideLoader();
  showElement(p);
  if (nbResults == 0) {
    inner.classList.add("hidden");
  }
}

function handleWebsocket(ws) {
  ws.onerror = (e) => {
    console.error(e);
    error = true;
    showError(STRINGS.websocket_error);
  }
  ws.onclose = () => {
    if (nbResults == 0 && !error) {
      showError(STRINGS.websocket_closed);
    }
  };
}

showElement(loader);
