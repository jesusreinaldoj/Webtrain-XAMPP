<?php
// Archivo: proxy-ejercicios.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Tu API Key de RapidAPI
$api_key = '3081e5bec3msha179d7ec17edeedp1c8c6ajsna037a270bb12';

// Permitir recibir el nombre del músculo por GET

$muscle = isset($_GET['muscle']) ? urlencode($_GET['muscle']) : '';
$target = isset($_GET['target']) ? urlencode($_GET['target']) : '';

if ($target) {
    // Si se pasa un target, usarlo en la URL
    $url = "https://exercisedb.p.rapidapi.com/exercises/target/{$target}?limit=10&offset=0";
} elseif ($muscle) {
    // Si se pasa un músculo, usarlo en la URL
    $url = "https://exercisedb.p.rapidapi.com/exercises/bodyPart/{$muscle}?limit=10&offset=0";
} else {
    // Si no se pasa músculo, traer todos los ejercicios
    $url = "https://exercisedb.p.rapidapi.com/exercises?limit=10&offset=0";
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// Agregar los headers necesarios para RapidAPI
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'X-RapidAPI-Key: ' . $api_key,
    'X-RapidAPI-Host: exercisedb.p.rapidapi.com'
]);
$result = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpcode == 200) {
    echo $result;
} else {
    http_response_code($httpcode);
    echo json_encode(['error' => 'No se pudo obtener los ejercicios']);
}
