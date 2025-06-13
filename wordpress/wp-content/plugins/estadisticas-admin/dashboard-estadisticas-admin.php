<?php
/*
Plugin Name: Admin Stats Dashboard
Description: Muestra estadísticas de noticias, usuarios y rutinas generadas con gráficas usando Chart.js. Solo visible para administradores.
Version: 1.0
Author: Tu Nombre
*/

if (!defined('ABSPATH')) exit;

// Agrega el menú en el admin
add_action('admin_menu', function() {
    add_menu_page(
        'Estadísticas',
        'Estadísticas',
        'manage_options',
        'admin-stats-dashboard',
        'mostrar_dashboard_estadisticas',
        'dashicons-chart-bar',
        2
    );
});

// Encolar Chart.js y estilos
add_action('admin_enqueue_scripts', function($hook) {
    if ($hook !== 'toplevel_page_admin-stats-dashboard') return;

    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js', [], null, true);
});

// Función principal para mostrar la página
function mostrar_dashboard_estadisticas() {
    $post_counts = wp_count_posts('article');
    $post_count = isset($post_counts->publish) ? $post_counts->publish : 0;

    global $wpdb;
    $users_by_month = [];
    $labels = [];
    $now = current_time('timestamp');

    for ($i = 5; $i >= 0; $i--) {
        $start = date('Y-m-01', strtotime("-$i months", $now));
        $end = date('Y-m-t 23:59:59', strtotime($start));
        $count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(ID) FROM $wpdb->users WHERE user_registered BETWEEN %s AND %s",
            $start, $end
        ));
        $users_by_month[] = (int)$count;
        $labels[] = date_i18n('F Y', strtotime($start));
    }

    $user_ids = get_users(['fields' => 'ID']);
    $total_rutinas = 0;
    foreach ($user_ids as $user_id) {
        $rutinas = get_user_meta($user_id, 'rutinas_generadas', true);
        if (is_array($rutinas)) {
            $total_rutinas += count($rutinas);
        }
    }

    // --- NUEVO: obtener usuarios por rol ---
    $count_users = count_users();
    $roles = $count_users['avail_roles']; // array rol => cantidad
    $roles_labels = array_keys($roles);
    $roles_counts = array_values($roles);

    ?>
    <div class="wrap">
        <h1>Estadísticas del Sitio</h1>
        <div style="display: flex; gap: 20px; margin-bottom: 40px;">
            <div style="background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 5px #ccc;">
                <h2>Total Noticias</h2>
                <p style="font-size: 2em;"><?= esc_html($post_count) ?></p>
            </div>
            <div style="background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 5px #ccc;">
                <h2>Total Rutinas Generadas</h2>
                <p style="font-size: 2em;"><?= esc_html($total_rutinas) ?></p>
            </div>
        </div>

        <h2>Usuarios registrados por mes</h2>
        <canvas id="usuariosChart" width="400" height="200"></canvas>

        <h2>Usuarios por Rol</h2>
        <canvas id="usuariosRolChart" width="400" height="200"></canvas>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx1 = document.getElementById('usuariosChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($labels) ?>,
                    datasets: [{
                        label: 'Usuarios registrados',
                        data: <?= json_encode($users_by_month) ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, precision: 0 }
                    }
                }
            });

            const ctx2 = document.getElementById('usuariosRolChart').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode($roles_labels) ?>,
                    datasets: [{
                        label: 'Usuarios por rol',
                        data: <?= json_encode($roles_counts) ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)'
                        ],
                        borderColor: 'rgba(255, 255, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });
        });
        </script>
    </div>
    <?php
}

