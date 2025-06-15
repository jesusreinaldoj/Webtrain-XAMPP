<!-- FOOTER -->
<footer>
    © 2025 Página de Entrenamiento. Todos los derechos reservados.
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/image-map-resizer@1.0.10/js/imageMapResizer.min.js"></script>
<script>
    window.onload = function() {
        imageMapResize();
    };


    // Función para obtener todos los ejercicios desde una API y mostrarlos en tarjetas Bootstrap
    async function mostrarEjerciciosPorPrincipal(muscle) {
        const contenedor = document.getElementById("cards-container");
        contenedor.innerHTML = ""; // limpiar

        // Lista de músculos que son 'target' en la API
        const targets = ["abductors","adductors", "abs", "triceps", "biceps", "calves", "forearms", "glutes", "lats", "levator scapulae", "pectorals", "serratus anterior", "spine", "traps", "upper back", "cardiovascular system"];

        let url = 'proxy-ejercicios.php';
        if (muscle) {
            if (targets.includes(muscle.toLowerCase())) {
                url += '?target=' + encodeURIComponent(muscle);
            } else {
                url += '?muscle=' + encodeURIComponent(muscle);
            }
        }

        try {
            let response = await fetch(url);
            if (!response.ok) throw new Error("Error al obtener ejercicios");
            let ejercicios = await response.json();

            // Si la respuesta es un objeto con .data.exercises, usa ese array
            if (ejercicios && typeof ejercicios === 'object' && ejercicios.data && Array.isArray(ejercicios.data.exercises)) {
                ejercicios = ejercicios.data.exercises;
            } else if (ejercicios && typeof ejercicios === 'object' && Array.isArray(ejercicios.exercises)) {
                ejercicios = ejercicios.exercises;
            }

            if (!Array.isArray(ejercicios) || ejercicios.length === 0) {
                contenedor.innerHTML = "<p>No se encontraron ejercicios.</p>";
                return;
            }

            ejercicios.forEach(ej => {
                contenedor.innerHTML += `
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="${ej.gifUrl || 'https://via.placeholder.com/150'}" class="card-img-top" alt="${ej.name}">
                        <div class="card-body">
                            <h5 class="card-title">${ej.name}</h5>
                            <p class="card-text">${ej.target ? 'Músculo principal: ' + ej.target : ''}</p>
                            <p class="card-text">${ej.equipment ? 'Equipo: ' + ej.equipment : ''}</p>
                        </div>
                    </div>
                </div>
            `;
            });
        } catch (error) {
            contenedor.innerHTML = "<p>Error al cargar los ejercicios.</p>";
            console.error(error);
        }
    }
    
    document.getElementById('grupoMuscular').addEventListener('change', async function() {
        debugger;
        const muscle = this.value;
        if (!muscle) return;

        // Diccionario de equivalencias para los nombres de músculos
        const imageApiMap = {
            'glutes': 'gluteus',
            // Puedes añadir más equivalencias si lo necesitas
        };
        const exerciseApiMap = {
            'gluteus': 'glutes',
            // Puedes añadir más equivalencias si lo necesitas
        };

        // Nombre para la API de imagen
        const muscleForImageApi = imageApiMap[muscle] || muscle;
        // Nombre para la API de ejercicios
        const muscleForExerciseApi = exerciseApiMap[muscle] || muscle;

        // Llamada a la API de imagen
        const url = `https://muscle-group-image-generator.p.rapidapi.com/getImage?muscleGroups=${encodeURIComponent(muscleForImageApi)}&color=200%2C100%2C80&transparentBackground=1`;
        const img = document.getElementById('muscle-image');
        img.style.opacity = 0.5;
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'X-RapidAPI-Key': 'cb1f423616msh46ba79571301a68p1d5207jsn87e148fb5158', // Reemplaza con tu API Key
                    'X-RapidAPI-Host': 'muscle-group-image-generator.p.rapidapi.com'
                }
            });
            if (!response.ok) throw new Error('Error al obtener la imagen');
            const blob = await response.blob();
            img.src = URL.createObjectURL(blob);
            img.onload = () => {
                img.style.opacity = 1;
            };
        } catch (error) {
            console.error(error);
            img.style.opacity = 1;
        }
        // Llamada a la API de ejercicios
        mostrarEjerciciosPorPrincipal(muscleForExerciseApi);
    });

    document.getElementById('subGrupos').addEventListener('change', async function() {
        const muscle = this.value;
        if (!muscle) return;

        // Nombre para la API de imagen
        const muscleForImageApi = muscle;
        // Nombre para la API de ejercicios
        const muscleForExerciseApi = muscle;

        // Llamada a la API de imagen
        const url = `https://muscle-group-image-generator.p.rapidapi.com/getImage?muscleGroups=${encodeURIComponent(muscleForImageApi)}&color=200%2C100%2C80&transparentBackground=1`;
        const img = document.getElementById('muscle-image');
        img.style.opacity = 0.5;
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'X-RapidAPI-Key': 'cb1f423616msh46ba79571301a68p1d5207jsn87e148fb5158', // Reemplaza con tu API Key
                    'X-RapidAPI-Host': 'muscle-group-image-generator.p.rapidapi.com'
                }
            });
            if (!response.ok) throw new Error('Error al obtener la imagen');
            const blob = await response.blob();
            img.src = URL.createObjectURL(blob);
            img.onload = () => {
                img.style.opacity = 1;
            };
        } catch (error) {
            console.error(error);
            img.style.opacity = 1;
        }
        // Llamada a la API de ejercicios
        mostrarEjerciciosPorPrincipal(muscleForExerciseApi);
    });
</script>
<?php wp_footer(); ?>

</body>

</html>
