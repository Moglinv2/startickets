<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link href="style/style.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                    fetchAllMovieDetails(data.verAhora).then(movies => {
                        verAhoraSection.innerHTML = movies.map(movie => `
                            <div class="relative rounded-xl overflow-hidden">
                                <img src="${movie.image}" class="object-cover h-full w-full -z-10" alt="Movie Image">
                                <div class="absolute top-0 h-full w-full bg-gradient-to-t from-black/50 p-3 flex flex-col justify-between">
                                    <div class="self-center flex flex-col items-center space-y-2">
                                        <span class="capitalize text-white font-medium drop-shadow-md">${movie.title}</span>
                                        <a href="movie.php?movie=${movie.id}" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 rounded-lg text-xs inline-block">Ver película</a>
                                    </div>
                                </div>
                            </div>
                        `).join('');
                    });

                    // Obtener detalles para películas próximas
                    fetchAllMovieDetails(data.proximamente).then(movies => {
                        proximamenteSection.innerHTML = movies.map(movie => `
                            <div class="relative rounded-xl overflow-hidden">
                                <img src="${movie.image}" class="object-cover h-full w-full -z-10" alt="Movie Image">
                                <div class="absolute top-0 h-full w-full bg-gradient-to-t from-black/50 p-3 flex flex-col justify-between">
                                    <div class="self-center flex flex-col items-center space-y-2">
                                        <span class="capitalize text-white font-medium drop-shadow-md">${movie.title}</span>
                                        <a href="movie.php?movie=${movie.id}" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 rounded-lg text-xs inline-block">Ver película</a>
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
<body>
    <section class="mt-9">
        <div class="flex items-center justify-between">
            <span class="font-semibold text-gray-700 text-base">En cartelera ahora</span>
        </div>
        <div id="verAhora" class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-x-5 gap-y-5">
            <!-- Películas en cartelera se insertarán aquí -->
        </div>
    </section>

    <section class="mt-9">
        <div class="flex items-center justify-between">
            <span class="font-semibold text-gray-700 text-base">Próximamente</span>
        </div>
        <div id="proximamente" class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-x-5 gap-y-5">
            <!-- Películas próximas se insertarán aquí -->
        </div>
    </section>
</body>
</html>
