function hexEncode(byteArray) {
  return Array.from(byteArray, function(byte) {
    return ('0' + (byte & 0xFF).toString(16)).slice(-2);
  }).join('');
}

const ws = new WebSocket(HELPER_URL + "/v1/bittorrent")

ws.onmessage = (msg) => {
  ws.onmessage = (msg) => addResult(msg.data);
  const a = inner.querySelector("a");
  const magnetLink = msg.data;
  a.href = magnetLink;
  a.textContent = magnetLink;
  const selection = window.getSelection();
  const range = document.createRange();
  range.selectNodeContents(a);
  selection.removeAllRanges();
  selection.addRange(range);
  showElement(inner);
  hideLoader();
}

handleWebsocket(ws);
