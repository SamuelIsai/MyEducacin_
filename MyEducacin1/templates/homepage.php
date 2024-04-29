<?php
include '../private/Config.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
if (isset($_POST['cerrar_sesion'])) {
    // Destruye la sesión y redirige a la página de inicio de sesión
    session_destroy();
    header("Location: login.php");
    exit();
}
$sql = "SELECT monedas FROM usuarios WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    // Vincular el parámetro
    $stmt->bind_param("i", $_SESSION['usuario']['id']); 

    // Ejecutar la consulta
    $stmt->execute();

    // Vincular el resultado
    $stmt->bind_result($user_coins);

    // Obtener el resultado
    $stmt->fetch();

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonBody = file_get_contents('php://input');
    $data = json_decode($jsonBody, true);
    $coinsEarned = isset($data['coinsEarned']) ? $data['coinsEarned'] : 0;

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

            // Devolver las monedas actualizadas al cliente
            echo json_encode(['success' => true, 'coins' => $updatedCoins]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Error al obtener las monedas actualizadas']);
            exit;
        }
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Error en la preparación de la consulta']);
        exit;
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Educacin</title>
    <link href="https://fonts.googleapis.com/css?family=Comic+Sans+MS" rel="stylesheet">
    <link rel="stylesheet" href="../recursos/css/estilos.css">
    <link rel="stylesheet" href="../recursos/css/game.css">
    <link rel="stylesheet" href="../recursos/css/game2.css">
    <link rel="stylesheet" href="../recursos/css/game3.css">
    <link rel="stylesheet" href="../recursos/css/game4.css">
    <link rel="stylesheet" href="../recursos/css/style.css">
    <link rel="stylesheet" href="../recursos/css/stylee.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Establece el tamaño del cuerpo y el HTML al 100% de la altura y ancho */
        html, body {
            height: 100%;
            width: 100%;
            font-family: 'Comic Sans MS', sans-serif; /* Cambia la fuente según tus preferencias */
            overflow: hidden; /* Evita las barras de desplazamiento */
        }

        body {
            background-color: #f1f1f1;
            display: flex;
            flex-direction: row;
            margin-top: 0px;
            margin-left: 0px;
        }

        /* Estilo para la barra de pestañas */
        .tab {
            background-color: #3a3ad1;
            width: 20%; /* Cambia el ancho según tus preferencias */
            height: 100%;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .tab button {
            display: block;
            background-color: inherit;
            font-size: 20px;
            color: #fff;
            padding: 12px 16px;
            width: 100%;
            margin-top: 20px;
            border: none;
            outline: none;
            text-align: left;
            cursor: pointer;
            transition: 0.3s;
        }

        .tab button:hover {
            background-color: #3a3ad1;
            border-radius: 20px;
        }

        /* Contenido de las pestañas */
        .tabcontent-container {
            width: 100%; /* Cambia el ancho según tus preferencias */
            height: 100%;
            margin-left: -20px;
            display: flex;
            flex-direction: column; /* Alinea el contenido en columna */
            justify-content: center; /* Centra verticalmente el contenido */
            align-items: flex-start; /* Alinea el contenido a la izquierda */
            overflow: auto; /* Agrega una barra de desplazamiento cuando sea necesario */
        }

        .tabcontent {
            padding: 20px;
            width: 100%; /* El contenido ocupa todo el ancho */
            /* display: none; */ /* Puedes comentar esta línea para que el contenido esté visible por defecto */
        }

        /* Estilos para los títulos y párrafos en el contenido */
        h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
        }

        /* Añade un estilo "active" para resaltar la pestaña seleccionada */
        .active {
            background-color: #ccc;
        }
        .button {
            background-color: #3a3ad1; /* Color de fondo */
            color: #fff; /* Color del texto */
            border: none; /* Sin borde */
            padding: 12px 20px; /* Espaciado interno */
            font-size: 18px; /* Tamaño de fuente */
            border-radius: 5px; /* Bordes redondeados */
            cursor: pointer;
            transition: background-color 0.3s; /* Transición suave de color de fondo */
        }

        /* Estilo de hover para el botón */
        .button:hover {
            background-color: #3a3ad1; /* Cambia el color de fondo al pasar el mouse */
        }
        .close{
            display: block;
            background-color: inherit;
            font-size: 20px;
            color: #fff;
            padding: 12px 16px;
            width: 100%;
            margin-top: 20px;
            border: none;
            outline: none;
            text-align: left;
            cursor: pointer;
            transition: 0.3s;
        }
    </style>
</head>
<body>
    <div class="tab">
        <a href="index.php" style="cursor: pointer; font-size: 24px; color: white;">MyEducacin</a>

        <button class="tablinks" onclick="openCity(event, 'Home')" >Inicio</button>
        <button class="tablinks" onclick="openCity(event, 'Nileves')" >Juegos</button>
        
        <form id="logoutForm" action="" method="post">
            <button class="tablinks" type="submit" name="cerrar_sesion">Cerrar Sesión</button>
        </form>
    </div>

    <div class="tabcontent-container">
        <div id="Home" class="tabcontent">
            <main>
                <h1 style="text-align: center; margin-top: 2px;">Educación Financiera Infantil</h1><br>
                <p></p> <br>

                <p style="font-size: 23px; text-align: right; word-spacing: -0.1em;">
                
                <p style=" font-size: 23px; text-align: center;"> 
                    El aprendizaje desde niños es más enriquecedor cuando es constante.
                    Esto es lo que ocurre con la Educación Financiera, un concepto que abarca 
                    diferentes aspectos de la vida y que si es enseñado desde temprana edad, 
                    preparará a los más pequeños para tomar mejores decisiones en el futuro.
                </p>
            </main>

            <div style="display: flex; flex-direction: column;">
                <div class="video-container-2" style="margin: 0 auto;">
                    <iframe style="width: 600px; height: 300px; border: 15px solid #3a3ad1; border-radius: 20px;" width="400" height="225" src="https://www.youtube.com/embed/gl37c399tJQ" frameborder="0" allowfullscreen></iframe>
                </div>

                <button class="chatbot-toggler">
                    <span class="material-symbols-rounded">mode_comment</span>
                    <span class="material-symbols-outlined">close</span>
                    </button>
                    <div style="height: 550px;"class="chatbot">
                    <header>
                        <h2>Chatbot</h2>
                        <span class="close-btn material-symbols-outlined">Cerrar</span>
                    </header>
                    <ul class="chatbox">
                        <li class="chat incoming">
                        <span class="material-symbols-outlined">smart_toy</span>
                        <p>Hola 👋<br>En que puedo ayudarte hoy?<br>Por ejemplo:<br> 1. consejos de ahorro. <br> 2. como ganar monedas. <br>3. como funciona la pagina. <br> 4. como cerrar sesion. <br> 5. ayuda con los juegos. </p>
                        </li>
                    </ul>
                    <div class="chat-input">
                        <textarea placeholder="Ecribe tu mensaje..." spellcheck="false" required></textarea>
                        <span id="send-btn" class="material-symbols-rounded">Enviar</span>
                    </div>
                </div>
            </div>
        </div>

        <div id="Nileves" class="tabcontent" style="background-image: url(../recursos/img/fondo1.jpeg); height: 100%; width: 100%; position: relative;">

            <div id="coins-container" style="position: fixed; top: 10px; right: 10px; background-color: #ffffff; padding: 10px; border-radius: 5px;">
                <img src="../recursos/img/moneda_icon.jpg" style="width: 20px; height: 20px;">
                <span id="user-coins"><?php echo $user_coins; ?></span>
            </div>
                
            <a style="display: flex; justify-content: center; font-size: 30px;">Juegos Disponibles</a>
            <div class="container_a">
                <div class="image-container">
                    <a class="imagess" onclick="openCity(event, 'Game')">
                        <img style="cursor: pointer;" class="myImage" src="../recursos/img/nicel1.jpeg" alt="Image 1">
                        <span class="image-text">Juego 1 !Monedas!</span>
                    </a>
                </div>
                <div class="image-container">
                    <a class="imagess" onclick="openCity(event, 'Game2')">
                        <img style="cursor: pointer;" class="myImage" src="../recursos/img/nivel2.jpeg" alt="Image 2">
                        <span class="image-text">Juego 2 !Billetes!</span>
                    </a>
                </div>
                <div class="image-container">
                    <a class="imagess" onclick="openCity(event, 'Game3')">
                        <img style="cursor: pointer;" class="myImage" src="../recursos/img/nivel3.jpeg" alt="Image 3">
                        <span class="image-text">Adivina de que pais es la moneda</span>
                    </a>
                </div>
                <div class="image-container">
                    <a class="imagess" onclick="openCity(event, 'Game4')">
                        <img style="cursor: pointer;" class="myImage" src="../recursos/img/nivel3.jpeg" alt="Image 4">
                        <span class="image-text">Encuentra su pareja</span>
                    </a>
                </div>
            </div>   
        </div>

        <div id="Game" class="tabcontent" style="display: none;">
            <div class="container" style="width: 60%; height: 90%;">
                <h3>
                    Arrastre y suelte las monedas en sus respectivos valores de moneda
                </h3>
                <div class="draggable-objects"></div>
                <div class="drop-points"></div>
            </div>
            <div style="color:rgb(84, 62, 192); font-size: 24px; float: left; margin-top: -350px;" class="timer">Tiempo restante: <span id="countdown">60</span></div>
            <div class="controls-container">
                <p class="result"></p>
                <div style="font-size: 16px;" id="stars" class="star-container"></div>
                <button id="start" style="margin-right: 10px">Empezar Juego</button>
            </div>
        </div>

        <div id="Game2" class="tabcontent" style="display: none;">
            <div class="container2">
                <h3>
                    Arrastre y suelte las billetes en sus respectivos valores de billete
                </h3>
                <div class="draggable-objects2"></div>
                <div class="drop-points2"></div>
            </div>
            <div style="color:rgb(84, 62, 192); font-size: 24px; float: left; margin-top: -350px;" class="timer2">Tiempo restante: <span id="countdown2">60</span></div>
            <div class="controls2-container2">
                <p class="result2"></p>
                <button id="start2" style="margin-right: 10px">Empezar Juego</button>
            </div>
        </div>

        <div id="Game3" class="tabcontent" style="display:none;">
            <div class="contenedor">
            <div class="puntaje" id="puntaje"></div>
            <div class="encabezado">
                <div class="categoria" id="categoria">
                </div>
                <div class="numero" id="numero"></div>
                <div class="pregunta" id="pregunta">
                </div>
                <img src="#" class="imagen" id="imagen">
            </div>
            <div class="btn" id="btn1" onclick="oprimir_btn(0)">
                opcion 1 </div>
            <div class="btn" id="btn2" onclick="oprimir_btn(1)">
                opcion 2 </div>
            <div class="btn" id="btn3" onclick="oprimir_btn(2)">
                opcion 3 </div>
            <div class="btn" id="btn4" onclick="oprimir_btn(3)">
                opcion 4 </div>
        
        </div>

        <div id="Game4" class="tabcontent" style="display: none;">
            <h4>juego de memoria</h4>
            <div class="grid-container">
            </div>
            <p>Score: <span class="score"></span></p>
            <div class="actions">
                <button onclick="restart()">Reiniciar el juego</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Oculta todos los contenidos de las pestañas al cargar la página
            var tabcontents = document.getElementsByClassName("tabcontent");
            for (var i = 0; i < tabcontents.length; i++) {
                tabcontents[i].style.display = "none";
            }
    
            // Muestra el contenido de "Home" por defecto
            document.getElementById("Home").style.display = "block";

        });
    
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
    
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
    
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
    
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        function cerrarSesion(){
            window.location.href = 'logou'
        }
    </script>

    
    <script src="../recursos/script.js" defer></script>
    <script type="module" src="../recursos/ajaxUtils.js"></script>
    <script type="module" src="../recursos/game1.js"></script>
    <script src="../recursos/game2.js" ></script>
    <script src="../recursos/game3.js" ></script>
    <script src="../recursos/game4.js" ></script>
</body>
</html>