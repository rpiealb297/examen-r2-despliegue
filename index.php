<?php
// Habilitar CORS para todas las peticiones
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Responder rápido a las preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Función helper para responder en JSON
function send_json($data, int $statusCode = 200): void {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// Obtener ruta limpia (sin query string ni ruta del script)
$uriPath    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath   = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$endpoint   = trim(substr($uriPath, strlen($basePath)), '/'); // p.ej: "load/client"
$method     = $_SERVER['REQUEST_METHOD'];

// Enrutado simple por método + endpoint
switch ($method) {

    case 'GET':
        if ($endpoint === 'load/client') {
            // GET /load/client  → 200 + listado de clientes
            $clientes = [
                ['id' => 1, 'nombre' => 'Cliente Prueba 1', 'email' => 'cliente1@example.com'],
                ['id' => 2, 'nombre' => 'Cliente Prueba 2', 'email' => 'cliente2@example.com'],
                ['id' => 3, 'nombre' => 'Cliente Prueba 3', 'email' => 'cliente3@example.com'],
            ];

            send_json([
                'status'   => 'ok',
                'message'  => 'Listado de clientes de prueba',
                'clientes' => $clientes,
            ], 200);
        }

        if ($endpoint === 'admin/load') {
            // GET /admin/load → 401 No autorizado
            send_json([
                'status'  => 'error',
                'message' => 'No está autorizado para acceder a este recurso.',
            ], 401);
        }

        if ($endpoint === 'admin/password') {
            // GET /admin/password → 403 Prohibido
            send_json([
                'status'  => 'error',
                'message' => 'Acceso prohibido a este recurso.',
            ], 403);
        }

        break;

    case 'POST':
        if ($endpoint === 'create/client') {
            // POST /create/client → 201 Creado
            // Aquí podrías leer datos del body si hiciera falta.
            send_json([
                'status'  => 'created',
                'message' => 'Cliente creado correctamente (prueba).',
            ], 201);
        }
        break;

    case 'PUT':
        if ($endpoint === 'update/client') {
            // PUT /update/client → 202 Actualizado
            send_json([
                'status'  => 'updated',
                'message' => 'Cliente actualizado correctamente (prueba).',
            ], 202);
        }
        break;
}

// Si nada ha coincidido → 404
send_json([
    'status'  => 'error',
    'message' => 'Recurso no encontrado.',
], 404);

