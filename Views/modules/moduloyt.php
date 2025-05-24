<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InnovaTube</title>
  <script src="https://cdn.tailwindcss.com"></script>
    <link href="<?php echo BASE_URL . 'Assets/css/moduloyt.css'; ?>" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Navbar -->
  <header class="bg-white shadow p-4 flex flex-col sm:flex-row justify-between items-center gap-4 sticky top-0 z-10">
    <!-- Logo y barra de búsqueda -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full">
      <div class="text-2xl font-bold text-red-600">InnovaTube</div>
      <div class="flex w-full sm:w-auto">
        <input id="searchInput" type="text" placeholder="Buscar videos..."
          class="flex-1 border border-gray-300 rounded-l-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500" />
          <button onclick="searchVideos()"
  class="flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors duration-200 text-sm">
  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103 10.5a7.5 7.5 0 0013.15 6.15z"/></svg>
  Buscar
</button>

      </div>
    </div>
    <div class="flex items-center justify-between w-full sm:w-auto gap-3">
      <span id="username" class="text-sm font-medium text-gray-700"><?php echo $_SESSION['usuario']; ?></span>
      <button onclick="logout()" title="Cerrar sesión"
        class="bg-gray-200 hover:bg-gray-300 p-2 rounded-full sm:px-3 sm:py-1 sm:rounded-md sm:text-sm sm:flex sm:items-center">
        <svg class="w-4 h-4 sm:mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
        </svg>
        <span class="hidden sm:inline"></span>
      </button>
    </div>
  </header>

  <!-- Botón de favoritos en móviles -->
  <div class="block lg:hidden p-4">
    <button onclick="toggleFavorites()"
      class="w-full bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-md">
      Mostrar/Ocultar Favoritos
    </button>
  </div>

  <!-- Main layout -->
  <main class="flex flex-col lg:flex-row gap-4 p-4">
    <!-- Sección de videos -->
    <section class="flex-1">
      <div id="videosContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Videos se cargan aquí -->
      </div>
    </section>

    <!-- Favoritos -->
    <aside id="favoritesPanel" class="lg:w-1/4 bg-white shadow p-4 rounded hidden lg:block transition-all">
      <h2 class="text-lg font-semibold mb-4">⭐ Favoritos</h2>
      <ul id="favoritesList" class="space-y-2 text-sm">
        <!-- Lista de favoritos -->
      </ul>
    </aside>
  </main>
  
  <script>const base_url = '<?php echo BASE_URL; ?>';</script>
  <script src="<?php echo BASE_URL . 'Assets/js/moduloyt.js'; ?>"></script>
</body>

</html>