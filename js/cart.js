// Κλήση της API για να πάρουμε τα έργα από τη βάση δεδομένων
const fetchArtworks = async () => {
    const response = await fetch('api/get_artworks.php');
    const artworks = await response.json();

    const artworksContainer = document.getElementById('artworks');
    artworks.forEach(artwork => {
        const artworkDiv = document.createElement('div');
        artworkDiv.classList.add('artwork');
        artworkDiv.innerHTML = `
            <img src="img/artworks/${artwork.image}" alt="${artwork.title}">
            <h3>${artwork.title}</h3>
            <p>${artwork.description}</p>
            <p>€${artwork.price.toFixed(2)}</p>
            <button onclick="addToCart(${artwork.id}, '${artwork.title}', ${artwork.price})">Προσθήκη στο καλάθι</button>
        `;
        artworksContainer.appendChild(artworkDiv);
    });
};

// Αποθήκευση και ανάκτηση καλαθιού
let cart = JSON.parse(localStorage.getItem('cart')) || [];

const addToCart = (id, title, price) => {
    const item = { id, title, price, quantity: 1 };
    const existingItem = cart.find(i => i.id === id);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push(item);
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
};

// Ενημέρωση αριθμού προϊόντων στο καλάθι
const updateCartCount = () => {
    const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
    document.querySelector('header nav a').textContent = `Το καλάθι μου (${cartCount})`;
};

window.onload = () => {
    fetchArtworks();
    updateCartCount();
};