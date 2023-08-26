const apiKey = '639db6763a0365cd3e75ac43587e0249c4349b9355f1924c305fb2111f6b72a3';
const coins = ['BTC', 'TRX', 'DOGE','SOL'];
const apiUrl = `https://min-api.cryptocompare.com/data/pricemulti?fsyms=${coins.join(',')}&tsyms=USD`;

function updateCryptoData(data) {
    coins.forEach(coin => {
        const coinData = data[coin].USD;
        document.getElementById(`${coin.toLowerCase()}Price`).textContent = coinData.toFixed(2) + ' USD';
    });
}

async function fetchData() {
    try {
        const response = await fetch(apiUrl, {
            headers: {
                Authorization: `Apikey ${apiKey}`
            }
        });
        const data = await response.json();

        updateCryptoData(data);
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

fetchData();
setInterval(fetchData, 10000);

