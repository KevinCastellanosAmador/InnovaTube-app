const favoritos = new Map();

async function cargarFavoritos() {
  const res = await fetch(`${base_url}moduloyt/obtener`);
  const data = await res.json();

  if (Array.isArray(data)) {
    data.forEach(({ video_id, titulo }) => {
      favoritos.set(video_id, titulo);
    });
    updateFavoritesUI();
  }
}

document.addEventListener("DOMContentLoaded", () => {
  cargarFavoritos();
  const categorias = [
    "videos de risa",
    "música",
    "documentales",
    "deportes",
    "tecnología",
  ];
  const categoriaAleatoria =
    categorias[Math.floor(Math.random() * categorias.length)];
  searchVideos(categoriaAleatoria);
});

async function searchVideos(defaultQuery = null) {
  const input = document.getElementById("searchInput");
  const query = defaultQuery || input.value.trim();
  const container = document.getElementById("videosContainer");

  if (!query) {
    container.innerHTML =
      "<p class='text-center text-gray-600'>Por favor, escribe algo para buscar.</p>";
    return;
  }

  if (!defaultQuery)
    container.innerHTML = "<p class='text-center'>🔎 Buscando videos...</p>";

  try {
    const response = await fetch(
      `${base_url}moduloyt/searchYT?q=${encodeURIComponent(query)}`
    );
    const data = await response.json();

    if (!data.items || data.items.length === 0) {
      container.innerHTML =
        "<p class='text-center text-red-500'>No se encontraron videos.</p>";
      return;
    }

    container.innerHTML = "";

    data.items.forEach((video) => {
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
        <button onclick="addToFavorites('${videoId}', '${title.replace(
        /'/g,
        "\\'"
      )}')" class="fav-button">
          ⭐ Agregar a Favoritos
        </button>
      `;

      container.appendChild(videoCard);
    });
  } catch (error) {
    console.error(error);
    container.innerHTML =
      "<p class='text-center text-red-500'>❌ Error al obtener resultados.</p>";
  }
}
function toggleFavorites() {
  const panel = document.getElementById("favoritesPanel");
  panel.classList.toggle("hidden");
}


async function addToFavorites(videoId, title) {
  if (favoritos.has(videoId)) {
    favoritos.delete(videoId);
    await fetch(`${base_url}moduloyt/eliminar`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ video_id: videoId })
    });
  } else {
    favoritos.set(videoId, title);
    await fetch(`${base_url}moduloyt/guardar`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ video_id: videoId, titulo: title })
    });
  }

  updateFavoritesUI();
}

function updateFavoritesUI() {
  const list = document.getElementById("favoritesList");
  list.innerHTML = "";

  if (favoritos.size === 0) {
    list.innerHTML = '<li class="text-gray-500 text-sm">No hay favoritos.</li>';
    return;
  }

  for (const [videoId, title] of favoritos.entries()) {
    const li = document.createElement("li");
    li.className = "bg-gray-100 p-2 rounded space-y-2";

    li.innerHTML = `
      <iframe 
        width="100%" 
        height="150" 
        src="https://www.youtube.com/embed/${videoId}" 
        frameborder="0" 
        allowfullscreen 
        class="rounded-md w-full">
      </iframe>
      <div class="flex justify-between items-center text-sm">
        <span class="truncate">${title}</span>
        <button onclick="removeFromFavorites('${videoId}')" class="text-red-500 hover:text-red-700 text-xs">✖</button>
      </div>
    `;

    list.appendChild(li);
  }
}

async function removeFromFavorites(videoId) {
  favoritos.delete(videoId);
    await fetch(`${base_url}moduloyt/eliminar`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ video_id: videoId })
    });

  updateFavoritesUI();
}

function toggleFavorites() {
  const panel = document.getElementById("favoritesPanel");
  const backdrop = document.getElementById("favoritesBackdrop");

  const isVisible = !panel.classList.contains("translate-x-full");

  if (isVisible) {
    panel.classList.add("translate-x-full");
    backdrop.classList.add("hidden");
  } else {
    panel.classList.remove("translate-x-full");
    backdrop.classList.remove("hidden");
  }
}
