<?php
/**
 * Plugin Name: Rutina Workout API
 * Description: Formulario para generar rutinas personalizadas con una API externa y guardarlas para cada usuario.
 * Version: 1.1
 * Author: Webtrain
 */

if (!defined('ABSPATH')) exit; // Seguridad

// Shortcode para mostrar el formulario
function rutina_form_shortcode()
{
    if (!is_user_logged_in()) {
        return '<p>Debes iniciar sesión para generar una rutina.</p>';
    }

    ob_start();
?>
    <form id="rutina-form" class="left-panel">
        <h1 class="mb-4">Generar Rutina Personalizada</h1>

        <label for="goal" class="form-label">¿Cuál es tu objetivo?</label>
        <input type="text" id="goal" name="goal" class="form-control mb-3" placeholder="Ej: Ganar músculo, mejorar resistencia..." required>

        <label for="fitness_level" class="form-label">Nivel físico:</label>
        <select id="fitness_level" name="fitness_level" class="form-select mb-3" required>
            <option value="Principiante">Principiante</option>
            <option value="Intermedio">Intermedio</option>
            <option value="Avanzado">Avanzado</option>
        </select>

        <label class="form-label">Preferencias:</label>
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" id="pesas" name="preferences[]" value="Entrenamiento con pesas" class="form-check-input">
                <label for="pesas" class="form-check-label">Pesas</label>
            </div>
            <div class="form-check">
                <input type="checkbox" id="cardio" name="preferences[]" value="Cardio" class="form-check-input">
                <label for="cardio" class="form-check-label">Cardio</label>
            </div>
        </div>

        <label for="health_conditions" class="form-label">Condiciones médicas:</label>
        <input type="text" id="health_conditions" name="health_conditions" class="form-control mb-3" value="Ninguna">

        <label for="days_per_week" class="form-label">Días por semana:</label>
        <input type="number" id="days_per_week" name="days_per_week" class="form-control mb-3" value="4" min="1" max="7">

        <label for="session_duration" class="form-label">Duración de sesión (minutos):</label>
        <input type="number" id="session_duration" name="session_duration" class="form-control mb-3" value="60">

        <label for="plan_duration_weeks" class="form-label">Duración del plan (semanas):</label>
        <input type="number" id="plan_duration_weeks" name="plan_duration_weeks" class="form-control mb-3" value="4">

        <input type="hidden" name="lang" value="es">
        <input type="hidden" name="action" value="generar_rutina">

        <button type="submit" class="btn btn-primary w-100">Generar rutina</button>
    </form>

    <div id="rutina-result" class="mt-4"></div>

    <script>
    document.getElementById('rutina-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        // Mostrar mensaje de carga
        document.getElementById('rutina-result').innerHTML = "<p><strong>Generando rutina...</strong> Por favor, espera unos segundos.</p>";

        fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
            method: "POST",
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            if (!data.success || !data.data || !data.data.result) {
                document.getElementById('rutina-result').innerHTML = "<p>No se pudo generar la rutina. Intenta más tarde.</p>";
                return;
            }

            const rutina = data.data.result;

            let html = `
                <h2>${rutina.seo_title}</h2>
                <p><strong>Objetivo:</strong> ${rutina.goal}</p>
                <p><strong>Nivel:</strong> ${rutina.fitness_level}</p>
                <p><strong>Duración del plan:</strong> ${rutina.total_weeks} semanas</p>
                <p><strong>Descripción:</strong> ${rutina.seo_content}</p>
                <h3>Ejercicios:</h3>
            `;

            if (!Array.isArray(rutina.exercises) || rutina.exercises.length === 0) {
                html += `<p>No se han generado ejercicios aún. Por favor, espera unos segundos y vuelve a intentarlo.</p>`;
            } else {
                rutina.exercises.forEach((dia, index) => {
                    html += `<div class="mb-3 card"><div class="card-body"><h4 class="card-title">Día ${index + 1} - ${dia.day}</h4><ul class="class="card-title"">`;
                    if (Array.isArray(dia.exercises)) {
                        dia.exercises.forEach(ejercicio => {
                            html += `<li><strong>${ejercicio.name}</strong> - ${ejercicio.sets} sets x ${ejercicio.repetitions} repeticiones (${ejercicio.duration}, equipo: ${ejercicio.equipment})</li>`;
                        });
                    }
                    html += "</ul></div></div>";
                });
            }

            document.getElementById('rutina-result').innerHTML = html;
        })
        .catch(error => {
            console.error("Error:", error);
            document.getElementById('rutina-result').innerHTML = "<p>Error al procesar la solicitud.</p>";
        });
    });
    </script>

<?php
    return ob_get_clean();
}
add_shortcode('formulario_rutina', 'rutina_form_shortcode');

// AJAX handler
add_action('wp_ajax_generar_rutina', 'generar_rutina_api');
// No permitimos usuarios no logueados que usen esta acción (el formulario no se muestra a no logueados)
add_action('wp_ajax_nopriv_generar_rutina', function() {
    wp_send_json_error(['message' => 'Debes iniciar sesión para generar una rutina.']);
});

function generar_rutina_api()
{
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'No autorizado']);
    }

    $goal = sanitize_text_field($_POST['goal']);
    $fitness_level = sanitize_text_field($_POST['fitness_level']);
    $preferences = isset($_POST['preferences']) ? array_map('sanitize_text_field', $_POST['preferences']) : [];
    $health_conditions = sanitize_text_field($_POST['health_conditions']);
    $days = intval($_POST['days_per_week']);
    $duration = intval($_POST['session_duration']);
    $weeks = intval($_POST['plan_duration_weeks']);
    $lang = 'es';

    $body = [
        'goal' => $goal,
        'fitness_level' => $fitness_level,
        'preferences' => $preferences,
        'health_conditions' => [$health_conditions],
        'schedule' => [
            'days_per_week' => $days,
            'session_duration' => $duration
        ],
        'plan_duration_weeks' => $weeks,
        'lang' => $lang
    ];

    $response = wp_remote_post('https://ai-workout-planner-exercise-fitness-nutrition-guide.p.rapidapi.com/generateWorkoutPlan?noqueue=1', [
        'headers' => [
            'Content-Type' => 'application/json',
            'X-RapidAPI-Key' => '729f0593c2msh5943d71aa7e36edp134690jsndf3d2b1f8507',
            'X-RapidAPI-Host' => 'ai-workout-planner-exercise-fitness-nutrition-guide.p.rapidapi.com'
        ],
        'body' => json_encode($body),
        'method' => 'POST',
        'timeout' => 20,
    ]);

    if (is_wp_error($response)) {
        wp_send_json_error(['message' => 'Error al conectarse a la API.']);
    } else {
        $data = json_decode(wp_remote_retrieve_body($response), true);

        if (!$data || !isset($data['result'])) {
            wp_send_json_error(['message' => 'Respuesta inválida de la API.']);
        }

        // Guardar la rutina en meta del usuario, agregando a un array de rutinas
        $user_id = get_current_user_id();
        $rutinas = get_user_meta($user_id, 'rutinas_generadas', true);
        if (!is_array($rutinas)) {
            $rutinas = [];
        }

        // Añadimos fecha para identificar
        $data['fecha_generacion'] = current_time('mysql');
        $rutinas[] = $data;

        update_user_meta($user_id, 'rutinas_generadas', $rutinas);

        wp_send_json_success($data);
    }
}

// Shortcode para mostrar las rutinas guardadas del usuario
function mostrar_rutinas_usuario()
{
    if (!is_user_logged_in()) {
        return '<p>Debes iniciar sesión para ver tus rutinas.</p>';
    }

    $user_id = get_current_user_id();
    $rutinas = get_user_meta($user_id, 'rutinas_generadas', true);

    if (empty($rutinas) || !is_array($rutinas)) {
        return '<p>No tienes rutinas guardadas.</p>';
    }

    ob_start();

    echo '<h2>Mis Rutinas Guardadas</h2>';

    foreach ($rutinas as $index => $rutina_data) {
        $rutina = $rutina_data['result'] ?? null;
        $fecha = isset($rutina_data['fecha_generacion']) ? esc_html($rutina_data['fecha_generacion']) : 'Fecha desconocida';

        if (!$rutina) continue;

        echo '<div style="border:1px solid #ccc; padding:15px; margin-bottom:20px;">';
        echo '<h3>Rutina #' . ($index + 1) . ' (' . $fecha . ')</h3>';
        echo '<p><strong>Objetivo:</strong> ' . esc_html($rutina['goal']) . '</p>';
        echo '<p><strong>Nivel:</strong> ' . esc_html($rutina['fitness_level']) . '</p>';
        echo '<p><strong>Duración del plan:</strong> ' . esc_html($rutina['total_weeks']) . ' semanas</p>';
        echo '<p><strong>Descripción:</strong> ' . esc_html($rutina['seo_content']) . '</p>';

        echo '<h4>Ejercicios:</h4>';
        if (empty($rutina['exercises']) || !is_array($rutina['exercises'])) {
            echo '<p>No hay ejercicios disponibles para esta rutina.</p>';
        } else {
            foreach ($rutina['exercises'] as $dia_index => $dia) {
                echo '<div class="card mb-3"><div class="card-body"><strong>Día ' . ($dia_index + 1) . ' - ' . esc_html($dia['day']) . '</strong><ul>';
                if (isset($dia['exercises']) && is_array($dia['exercises'])) {
                    foreach ($dia['exercises'] as $ejercicio) {
                        echo '<li><strong>' . esc_html($ejercicio['name']) . '</strong> - ' . esc_html($ejercicio['sets']) . ' sets x ' . esc_html($ejercicio['repetitions']) . ' repeticiones (' . esc_html($ejercicio['duration']) . ', equipo: ' . esc_html($ejercicio['equipment']) . ')</li>';
                    }
                }
                echo '</ul></div></div>';
            }
        }
        echo '</div>';
    }

    return ob_get_clean();
}
add_shortcode('mis_rutinas', 'mostrar_rutinas_usuario');
