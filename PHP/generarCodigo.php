<?php
include 'Conexion.php';
session_start();

// Verificar si se recibió el documento
if (!isset($_POST['documentoCode'])) {
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'titulo' => 'Falta de datos',
        'texto' => 'No se recibió el documento para enviar el código.'
    ];
    header("Location: ../index.php");
    exit();
}

$documento = $_POST['documentoCode'];
$codigo = bin2hex(random_bytes(8)); // Código de 16 caracteres

// Actualiza el código en la base de datos
mysqli_query($conexion, "UPDATE usuarios SET codigo_verificacion = '$codigo' WHERE documento = '$documento'");

// Buscar el correo del usuario
$query = "SELECT email FROM usuarios WHERE documento = '$documento'";
$result = mysqli_query($conexion, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];

    // ✅ ENVÍO CON API DE MAILERSEND
    $apiKey = 'mlsn.4c47607e709649774745dbea0adf0aeaaaa6f519f7595e0a07c14078b4c49eb8'; // Reemplaza esto

    $data = [
        "from" => [
            "email" => "notificaciones@almacenctgisena.online",
            "name" => "Sistema de Gestión"
        ],
        "to" => [
            ["email" => $email]
        ],
        "subject" => "Código de verificación",
        "text" => "Tu código de verificación es: $codigo",
        "html" => "<p>Tu código de verificación es: <strong>$codigo</strong></p>"
    ];

    $ch = curl_init('https://api.mailersend.com/v1/email');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 202) {
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'titulo' => 'Código enviado',
            'texto' => "Un código ha sido enviado a tu correo: $email"
        ];
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Error de correo',
            'texto' => "No se pudo enviar el correo mediante la API. Código HTTP: $httpCode<br>Respuesta: $response"
        ];
    }

    header("Location: ../index.php");
    exit();
} else {
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'titulo' => 'Usuario no encontrado',
        'texto' => 'No se encontró un usuario con ese documento.'
    ];
    header("Location: ../index.php");
    exit();
}
?>
