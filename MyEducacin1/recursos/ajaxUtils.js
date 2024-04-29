// En ajaxUtils.js

function updateCoinsContainer(coins) {
  const coinsContainer = document.getElementById('user-coins');
  if (coinsContainer) {
      coinsContainer.textContent = coins;
  }
}

async function saveCoinsToDatabase(coinsEarned) {
  try {
      const response = await fetch('../templates/homepage.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
          },
          body: JSON.stringify({ coinsEarned}),
      });

      const responseData = await response.json();

      if (responseData.success) {
          updateCoinsContainer(responseData.coins);
      } else {
          console.error('Error al guardar monedas:', responseData.error);
      }
  } catch (error) {
      console.error('Error al guardar monedas:', error);
  }
}

export {saveCoinsToDatabase}
