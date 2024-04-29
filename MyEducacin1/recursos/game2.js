// Referencias iniciales
let draggableObjects2;
let dropPoints2;

const starButton2 = document.getElementById("start2");
const result2 = document.querySelector(".result2");
const controls2 = document.querySelector(".controls2-container2");
const dragContainer2 = document.querySelector(".draggable-objects2");
const dropContainer2 = document.querySelector(".drop-points2");
const data2 = ["$1.00", "$5.00", "$50.00", "$10.00", "$20.00", "$100.00"];

let deviceType2 = "";
let initialX2 = 0,
    initialY2 = 0;
let currentElement2 = "";
let moveElement2 = false;
let countdown2; // Variable para almacenar el temporizador
let correctCoins2 = 0; // Contador de monedas en la posición correcta
let placedCoins2 = 0; // Contador de monedas colocadas

const isTouchDevice2 = () => {
    try {
        document.createEvent("TouchEvent");
        deviceType2 = "touch";
        return true;
    } catch (e) {
        deviceType2 = "mouse";
        return false;
    }
};

let count2 = 0;

// Valor aleatorio del array
const randomValueGenerator2 = () => {
    return data2[Math.floor(Math.random() * data2.length)];
};

const stopGame2 = () => {
    controls2.classList.remove("hide");
    starButton2.classList.remove("hide");
};

function startTimer2(duration) {
    let timer = duration;
    countdown2 = setInterval(function () {
        const countdownDisplay = document.getElementById("countdown2");
        countdownDisplay.textContent = timer + " segundos";

        if (--timer < 0) {
            clearInterval(countdown2); // Detiene el temporizador cuando llega a cero
            result2.innerText = "¡Perdiste 😔!";
            stopGame2();
        }
    }, 1000);
}

function dragStart(e) {
    if (isTouchDevice2()) {
        initialX2 = e.touches[0].clientX;
        initialY2 = e.touches[0].clientY;

        moveElement2 = true;
        currentElement2 = e.target;
    } else {
        e.dataTransfer.setData("text", e.target.id);
    }
}

function dragOver(e) {
    e.preventDefault();
}

const touchMove2 = (e) => {
    if (moveElement2) {
        e.preventDefault();
        let newX = e.touches[0].clientX;
        let newY = e.touches[0].clientY;
        let currentSelectedElement = document.getElementById(e.target.id);
        currentSelectedElement.parentElement.style.top =
            currentSelectedElement.parentElement.offsetTop - (initialY2 - newY) + "px";
        currentSelectedElement.parentElement.style.left =
            currentSelectedElement.parentElement.offsetLeft - (initialX2 - newX) + "px";
        initialX2 = newX;
        initialY2 = newY;
    }
};

const drop2 = (e) => {
    e.preventDefault();
    if (isTouchDevice2()) {
        moveElement2 = false;
        const currentDrop = document.querySelector(`div [data-id='${e.target.id}']`);
        const currentDropBound = currentDrop.getBoundingClientRect();
        if (
            initialX2 >= currentDropBound.left &&
            initialX2 <= currentDropBound.right &&
            initialY2 >= currentDropBound.top &&
            initialY2 <= currentDropBound.bottom
        ) {
            currentDrop.classList.add("dropped");

            currentElement2.classList.add("hide");
            currentDrop.innerHTML = `<img src="../recursos/img/billetes/${currentElement2.id}.png">`;

            count2 += 1;
        }
    } else {
        const draggedElementData = e.dataTransfer.getData("text");

        const droppableElementData = e.target.getAttribute("data-id");
        if (draggedElementData === droppableElementData) {
            const draggedElement = document.getElementById(draggedElementData);

            e.target.classList.add("dropped");

            draggedElement.classList.add("hide");

            draggedElement.setAttribute("draggable", "false");
            e.target.innerHTML = `<img src="../recursos/img/billetes/${draggedElementData}.png">`;

            count2 += 1;
        }
    }

    if (count2 == 3) {
        result2.innerText = "¡Ganaste!";
        stopGame2();
        clearInterval(countdown2);
    }
};

const creator2 = () => {
    dragContainer2.innerHTML = "";
    dropContainer2.innerHTML = "";
    let randomData = [];
    for (let i = 1; i <= 3; i++) {
        let randomValue = randomValueGenerator2();
        if (!randomData.includes(randomValue)) {
            randomData.push(randomValue);
        } else {
            i -= 1;
        }
    }
    for (let i of randomData) {
        const flagDiv = document.createElement("div");
        flagDiv.classList.add("draggable-image");
        flagDiv.setAttribute("draggable", true);
        if (isTouchDevice2()) {
            flagDiv.style.position = "absolute";
        }
        flagDiv.innerHTML = `<img src="../recursos/img/billetes/${i}.png" id="${i}">`;
        dragContainer2.appendChild(flagDiv);
    }
    randomData = randomData.sort(() => 0.5 - Math.random());
    for (let i of randomData) {
        const countryDiv = document.createElement("div");
        countryDiv.innerHTML = `<div class='countries' data-id='${i}'>
        ${i.charAt(0).toUpperCase() + i.slice(1).replace("-", " ")}
        </div>`;
        dropContainer2.appendChild(countryDiv);
    }
};

starButton2.addEventListener("click", async function startGame2() {
    currentElement2 = "";
    controls2.classList.add("hide");
    starButton2.classList.add("hide");

    await creator2();
    count2 = 0;
    dropPoints2 = document.querySelectorAll(".countries");
    draggableObjects2 = document.querySelectorAll(".draggable-image");

    draggableObjects2.forEach((element) => {
        element.addEventListener("dragstart", dragStart);
        element.addEventListener("touchstart", dragStart);
        element.addEventListener("touchend", drop2);
        element.addEventListener("touchmove", touchMove2);
    });
    dropPoints2.forEach((element) => {
        element.addEventListener("dragover", dragOver);
        element.addEventListener("drop", drop2);
    });

    startTimer2(60); // 60 segundos
});
