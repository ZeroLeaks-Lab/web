class History {
  constructor(container) {
    this.container = container;
    this.tbody = this.container.querySelector("tbody");
    const json = localStorage.getItem("history");
    if (json === null) {
      this.history = [];
    } else {
      this.history = JSON.parse(json);
    }
  }

  display() {
    this.tbody.replaceChildren();
    for (let i = this.history.length - 1; i >= 0; --i) {
      const tr = createIpTr(this.history[i][0], this.history[i][1]);
      const time_td = document.createElement("td");
      time_td.textContent = new Date(this.history[i][2]).toLocaleString();
      tr.append(time_td);
      this.tbody.append(tr);
    }
    if (this.history.length > 0) {
      showElement(this.container);
    }
  }

  #save() {
    localStorage.setItem("history", JSON.stringify(this.history));
  }

  add(ip, country) {
    if (this.history.length > 0 && this.history[this.history.length - 1][0] === ip) {
      return;
    }
    this.history.push([ip, country, Date.now()]);
    if (HISTORY_MAX_SIZE != 0) {
      const e = this.history.length - HISTORY_MAX_SIZE;
      for (let i = 0; i < e; ++i) {
        this.history.shift();
      }
    }
    this.#save();
    this.display();
  }

  clear() {
    this.history = [];
    this.#save();
    this.container.classList.add("hidden");
  }
}

const ipHistory = new History(document.querySelector("#history"));
ipHistory.display();

document.querySelector("#history button").onclick = () => {
  ipHistory.clear();
}
