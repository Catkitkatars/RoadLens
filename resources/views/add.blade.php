<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,600;1,600&family=Russo+One&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geotag-photo@0.5.1/dist/Leaflet.GeotagPhoto.css" />
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"
/>
    <link href="{{ asset('dist/css/styles.css') }}" rel="stylesheet">
    <link rel="icon" href="/dist/images/siteImg/RoadLensOnWebWhite.png">
    <title>RoadLens</title>
</head>

<body>
    <header>
        
        <div class="header-contaner">
        <div class="side_menu">
                <div class="burger_box">
                    <div class="menu-icon-container">
                        <a href="#" class="menu-icon js-menu_toggle closed">
                            <span class="menu-icon_box">
                                <span class="menu-icon_line menu-icon_line--1"></span>
                                <span class="menu-icon_line menu-icon_line--2"></span>
                                <span class="menu-icon_line menu-icon_line--3"></span>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="px-3">
                    <div class="header_login-img">
                        <img src="https://i.imgur.com/hczKIze.jpg" alt="">
                    </div>
                    <ul class="list_load">
                        <li class="list_item"><a href="#"><span class="menu-icon white-icon material-symbols-outlined">home</span>Главная</a></li>
                        <li class="list_item"><a href="#"><span class="menu-icon white-icon material-symbols-outlined">filter_alt</span>Фильтр</a></li>
                        <li class="list_item"><a href="#"><span class="menu-icon white-icon material-symbols-outlined">videocam</span>Типы камер</a></li>
                        <li class="list_item"><a href="#"><span class="menu-icon white-icon material-symbols-outlined">developer_guide</span>О проекте</a></li>
                    </ul>
                </div>
            </div>
            <a href="#" class="header-logo">
                <img src="/dist/images/siteImg/RoadLensOnWebWhite.png" alt="logo">
                <h1>RoadLens</h1>
            </a>
        </div>
    </header>
    <main>
        <div class="container-map-edit">
            <section>
                
                <form class="edit-form" method="POST" action="/edit/submit">
                @csrf
                <div class="name-block">
                    <div class="name-block_container">
                        <h3 class="name-block_h3">Добавить</h3>
                    </div>
                </div>
                <div class="flex-form">
                    <div class="select">
                        <label class="select-label" for="countries">Страна:</label><br>
                        <select name="country" id="countries" class="">
                            <option value="">--Выберите страну--</option>
                            <option value="1">Россия</option>
                            <option value="2">Азербайджан</option>
                            <option value="3">Беларусь</option>
                            <option value="4">Китай</option>
                            <option value="5">Эстония</option>
                            <option value="6">Финляндия</option>
                            <option value="7">Грузия</option>
                            <option value="8">Казахстан</option>
                            <option value="9">Латвия</option>
                            <option value="10">Литва</option>
                            <option value="11">Монголия</option>
                            <option value="12">Таджикистан</option>
                            <option value="13">Украина</option>
                            <option value="14">Узбекистан</option>
                        </select>

                    </div>
                    <div class="select">
                        <label class="select-label" for="regions">Регион:</label><br>
                        <select name="region" id="regions" class="">
                            <option value="">--Выберите регион--</option>
                            <option value="1">1 Республика Адыгея (Адыгея)</option>
                            <option value="2">2 Республика Башкортостан</option>
                            <option value="3">3 Республика Бурятия</option>
                            <option value="4">4 Республика Алтай</option>
                            <option value="5">5 Республика Дагестан</option>
                            <option value="6">6 Республика Ингушетия</option>
                            <option value="7">7 Кабардино-Балкарская Республика</option>
                            <option value="8">8 Республика Калмыкия</option>
                            <option value="9">9 Карачаево-Черкесская Республика</option>
                            <option value="10">10 Республика Карелия</option>
                            <option value="11">11 Республика Коми</option>
                            <option value="12">12 Республика Марий Эл</option>
                            <option value="13">13 Республика Мордовия</option>
                            <option value="14">14 Республика Саха (Якутия)</option>
                            <option value="15">15 Республика Северная Осетия - Алания</option>
                            <option value="16">16 Республика Татарстан (Татарстан)</option>
                            <option value="17">17 Республика Тыва</option>
                            <option value="18">18 Удмуртская Республика</option>
                            <option value="19">19 Республика Хакасия</option>
                            <option value="20">20 Чеченская Республика</option>
                            <option value="21">21 Чувашская Республика - Чувашия</option>
                            <option value="22">22 Алтайский край</option>
                            <option value="23">23 Краснодарский край</option>
                            <option value="24">24 Красноярский край</option>
                            <option value="25">25 Приморский край</option>
                            <option value="26">26 Ставропольский край</option>
                            <option value="27">27 Хабаровский край</option>
                            <option value="28">28 Амурская область</option>
                            <option value="29">29 Архангельская область</option>
                            <option value="30">30 Астраханская область</option>
                            <option value="31">31 Белгородская область</option>
                            <option value="32">32 Брянская область</option>
                            <option value="33">33 Владимирская область</option>
                            <option value="34">34 Волгоградская область</option>
                            <option value="35">35 Вологодская область</option>
                            <option value="36">36 Воронежская область</option>
                            <option value="37">37 Ивановская область</option>
                            <option value="38">38 Иркутская область</option>
                            <option value="39">39 Калининградская область</option>
                            <option value="40">40 Калужская область</option>
                            <option value="41">41 Камчатский край</option>
                            <option value="42">42 Кемеровская область</option>
                            <option value="43">43 Кировская область</option>
                            <option value="44">44 Костромская область</option>
                            <option value="45">45 Курганская область</option>
                            <option value="46">46 Курская область</option>
                            <option value="47">47 Ленинградская область</option>
                            <option value="48">48 Липецкая область</option>
                            <option value="49">49 Магаданская область</option>
                            <option value="50">50 Московская область</option>
                            <option value="51">51 Мурманская область</option>
                            <option value="52">52 Нижегородская область</option>
                            <option value="53">53 Новгородская область</option>
                            <option value="54">54 Новосибирская область</option>
                            <option value="55">55 Омская область</option>
                            <option value="56">56 Оренбургская область</option>
                            <option value="57">57 Орловская область</option>
                            <option value="58">58 Пензенская область</option>
                            <option value="59">59 Пермский край</option>
                            <option value="60">60 Псковская область</option>
                            <option value="61">61 Ростовская область</option>
                            <option value="62">62 Рязанская область</option>
                            <option value="63">63 Самарская область</option>
                            <option value="64">64 Саратовская область</option>
                            <option value="65">65 Сахалинская область</option>
                            <option value="66">66 Свердловская область</option>
                            <option value="67">67 Смоленская область</option>
                            <option value="68">68 Тамбовская область</option>
                            <option value="69">69 Тверская область</option>
                            <option value="70">70 Томская область</option>
                            <option value="71">71 Тульская область</option>
                            <option value="72">72 Тюменская область</option>
                            <option value="73">73 Ульяновская область</option>
                            <option value="74">74 Челябинская область</option>
                            <option value="75">75 Забайкальский край</option>
                            <option value="76">76 Ярославская область</option>
                            <option value="77">77 Москва</option>
                            <option value="78">78 Санкт-Петербург</option>
                            <option value="79">79 Еврейская автономная область</option>
                            <option value="80">80 Чукотский автономный округ</option>
                            <option value="81">81 Ненецкий автономный округ</option>
                            <option value="82">82 Ханты-Мансийский автономный округ - Югра</option>
                            <option value="83">83 Ямало-Ненецкий автономный округ</option>
                            <option value="84">84 Республика Крым</option>
                            <option value="85">85 Севастополь</option>
                        </select>
                    </div>
                    <div class="select">
                        <label class="select-label" for="type">Тип:</label><br>
                        <select name="type" id="type" class="">
                            <option value="">--Выберите тип--</option>
                            <option value="1">Безрадарный(не шумит)</option>
                            <option value="2">Радарный(шумит)</option>
                            <option value="3">Видеоблок</option>
                            <option value="4">Контроль остановки</option>
                            <option value="5">Муляж</option>
                            <option value="6">Контроль светофора</option>
                            <option value="7">Мобильная камера</option>
                        </select>
                    </div>
                    <div class="select">
                        <label class="select-label" for="model">Модель:</label><br>
                        <select name="model" id="model" class="">
                            <option value="">--Выберите модель--</option>
                            <option value="1">Кордон</option>
                            <option value="2">Арена</option>
                            <option value="3">Крис</option>
                            <option value="4">Скат</option>
                            <option value="5">Интегра-КДД</option>
                            <option value="6">Мангуст</option>
                            <option value="7">Азимут</option>
                        </select>
                    </div>
                    
                    <div class="input-box">
                        <input id="latitude" class="input-fixed" type="text" name="camera_latitude" required="">
                        <label>Широта</label>
                    </div>
                    <div class="input-box">
                        <input id="longitude"class="input-fixed" type="text" name="camera_longitude" required="">
                        <label>Долгота</label>
                    </div>

                    <div class="input-box" style="display: none">
                        <input id="target_latitude" class="input-fixed" type="text" name="target_latitude" required="">
                        <label>Широта таргет</label>
                    </div>
                    <div class="input-box" style="display: none">
                        <input id="target_longitude"class="input-fixed" type="text" name="target_longitude" required="">
                        <label>Долгота таргет</label>
                    </div>

                    <div class="input-box">
                        <input id="direction" class="input-fixed" type="text" name="direction" required="">
                        <label>Направление</label>
                    </div>
                    <div class="input-box">
                        <input id="distance"class="input-fixed" type="text" name="distance" required="">
                        <label>Длина луча</label>
                    </div>
                    <div class="input-box">
                        <input id="angle" class="input-fixed" type="text" name="angle" required="">
                        <label>Ширина луча</label>
                    </div>
                    <div class="">
                        <label>Скорость</label>
                        <div class="speed-box">
                            <div class="input-box">
                                <input id="speed-car" class="input-fixed" type="text" name="car_speed" required="">
                                <label>Легковой</label>
                            </div>
                            <div class="input-box">
                                <input id="speed-truck" class="input-fixed" type="text" name="truck_speed" required="">
                                <label>Грузовой</label>
                            </div>
                        </div>
                    </div>
                    <div class="input-box">
                        <input id="source" class="input-fixed" type="text" name="source" required="">
                        <label>Источник</label>
                    </div>
                    <div class="edit-text-block">
                        <p>Модератор:</p>
                    </div>
                        <div class="chekbox-block">
                            <div class="container">
                                <ul class="ks-cboxtags">
                                    <li><input type="checkbox" id="checkboxNine" name="flags[verified]" value="1" checked><label for="checkboxNine" >Подтвержден</label></li>
                                    <li><input type="checkbox" id="checkboxOne" name="flags[rear]" value="2" ><label for="checkboxOne">В спину</label></li>
                                    <li><input type="checkbox" id="checkboxTwo" name="flags[markup]" value="3"><label for="checkboxTwo">Разметка</label></li>
                                    <li><input type="checkbox" id="checkboxThree" name="flags[crosswalk]" value="4"><label for="checkboxThree">Пешеходный</label></li>
                                    <li><input type="checkbox" id="checkboxFour" name="flags[roadside]" value="5"><label for="checkboxFour">Обочина</label></li>
                                    <li><input type="checkbox" id="checkboxFive" name="flags[bus_line]" value="6"><label for="checkboxFive">Автобусная</label></li>
                                    <li><input type="checkbox" id="checkboxSix" name="flags[stop_monitoring]" value="7"><label for="checkboxSix">Контроль остановки</label></li>
                                    <li><input type="checkbox" id="checkboxSeven" name="flags[cargo_control]" value="8"><label for="checkboxSeven">Грузовой контроль</label></li>
                                    <li><input type="checkbox" id="checkboxEight" name="flags[additional]" value="9"><label for="checkboxEight">Дополнительный</label></li>
                                </ul>
                            </div>
                        </div>
                        <div class="edit-submit">
                            <button type="submit">
                                Добавить
                            </button>
                        </div>
                </div>
            </form>
            </section>
            <div id="map" class="map" style=""></div>
        </div>
    </main>
    
    
    

    <footer></footer>

   
    <script type="module" src="{{ asset('dist/js/edit.js') }}"></script>
</body>
</html>