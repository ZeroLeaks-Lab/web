function loadIPs() {
  const p = new RTCPeerConnection({ iceServers: [{ urls: "stun:" + STUN_SERVER }] });
  p.onicecandidate = (event) => {
    if (event.candidate && event.candidate.candidate) {
      console.log(event.candidate)
      const split = event.candidate.candidate.split(" ");
      if (split[7] !== "host") {
        addResult(split[4]);
      }
    }
  };
  p.createDataChannel("");
  p.createOffer().then((offer) => p.setLocalDescription(offer))
}

loadIPs();
