//funcion para videos leatorios al inicio
document.addEventListener("DOMContentLoaded", () => {
  const categorias = ['videos de risa', 'música', 'documentales', 'deportes', 'tecnología'];
  const categoriaAleatoria = categorias[Math.floor(Math.random() * categorias.length)];
  searchVideos(categoriaAleatoria);
});

async function searchVideos(defaultQuery = null) {
  const input = document.getElementById('searchInput');
  const query = defaultQuery || input.value.trim();
  const container = document.getElementById('videosContainer');

  if (!query) {
    container.innerHTML = "<p class='text-center text-gray-600'>Por favor, escribe algo para buscar.</p>";
    return;
  }

  if (!defaultQuery) container.innerHTML = "<p class='text-center'>🔎 Buscando videos...</p>";

  try {
    const response = await fetch(`${base_url}moduloyt/searchYT?q=${encodeURIComponent(query)}`);
    const data = await response.json();

    if (!data.items || data.items.length === 0) {
      container.innerHTML = "<p class='text-center text-red-500'>No se encontraron videos.</p>";
      return;
    }

    container.innerHTML = "";

    data.items.forEach(video => {
      const videoId = video.id.videoId;
      const title = video.snippet.title;
      const thumbnail = video.snippet.thumbnails.medium.url;
      const channel = video.snippet.channelTitle;

      const videoCard = document.createElement("div");
      videoCard.className = "video-card";

      videoCard.innerHTML = `
        <iframe 
          width="100%" 
          height="200" 
          src="https://www.youtube.com/embed/${videoId}" 
          frameborder="0" 
          allowfullscreen 
          class="rounded-lg mb-2">
        </iframe>
        <h3 class="video-title">${title}</h3>
        <p class="video-channel">Canal: ${channel}</p>
        <button onclick="addToFavorites('${videoId}', '${title.replace(/'/g, "\\'")}')" class="fav-button">
          ⭐ Agregar a Favoritos
        </button>
      `;

      container.appendChild(videoCard);
    });

  } catch (error) {
    console.error(error);
    container.innerHTML = "<p class='text-center text-red-500'>❌ Error al obtener resultados.</p>";
  }
}

function addToFavorites(videoId, title) {
  const list = document.getElementById('favoritesList');
  const li = document.createElement('li');
  li.textContent = title;
  list.appendChild(li);

  // Aquí puedes hacer un POST a `/backend/api/favorites.php`
}

function logout() {
  // Simula cierre de sesión, más adelante redirecciona o destruye sesión PHP
  window.location.href = '/backend/logout.php';
}


function addToFavorites(videoId, title) {
  const list = document.getElementById("favoritesList");
  const li = document.createElement("li");
  li.textContent = title;
  list.appendChild(li);

}

function logout() {
  window.location.href = "/backend/logout.php";
}