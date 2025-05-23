<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InnovaTube</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="app.js"></script>
</head>

<body class="bg-gray-100 text-gray-900">

  <!-- Navbar -->
  <header
    class="bg-white shadow p-4 flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-4 sticky top-0 z-10">
    <div class="text-2xl font-bold text-red-600">InnovaTube</div>

    <div class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
      <div class="flex w-full sm:w-auto">
        <input type="text" id="searchInput" placeholder="Buscar videos..."
          class="border border-gray-300 rounded-l px-3 py-2 w-full sm:w-64" />
        <button onclick="searchVideos()" class="bg-red-600 text-white px-4 py-2 rounded-r hover:bg-red-700">
          Buscar
        </button>
      </div>
      <div class="flex items-center gap-2 mt-2 sm:mt-0">
        <span id="username" class="text-sm font-medium text-gray-700 hidden sm:inline">Usuario</span>
        <button onclick="logout()" class="text-sm bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">
          Cerrar sesión
        </button>
      </div>
    </div>
  </header>

  <!-- Main layout -->
  <main class="flex flex-col lg:flex-row gap-4 p-4">
    <!-- Sección de videos -->
    <section class="flex-1">
      <h2 class="text-lg font-semibold mb-4">Resultados</h2>
      <div id="videosContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Videos se cargan aquí -->
      </div>
    </section>

    <!-- Favoritos -->
    <aside class="lg:w-1/4 bg-white shadow p-4 rounded h-fit">
      <h2 class="text-lg font-semibold mb-4">Favoritos</h2>
      <ul id="favoritesList" class="space-y-2 text-sm">
        <!-- Lista de favoritos -->
      </ul>
    </aside>
  </main>
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
          videoCard.className = "bg-white p-3 rounded shadow hover:shadow-lg transition";

          videoCard.innerHTML = `
            <iframe 
              width="100%" 
              height="200" 
              src="https://www.youtube.com/embed/${videoId}" 
              frameborder="0" 
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
              allowfullscreen 
              class="rounded mb-2">
            </iframe>
            <h3 class="font-semibold text-sm truncate mb-1">${title}</h3>
            <p class="text-xs text-gray-500">Canal: ${channel}</p>
            <button onclick="addToFavorites('${videoId}', '${title.replace(/'/g, "\\'")}')" 
              class="mt-2 text-xs bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
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