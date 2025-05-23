<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InnovaTube</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="app.js"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">
  <!-- Navbar -->
  <header class="bg-white shadow-sm p-4 flex flex-col sm:flex-row justify-between items-center gap-4 sticky top-0 z-10">
    <div class="text-3xl font-bold text-red-600 tracking-tight">InnovaTube</div>

    <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
      <div class="flex w-full sm:w-80">
        <input type="text" id="searchInput" placeholder="Buscar videos..."
          class="border border-gray-300 rounded-l-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-red-500" />
        <button onclick="searchVideos()" class="bg-red-600 text-white px-4 py-2 rounded-r-lg hover:bg-red-700">
          Buscar
        </button>
      </div>
      <div class="flex items-center gap-3 text-sm font-medium">
        <span id="username" class="hidden sm:inline text-gray-700">Usuario</span>
        <button onclick="logout()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg">
          Cerrar sesión
        </button>
      </div>
    </div>
  </header>

  <!-- Layout principal -->
  <main class="flex flex-col lg:flex-row gap-6 p-6">
    <!-- Resultados -->
    <section class="flex-1">
      <h2 class="text-xl font-semibold mb-4">Resultados</h2>
      <div id="videosContainer" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
        <!-- Videos aquí -->
      </div>
    </section>

    <!-- Favoritos -->
    <aside class="lg:w-1/4 bg-white shadow rounded-2xl p-5">
      <h2 class="text-xl font-semibold mb-4">⭐ Favoritos</h2>
      <ul id="favoritesList" class="space-y-4">
        <!-- Lista de favoritos -->
      </ul>
    </aside>
  </main>

  <!-- Estilo para tarjetas de video -->
  <style>
    .video-card {
      @apply bg-white p-4 rounded-2xl shadow transition hover:shadow-lg flex flex-col;
    }

    .video-title {
      @apply font-semibold text-base text-gray-800 leading-snug mt-2 truncate;
    }

    .video-channel {
      @apply text-sm text-gray-500 mt-1;
    }

    .fav-button {
      @apply mt-3 inline-flex items-center gap-1 text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md;
    }
  </style>
  <script>
    const base_url = '<?php echo BASE_URL; ?>';

    async function searchVideos() {
      const query = document.getElementById('searchInput').value.trim();
      if (!query) return;

      const container = document.getElementById('videosContainer');
      container.innerHTML = 'Cargando...';

      try {
        const res = await fetch(`${base_url}moduloyt/searchYT?q=${encodeURIComponent(query)}`);
        const data = await res.json();

        container.innerHTML = '';

        if (!data.items || data.items.length === 0) {
          container.innerHTML = 'No se encontraron videos.';
          return;
        }

        data.items.forEach(video => {
          const videoCard = document.createElement('div');
          videoCard.className = 'bg-white p-2 rounded shadow hover:shadow-lg transition';

          videoCard.innerHTML = `
        <img src="${video.snippet.thumbnails.medium.url}" class="w-full rounded">
        <h3 class="text-sm mt-2 font-semibold">${video.snippet.title}</h3>
        <button onclick="addToFavorites('${video.id.videoId}', '${video.snippet.title}')" class="mt-2 bg-blue-500 text-white text-xs px-2 py-1 rounded hover:bg-blue-600">Agregar a Favoritos</button>
      `;

          container.appendChild(videoCard);
        });
      } catch (err) {
        console.error(err);
        container.innerHTML = 'Error al cargar los videos.';
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

    async function searchVideos() {
      const query = document.getElementById('searchInput').value.trim();
      const container = document.getElementById('videosContainer');

      if (!query) {
        container.innerHTML = "<p class='text-center text-gray-600'>Por favor, escribe algo para buscar.</p>";
        return;
      }

      container.innerHTML = "<p class='text-center'>🔎 Buscando videos...</p>";

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
      const list = document.getElementById("favoritesList");

      const li = document.createElement("li");
      li.textContent = title;
      list.appendChild(li);

      // Aquí luego conectamos con backend para guardarlos realmente en la base de datos
    }

    function logout() {
      window.location.href = "/backend/logout.php";
    }
  </script>
</body>

</html>