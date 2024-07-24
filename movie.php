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
    <style>
        #movie-slider {
            position: relative;
            overflow: hidden;
            width: 100%; /* Asegura que el slider ocupe todo el ancho disponible */
        }

        #movie-images {
            display: flex;
            flex-wrap: nowrap;
            gap: 1rem;
            transition: transform 0.3s ease; /* Transición suave al desplazarse */
        }

        button {
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro semi-transparente */
            border: none;
            border-radius: 50%;
            color: white;
            z-index: 10;
        }
        .px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
}

.mt-6 {
    margin-top: 1.5rem;
}

.px-2 {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
}

.py-1 {
    padding-top: 0.25rem;
    padding-bottom: 0.25rem;
}

    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");
            const movieImages = document.getElementById("movie-images");
            
            let scrollAmount = 0;
            const scrollStep = 300; // Ajusta esto según el tamaño de las imágenes

            // Botón de navegación hacia atrás
            prevBtn.addEventListener("click", () => {
                scrollAmount -= scrollStep;
                if (scrollAmount < 0) {
                    scrollAmount = 0;
                }
                movieImages.style.transform = `translateX(-${scrollAmount}px)`;
            });

            // Botón de navegación hacia adelante
            nextBtn.addEventListener("click", () => {
                scrollAmount += scrollStep;
                const maxScroll = movieImages.scrollWidth - movieImages.clientWidth;
                if (scrollAmount > maxScroll) {
                    scrollAmount = maxScroll;
                }
                movieImages.style.transform = `translateX(-${scrollAmount}px)`;
            });
        });

    </script>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                const params = new URLSearchParams(window.location.search);
                const movieId = params.get('movie');
                if (movieId) {
                    fetch(`https://imdb-api.xsebasthian.workers.dev/title/${movieId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('movie-title').textContent = data.title;
                            document.getElementById('movie-image').style.backgroundImage = `url(${data.image})`;
                            document.getElementById('movie-plot').textContent = data.plot;
                            document.getElementById('movie-rating').textContent = `${data.rating.star} / 10 (${data.rating.count} reviews)`;
                            document.getElementById('movie-genre').textContent = data.genre.join(', ');

                            const actors = data.actors_v2.map(actor => `<a href="#">${actor.name}</a>`).join(', ');
                            document.getElementById('movie-actors').innerHTML = actors;

                            const images = data.images.map(img => `
                                <div class="relative rounded-xl overflow-hidden w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5">
                                    <img src="${img}" class="object-cover w-full h-full" alt="Movie Image">
                                    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-black/50 p-3 flex flex-col justify-between">
                                        <span class="capitalize text-white font-medium drop-shadow-md">${data.title}</span>
                                    </div>
                                </div>
                            `).join('');

                            document.getElementById('movie-images').innerHTML = images;

                            // Inicialización del slider
                            const prevBtn = document.getElementById('prevBtn');
                            const nextBtn = document.getElementById('nextBtn');
                            const movieSlider = document.getElementById('movie-slider');
                            let scrollAmount = 0;

                            nextBtn.addEventListener('click', () => {
                                scrollAmount += movieSlider.clientWidth / 2;
                                if (scrollAmount > movieSlider.scrollWidth - movieSlider.clientWidth) {
                                    scrollAmount = movieSlider.scrollWidth - movieSlider.clientWidth;
                                }
                                movieSlider.scrollTo({
                                    top: 0,
                                    left: scrollAmount,
                                    behavior: 'smooth'
                                });
                            });

                            prevBtn.addEventListener('click', () => {
                                scrollAmount -= movieSlider.clientWidth / 2;
                                if (scrollAmount < 0) {
                                    scrollAmount = 0;
                                }
                                movieSlider.scrollTo({
                                    top: 0,
                                    left: scrollAmount,
                                    behavior: 'smooth'
                                });
                            });
                        })
                        .catch(error => console.error('Error fetching movie data:', error));
                }
            });

            </script>
            
            
            
            
</head>

<body x-data="{ isDark: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches) }" :class="{ 'dark': isDark }" class="font-montserrat text-sm bg-white dark:bg-zinc-900">
    <div class="flex min-h-screen 2xl:max-w-screen-2xl 2xl:mx-auto 2xl:border-x-2 2xl:border-gray-200 dark:2xl:border-zinc-700">
        <!-- Left Sidebar -->
        <main class="flex-1 py-10 px-5 sm:px-10">
            <header class="font-bold text-lg flex items-center gap-x-3 md:hidden mb-12">
                <span class="mr-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-700 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </span>
                <svg class="h-8 w-8 fill-red-600 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M10 15.5v-7c0-.41.47-.65.8-.4l4.67 3.5c.27.2.27.6 0 .8l-4.67 3.5c-.33.25-.8.01-.8-.4Zm11.96-4.45c.58 6.26-4.64 11.48-10.9 10.9 -4.43-.41-8.12-3.85-8.9-8.23 -.26-1.42-.19-2.78.12-4.04 .14-.58.76-.9 1.31-.7v0c.47.17.75.67.63 1.16 -.2.82-.27 1.7-.19 2.61 .37 4.04 3.89 7.25 7.95 7.26 4.79.01 8.61-4.21 7.94-9.12 -.51-3.7-3.66-6.62-7.39-6.86 -.83-.06-1.63.02-2.38.2 -.49.11-.99-.16-1.16-.64v0c-.2-.56.12-1.17.69-1.31 1.79-.43 3.75-.41 5.78.37 3.56 1.35 6.15 4.62 6.5 8.4ZM5.5 4C4.67 4 4 4.67 4 5.5 4 6.33 4.67 7 5.5 7 6.33 7 7 6.33 7 5.5 7 4.67 6.33 4 5.5 4Z"></path>
                </svg>
                <div class="tracking-wide dark:text-white flex-1">MMovie<span class="text-red-600">.</span></div>
                <div class="relative items-center content-center flex ml-2">
                    <span class="text-gray-400 absolute left-4 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" class="text-xs ring-1 bg-transparent ring-gray-200 dark:ring-zinc-600 focus:ring-red-300 pl-10 pr-5 text-gray-600 dark:text-white py-3 rounded-full w-full outline-none focus:ring-1" placeholder="Search ...">
                </div>
            </header>
            <section>
                <nav class="flex space-x-6 text-gray-400 font-medium">
                    <a href="#" class="hover:text-gray-700 dark:hover:text-white">Cartelera</a>
                    <a href="#" class="text-gray-700 dark:text-white font-semibold">Combos</a>
                    <a class="hidden flex items-center space-x-2 py-1 mt-4" href="#">
                        <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input type="checkbox" name="toggle" id="toggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer" @click="isDark = !isDark; localStorage.setItem('darkMode', isDark);" :checked="isDark" />
                            <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                        </div>
                        <label for="toggle" class="">Dark Theme</label>
                    </a>
                </nav>
                <div class="flex flex-col justify-between mt-4 bg-black/10 bg-blend-multiply rounded-3xl h-80 overflow-hidden bg-cover bg-center px-7 pt-4 pb-6 text-white" id="movie-image">
                    <div class="bg-gradient-to-r from-black/30 to-transparent -mx-7 -mb-6 px-7 pb-6 pt-2">
                        <span class="uppercase text-3xl font-semibold drop-shadow-lg" id="movie-title">Título de la película</span>
                        <div class="text-xs text-gray-200 mt-2" id="movie-genre">
                            <a href="#">Género</a>
                        </div>
                        <div class="mt-4 flex space-x-3 items-center">
                            <a href="#" class="p-2.5 bg-gray-800/80 rounded-lg hover:bg-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 015.656 5.656L10 18.656l-6.828-6.828a4 4 0 010-5.656z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div></br>
                <<div class="bg-white dark:bg-zinc-800 rounded-3xl p-7 flex flex-col md:flex-row md:justify-between items-start gap-6">
    <div class="bg-white dark:bg-zinc-800 rounded-3xl p-6 grid grid-cols-2 grid-rows-2 gap-6">
        <div class="flex flex-col justify-center items-center bg-gray-100 dark:bg-zinc-700 rounded-lg p-4 space-y-4"> <!-- Agregado space-y-4 para separar el texto del borde -->
            <h2 class="text-lg font-semibold mb-2 dark:text-white">Sinopsis</h2>
            <div class="p-8 w-full"> <!-- Agregar padding y ocupar el 100% del ancho del contenedor -->
                <p class="text-gray-700 dark:text-white text-sm" id="movie-plot">Sinopsis de la película.</p>
            </div>
        </div>
        <div class="flex flex-col justify-center items-center bg-gray-100 dark:bg-zinc-700 rounded-lg p-4 space-y-4">
            <h2 class="text-lg font-semibold mb-2 dark:text-white">Calificación</h2>
            <p class="text-gray-700 dark:text-white text-sm" id="movie-rating">Calificación de la película.</p>
        </div>
        <div class="flex flex-col justify-center items-center bg-gray-100 dark:bg-zinc-700 rounded-lg p-4 space-y-4">
            <h2 class="text-lg font-semibold mb-2 dark:text-white">Reparto</h2>
            <p class="text-gray-700 dark:text-white text-sm" id="movie-actors">Actores de la película.</p>
        </div>
        <div class="flex flex-col justify-center items-center bg-gray-100 dark:bg-zinc-700 rounded-lg p-4 space-y-4">
            <h2 class="text-lg font-semibold mb-2 dark:text-white">Tráiler</h2>
            <div id="movie-trailer" class="flex justify-center items-center">
                <p class="text-gray-700 dark:text-white text-sm">Tráiler de la película.</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col items-center mt-6 px-4">
        <a href="" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 rounded-lg text-xs">Comprar boletas</a>
    </div>

    <div class="bg-white dark:bg-zinc-800 rounded-3xl p-7 col-span-full mt-6">
        <h2 class="text-lg font-semibold mb-4 dark:text-white text-center">Imágenes</h2>
        <div id="movie-slider" class="relative overflow-hidden px-4">
            <div id="movie-images" class="flex space-x-4 px-4">
                <!-- Las imágenes se agregarán aquí mediante JavaScript -->
            </div>
            <button id="prevBtn" class="absolute left-0 top-1/2 transform -translate-y-1/2 px-2 py-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a.75.75 0 0 0-.53.22l-7 7a.75.75 0 0 0 0 1.06l7 7a.75.75 0 0 0 1.06-1.06L4.56 11H17a.75.75 0 0 0 0-1.5H4.56l5.47-5.47A.75.75 0 0 0 10 3z" clip-rule="evenodd" />
                </svg>
            </button>
            <button id="nextBtn" class="absolute right-0 top-1/2 transform -translate-y-1/2 px-2 py-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a.75.75 0 0 1 .53.22l7 7a.75.75 0 0 1 0 1.06l-7 7a.75.75 0 0 1-1.06-1.06l5.47-5.47H3a.75.75 0 0 1 0-1.5h11.94l-5.47-5.47A.75.75 0 0 1 10 3z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</div>

                
            </section>
        </main>
    </div>
</body>

</html>