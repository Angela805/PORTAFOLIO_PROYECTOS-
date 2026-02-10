<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'db_conexion.php';

$medicamento_id = (int)($_GET['id'] ?? 0); // Obtenemos el ID desde la URL (GET)

if ($medicamento_id > 0) {
    // Operación CRUD: Eliminar (DELETE)
    $sql = "DELETE FROM Medicamentos WHERE id = ?";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $medicamento_id); // i = integer

    if ($stmt->execute()) {
        // Redirige al panel con un mensaje de éxito 
        $mensaje = urlencode("Eliminación Exitosa: Medicamento con ID **$medicamento_id** eliminado correctamente.");
        header("Location: panel.php?estado=$mensaje");
        exit();
    } else {
        // Redirige con mensaje de error
        $mensaje = urlencode("Error al intentar eliminar el medicamento: " . $stmt->error);
        header("Location: panel.php?estado=$mensaje");
        exit();
    }
    $stmt->close();
} else {
    // Si no hay ID válido, redirigir con error
    $mensaje = urlencode("Error: ID de medicamento no proporcionado para eliminar.");
    header("Location: panel.php?estado=$mensaje");
    exit();
}
$conexion->close();
?>