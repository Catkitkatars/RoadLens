
let averageSpeedBtn = document.querySelector('#checkbox10');
let averageSpeedBlock = document.querySelector('.averageSpeedBlock');
let averageSpeedInputs = document.querySelector('.averageSpeedInputs');

averageSpeedBtn.addEventListener('click', () => {
    averageSpeedBlock.style.display =  'block';
    if (averageSpeedBtn.checked) {
        let html = `
        <div class="input-box">
            <input id="averageSpeedUlid" class="input-fixed" type="text" name="ASC[ulid]" required="">
            <label>ulid следующей камеры</label>
        </div>
        <div class="input-box">
            <input id="averageSpeed" class="input-fixed" type="text" name="ASC[speed]" required="">
            <label>Средняя скорость</label>
        </div>
        `
        averageSpeedInputs.innerHTML = html;
    } else {
        averageSpeedBlock.style.display =  'none';
        averageSpeedInputs.innerHTML = '';   
    }

})


