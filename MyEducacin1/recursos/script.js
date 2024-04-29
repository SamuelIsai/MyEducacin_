const chatbotToggler = document.querySelector(".chatbot-toggler");
const closeBtn = document.querySelector(".close-btn");
const chatbox = document.querySelector(".chatbox");
const chatInput = document.querySelector(".chat-input textarea");
const sendChatBtn = document.querySelector(".chat-input span");

let userMessage = null; // Variable to store user's message
const inputInitHeight = chatInput.scrollHeight;

const createChatLi = (message, className) => {
    // Create a chat <li> element with passed message and className
    const chatLi = document.createElement("li");
    chatLi.classList.add("chat", `${className}`);
    let chatContent = className === "outgoing" ? `<p></p>` : `<span class="material-symbols-outlined">smart_toy</span><p></p>`;
    chatLi.innerHTML = chatContent;
    chatLi.querySelector("p").textContent = message;
    return chatLi; // return chat <li> element
}

const generateResponse = (chatElement) => {
    const messageElement = chatElement.querySelector("p");
    const userMessageLC = userMessage.toLowerCase(); // Convert message to lowercase for comparison

    if (userMessageLC.includes("hola")) {
        messageElement.textContent = "Hola 👋 En que puedo ayudarte hoy? Por ejemplo: consejos de ahorro, como ganar monedas, como funciona la pagina, etc.";
    } else if (userMessageLC.includes("1") || userMessageLC.includes("consejos para ahorrar")) {
        messageElement.textContent = "El ahorro es guardar dinero para usarlo en el futuro. Puedes empezar ahorrando una pequeña cantidad cada semana o mes.";
    } else if (userMessageLC.includes("como ganar monedas")|| userMessageLC.includes("2")) {
            messageElement.textContent = "Para ganar monedas debes terminar un juego correctamente.";
    } else if (userMessageLC.includes("como cerrar sesión")|| userMessageLC.includes("4") || userMessageLC.includes("como se cierra la sesion")) {
        messageElement.textContent = "Para cerrar sesión, ve a al menu lateral y selecciona 'Cerrar sesión'.";
    } else if (userMessageLC.includes("quienes somos") || userMessageLC.includes("quienes son")) {
        messageElement.textContent = "Somos un equipo dedicado a la educación financiera para niños. ¿En qué más puedo asistirte?";
    } else if (userMessageLC.includes("cual es el objetivo") || userMessageLC.includes("objetivo")) {
        messageElement.textContent = "Nuestro objetivo es enseñar finanzas de una manera divertida y educativa. ¿En qué más puedo ayudarte?";
    } else if (userMessageLC.includes("que es educación financiera") || userMessageLC.includes("educacion financiera infantil")) {
        messageElement.textContent = "La educación financiera enseña sobre cómo manejar el dinero de manera inteligente desde temprana edad.";
    } else if (userMessageLC.includes("dinero") || userMessageLC.includes("que es dinero")|| userMessageLC.includes("como se utiliza el dinero") || userMessageLC.includes("que es el dinero")) {
        messageElement.textContent = "El dinero es un recurso que se utiliza para comprar bienes y servicios. La educación financiera te ayuda a administrarlo mejor.";
    } else if (userMessageLC.includes("consejos para ahorrar")|| userMessageLC.includes("ahorro")|| userMessageLC.includes("consejos")) {
        messageElement.textContent = "Puedes ahorrar guardando un porcentaje de tu dinero semanalmente y evitando gastos innecesarios.";
    } else if (userMessageLC.includes("como funciona la pagina")|| userMessageLC.includes("3")|| userMessageLC.includes("que hace la pagina")) {
        messageElement.textContent = "La página ofrece diversos juegos de ordenar monedas, un quiz de conocer la moneda de cada pais, para enseñar finanzas de forma divertida.";
    } else if (userMessageLC.includes("cómo puedo ganar en el juego")|| userMessageLC.includes("como gano")) {
        messageElement.textContent = "¡Practica y aprende! Con cada juego, mejorarás tus habilidades y conocimientos financieros.";
    } else if (userMessageLC.includes("ayuda con los juegos") || userMessageLC.includes("5")) {
        messageElement.textContent = "En cada juego, busca pistas y presta atención a las imagenes que se presentan. ¡Diviértete mientras aprendes!";
    } else if (userMessageLC.includes("conceptos básicos de finanzas")|| userMessageLC.includes("conceptos basicos")|| userMessageLC.includes("que son finanzas")) {
        messageElement.textContent = "Los conceptos básicos incluyen ahorro, presupuesto, gasto inteligente e inversión. ¡Son fundamentales!";
    } else if (userMessageLC.includes("planificación financiera")|| userMessageLC.includes("planificacion")) {
        messageElement.textContent = "La planificación financiera implica establecer metas, hacer presupuestos y seguir un plan de ahorro.";
    } else if (userMessageLC.includes("gestión del dinero")|| userMessageLC.includes("gestionar dinero")) {
        messageElement.textContent = "Gestionar el dinero implica controlar tus gastos, ahorrar y aprender a invertir de manera inteligente.";
    } else if (userMessageLC.includes("comprender el valor del dinero")|| userMessageLC.includes("que vale el dinero")|| userMessageLC.includes("cual es el valor del dinero")) {
        messageElement.textContent = "El dinero es una herramienta para comprar cosas y alcanzar metas. Es importante usarlo con sabiduría.";
    } else if (userMessageLC.includes("enseñar finanzas a los niños") || userMessageLC.includes("es bueno enseñar finanzas")|| userMessageLC.includes("finanzas a los niños")) {
        messageElement.textContent = "Enseñar finanzas a los niños ayuda a desarrollar habilidades financieras desde pequeños.";
    } else if (userMessageLC.includes("desafíos financieros") || userMessageLC.includes("desafios")) {
        messageElement.textContent = "Los desafíos financieros pueden incluir ahorros, presupuestos o planificación de gastos.";
    } else if (userMessageLC.includes("lecciones de finanzas") || userMessageLC.includes("lecciones")) {
        messageElement.textContent = "Las lecciones de finanzas pueden cubrir temas como ahorro, inversión, gasto inteligente y más.";
    } else if (userMessageLC.includes("juegos educativos de finanzas")|| userMessageLC.includes("juegos educativos")|| userMessageLC.includes("sirven los juegos educativos")) {
        messageElement.textContent = "Los juegos educativos pueden ayudar a entender conceptos financieros básicos de una manera divertida.";
    } else if (userMessageLC.includes("mejorar mis habilidades financieras")|| userMessageLC.includes("habilidades") || userMessageLC.includes("como mejorar mis habilidades")) {
        messageElement.textContent = "Puedes mejorar tus habilidades financieras practicando ahorro, aprendiendo a invertir y haciendo presupuestos.";
    } else if (userMessageLC.includes("herramientas para educación financiera")|| userMessageLC.includes("herramientas")) {
        messageElement.textContent = "Hay muchas herramientas disponibles como juegos, calculadoras de presupuesto y actividades interactivas.";
    } else if (userMessageLC.includes("objetivos financieros")|| userMessageLC.includes("objetivos")) {
        messageElement.textContent = "Establecer objetivos financieros te ayuda a dirigir tus esfuerzos hacia metas específicas de dinero.";
    } else if (userMessageLC.includes("gastos inteligentes")|| userMessageLC.includes("gastar inteligente")|| userMessageLC.includes("gastar")|| userMessageLC.includes("gastos")) {
        messageElement.textContent = "Los gastos inteligentes son aquellos que están alineados con tus objetivos financieros y necesidades.";
    } else if (userMessageLC.includes("juegos interactivos de finanzas")|| userMessageLC.includes("juegos de finanzas")) {
        messageElement.textContent = "Los juegos interactivos pueden simular situaciones financieras reales para aprender jugando.";
    } else if (userMessageLC.includes("como funciona el quiz")|| userMessageLC.includes("que es el quiz")|| userMessageLC.includes("quiz")) {
        messageElement.textContent = "Seleccionando la respuesta correcta de la pregunta que se presenta basandose en la imagen.";
    } else if (userMessageLC.includes("como funciona el chatbot")|| userMessageLC.includes("como funcionas")|| userMessageLC.includes("hola")|| userMessageLC.includes(".")) {
        messageElement.textContent = "Puedes preguntarme cosas especificas, por ejemplo. como ganar monedas,  consejos, etc.";
    } else {
        messageElement.textContent = "Lo siento, no entendí. ¿Puedes preguntar de otra manera?";
    }
}

const handleChat = () => {
    userMessage = chatInput.value.trim(); // Get user entered message and remove extra whitespace
    if(!userMessage) return;

    // Clear the input textarea and set its height to default
    chatInput.value = "";
    chatInput.style.height = `${inputInitHeight}px`;

    // Append the user's message to the chatbox
    chatbox.appendChild(createChatLi(userMessage, "outgoing"));
    chatbox.scrollTo(0, chatbox.scrollHeight);
    
    // Show "Pensando..." after a delay of 1.5 seconds (1500 milliseconds)
    const incomingChatLi = createChatLi("Pensando...", "Entrante");
    setTimeout(() => {
        chatbox.appendChild(incomingChatLi);
        chatbox.scrollTo(0, chatbox.scrollHeight);
        generateResponse(incomingChatLi);
    }, 1500);
}

chatInput.addEventListener("input", () => {
    // Adjust the height of the input textarea based on its content
    chatInput.style.height = `${inputInitHeight}px`;
    chatInput.style.height = `${chatInput.scrollHeight}px`;
});

chatInput.addEventListener("keydown", (e) => {
    // If Enter key is pressed without Shift key and the window 
    // width is greater than 800px, handle the chat
    if(e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
        e.preventDefault();
        handleChat();
    }
});

sendChatBtn.addEventListener("click", handleChat);
closeBtn.addEventListener("click", () => document.body.classList.remove("show-chatbot"));
chatbotToggler.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));