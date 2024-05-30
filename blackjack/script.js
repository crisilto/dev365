let cards = [];
let dealerCards = [];
let sum = 0;
let dealerSum = 0;
let hasBlackJack = false;
let isAlive = false;
let isStand = false;
let message = "";
let messageEl = document.getElementById("message-el");
let sumEl = document.getElementById("sum-el");
let cardsEl = document.getElementById("cards-el");
let dealerCardsEl = document.getElementById("dealer-cards-el");
let sumDealerEl = document.getElementById("sum-dealer-el");
let betAmount = 0;

let betInput = document.getElementById("bet-amount");
let betBtn = document.getElementById("bet-btn");

function placeBet() {
    const bet = parseInt(betInput.value);
    if (!isNaN(bet) && bet > 0 && bet <= userMonedero) {
        betAmount = bet;
        userMonedero -= bet; 
        updateMonederoDisplay();
        updateMonederoDatabase();
    } else {
        alert("Saldo insuficiente o apuesta inválida.");
        window.location.href = '../add_funds.php'; 
    }
}

function updateMonederoDisplay() {
    const staticPlayerChips = document.getElementById("monedero");
    staticPlayerChips.textContent = userMonedero.toFixed(2);
}

function updateMonederoDatabase() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_monedero.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            const response = JSON.parse(xhr.responseText);
            if (!response.success) {
                console.error('Error updating monedero:', response.message);
            }
        }
    };
    xhr.send(`monedero=${userMonedero}&usuario_id=${userId}`);
}
function handleChips(playerWins) {
    if (playerWins) {
        userMonedero += betAmount * 2; 
    }
    updateMonederoDisplay();
    updateMonederoDatabase();

    betAmount = 0;

    betInput.style.display = "block";
    betBtn.style.display = "block";
}

function startGame() {
    if (betAmount === 0) {
        alert("Por favor, fija una apuesta primero.");
        return;
    }

    isAlive = true;
    hasBlackJack = false;
    isStand = false;

    cards = [getRandomCard(), getRandomCard()];
    sum = cards.reduce((a, b) => a + b, 0);

    dealerCards = [getRandomCard()];
    dealerSum = dealerCards[0];

    renderGame();
}

function getRandomCard() {
    let randomNumber = Math.floor((Math.random() * 13) + 1);
    if (randomNumber === 1) {
        return 11;
    } else if (randomNumber > 10) {
        return 10;
    } else {
        return randomNumber;
    }
}

function playerDealerTurn() {
    while (dealerSum < 17) {
        let dealerCard = getRandomCard();
        dealerCards.push(dealerCard);
        dealerSum += dealerCard;
        dealerCardsEl.textContent += " " + dealerCard;
        sumDealerEl.textContent = "Suma: " + dealerSum;
    }
    compareHands();
}

function renderGame() {
    cardsEl.textContent = "Cartas: " + cards.join(" ");
    sumEl.textContent = "Suma: " + sum;
    dealerCardsEl.textContent = "Cartas: " + dealerCards.join(" ");
    sumDealerEl.textContent = "Suma: " + dealerSum;

    if (sum === 21) {
        message = "¡Tienes Blackjack!";
        hasBlackJack = true;
        playerDealerTurn();
    } else if (sum > 21) {
        message = "¡Te has pasado!";
        isAlive = false;
        playerDealerTurn();
    } else {
        message = "¿Quieres una nueva carta?";
    }

    messageEl.textContent = message;
}

function newCard() {
    if (isAlive && !hasBlackJack) {
        let card = getRandomCard();
        sum += card;
        cards.push(card);
        renderGame();
    }
}

function playerStands() {
    if (isAlive && !hasBlackJack) {
        isAlive = false;
        playerDealerTurn();
        isStand = true;
    }
    compareHands();
}

function compareHands() {
    let playerWins = false;

    if (sum > 21) {
        message = "¡La banca gana!";
    } else if (dealerSum > 21 || sum > dealerSum) {
        message = "¡Tú ganas!";
        playerWins = true;
    } else if (sum === dealerSum) {
        message = "¡Empate!";
    } else {
        message = "¡La banca gana!";
    }

    messageEl.textContent = message;
    handleChips(playerWins);
}

function restartGame() {
    location.reload();
}

document.getElementById("bet-btn").addEventListener("click", placeBet);
document.getElementById("start-btn").addEventListener("click", startGame);
document.getElementById("card-btn").addEventListener("click", newCard);
document.getElementById("stand-btn").addEventListener("click", playerStands);
document.getElementById("restart-btn").addEventListener("click", restartGame);
