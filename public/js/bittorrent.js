function hexEncode(byteArray) {
  return Array.from(byteArray, function(byte) {
    return ('0' + (byte & 0xFF).toString(16)).slice(-2);
  }).join('');
}

var magnetLink;

const ws = new WebSocket(HELPER_URL + "/v1/bittorrent")
const magnetContainer = document.getElementById("magnet");

ws.onmessage = (msg) => {
  magnetLink = msg.data;
  ws.onmessage = (msg) => addResult(msg.data);
  const a = magnetContainer.querySelector("a");
  a.href = magnetLink;
  a.textContent = magnetLink;
  const selection = window.getSelection();
  const range = document.createRange();
  range.selectNodeContents(a);
  selection.removeAllRanges();
  selection.addRange(range);
  showElement(magnetContainer);
  hideLoader();
}

ws.onerror = (e) => {
  console.error(e);
  showError(STRINGS.websocket_error);
}
