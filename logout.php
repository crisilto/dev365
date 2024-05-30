<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html,
        body {
            font-family: Arial, sans-serif;
            background-color: #282828;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333333;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .message {
            background-color: #286647;
            /* Verde oscuro */
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        .message h1 {
            color: #efe067;
            /* Amarillo */
            margin-bottom: 10px;
            font-size: 2em;
        }

        .message p {
            font-size: 1.2em;
            margin-top: 10px;
        }

        .message a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #efe067;
            /* Amarillo */
            color: #286647;
            /* Verde oscuro */
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .message a:hover {
            background-color: #d7ca3f;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="message">
            <h1>Has cerrado sesión</h1>
            <p>Has cerrado sesión correctamente. Haz clic en el botón de abajo para volver a la página de inicio de sesión.</p>
            <a href="login.html">Volver a iniciar sesión</a>
        </div>
    </div>
</body>

</html>