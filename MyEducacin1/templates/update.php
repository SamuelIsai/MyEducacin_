<?php

include '../private/Config.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    http_response_code(401); // No autorizado
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}

$jsonBody = file_get_contents('php://input');
if ($jsonBody !== null) {
    $data = json_decode($jsonBody, true);
    $coinsEarned = isset($data['coinsEarned']) ? $data['coinsEarned'] : 0;
} else {
    $coinsEarned = 0;
}

// Actualizar las monedas en la base de datos
$updateCoinsQuery = "UPDATE usuarios SET monedas = monedas + ? WHERE id = ?";
$stmt = $mysqli->prepare($updateCoinsQuery);

if ($stmt) {
    $stmt->bind_param("ii", $coinsEarned, $_SESSION['usuario']['id']);
    $stmt->execute();
    $stmt->close();

    // Obtener las monedas actualizadas después de la actualización
    $getCoinsQuery = "SELECT monedas FROM usuarios WHERE id = ?";
    $stmtGetCoins = $mysqli->prepare($getCoinsQuery);

    if ($stmtGetCoins) {
        $stmtGetCoins->bind_param("i", $_SESSION['usuario']['id']);
        $stmtGetCoins->execute();
        $stmtGetCoins->bind_result($updatedCoins);
        $stmtGetCoins->fetch();
        $stmtGetCoins->close();

        // Configurar el encabezado de respuesta como JSON
        header('Content-Type: application/json');

        // Devolver las monedas actualizadas al cliente como JSON
        echo json_encode(['success' => true, 'coins' => $updatedCoins]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Error al obtener las monedas actualizadas']);
    }

} else {
    http_response_code(500);  // Error interno del servidor
    echo json_encode(['success' => false, 'error' => 'Error en la preparación de la consulta']);
}

?>
