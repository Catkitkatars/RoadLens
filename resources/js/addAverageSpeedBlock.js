
let averageSpeedBtn = document.querySelector('#checkbox10');
let averageSpeedBlock = document.querySelector('.averageSpeedBlock');

averageSpeedBtn.addEventListener('click', () => {
    if (averageSpeedBlock.style.display === 'none' || averageSpeedBlock.style.display === '') {
        averageSpeedBlock.style.display = 'block';
    } else {
        averageSpeedBlock.style.display = 'none';
    }
})


