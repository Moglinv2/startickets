<?php
session_start(); // Iniciar la sesión

// Incluir archivo de configuración
include 'config.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    header("Location: login.php");
    exit();
}

// Manejo del cierre de sesión
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy(); // Eliminar los datos de la sesión
    header("Location: login.php"); // Redirigir al inicio de sesión
    exit();
}

// Obtener información del usuario desde la sesión
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en" :class="isDark ? 'dark' : 'light'" x-data="{ isDark: false }">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Mazyar">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/style.css" rel="stylesheet">
    <meta name="author" content="Mazyar">
    <title>StarTickets</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Primero obtenemos los IDs de movies.php
            fetch('movies.php')
                .then(response => response.json())
                .then(data => {
                    const fetchMovieDetails = (id) => 
                        fetch(`https://imdb-api.xsebasthian.workers.dev/title/${id}`)
                            .then(response => response.json())
                            .catch(error => console.error('Error fetching movie details:', error));

                    const fetchAllMovieDetails = (ids) => Promise.all(ids.map(fetchMovieDetails));

                    const verAhoraSection = document.getElementById('verAhora');
                    const proximamenteSection = document.getElementById('proximamente');

                    // Obtener detalles para películas en cartelera
                   // Obtener detalles para películas que ya están disponibles
fetchAllMovieDetails(data.verAhora).then(movies => {
    verAhoraSection.innerHTML = movies.map(movie => `
        <div class="relative rounded-xl overflow-hidden bg-gray-900">
            <img src="${movie.image}" class="object-cover h-full w-full" alt="Movie Image">
            <div class="absolute top-0 h-full w-full bg-gradient-to-t from-black/50 p-3 grid grid-rows-3">
                <!-- Primera Fila con Fondo Negro Degradado para el Título -->
                <div class="flex items-center justify-center row-span-1 bg-black bg-opacity-70 py-2">
                    <span class="text-white font-medium text-lg">${movie.title}</span>
                </div>
                <!-- Fila Vacía en el Medio -->
                <div class="row-span-1"></div>
                <!-- Última Fila con Botón Ampliado y Texto Blanco -->
                <div class="flex items-center justify-center row-span-1">
                    <a href="movie.php?movie=${movie.id}" class="px-6 py-3 bg-red-600 hover:bg-red-700 rounded-lg text-white text-center text-lg w-full">Ver película</a>
                </div>
            </div>
        </div>
    `).join('');
});

// Obtener detalles para películas próximas
fetchAllMovieDetails(data.proximamente).then(movies => {
    proximamenteSection.innerHTML = movies.map(movie => `
        <div class="relative rounded-xl overflow-hidden bg-gray-900">
            <img src="${movie.image}" class="object-cover h-full w-full" alt="Movie Image">
            <div class="absolute top-0 h-full w-full bg-gradient-to-t from-black/50 p-3 grid grid-rows-3">
                <!-- Primera Fila con Fondo Negro Degradado para el Título -->
                <div class="flex items-center justify-center row-span-1 bg-black bg-opacity-70 py-2">
                    <span class="text-white font-medium text-lg">${movie.title}</span>
                </div>
                <!-- Fila Vacía en el Medio -->
                <div class="row-span-1"></div>
                <!-- Última Fila con Botón Ampliado y Texto Blanco -->
                <div class="flex items-center justify-center row-span-1">
                    <a href="movie.php?movie=${movie.id}" class="px-6 py-3 bg-red-600 hover:bg-red-700 rounded-lg text-white text-center text-lg w-full">Ver película</a>
                </div>
            </div>
        </div>
    `).join('');
});

                })
                .catch(error => console.error('Error fetching movie IDs:', error));
        });
    </script>
</head>

<body x-data="{ isDark: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches) }" :class="{ 'dark': isDark }" class="font-montserrat text-sm bg-white dark:bg-zinc-900" >
    <div class="flex min-h-screen  2xl:max-w-screen-2xl 2xl:mx-auto 2xl:border-x-2 2xl:border-gray-200 dark:2xl:border-zinc-700 ">
        <!-- Left Sidebar -->
        

        <main class=" flex-1 py-10  px-5 sm:px-10 ">

            <header class=" font-bold text-lg flex items-center  gap-x-3 md:hidden mb-12 ">
                <span class="mr-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-700 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                      </svg>
                </span>
                <svg class="h-8 w-8 fill-red-600 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                </svg>
   
                <div class="tracking-wide dark:text-white flex-1">StarTickets<span class="text-red-600">.</span></div>

                <div class="relative items-center content-center flex ml-2">
                    <span class="text-gray-400 absolute left-4 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" class="text-xs ring-1 bg-transparent ring-gray-200 dark:ring-zinc-600 focus:ring-red-300 pl-10 pr-5 text-gray-600 dark:text-white  py-3 rounded-full w-full outline-none focus:ring-1" placeholder="Search ...">
                </div>
            </header>
           
            <section>
            <nav class="flex items-center justify-between space-x-6 text-gray-400 font-medium">
                <a href="index.php" class="hover:text-gray-700 dark:hover:text-white">Cartelera</a>
                
                <!-- Mensaje de bienvenida y botón de cierre de sesión -->
                <div class="flex items-center space-x-6">
                    <span class="text-white">Bienvenido, <?php echo htmlspecialchars($username); ?>!</span>
                    <a href="?action=logout" class="px-5 py-2.5 bg-red-600  hover:bg-red-700 rounded-lg text-center font-medium block text-white">Cerrar sesión</a>
                    <a class="hidden flex items-center space-x-2 py-1 mt-4" href="#">
                        <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input type="checkbox" name="toggle" id="toggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer"
                                @click="isDark = !isDark; localStorage.setItem('darkMode', isDark);" 
                                :checked="isDark"/>
                            <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                        </div>
                        <label for="toggle" class="">Dark Theme</label>
                    </a>
                </div>
            </nav>


                <div class="flex flex-col justify-between mt-4 bg-black/10 bg-blend-multiply rounded-3xl h-80 overflow-hidden bg-cover bg-center px-7 pt-4 pb-6 text-white"
                 style="background-image: url('images/inception.jpg');" >
                    <!-- <img class="object-cover w-full h-full" src="images/inception.jpg" alt=""> -->
                    
                    
                    <div class="bg-gradient-to-r from-black/30 to-transparent -mx-7 -mb-6 px-7 pb-6 pt-2">
                        <span class="uppercase text-3xl font-semibold drop-shadow-lg ">Inception</span>
                        <div class="text-xs text-gray-200 mt-2">
                            <a href="#" class="">Action</a>,
                            <a href="#" class="">Adventure</a>,
                            <a href="#" class="">Sci-Fi</a>
                        </div>
                        <div class="mt-4 flex space-x-3 items-center">
                            <a href="#" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 rounded-lg text-xs inline-block">Ver pelicula</a>
                            <a href="#" class="p-2.5 bg-gray-800/80 rounded-lg hover:bg-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mt-9">
                <div class="flex items-center justify-between">
                    <span class="font-semibold text-gray-700 text-base dark:text-white">En cartelera ahora</span>
                    <div class="flex items-center space-x-2 fill-gray-500">
                        <svg class="h-7 w-7 rounded-full border p-1 hover:border-red-600 hover:fill-red-600 dark:fill-white dark:hover:fill-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M13.293 6.293L7.58 12l5.7 5.7 1.41-1.42 -4.3-4.3 4.29-4.293Z"></path>
                        </svg>
                        <svg class="h-7 w-7 rounded-full border p-1 hover:border-red-600 hover:fill-red-600 dark:fill-white dark:hover:fill-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M10.7 17.707l5.7-5.71 -5.71-5.707L9.27 7.7l4.29 4.293 -4.3 4.29Z"></path>
                        </svg>
                    </div>
                </div>
               
                <div id="verAhora" class="mt-4 grid grid-cols-2  sm:grid-cols-4 gap-x-5 gap-y-5">
                    
                    
                </div>
            </section>
            <section class="mt-9">
                <div class="flex items-center justify-between">
                    <span class="font-semibold text-gray-700 text-base dark:text-white">Proximamente</span>
                    <div class="flex items-center space-x-2 fill-gray-500">
                        <svg class="h-7 w-7 rounded-full border p-1 hover:border-red-600 hover:fill-red-600 dark:fill-white dark:hover:fill-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M13.293 6.293L7.58 12l5.7 5.7 1.41-1.42 -4.3-4.3 4.29-4.293Z"></path>
                        </svg>
                        <svg class="h-7 w-7 rounded-full border p-1 hover:border-red-600 hover:fill-red-600 dark:fill-white dark:hover:fill-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M10.7 17.707l5.7-5.71 -5.71-5.707L9.27 7.7l4.29 4.293 -4.3 4.29Z"></path>
                        </svg>
                    </div>
                </div>
               
                <div id="proximamente" class="mt-4 grid grid-cols-2  sm:grid-cols-4 gap-x-5 gap-y-5">
                    
                </div>
            </section>
            

        </main>

        <!-- Right Sidebar -->
        <aside class=" w-1/5 py-10 px-10  min-w-min  border-l border-gray-300 dark:border-zinc-700 hidden lg:block ">

            

            <div class="mt-10">
                <span class="font-semibold text-gray-700 dark:text-white">Peliculas populares</span>
                <ul class="mt-4 text-gray-400 text-xs space-y-3">
                    <li class="flex space-y-3 space-x-3 ">
                        <img src="https://caribbeancinemas.com/img/posters/9316.jpg" class="w-1/3 rounded-md" alt="">
                        <div class="flex flex-col justify-between  ">
                            <div class="flex flex-col space-y-1">
                                <span class="text-gray-700 dark:text-white font-semibold">FURIOSA: A MAD MAX SAGA</span>
                                <span class="text-xxs hidden xl:block">Drama</span>
                            </div>
                            <div class="flex space-x-2 items-center">
                                <svg class="w-8 h-5" xmlns="http://www.w3.org/2000/svg" width="64" height="32" viewBox="0 0 64 32" version="1.1"><g fill="#F5C518"><rect x="0" y="0" width="100%" height="100%" rx="4"></rect></g><g transform="translate(8.000000, 7.000000)" fill="#000000" fill-rule="nonzero"><polygon points="0 18 5 18 5 0 0 0"></polygon><path d="M15.6725178,0 L14.5534833,8.40846934 L13.8582008,3.83502426 C13.65661,2.37009263 13.4632474,1.09175121 13.278113,0 L7,0 L7,18 L11.2416347,18 L11.2580911,6.11380679 L13.0436094,18 L16.0633571,18 L17.7583653,5.8517865 L17.7707076,18 L22,18 L22,0 L15.6725178,0 Z"></path><path d="M24,18 L24,0 L31.8045586,0 C33.5693522,0 35,1.41994415 35,3.17660424 L35,14.8233958 C35,16.5777858 33.5716617,18 31.8045586,18 L24,18 Z M29.8322479,3.2395236 C29.6339219,3.13233348 29.2545158,3.08072342 28.7026524,3.08072342 L28.7026524,14.8914865 C29.4312846,14.8914865 29.8796736,14.7604764 30.0478195,14.4865461 C30.2159654,14.2165858 30.3021941,13.486105 30.3021941,12.2871637 L30.3021941,5.3078959 C30.3021941,4.49404499 30.272014,3.97397442 30.2159654,3.74371416 C30.1599168,3.5134539 30.0348852,3.34671372 29.8322479,3.2395236 Z"></path><path d="M44.4299079,4.50685823 L44.749518,4.50685823 C46.5447098,4.50685823 48,5.91267586 48,7.64486762 L48,14.8619906 C48,16.5950653 46.5451816,18 44.749518,18 L44.4299079,18 C43.3314617,18 42.3602746,17.4736618 41.7718697,16.6682739 L41.4838962,17.7687785 L37,17.7687785 L37,0 L41.7843263,0 L41.7843263,5.78053556 C42.4024982,5.01015739 43.3551514,4.50685823 44.4299079,4.50685823 Z M43.4055679,13.2842155 L43.4055679,9.01907814 C43.4055679,8.31433946 43.3603268,7.85185468 43.2660746,7.63896485 C43.1718224,7.42607505 42.7955881,7.2893916 42.5316822,7.2893916 C42.267776,7.2893916 41.8607934,7.40047379 41.7816216,7.58767002 L41.7816216,9.01907814 L41.7816216,13.4207851 L41.7816216,14.8074788 C41.8721037,15.0130276 42.2602358,15.1274059 42.5316822,15.1274059 C42.8031285,15.1274059 43.1982131,15.0166981 43.281155,14.8074788 C43.3640968,14.5982595 43.4055679,14.0880581 43.4055679,13.2842155 Z"></path></g></svg>
                                <span>9.2</span>
                            </div>
                        </div>
                    </li>
                    <li class="pt-1">
                        
                    </li>

                </ul>
            </div>
            <div class="mt-10">
                <span class="font-semibold text-gray-700 dark:text-white">Favorites</span>
                <ul class="mt-4 text-gray-400 text-xs space-y-3">
                    <li class="flex space-x-3 ">
                        <img src="https://upload.wikimedia.org/wikipedia/en/c/c1/The_Matrix_Poster.jpg" class="object-cover w-1/3 rounded-md" alt="">
                        <div class="flex flex-col justify-between  ">
                            <div class="flex flex-col space-y-1">
                                <span class="text-gray-700 dark:text-white font-semibold">The Matrix</span>
                                <span class="text-xxs hidden xl:block">Action, Sci-Fi</span>
                            </div>
                            <div class="flex space-x-2 items-center">
                                <svg class="w-8 h-5" xmlns="http://www.w3.org/2000/svg" width="64" height="32" viewBox="0 0 64 32" version="1.1"><g fill="#F5C518"><rect x="0" y="0" width="100%" height="100%" rx="4"></rect></g><g transform="translate(8.000000, 7.000000)" fill="#000000" fill-rule="nonzero"><polygon points="0 18 5 18 5 0 0 0"></polygon><path d="M15.6725178,0 L14.5534833,8.40846934 L13.8582008,3.83502426 C13.65661,2.37009263 13.4632474,1.09175121 13.278113,0 L7,0 L7,18 L11.2416347,18 L11.2580911,6.11380679 L13.0436094,18 L16.0633571,18 L17.7583653,5.8517865 L17.7707076,18 L22,18 L22,0 L15.6725178,0 Z"></path><path d="M24,18 L24,0 L31.8045586,0 C33.5693522,0 35,1.41994415 35,3.17660424 L35,14.8233958 C35,16.5777858 33.5716617,18 31.8045586,18 L24,18 Z M29.8322479,3.2395236 C29.6339219,3.13233348 29.2545158,3.08072342 28.7026524,3.08072342 L28.7026524,14.8914865 C29.4312846,14.8914865 29.8796736,14.7604764 30.0478195,14.4865461 C30.2159654,14.2165858 30.3021941,13.486105 30.3021941,12.2871637 L30.3021941,5.3078959 C30.3021941,4.49404499 30.272014,3.97397442 30.2159654,3.74371416 C30.1599168,3.5134539 30.0348852,3.34671372 29.8322479,3.2395236 Z"></path><path d="M44.4299079,4.50685823 L44.749518,4.50685823 C46.5447098,4.50685823 48,5.91267586 48,7.64486762 L48,14.8619906 C48,16.5950653 46.5451816,18 44.749518,18 L44.4299079,18 C43.3314617,18 42.3602746,17.4736618 41.7718697,16.6682739 L41.4838962,17.7687785 L37,17.7687785 L37,0 L41.7843263,0 L41.7843263,5.78053556 C42.4024982,5.01015739 43.3551514,4.50685823 44.4299079,4.50685823 Z M43.4055679,13.2842155 L43.4055679,9.01907814 C43.4055679,8.31433946 43.3603268,7.85185468 43.2660746,7.63896485 C43.1718224,7.42607505 42.7955881,7.2893916 42.5316822,7.2893916 C42.267776,7.2893916 41.8607934,7.40047379 41.7816216,7.58767002 L41.7816216,9.01907814 L41.7816216,13.4207851 L41.7816216,14.8074788 C41.8721037,15.0130276 42.2602358,15.1274059 42.5316822,15.1274059 C42.8031285,15.1274059 43.1982131,15.0166981 43.281155,14.8074788 C43.3640968,14.5982595 43.4055679,14.0880581 43.4055679,13.2842155 Z"></path></g></svg>
                                <span>8.7</span>
                            </div>
                        </div>
                    </li>
                    
                    <li class="pt-1">
                        
                    </li>

                </ul>
            </div>
            
        </aside><!-- /Right Sidebar -->


    </div>

</body>

</html>