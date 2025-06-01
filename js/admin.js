let artworks = JSON.parse(localStorage.getItem("artworks")) || [];

const form = document.getElementById("artwork-form");
const listContainer = document.getElementById("artwork-list");
const idField = document.getElementById("artwork-id");

function renderArtworks() {
  listContainer.innerHTML = "";
  artworks.forEach((art, index) => {
    const div = document.createElement("div");
    div.className = "artwork";
    div.innerHTML = `
      <img src="${art.image}" alt="${art.title}">
      <h3>${art.title}</h3>
      <p>${art.price}€</p>
      <button onclick="editArtwork(${index})">✏️</button>
      <button onclick="deleteArtwork(${index})">🗑️</button>
    `;
    listContainer.appendChild(div);
  });
}

function editArtwork(index) {
  const art = artworks[index];
  idField.value = index;
  form.title.value = art.title;
  form.image.value = art.image;
  form.price.value = art.price;
}

function deleteArtwork(index) {
  if (confirm("Σίγουρα;")) {
    artworks.splice(index, 1);
    saveAndRender();
  }
}

function saveAndRender() {
  localStorage.setItem("artworks", JSON.stringify(artworks));
  renderArtworks();
}

form.addEventListener("submit", (e) => {
  e.preventDefault();
  const newArt = {
    title: form.title.value,
    image: form.image.value,
    price: parseFloat(form.price.value)
  };

  const id = idField.value;
  if (id) {
    artworks[id] = newArt;
    idField.value = "";
  } else {
    artworks.push(newArt);
  }

  form.reset();
  saveAndRender();
});

renderArtworks();
