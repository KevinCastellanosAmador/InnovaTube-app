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
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103 10.5a7.5 7.5 0 0013.15 6.15z" />
          </svg>
          Buscar
        </button>

      </div>
    </div>
    <div class="flex items-center justify-between w-full sm:w-auto gap-3">
      <span id="username" class="text-sm font-medium text-gray-700"><?php echo $_SESSION['usuario']; ?></span>
      <div class="flex items-center justify-between w-full sm:w-auto gap-3">
        <!-- Botón Mostrar/Ocultar Favoritos -->
        <button onclick="toggleFavorites()" title="Favoritos"
          class="lg:hidden flex items-center gap-1 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-medium px-3 py-1 rounded-md text-sm transition-colors duration-200">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path
              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.157c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.286 3.95c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37 2.448c-.784.57-1.838-.197-1.539-1.118l1.286-3.95a1 1 0 00-.364-1.118L2.07 9.377c-.783-.57-.38-1.81.588-1.81h4.157a1 1 0 00.95-.69l1.286-3.95z" />
          </svg>
          Favoritos
        </button>
      </div>
      <button onclick="window.location.href='<?php echo BASE_URL . 'principal/logout'; ?>'" title="Cerrar sesión"
        class="bg-gray-200 hover:bg-gray-300 p-2 rounded-full sm:px-3 sm:py-1 sm:rounded-md sm:text-sm sm:flex sm:items-center">
        <svg class="w-4 h-4 sm:mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
        </svg>
        <span class="hidden sm:inline">Salir</span>
      </button>
    </div>
  </header>

  <main class="flex flex-col lg:flex-row gap-4 p-4">
    <!-- Sección de videos -->
    <section class="flex-1">
      <div id="videosContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Videos se cargan aquí -->
      </div>
    </section>

    <!-- Favoritos -->
    <aside id="favoritesPanel"
  class="fixed lg:static top-0 right-0 max-h-screen w-3/4 max-w-xs lg:max-w-full bg-white shadow p-4 z-50 transform translate-x-full lg:translate-x-0 lg:w-1/4 overflow-y-auto transition-transform duration-300 ease-in-out">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">⭐ Favoritos</h2>
        <button onclick="toggleFavorites()" class="lg:hidden text-gray-500 hover:text-gray-800 text-xl">&times;</button>
      </div>
      <ul id="favoritesList" class="space-y-4 text-sm">
        <!-- Lista de favoritos -->
      </ul>
    </aside>
  </main>
  <div id="favoritesBackdrop" onclick="toggleFavorites()"
    class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

  <script>const base_url = '<?php echo BASE_URL; ?>';</script>
  <script src="<?php echo BASE_URL . 'Assets/js/moduloyt.js'; ?>"></script>
</body>

</html>