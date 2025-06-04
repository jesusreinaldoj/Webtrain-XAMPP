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
    async function mostrarEjercicios(muscle) {
        const contenedor = document.getElementById("cards-container");
        contenedor.innerHTML = ""; // limpiar
        try {
            let response;
            try {
                let url = 'proxy-ejercicios.php';
                if (muscle) {
                    url += '?muscle=' + encodeURIComponent(muscle);
                }
                response = await fetch(url);
                if (!response.ok) throw new Error();
            } catch {
                let url = './proxy-ejercicios.php';
                if (muscle) {
                    url += '?muscle=' + encodeURIComponent(muscle);
                }
                response = await fetch(url);
            }
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
                        <img src="${ej.gifUrl || 'https://via.placeholder.com/150'}" class="card-img-top" alt="${ej.name}" onclick="alertar()">
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

    function alertar() {
        alert("CONNECTED TO THE HEAD!");
    }

    document.getElementById('grupoMuscular').addEventListener('change', async function() {
        const muscle = this.value;
        if (!muscle) return;

        // Construir la URL con el músculo seleccionado
        const url = `https://muscle-group-image-generator.p.rapidapi.com/getImage?muscleGroups=${encodeURIComponent(muscle)}&color=200%2C100%2C80&transparentBackground=1`;

        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'X-RapidAPI-Key': 'TU_API_KEY_AQUI', // Reemplaza con tu API Key
                    'X-RapidAPI-Host': 'muscle-group-image-generator.p.rapidapi.com'
                }
            });
            if (!response.ok) throw new Error('Error al obtener la imagen');
            const data = await response.json();

            // Supongamos que la respuesta tiene una propiedad 'imageUrl'
            // Muestra la imagen en algún lugar de tu página
            // Por ejemplo, puedes crear un <img id="muscle-image"> en tu HTML
            document.getElementById('muscle-image').src = data.imageUrl;
        } catch (error) {
            console.error(error);
        }
    });

    // Cambia TU_API_KEY_AQUI por tu clave real de RapidAPI
    document.getElementById('grupoMuscular').addEventListener('change', async function() {
        const muscle = this.value;
        if (!muscle) return;

        const url = `https://muscle-group-image-generator.p.rapidapi.com/getImage?muscleGroups=${encodeURIComponent(muscle)}&color=200%2C100%2C80&transparentBackground=1`;

        // Efecto de actualización (opcional: desvanecer la imagen)
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
            const data = await response.json();

            // Actualiza la imagen
            img.src = data.imageUrl;
            img.onload = () => {
                img.style.opacity = 1;
            }; // Vuelve a mostrar la imagen al cargar
        } catch (error) {
            console.error(error);
            img.style.opacity = 1;
        }
    });
</script>
<?php wp_footer(); ?>

</body>

</html>