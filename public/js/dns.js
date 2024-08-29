const imgs = document.getElementById("imgs");

const ws = new WebSocket(HELPER_URL + "/v1/dns");

ws.onmessage = (msg) => {
  const params = JSON.parse(msg.data);
  ws.onmessage = (msg) => addResult(msg.data);
  const size = Math.min(params.subdomains.length, 6);
  for (let i = 0; i < size; ++i) {
    const img = document.createElement("img");
    img.src = "https://" + params.subdomains[i] + "." + params.base;
    imgs.append(img);
  }
}

ws.onerror = (e) => {
  console.error(e);
  showError(STRINGS.websocket_error);
}
