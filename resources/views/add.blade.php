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
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <select name="country" id="selectCountries" class="">
                        </select>

                    </div>
                    <div class="select">
                        <label class="select-label" for="regions">Регион:</label><br>
                        <select name="region" id="selectRegions" class="">
                        </select>
                    </div>
                    <div class="select">
                        <label class="select-label" for="type">Тип:</label><br>
                        <select name="type" id="selectType" class="">
                        </select>
                    </div>
                    <div class="select">
                        <label class="select-label" for="model">Модель:</label><br>
                        <select name="model" id="selectModel" class="">
                        </select>
                    </div>
                    
                    <div class="input-box">
                        <input id="latitude" class="input-fixed" type="text" name="camera_latitude" value="{{ $latitude }}"required="">
                        <label>Широта</label>
                    </div>
                    <div class="input-box">
                        <input id="longitude"class="input-fixed" type="text" name="camera_longitude" value="{{ $longitude }}" required="">
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